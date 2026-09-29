<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('sort_order')->get()->groupBy('category');
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.form', ['skill' => new Skill(), 'categories' => Skill::categories()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:technical,design,tool,soft',
            'proficiency' => 'required|integer|min:0|max:100',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
            'featured'    => 'nullable|boolean',
        ]);
        $data['featured'] = $request->boolean('featured');
        Skill::create($data);
        return redirect()->route('admin.skills.index')->with('success', 'Skill added.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.form', ['skill' => $skill, 'categories' => Skill::categories()]);
    }

    public function update(Request $request, Skill $skill)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:technical,design,tool,soft',
            'proficiency' => 'required|integer|min:0|max:100',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
            'featured'    => 'nullable|boolean',
        ]);
        $data['featured'] = $request->boolean('featured');
        $skill->update($data);
        return redirect()->route('admin.skills.index')->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill deleted.');
    }
}
