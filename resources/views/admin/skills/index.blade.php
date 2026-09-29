@extends('layouts.admin')
@section('title','Skills')
@section('page-title','Skills Management')
@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-400">{{ $skills->flatten()->count() }} total skills</p>
    <a href="{{ route('admin.skills.create') }}" class="btn-primary text-sm">+ Add Skill</a>
</div>
@foreach($skills as $cat => $catSkills)
<div class="admin-card mb-5">
    <h3 class="font-semibold text-white capitalize mb-4 flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-blue-500"></span>{{ $cat }}
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-white/5 text-left text-xs text-gray-500 uppercase tracking-wider">
                <th class="pb-2 pr-4">Name</th><th class="pb-2 pr-4">Proficiency</th><th class="pb-2 pr-4">Featured</th><th class="pb-2 pr-4">Order</th><th class="pb-2">Actions</th>
            </tr></thead>
            <tbody class="divide-y divide-white/5">
            @foreach($catSkills as $skill)
            <tr>
                <td class="py-3 pr-4 text-white font-medium">{{ $skill->name }}</td>
                <td class="py-3 pr-4">
                    <div class="flex items-center gap-2">
                        <div class="flex-1 skill-bar-track w-24"><div class="skill-bar-fill" data-width="{{ $skill->proficiency }}" style="width:0%"></div></div>
                        <span class="text-cyan-400 text-xs font-bold">{{ $skill->proficiency }}%</span>
                    </div>
                </td>
                <td class="py-3 pr-4"><span class="{{ $skill->featured ? 'text-emerald-400' : 'text-gray-600' }} text-xs font-semibold">{{ $skill->featured ? '✓ Yes' : 'No' }}</span></td>
                <td class="py-3 pr-4 text-gray-500">{{ $skill->sort_order }}</td>
                <td class="py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.skills.edit', $skill) }}" class="text-xs text-blue-400 hover:text-blue-300">Edit</a>
                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete this skill?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
@endsection
