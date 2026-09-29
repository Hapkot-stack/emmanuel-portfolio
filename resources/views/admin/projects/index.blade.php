@extends('layouts.admin')
@section('title','Projects')
@section('page-title','Project Management')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-400">{{ $projects->count() }} projects</p>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary text-sm">+ Add Project</a>
</div>
<div class="admin-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-white/5 text-left text-xs text-gray-500 uppercase tracking-wider">
            <th class="pb-3 pr-4">Title</th><th class="pb-3 pr-4">Technologies</th><th class="pb-3 pr-4">Featured</th><th class="pb-3 pr-4">Website</th><th class="pb-3">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-white/5">
        @forelse($projects as $p)
        <tr>
            <td class="py-3 pr-4"><span class="font-semibold text-white">{{ $p->title }}</span></td>
            <td class="py-3 pr-4"><div class="flex flex-wrap gap-1">@foreach(array_slice($p->tech_array,0,3) as $t)<span class="text-xs px-2 py-0.5 rounded-full bg-cyan-400/10 text-cyan-400">{{ $t }}</span>@endforeach</div></td>
            <td class="py-3 pr-4"><span class="{{ $p->featured?'text-emerald-400':'text-gray-600' }} text-xs font-semibold">{{ $p->featured?'✓ Yes':'No' }}</span></td>
            <td class="py-3 pr-4"><span class="{{ $p->website_available?'text-emerald-400':'text-amber-400' }} text-xs">{{ $p->website_available?'Live':'Under Dev' }}</span></td>
            <td class="py-3"><div class="flex gap-3"><a href="{{ route('admin.projects.edit',$p) }}" class="text-xs text-blue-400 hover:text-blue-300">Edit</a>
            <form method="POST" action="{{ route('admin.projects.destroy',$p) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-xs text-red-400 hover:text-red-300">Delete</button></form></div></td>
        </tr>
        @empty
        <tr><td colspan="5" class="py-10 text-center text-gray-600">No projects. <a href="{{ route('admin.projects.create') }}" class="text-blue-400">Add one</a>.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
