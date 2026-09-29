@extends('layouts.admin')
@section('title','SEO Settings')
@section('page-title','SEO Management')
@section('admin-content')
<div class="max-w-2xl">
    <div class="admin-card">
        <form method="POST" action="{{ route('admin.seo.update') }}" class="space-y-5">
            @csrf
            <div><label class="form-label">Meta Title</label><input type="text" name="meta_title" value="{{ old('meta_title',$seo->meta_title) }}" class="form-input" required><p class="text-xs text-gray-600 mt-1">Recommended: 50–60 characters</p></div>
            <div><label class="form-label">Meta Description</label><textarea name="meta_description" rows="3" class="form-input resize-none" required>{{ old('meta_description',$seo->meta_description) }}</textarea><p class="text-xs text-gray-600 mt-1">Recommended: 150–160 characters</p></div>
            <div><label class="form-label">Meta Keywords</label><input type="text" name="meta_keywords" value="{{ old('meta_keywords',$seo->meta_keywords) }}" class="form-input" placeholder="comma, separated, keywords"></div>
            <div><label class="form-label">Google Analytics ID (optional)</label><input type="text" name="google_analytics" value="{{ old('google_analytics',$seo->google_analytics) }}" class="form-input" placeholder="G-XXXXXXXXXX"></div>
            <button type="submit" class="btn-primary">Save SEO Settings</button>
        </form>
    </div>
</div>
@endsection
