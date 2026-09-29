<?php
namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\Project;
use App\Models\SeoSetting;

class ProjectController extends Controller
{
    public function index()
    {
        AnalyticsEvent::track('page_view', '/projects');
        $projects = Project::visible()->with('screenshots')->orderBy('sort_order')->get();
        $seo      = SeoSetting::first();
        return view('public.projects', compact('projects', 'seo'));
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->with('screenshots')->firstOrFail();
        AnalyticsEvent::track('project_view', '/projects/'.$slug, $project->title);
        $related = Project::visible()->where('id','!=',$project->id)->take(3)->get();
        return view('public.project_detail', compact('project','related'));
    }
}
