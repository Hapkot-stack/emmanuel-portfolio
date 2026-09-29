<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\CareerTrack;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ResumeType;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Models\TimelineEntry;

class RecruiterController extends Controller
{
    public function index()
    {
        $profile      = Profile::first();
        $skills       = Skill::orderBy('sort_order')->get()->groupBy('category');
        $projects     = Project::visible()->with('screenshots')->orderBy('sort_order')->get();
        $experiences  = Experience::orderBy('sort_order')->get();
        $educations   = Education::orderBy('sort_order')->get();
        $certificates = Certificate::orderBy('sort_order')->get();
        $socialLinks  = SocialLink::where('active', true)->orderBy('sort_order')->get();
        $careerTracks = CareerTrack::query()
            ->get()
            ->filter(fn(CareerTrack $track) => data_get($track->published, 'is_public', false))
            ->sortBy(fn(CareerTrack $track) => data_get($track->published, 'sort_order', 0))
            ->values();
        $resumeTypes = ResumeType::query()
            ->get()
            ->filter(fn(ResumeType $resume) => data_get($resume->published, 'is_public', false))
            ->sortBy(fn(ResumeType $resume) => data_get($resume->published, 'sort_order', $resume->sort_order))
            ->values();
        $timeline = TimelineEntry::orderByDesc('sort_order')->get();

        return view('public.recruiter', compact(
            'profile',
            'skills',
            'projects',
            'experiences',
            'educations',
            'certificates',
            'socialLinks',
            'careerTracks',
            'resumeTypes',
            'timeline'
        ));
    }
}
