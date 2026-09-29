<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new Project()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'technologies'      => 'required|string',
            'github_url'        => 'nullable|url',
            'website_url'       => 'nullable|url',
            'website_available' => 'nullable|boolean',
            'featured'          => 'nullable|boolean',
            'sort_order'        => 'nullable|integer',
            'cover_image'       => 'nullable|image|max:4096',
        ]);
        $data['featured']          = $request->boolean('featured');
        $data['website_available'] = $request->boolean('website_available');
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }
        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project added.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'technologies'      => 'required|string',
            'github_url'        => 'nullable|url',
            'website_url'       => 'nullable|url',
            'website_available' => 'nullable|boolean',
            'featured'          => 'nullable|boolean',
            'sort_order'        => 'nullable|integer',
            'cover_image'       => 'nullable|image|max:4096',
        ]);
        $data['featured']          = $request->boolean('featured');
        $data['website_available'] = $request->boolean('website_available');
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
            Storage::disk('public')->delete($project->cover_image);
        }
        $project->delete();
        return back()->with('success', 'Project deleted.');
    }
}
