@extends('layouts.admin')
@section('title', $experience->exists ? 'Edit Experience' : 'Add Experience')
@section('page-title', $experience->exists ? 'Edit Experience' : 'Add Experience')
@section('admin-content')
<div class="max-w-2xl">
    <div class="admin-card">
        <form method="POST" action="{{ $experience->exists ? route('admin.experience.update',$experience) : route('admin.experience.store') }}" class="space-y-4">
            @csrf @if($experience->exists) @method('PUT') @endif
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label class="form-label">Job Title</label><input type="text" name="title" value="{{ old('title',$experience->title) }}" class="form-input" required></div>
                <div><label class="form-label">Company / Organisation</label><input type="text" name="company" value="{{ old('company',$experience->company) }}" class="form-input" required></div>
                <div><label class="form-label">Location</label><input type="text" name="location" value="{{ old('location',$experience->location) }}" class="form-input"></div>
                <div><label class="form-label">Period</label><input type="text" name="period" value="{{ old('period',$experience->period) }}" class="form-input" placeholder="2023 – Present" required></div>
                <div>
                    <label class="form-label">Type</label>
                    <select name="type" class="form-input">
                        @foreach(['work','freelance','volunteer'] as $t)<option value="{{ $t }}" {{ old('type',$experience->type)==$t?'selected':'' }}>{{ ucfirst($t) }}</option>@endforeach
                    </select>
                </div>
                <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',$experience->sort_order??0) }}" class="form-input"></div>
            </div>
            <div><label class="form-label">Description</label><textarea name="description" rows="4" class="form-input resize-y" required>{{ old('description',$experience->description) }}</textarea></div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="current" value="1" class="rounded border-white/20 bg-dark-700 text-blue-500" {{ old('current',$experience->current)?'checked':'' }}>
                <span class="text-sm text-gray-300">This is my current role</span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">{{ $experience->exists ? 'Update' : 'Add' }}</button>
                <a href="{{ route('admin.experience.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
