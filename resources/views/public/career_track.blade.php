@extends('layouts.app')
@section('title', $content['title'].' | Career Center')
@section('description', $content['description'])

@section('content')
@if($previewDraft)
<div style="padding:9px 16px;text-align:center;background:#0F172A;color:#fff;font-size:12px;font-weight:700">Draft Preview · Not Published</div>
@endif
<section class="sec">
    <div class="container" style="max-width:1000px">
        <a href="{{ route('home') }}#career-center" class="s-pill" style="color:var(--b2);border-color:var(--b5);background:var(--b7)">← Career Center</a>

        <header style="padding:32px 0 28px">
            <div class="pill">{{ $content['category'] }}</div>
            <h1 style="font-size:clamp(2rem,5vw,3.4rem);margin:0 0 12px">{{ $content['title'] }}</h1>
            <p style="max-width:720px;color:var(--t3);font-size:1.05rem;line-height:1.7">{{ $content['description'] }}</p>
            @if($resumeType)
            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:22px">
                <a href="{{ route('cv.preview', $resumeType->type_key) }}" target="_blank" rel="noopener" class="btn btn-s">View Related Resume</a>
                <a href="{{ route('cv.download', $resumeType->type_key) }}" class="btn btn-p">Download Related Resume</a>
            </div>
            @endif
        </header>

        @if($featuredSkills->isNotEmpty())
        <section class="sec-alt" style="padding:24px;border-radius:14px;margin-bottom:24px">
            <h2 style="font-size:1.4rem;margin-bottom:16px">Featured Skills</h2>
            <div style="display:flex;flex-wrap:wrap;gap:8px">
                @foreach($featuredSkills as $skill)
                <span class="chip" style="background:var(--b7);color:var(--b2);border-color:var(--b5)">{{ $skill->name }}</span>
                @endforeach
            </div>
        </section>
        @endif

        @if($featuredProjects->isNotEmpty())
        <section>
            <h2 style="font-size:1.4rem;margin-bottom:16px">Featured Projects</h2>
            <div class="proj-grid">
                @foreach($featuredProjects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="pcard">
                    <div class="pcov">
                        @if($project->cover_image)
                        <img src="{{ Str::startsWith($project->cover_image, 'projects/') ? asset('storage/'.$project->cover_image) : asset($project->cover_image) }}" alt="{{ $project->title }}">
                        @else
                        <div class="pcov-empty">🚀</div>
                        @endif
                    </div>
                    <div class="pbody">
                        <h3 class="ptitle">{{ $project->title }}</h3>
                        <p class="pdesc">{{ $project->short_description ?? $project->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</section>
@endsection