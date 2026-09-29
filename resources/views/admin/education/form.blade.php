@extends('layouts.admin')
@section('title', $education->exists ? 'Edit Education' : 'Add Education')
@section('page-title', $education->exists ? 'Edit Education' : 'Add Education')
@section('admin-content')
<div class="max-w-lg">
    <div class="admin-card">
        <form method="POST" action="{{ $education->exists ? route('admin.education.update',$education) : route('admin.education.store') }}" class="space-y-4">
            @csrf @if($education->exists) @method('PUT') @endif
            <div><label class="form-label">Degree / Qualification</label><input type="text" name="degree" value="{{ old('degree',$education->degree) }}" class="form-input" required></div>
            <div><label class="form-label">Institution</label><input type="text" name="institution" value="{{ old('institution',$education->institution) }}" class="form-input" required></div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label class="form-label">Location</label><input type="text" name="location" value="{{ old('location',$education->location) }}" class="form-input"></div>
                <div><label class="form-label">Period</label><input type="text" name="period" value="{{ old('period',$education->period) }}" class="form-input" placeholder="2023 – 2026" required></div>
                <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',$education->sort_order??0) }}" class="form-input"></div>
            </div>
            <div><label class="form-label">Description (optional)</label><textarea name="description" rows="3" class="form-input resize-y">{{ old('description',$education->description) }}</textarea></div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">{{ $education->exists ? 'Update' : 'Add' }}</button>
                <a href="{{ route('admin.education.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
