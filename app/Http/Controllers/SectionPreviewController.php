<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\ProjectScreenshot;
use App\Models\SocialLink;
use App\Models\Skill;
use App\Models\TimelineEntry;

class SectionPreviewController extends Controller
{
    public function show(string $section)
    {
        $profile = Profile::first();

        $content = match ($section) {
            'experience' => ['title' => 'Experience', 'type' => 'records', 'items' => Experience::orderBy('sort_order')->get()],
            'education' => ['title' => 'Education', 'type' => 'records', 'items' => Education::orderBy('sort_order')->get()],
            'certificates' => ['title' => 'Certificates', 'type' => 'certificates', 'items' => Certificate::orderBy('sort_order')->get()],
            'project-screenshots' => ['title' => 'Project Screenshots', 'type' => 'screenshots', 'items' => ProjectScreenshot::with('project')->orderBy('sort_order')->get()],
            'expertise' => ['title' => 'Expertise', 'type' => 'skills', 'items' => Skill::orderBy('sort_order')->get()],
            'journey' => ['title' => 'Journey', 'type' => 'journey', 'items' => collect([
                ['title' => 'Profile and Biography', 'description' => $profile?->bio_short ?: $profile?->bio],
                ['title' => 'Experience', 'items' => Experience::orderBy('sort_order')->get()],
                ['title' => 'Education', 'items' => Education::orderBy('sort_order')->get()],
                ['title' => 'Certificates', 'items' => Certificate::orderBy('sort_order')->get()],
                ['title' => 'Timeline', 'items' => TimelineEntry::orderByDesc('sort_order')->get()],
            ])],
            'connect' => ['title' => 'Connect', 'type' => 'connect', 'items' => SocialLink::where('active', true)->orderBy('sort_order')->get()],
            'hire-me' => ['title' => 'Hire Me', 'type' => 'hire-me', 'items' => collect([
                ['title' => 'Availability', 'description' => $profile?->open_to ?: 'Contact Emmanuel to discuss availability.'],
                ['title' => 'Contact Information', 'description' => $profile?->email, 'phone' => $profile?->phone, 'location' => $profile?->location],
            ])],
            default => abort(404),
        };

        $isSectionOnlyPreview = true;

        return view('public.section-preview', compact('content', 'section', 'isSectionOnlyPreview'));
    }
}
