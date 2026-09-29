<?php

namespace App\Http\Controllers;

use App\Models\CareerTrack;
use App\Models\Project;
use App\Models\ResumeType;
use App\Models\Skill;

class CareerController extends Controller
{
    public function show(string $slug)
    {
        return $this->render($slug, false);
    }

    public function adminPreview(string $slug)
    {
        return $this->render($slug, true);
    }

    private function render(string $slug, bool $previewDraft)
    {
        $track = CareerTrack::where('slug', $slug)->firstOrFail();
        $content = $previewDraft ? $track->draft : $track->published;
        abort_unless($previewDraft || data_get($content, 'is_public', false), 404);

        $featuredSkills = Skill::whereIn('id', data_get($content, 'featured_skill_ids', []))
            ->orderBy('sort_order')
            ->get();
        $featuredProjects = Project::visible()
            ->with('screenshots')
            ->whereIn('id', data_get($content, 'featured_project_ids', []))
            ->orderBy('sort_order')
            ->get();
        $resumeType = ResumeType::where('type_key', data_get($content, 'resume_type'))
            ->where('published->is_public', true)
            ->first();

        return view('public.career_track', compact('track', 'content', 'featuredSkills', 'featuredProjects', 'resumeType', 'previewDraft'));
    }
}
