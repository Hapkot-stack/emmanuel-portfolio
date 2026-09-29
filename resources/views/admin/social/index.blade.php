@extends('layouts.admin')
@section('title','Social Links')
@section('page-title','Social Link Management')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-400">{{ $links->count() }} links</p>
    <a href="{{ route('admin.social.create') }}" class="btn-primary text-sm">+ Add Link</a>
</div>
<div class="admin-card overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-white/5 text-left text-xs text-gray-500 uppercase tracking-wider">
            <th class="pb-3 pr-4">Platform</th><th class="pb-3 pr-4">Label</th><th class="pb-3 pr-4">URL</th><th class="pb-3 pr-4">Active</th><th class="pb-3">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-white/5">
        @forelse($links as $link)
        <tr>
            <td class="py-3 pr-4 capitalize font-semibold text-white">{{ $link->platform }}</td>
            <td class="py-3 pr-4 text-gray-300">{{ $link->label }}</td>
            <td class="py-3 pr-4 text-gray-500 text-xs truncate max-w-xs">{{ $link->url }}</td>
            <td class="py-3 pr-4"><span class="{{ $link->active?'text-emerald-400':'text-gray-600' }} text-xs font-semibold">{{ $link->active?'✓ Active':'Inactive' }}</span></td>
            <td class="py-3"><div class="flex gap-3">
                <a href="{{ route('admin.social.edit',$link) }}" class="text-xs text-blue-400 hover:text-blue-300">Edit</a>
                <form method="POST" action="{{ route('admin.social.destroy',$link) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-xs text-red-400 hover:text-red-300">Delete</button></form>
            </div></td>
        </tr>
        @empty
        <tr><td colspan="5" class="py-10 text-center text-gray-600">No links.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
