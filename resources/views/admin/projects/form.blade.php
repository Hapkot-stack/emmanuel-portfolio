@extends('layouts.admin')
@section('title', $project->exists ? 'Edit Project' : 'Add Project')
@section('page-title', $project->exists ? 'Edit Project' : 'Add Project')
@section('admin-content')
<div class="max-w-2xl">
    <div class="admin-card">
        <form method="POST" action="{{ $project->exists ? route('admin.projects.update',$project) : route('admin.projects.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @if($project->exists) @method('PUT') @endif
            <div><label class="form-label">Project Title</label><input type="text" name="title" value="{{ old('title',$project->title) }}" class="form-input" required></div>
            <div><label class="form-label">Description</label><textarea name="description" rows="4" class="form-input resize-y" required>{{ old('description',$project->description) }}</textarea></div>
            <div><label class="form-label">Technologies (comma separated)</label><input type="text" name="technologies" value="{{ old('technologies',$project->technologies) }}" class="form-input" placeholder="HTML, CSS, JavaScript, PHP" required></div>
            <div class="grid sm:grid-cols-2 gap-5">
                <div><label class="form-label">GitHub URL</label><input type="url" name="github_url" value="{{ old('github_url',$project->github_url) }}" class="form-input"></div>
                <div><label class="form-label">Website URL</label><input type="url" name="website_url" value="{{ old('website_url',$project->website_url) }}" class="form-input"></div>
                <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',$project->sort_order??0) }}" class="form-input"></div>
            </div>
            <div>
                <label class="form-label">Cover Image</label>
                @if($project->cover_image)<img src="{{ Str::startsWith($project->cover_image,'projects/') ? asset('storage/'.$project->cover_image) : asset($project->cover_image) }}" class="h-24 rounded-xl object-cover mb-2">@endif
                <input type="file" name="cover_image" accept="image/*" class="form-input text-xs">
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" class="rounded border-white/20 bg-dark-700 text-blue-500" {{ old('featured',$project->featured)?'checked':'' }}>
                    <span class="text-sm text-gray-300">Featured on homepage</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="website_available" value="1" class="rounded border-white/20 bg-dark-700 text-blue-500" {{ old('website_available',$project->website_available)?'checked':'' }}>
                    <span class="text-sm text-gray-300">Website is live</span>
                </label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">{{ $project->exists ? 'Update' : 'Add' }} Project</button>
                <a href="{{ route('admin.projects.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
