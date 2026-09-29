<?php
namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SeoSetting;
use App\Models\Skill;

class ResumeController extends Controller
{
    public function index()
    {
        AnalyticsEvent::track('page_view', '/resume');
        $profile      = Profile::first();
        $skills       = Skill::orderBy('sort_order')->get();
        $experiences  = Experience::orderBy('sort_order')->get();
        $educations   = Education::orderBy('sort_order')->get();
        $certificates = Certificate::orderBy('sort_order')->get();
        $projects     = Project::visible()->orderBy('sort_order')->get();
        $seo          = SeoSetting::first();
        return view('public.resume', compact(
            'profile','skills','experiences','educations','certificates','projects','seo'
        ));
    }
}
