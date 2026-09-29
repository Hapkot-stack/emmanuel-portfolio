<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function edit()
    {
        $seo = SeoSetting::firstOrNew([]);
        return view('admin.seo.edit', compact('seo'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'meta_title'        => 'required|string|max:255',
            'meta_description'  => 'required|string|max:500',
            'meta_keywords'     => 'nullable|string|max:500',
            'google_analytics'  => 'nullable|string|max:50',
        ]);
        SeoSetting::updateOrCreate(['id' => 1], $data);
        return back()->with('success', 'SEO settings saved.');
    }
}
