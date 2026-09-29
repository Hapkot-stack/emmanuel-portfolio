<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrNew([]);
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'bio'         => 'required|string',
            'email'       => 'required|email',
            'phone'       => 'nullable|string|max:50',
            'location'    => 'nullable|string|max:255',
            'github_url'  => 'nullable|url',
            'linkedin_url'=> 'nullable|url',
            'whatsapp'    => 'nullable|string|max:50',
            'avatar'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($data['avatar']);
        }

        Profile::updateOrCreate(['id' => 1], $data);
        return back()->with('success', 'Profile updated successfully.');
    }
}
