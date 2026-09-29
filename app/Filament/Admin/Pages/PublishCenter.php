<?php

namespace App\Filament\Admin\Pages;

use App\Models\HomepageSection;
use App\Models\HomepageSectionVersion;
use App\Models\CareerTrack;
use App\Models\CareerTrackVersion;
use App\Models\ResumeType;
use App\Models\ResumeTypeVersion;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PublishCenter extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationGroup = 'Publish Center';
    protected static ?string $navigationLabel = 'Publish Website';
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.admin.pages.publish-center';

    public function pendingSections(): Collection
    {
        return HomepageSection::all()
            ->filter(fn(HomepageSection $section) => $section->hasPendingChanges())
            ->sortBy('label')
            ->values();
    }

    public function pendingResumes(): Collection
    {
        return ResumeType::all()
            ->filter(fn(ResumeType $resumeType) => $resumeType->hasPendingChanges())
            ->sortBy('sort_order')
            ->values();
    }

    public function pendingCareerTracks(): Collection
    {
        return CareerTrack::all()
            ->filter(fn(CareerTrack $track) => $track->hasPendingChanges())
            ->sortBy(fn(CareerTrack $track) => data_get($track->draft, 'sort_order', 0))
            ->values();
    }

    public function recentVersions(): Collection
    {
        return HomepageSectionVersion::with('section')->latest()->limit(25)->get();
    }

    public function recentResumeVersions(): Collection
    {
        return ResumeTypeVersion::with('resumeType')->latest()->limit(25)->get();
    }

    public function recentCareerTrackVersions(): Collection
    {
        return CareerTrackVersion::with('careerTrack')->latest()->limit(25)->get();
    }

    public function publishAll(): void
    {
        DB::transaction(function (): void {
            foreach ($this->pendingSections() as $section) {
                $this->publishSectionRecord($section);
            }

            foreach ($this->pendingResumes() as $resumeType) {
                $this->publishResumeRecord($resumeType);
            }

            foreach ($this->pendingCareerTracks() as $track) {
                $this->publishCareerTrackRecord($track);
            }
        });

        Notification::make()->title('Website published')->success()->send();
    }

    public function publishSection(int $sectionId): void
    {
        $section = HomepageSection::findOrFail($sectionId);

        if (! $section->hasPendingChanges()) {
            return;
        }

        DB::transaction(fn() => $this->publishSectionRecord($section));
        Notification::make()->title($section->label . ' published')->success()->send();
    }

    public function publishResume(int $resumeTypeId): void
    {
        $resumeType = ResumeType::findOrFail($resumeTypeId);

        if (! $resumeType->hasPendingChanges()) {
            return;
        }

        DB::transaction(fn() => $this->publishResumeRecord($resumeType));
        Notification::make()->title(data_get($resumeType->draft, 'label') . ' published')->success()->send();
    }

    public function publishCareerTrack(int $trackId): void
    {
        $track = CareerTrack::findOrFail($trackId);

        if (! $track->hasPendingChanges()) {
            return;
        }

        DB::transaction(fn() => $this->publishCareerTrackRecord($track));
        Notification::make()->title(data_get($track->draft, 'title') . ' published')->success()->send();
    }

    public function rollbackVersion(int $versionId): void
    {
        $version = HomepageSectionVersion::with('section')->findOrFail($versionId);
        $section = $version->section;

        DB::transaction(function () use ($section, $version): void {
            $section->version++;
            $section->draft = $version->content;
            $section->published = $version->content;
            $section->published_at = now();
            $section->save();

            $section->versions()->create([
                'version' => $section->version,
                'content' => $version->content,
                'published_by' => auth()->id(),
            ]);
        });

        Notification::make()->title($section->label . ' rolled back')->success()->send();
    }

    public function rollbackResumeVersion(int $versionId): void
    {
        $version = ResumeTypeVersion::with('resumeType')->findOrFail($versionId);
        $resumeType = $version->resumeType;

        DB::transaction(function () use ($resumeType, $version): void {
            $resumeType->version++;
            $resumeType->draft = $version->content;
            $resumeType->published = $version->content;
            $resumeType->template = data_get($version->content, 'template', $resumeType->template);
            $resumeType->sort_order = (int) data_get($version->content, 'sort_order', $resumeType->sort_order);
            $resumeType->published_at = now();
            $resumeType->save();

            $resumeType->versions()->create([
                'version' => $resumeType->version,
                'content' => $version->content,
                'published_by' => auth()->id(),
            ]);
        });

        Notification::make()->title(data_get($resumeType->published, 'label') . ' rolled back')->success()->send();
    }

    public function rollbackCareerTrackVersion(int $versionId): void
    {
        $version = CareerTrackVersion::with('careerTrack')->findOrFail($versionId);
        $track = $version->careerTrack;

        DB::transaction(function () use ($track, $version): void {
            $track->version++;
            $track->draft = $version->content;
            $track->published = $version->content;
            $track->published_at = now();
            $track->save();
            $track->versions()->create([
                'version' => $track->version,
                'content' => $version->content,
                'published_by' => auth()->id(),
            ]);
        });

        Notification::make()->title(data_get($track->published, 'title') . ' rolled back')->success()->send();
    }

    private function publishSectionRecord(HomepageSection $section): void
    {
        $section->version++;
        $section->published = $section->draft;
        $section->published_at = now();
        $section->save();

        $section->versions()->create([
            'version' => $section->version,
            'content' => $section->published,
            'published_by' => auth()->id(),
        ]);
    }

    private function publishResumeRecord(ResumeType $resumeType): void
    {
        $resumeType->version++;
        $resumeType->published = $resumeType->draft;
        $resumeType->template = data_get($resumeType->draft, 'template', $resumeType->template);
        $resumeType->sort_order = (int) data_get($resumeType->draft, 'sort_order', $resumeType->sort_order);
        $resumeType->published_at = now();
        $resumeType->save();

        $resumeType->versions()->create([
            'version' => $resumeType->version,
            'content' => $resumeType->published,
            'published_by' => auth()->id(),
        ]);
    }

    private function publishCareerTrackRecord(CareerTrack $track): void
    {
        $track->version++;
        $track->published = $track->draft;
        $track->published_at = now();
        $track->save();
        $track->versions()->create([
            'version' => $track->version,
            'content' => $track->published,
            'published_by' => auth()->id(),
        ]);
    }
}
