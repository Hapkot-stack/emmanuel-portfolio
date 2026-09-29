<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\CareerTrack;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Models\SeoSetting;
use App\Models\TimelineEntry;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $isDraftPreview = $request->routeIs('admin.homepage-preview') && auth()->check();
        $sectionPreview = $isDraftPreview ? $request->query('section') : null;
        $previewSections = [
            'hero',
            'career-center',
            'resume-center',
            'skills-preview',
            'featured-projects',
            'building-projects',
            'social-section',
            'timeline',
            'contact-cta',
        ];

        if ($sectionPreview !== null) {
            abort_unless(in_array($sectionPreview, $previewSections, true), 404);
        }

        if (! $isDraftPreview) {
            AnalyticsEvent::track('page_view', '/');
        }

        $profile = Profile::first() ?? new Profile([
            'name' => 'Emmanuel Tokpah',
            'title' => 'Software Developer',
            'subtitle' => 'Information Systems Student',
            'bio' => 'Building software products, analytics platforms, business systems and trading technologies.',
            'bio_short' => 'Building software products, analytics platforms, business systems and trading technologies.',
            'email' => 'emmanueltokpah94@gmail.com',
            'phone' => '+250 792 406 443',
            'location' => 'Kigali, Rwanda',
            'github_url' => '#',
            'linkedin_url' => '#',
            'whatsapp' => '#',
            'website_url' => '#',
            'years_experience' => 2,
            'open_to' => 'Full-time, freelance, remote',
            'resume_headline' => 'Software Developer',
            'tech_stack' => [
                'Laravel',
                'PHP',
                'MySQL',
                'JavaScript',
                'API Development',
                'Git',
                'Figma',
                'Excel',
                'PowerPoint',
                'Cybersecurity',
            ],
            'titles' => [
                'Software Developer',
                'Information Systems Student',
                'Trading Systems Builder',
                'Electrical Technician',
                'Data & Reporting Professional',
            ],
        ]);

        $featuredSkills  = Skill::where('featured', true)->orderBy('sort_order')->get();
        $careerTracks = CareerTrack::all()
            ->filter(fn(CareerTrack $track) => data_get($track->published, 'is_public', false))
            ->sortBy(fn(CareerTrack $track) => data_get($track->published, 'sort_order', 0))
            ->values();
        $allSkills       = Skill::orderBy('sort_order')->get()->groupBy('category');
        $skillCategory = $sectionPreview === 'skills-preview' ? $request->query('skill_category') : null;

        if ($skillCategory !== null) {
            abort_unless(in_array($skillCategory, Skill::categories(), true), 404);
        }

        if (in_array($skillCategory, Skill::categories(), true)) {
            $allSkills = $allSkills->only($skillCategory);
        }
        $featuredProjects = Project::visible()->featured()->orderBy('sort_order')->take(4)->get();
        $socialLinks     = SocialLink::where('active', true)->orderBy('sort_order')->get();
        $timeline        = TimelineEntry::orderBy('sort_order', 'desc')->get();
        $buildingProjects = Project::whereIn('status', ['in_development', 'testing'])->orderBy('sort_order')->get();
        $seo             = SeoSetting::first();
        $homepageSections = HomepageSection::all()
            ->mapWithKeys(fn(HomepageSection $section) => [
                $section->section_key => $isDraftPreview ? $section->draft : $section->published,
            ])
            ->all();

        $stats = [
            'projects'     => Project::visible()->count(),
            'skills'       => Skill::count(),
            'certificates' => \App\Models\Certificate::count(),
            'experience'   => \App\Models\Experience::count(),
        ];

        return view('public.home', compact(
            'profile',
            'featuredSkills',
            'careerTracks',
            'allSkills',
            'featuredProjects',
            'socialLinks',
            'timeline',
            'buildingProjects',
            'seo',
            'stats',
            'homepageSections',
            'isDraftPreview',
            'sectionPreview'
        ));
    }
}
