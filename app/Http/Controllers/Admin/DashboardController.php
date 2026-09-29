<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Certificate;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'skills'       => Skill::count(),
            'projects'     => Project::count(),
            'experiences'  => Experience::count(),
            'educations'   => Education::count(),
            'certificates' => Certificate::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
