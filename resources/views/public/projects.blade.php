@extends('layouts.app')
@section('title', 'Projects | Emmanuel Tokpah')
@section('description', 'Software projects, platforms, and systems built by Emmanuel Tokpah.')

@section('content')
<div style="padding:3rem 0 5rem">
    <div class="container">

        <div class="section-header" style="margin-top:1rem">
            <div class="section-pill">Portfolio</div>
            <h1 class="section-title">All <span class="grad-text">Projects</span></h1>
            <p class="section-sub">Software products, platforms, and systems built to solve real-world problems.</p>
        </div>

        {{-- Filter hint --}}
        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;justify-content:center;margin-bottom:2.5rem">
            @foreach(['All','Live','In Development','Testing','Archived'] as $filter)
            <span style="font-size:0.78rem;font-weight:600;padding:0.3rem 0.9rem;border-radius:9999px;background:var(--bg-alt);border:1px solid var(--border);color:var(--text-muted);cursor:default">{{ $filter }}</span>
            @endforeach
        </div>

        <div class="projects-grid">
            @forelse($projects as $project)
            @php
            $sc = ['live'=>'status-live','published'=>'status-published','in_development'=>'status-dev','testing'=>'status-testing','archived'=>'status-archived','draft'=>'status-draft'][$project->status] ?? 'status-draft';
            @endphp
            <div class="project-card">

                {{-- Cover --}}
                <div class="project-cover">
                    @if($project->cover_image)
                        <img src="{{ Str::startsWith($project->cover_image,'projects/') ? asset('storage/'.$project->cover_image) : asset($project->cover_image) }}"
                             alt="{{ $project->title }}">
                    @else
                        <div class="project-cover-empty">🚀</div>
                    @endif
                    <span class="status-badge {{ $sc }}">{{ $project->status_label }}</span>
                    @if($project->featured)
                    <span class="status-badge status-published" style="left:auto;right:0.75rem">★ Featured</span>
                    @endif
                </div>

                {{-- Body --}}
                <div class="project-body">
                    <h3 class="project-title">{{ $project->title }}</h3>
                    <p class="project-desc">{{ $project->short_description ?? $project->description }}</p>

                    @if($project->progress > 0 && $project->progress < 100)
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:0.72rem;color:var(--text-muted);margin-bottom:0.3rem">
                            <span>Progress</span><span style="font-weight:700;color:var(--primary)">{{ $project->progress }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" data-w="{{ $project->progress }}" style="width:0%"></div>
                        </div>
                    </div>
                    @endif

                    <div class="project-stack">
                        @foreach(array_slice($project->tech_array,0,5) as $t)
                        <span class="stack-tag">{{ $t }}</span>
                        @endforeach
                    </div>

                    @if(!$project->website_available)
                    <div class="under-dev">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Website Under Development
                    </div>
                    @endif

                    <div class="project-actions">
                        <a href="{{ route('projects.show',$project->slug) }}" class="btn btn-primary btn-sm">Case Study</a>
                        @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn btn-secondary btn-sm">
                            <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                            GitHub
                        </a>
                        @endif
                        @if($project->website_available && $project->website_url)
                        <a href="{{ $project->website_url }}" target="_blank" class="btn btn-secondary btn-sm">Live ↗</a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:4rem;color:var(--text-muted)">
                No published projects yet.
            </div>
            @endforelse
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
    var obs=new IntersectionObserver(function(entries){ entries.forEach(function(e){ if(e.isIntersecting){ setTimeout(function(){ e.target.style.width=e.target.dataset.w+'%'; },150); obs.unobserve(e.target); } }); },{threshold:0.3});
    document.querySelectorAll('.progress-fill[data-w]').forEach(function(b){ b.style.width='0%'; obs.observe(b); });
});
</script>
@endsection
