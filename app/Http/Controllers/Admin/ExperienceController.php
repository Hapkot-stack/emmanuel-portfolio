<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('sort_order')->get();
        return view('admin.experience.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experience.form', ['experience' => new Experience()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'period'      => 'required|string|max:100',
            'description' => 'required|string',
            'type'        => 'required|in:work,freelance,volunteer',
            'current'     => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['current'] = $request->boolean('current');
        Experience::create($data);
        return redirect()->route('admin.experience.index')->with('success', 'Experience added.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experience.form', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'company'     => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'period'      => 'required|string|max:100',
            'description' => 'required|string',
            'type'        => 'required|in:work,freelance,volunteer',
            'current'     => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
        ]);
        $data['current'] = $request->boolean('current');
        $experience->update($data);
        return redirect()->route('admin.experience.index')->with('success', 'Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Experience deleted.');
    }
}
