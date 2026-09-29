<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::orderBy('sort_order')->get();
        return view('admin.education.index', compact('educations'));
    }

    public function create()
    {
        return view('admin.education.form', ['education' => new Education()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'degree'      => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'period'      => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        Education::create($data);
        return redirect()->route('admin.education.index')->with('success', 'Education added.');
    }

    public function edit(Education $education)
    {
        return view('admin.education.form', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $data = $request->validate([
            'degree'      => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'period'      => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer',
        ]);
        $education->update($data);
        return redirect()->route('admin.education.index')->with('success', 'Education updated.');
    }

    public function destroy(Education $education)
    {
        $education->delete();
        return back()->with('success', 'Education deleted.');
    }
}
