<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ResumeType;
use App\Models\Skill;
use Barryvdh\DomPDF\Facade\Pdf;

class CvController extends Controller
{
    private array $templates = [
        'developer' => 'cv.developer',
        'ict_officer' => 'cv.ict_officer',
        'data_officer' => 'cv.data_officer',
        'ngo' => 'cv.ngo',
        'electrical' => 'cv.electrical',
        'one_page' => 'public.resume',
    ];

    private function getData(): array
    {
        return [
            'profile'      => Profile::first(),
            'skills'       => Skill::orderBy('sort_order')->get(),
            'experiences'  => Experience::orderBy('sort_order')->get(),
            'educations'   => Education::orderBy('sort_order')->get(),
            'certificates' => Certificate::orderBy('sort_order')->get(),
            'projects'     => Project::visible()->orderBy('sort_order')->get(),
        ];
    }

    public function center()
    {
        AnalyticsEvent::track('page_view', '/cv');
        $cvTypes = ResumeType::query()
            ->get()
            ->filter(fn(ResumeType $type) => data_get($type->published, 'is_public', false))
            ->sortBy(fn(ResumeType $type) => data_get($type->published, 'sort_order', $type->sort_order))
            ->mapWithKeys(fn(ResumeType $type) => [$type->type_key => $type->published])
            ->all();

        return view('public.resume_center', compact('cvTypes'));
    }

    public function preview(string $type)
    {
        $resumeType = ResumeType::where('type_key', $type)->firstOrFail();
        abort_unless(data_get($resumeType->published, 'is_public', false), 404);

        return $this->renderResume($resumeType, $resumeType->published);
    }

    public function download(string $type)
    {
        $resumeType = ResumeType::where('type_key', $type)->firstOrFail();
        abort_unless(data_get($resumeType->published, 'is_public', false), 404);
        AnalyticsEvent::track('cv_download', '/cv/' . $type . '/download', data_get($resumeType->published, 'label'));

        return $this->downloadResume($resumeType, $resumeType->published);
    }

    public function adminPreview(string $type)
    {
        $resumeType = ResumeType::where('type_key', $type)->firstOrFail();

        return $this->renderResume($resumeType, $resumeType->draft);
    }

    public function adminDownload(string $type)
    {
        $resumeType = ResumeType::where('type_key', $type)->firstOrFail();

        return $this->downloadResume($resumeType, $resumeType->draft);
    }

    private function renderResume(ResumeType $resumeType, array $metadata)
    {
        $data = $this->getData();
        $data['cvType'] = $resumeType->type_key;
        $data['cvMeta'] = $metadata;

        return view($this->templateView($metadata), $data);
    }

    private function downloadResume(ResumeType $resumeType, array $metadata)
    {
        $data = $this->getData();
        $data['cvType'] = $resumeType->type_key;
        $data['cvMeta'] = $metadata;

        $pdf = Pdf::loadView($this->templateView($metadata), $data)
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'sans-serif')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', false);

        $filename = 'Emmanuel_Tokpah_' . str_replace([' ', '/'], '_', $metadata['label']) . '.pdf';

        return $pdf->download($filename);
    }

    private function templateView(array $metadata): string
    {
        return $this->templates[$metadata['template'] ?? 'developer'] ?? abort(404);
    }
}
