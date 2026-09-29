@extends('layouts.admin')
@section('title','Theme Settings')
@section('page-title','Theme Management')
@section('admin-content')
<div class="max-w-lg">
    <div class="admin-card">
        <form method="POST" action="{{ route('admin.theme.update') }}" class="space-y-5">
            @csrf
            <div>
                <label class="form-label">Default Mode</label>
                <select name="default_mode" class="form-input">
                    <option value="dark"  {{ old('default_mode',$theme->default_mode)=='dark'  ?'selected':'' }}>Dark Mode</option>
                    <option value="light" {{ old('default_mode',$theme->default_mode)=='light' ?'selected':'' }}>Light Mode</option>
                </select>
            </div>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Primary Color</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" name="primary_color" value="{{ old('primary_color',$theme->primary_color??'#2563EB') }}" class="w-10 h-10 rounded-lg border border-white/10 bg-transparent cursor-pointer">
                        <input type="text" value="{{ old('primary_color',$theme->primary_color??'#2563EB') }}" class="form-input text-xs" placeholder="#2563EB" readonly>
                    </div>
                </div>
                <div>
                    <label class="form-label">Secondary Color</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" name="secondary_color" value="{{ old('secondary_color',$theme->secondary_color??'#06B6D4') }}" class="w-10 h-10 rounded-lg border border-white/10 bg-transparent cursor-pointer">
                        <input type="text" value="{{ old('secondary_color',$theme->secondary_color??'#06B6D4') }}" class="form-input text-xs" placeholder="#06B6D4" readonly>
                    </div>
                </div>
                <div>
                    <label class="form-label">Accent Color</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" name="accent_color" value="{{ old('accent_color',$theme->accent_color??'#8B5CF6') }}" class="w-10 h-10 rounded-lg border border-white/10 bg-transparent cursor-pointer">
                        <input type="text" value="{{ old('accent_color',$theme->accent_color??'#8B5CF6') }}" class="form-input text-xs" placeholder="#8B5CF6" readonly>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-primary">Save Theme</button>
        </form>
    </div>
</div>
@endsection
