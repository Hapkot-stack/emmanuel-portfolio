@extends('layouts.admin')
@section('title', $skill->exists ? 'Edit Skill' : 'Add Skill')
@section('page-title', $skill->exists ? 'Edit Skill' : 'Add Skill')
@section('admin-content')
<div class="max-w-lg">
    <div class="admin-card">
        <form method="POST" action="{{ $skill->exists ? route('admin.skills.update',$skill) : route('admin.skills.store') }}" class="space-y-4">
            @csrf @if($skill->exists) @method('PUT') @endif
            <div><label class="form-label">Skill Name</label><input type="text" name="name" value="{{ old('name',$skill->name) }}" class="form-input" required></div>
            <div>
                <label class="form-label">Category</label>
                <select name="category" class="form-input">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category',$skill->category)==$cat?'selected':'' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="form-label">Proficiency (0–100)</label><input type="number" name="proficiency" value="{{ old('proficiency',$skill->proficiency??80) }}" min="0" max="100" class="form-input" required></div>
            <div><label class="form-label">Icon (optional)</label><input type="text" name="icon" value="{{ old('icon',$skill->icon) }}" class="form-input" placeholder="e.g. html5, js, php"></div>
            <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order',$skill->sort_order??0) }}" class="form-input"></div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="featured" value="1" class="rounded border-white/20 bg-dark-700 text-blue-500" {{ old('featured',$skill->featured)?'checked':'' }}>
                <span class="text-sm text-gray-300">Show in featured skills (homepage)</span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">{{ $skill->exists ? 'Update' : 'Add' }} Skill</button>
                <a href="{{ route('admin.skills.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
