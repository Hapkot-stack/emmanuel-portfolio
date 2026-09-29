@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('admin-content')
<div class="space-y-6">

    {{-- Welcome --}}
    <div class="admin-card bg-gradient-to-br from-blue-600/20 to-cyan-600/10 border-blue-500/20">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white">Welcome back, Emmanuel 👋</h2>
                <p class="text-sm text-gray-400 mt-1">Your portfolio is live and looking great.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('home') }}" target="_blank" class="btn-outline text-xs px-4 py-2">View Site ↗</a>
                <a href="{{ route('cv.center') }}" target="_blank" class="btn-primary text-xs px-4 py-2">CV Center ↗</a>
            </div>
        </div>
    </div>

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        @php
        $statCards = [
            ['label'=>'Skills',       'value'=>$stats['skills'],       'color'=>'from-blue-600 to-blue-800',    'route'=>'admin.skills.index'],
            ['label'=>'Projects',     'value'=>$stats['projects'],     'color'=>'from-cyan-600 to-cyan-800',    'route'=>'admin.projects.index'],
            ['label'=>'Experiences',  'value'=>$stats['experiences'],  'color'=>'from-violet-600 to-violet-800','route'=>'admin.experience.index'],
            ['label'=>'Education',    'value'=>$stats['educations'],   'color'=>'from-emerald-600 to-emerald-800','route'=>'admin.education.index'],
            ['label'=>'Certificates', 'value'=>$stats['certificates'], 'color'=>'from-orange-600 to-orange-800','route'=>'admin.certificates.index'],
        ];
        @endphp
        @foreach($statCards as $s)
        <a href="{{ route($s['route']) }}" class="admin-card flex flex-col items-center justify-center py-6 hover:border-white/20 hover:-translate-y-0.5 transition-all">
            <div class="text-4xl font-extrabold font-display bg-gradient-to-br {{ $s['color'] }} bg-clip-text text-transparent">{{ $s['value'] }}</div>
            <div class="text-xs text-gray-500 mt-1 uppercase tracking-widest">{{ $s['label'] }}</div>
        </a>
        @endforeach
    </div>

    {{-- Quick actions --}}
    <div class="admin-card">
        <h3 class="font-semibold text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('admin.skills.create') }}"       class="glass px-4 py-3 text-sm text-center hover:bg-white/10 transition-all rounded-xl">+ Add Skill</a>
            <a href="{{ route('admin.projects.create') }}"     class="glass px-4 py-3 text-sm text-center hover:bg-white/10 transition-all rounded-xl">+ Add Project</a>
            <a href="{{ route('admin.experience.create') }}"   class="glass px-4 py-3 text-sm text-center hover:bg-white/10 transition-all rounded-xl">+ Add Experience</a>
            <a href="{{ route('admin.certificates.create') }}" class="glass px-4 py-3 text-sm text-center hover:bg-white/10 transition-all rounded-xl">+ Add Certificate</a>
        </div>
    </div>

    {{-- CV quick links --}}
    <div class="admin-card">
        <h3 class="font-semibold text-white mb-4">CV Generator — Quick Download</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach(['developer'=>['💻','Developer'],'ngo'=>['🌍','NGO'],'data-officer'=>['📊','Data Officer'],'ict-officer'=>['🖥️','ICT Officer']] as $type=>$info)
            <a href="{{ route('cv.download', $type) }}" class="glass px-4 py-3 text-sm text-center hover:bg-white/10 transition-all rounded-xl flex flex-col items-center gap-1">
                <span class="text-xl">{{ $info[0] }}</span>
                <span class="text-gray-300">{{ $info[1] }} CV</span>
            </a>
            @endforeach
        </div>
    </div>

</div>
@endsection
