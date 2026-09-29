@extends('layouts.admin')
@section('title','Experience')
@section('page-title','Experience Management')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-400">{{ $experiences->count() }} entries</p>
    <a href="{{ route('admin.experience.create') }}" class="btn-primary text-sm">+ Add Experience</a>
</div>
<div class="space-y-3">
    @forelse($experiences as $exp)
    <div class="admin-card flex items-start justify-between gap-4">
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="font-semibold text-white">{{ $exp->title }}</span>
                <span class="text-gray-400 text-sm">· {{ $exp->company }}</span>
                @if($exp->current)<span class="text-xs bg-emerald-500/20 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-full">Current</span>@endif
                <span class="text-xs bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-0.5 rounded-full capitalize">{{ $exp->type }}</span>
            </div>
            <div class="text-xs text-cyan-400 mb-2">{{ $exp->period }}@if($exp->location) · {{ $exp->location }}@endif</div>
            <p class="text-sm text-gray-400 line-clamp-2">{{ $exp->description }}</p>
        </div>
        <div class="flex gap-3 flex-shrink-0">
            <a href="{{ route('admin.experience.edit',$exp) }}" class="text-xs text-blue-400 hover:text-blue-300">Edit</a>
            <form method="POST" action="{{ route('admin.experience.destroy',$exp) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-xs text-red-400 hover:text-red-300">Delete</button></form>
        </div>
    </div>
    @empty
    <div class="admin-card text-center py-10 text-gray-600">No experience entries. <a href="{{ route('admin.experience.create') }}" class="text-blue-400">Add one</a>.</div>
    @endforelse
</div>
@endsection
