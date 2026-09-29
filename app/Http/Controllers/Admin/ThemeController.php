<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function edit()
    {
        $theme = ThemeSetting::firstOrNew([]);
        return view('admin.theme.edit', compact('theme'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'default_mode'    => 'required|in:light,dark',
            'primary_color'   => 'required|string|max:20',
            'secondary_color' => 'required|string|max:20',
            'accent_color'    => 'required|string|max:20',
        ]);
        ThemeSetting::updateOrCreate(['id' => 1], $data);
        return back()->with('success', 'Theme settings saved.');
    }
}
