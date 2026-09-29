@extends('layouts.admin')
@section('title','Education')
@section('page-title','Education Management')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-400">{{ $educations->count() }} entries</p>
    <a href="{{ route('admin.education.create') }}" class="btn-primary text-sm">+ Add Education</a>
</div>
<div class="space-y-3">
    @forelse($educations as $edu)
    <div class="admin-card flex items-start justify-between gap-4">
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="font-semibold text-white">{{ $edu->degree }}</span>
                <span class="text-gray-400 text-sm">· {{ $edu->institution }}</span>
            </div>
            <div class="text-xs text-violet-400 mb-2">{{ $edu->period }}@if($edu->location) · {{ $edu->location }}@endif</div>
            @if($edu->description)<p class="text-sm text-gray-400 line-clamp-2">{{ $edu->description }}</p>@endif
        </div>
        <div class="flex gap-3 flex-shrink-0">
            <a href="{{ route('admin.education.edit',$edu) }}" class="text-xs text-blue-400 hover:text-blue-300">Edit</a>
            <form method="POST" action="{{ route('admin.education.destroy',$edu) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-xs text-red-400 hover:text-red-300">Delete</button></form>
        </div>
    </div>
    @empty
    <div class="admin-card text-center py-10 text-gray-600">No entries. <a href="{{ route('admin.education.create') }}" class="text-blue-400">Add one</a>.</div>
    @endforelse
</div>
@endsection
