@extends('layouts.admin')
@section('title','Profile')
@section('page-title','Profile Management')
@section('admin-content')
<div class="max-w-2xl">
    <div class="admin-card">
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid sm:grid-cols-2 gap-5">
                <div><label class="form-label">Full Name</label><input type="text" name="name" value="{{ old('name',$profile->name) }}" class="form-input" required></div>
                <div><label class="form-label">Professional Title</label><input type="text" name="title" value="{{ old('title',$profile->title) }}" class="form-input" required></div>
                <div><label class="form-label">Subtitle / Tagline</label><input type="text" name="subtitle" value="{{ old('subtitle',$profile->subtitle) }}" class="form-input"></div>
                <div><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email',$profile->email) }}" class="form-input" required></div>
                <div><label class="form-label">Phone</label><input type="text" name="phone" value="{{ old('phone',$profile->phone) }}" class="form-input"></div>
                <div><label class="form-label">Location</label><input type="text" name="location" value="{{ old('location',$profile->location) }}" class="form-input"></div>
                <div><label class="form-label">GitHub URL</label><input type="url" name="github_url" value="{{ old('github_url',$profile->github_url) }}" class="form-input"></div>
                <div><label class="form-label">LinkedIn URL</label><input type="url" name="linkedin_url" value="{{ old('linkedin_url',$profile->linkedin_url) }}" class="form-input"></div>
                <div><label class="form-label">WhatsApp Number</label><input type="text" name="whatsapp" value="{{ old('whatsapp',$profile->whatsapp) }}" class="form-input" placeholder="+250..."></div>
                <div>
                    <label class="form-label">Profile Photo</label>
                    @if($profile->avatar)<img src="{{ asset($profile->avatar) }}" class="w-16 h-16 rounded-xl object-cover mb-2">@endif
                    <input type="file" name="avatar" accept="image/*" class="form-input text-xs">
                </div>
            </div>
            <div><label class="form-label">Bio / Summary</label><textarea name="bio" rows="5" class="form-input resize-y" required>{{ old('bio',$profile->bio) }}</textarea></div>
            <button type="submit" class="btn-primary">Save Profile</button>
        </form>
    </div>
</div>
@endsection
