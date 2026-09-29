<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $links = SocialLink::orderBy('sort_order')->get();
        return view('admin.social.index', compact('links'));
    }

    public function create()
    {
        return view('admin.social.form', ['link' => new SocialLink()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'platform'   => 'required|string|max:50',
            'label'      => 'required|string|max:100',
            'url'        => 'required|string|max:500',
            'icon'       => 'nullable|string|max:100',
            'color'      => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
            'active'     => 'nullable|boolean',
        ]);
        $data['active'] = $request->boolean('active');
        SocialLink::create($data);
        return redirect()->route('admin.social.index')->with('success', 'Social link added.');
    }

    public function edit(SocialLink $socialLink)
    {
        return view('admin.social.form', ['link' => $socialLink]);
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $data = $request->validate([
            'platform'   => 'required|string|max:50',
            'label'      => 'required|string|max:100',
            'url'        => 'required|string|max:500',
            'icon'       => 'nullable|string|max:100',
            'color'      => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
            'active'     => 'nullable|boolean',
        ]);
        $data['active'] = $request->boolean('active');
        $socialLink->update($data);
        return redirect()->route('admin.social.index')->with('success', 'Social link updated.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        return back()->with('success', 'Social link deleted.');
    }
}
