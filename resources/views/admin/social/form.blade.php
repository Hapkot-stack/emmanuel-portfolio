@extends('layouts.admin')
@section('title', $link->exists ? 'Edit Social Link' : 'Add Social Link')
@section('page-title', $link->exists ? 'Edit Social Link' : 'Add Social Link')
@section('admin-content')
<div class="max-w-lg">
    <div class="admin-card">
        <form method="POST" action="{{ $link->exists ? route('admin.social.update',$link) : route('admin.social.store') }}" class="space-y-4">
            @csrf @if($link->exists) @method('PUT') @endif
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label class="form-label">Platform</label><input type="text" name="platform" value="{{ old('platform',$link->platform) }}" class="form-input" placeholder="github" required></div>
                <div><label class="form-label">Display Label</label><input type="text" name="label" value="{{ old('label',$link->label) }}" class="form-input" placeholder="GitHub" required></div>
            </div>
            <div><label class="form-label">URL</label><input type="text" name="url" value="{{ old('url',$link->url) }}" class="form-input" placeholder="https://..." required></div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label class="form-label">Icon</label><input type="text" name="icon" value="{{ old('icon',$link->icon) }}" class="form-input" placeholder="github"></div>
                <div><label class="form-label">Color (hex)</label><input type="text" name="color" value="{{ old('color',$link->color) }}" class="form-input" placeholder="#6e5494"></div>
                <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',$link->sort_order??0) }}" class="form-input"></div>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="active" value="1" class="rounded border-white/20 bg-dark-700 text-blue-500" {{ old('active',$link->active??true)?'checked':'' }}>
                <span class="text-sm text-gray-300">Active (show on site)</span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">{{ $link->exists ? 'Update' : 'Add' }}</button>
                <a href="{{ route('admin.social.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
