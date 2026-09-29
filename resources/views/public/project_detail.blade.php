@extends('layouts.app')
@section('title', $project->title . ' | Emmanuel Tokpah')
@section('description', $project->short_description ?? Str::limit($project->description, 160))

@section('content')
<div style="padding:3rem 0 5rem">
    <div class="container" style="max-width:980px">

        {{-- Breadcrumb --}}
        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--text-muted);margin-bottom:2rem">
            <a href="{{ route('home') }}" style="color:var(--text-muted);transition:color 0.15s" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">Home</a>
            <span style="color:var(--text-dim)">›</span>
            <a href="{{ route('projects') }}" style="color:var(--text-muted);transition:color 0.15s" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">Projects</a>
            <span style="color:var(--text-dim)">›</span>
            <span style="color:var(--text)">{{ $project->title }}</span>
        </div>

        {{-- Hero --}}
        <div style="margin-bottom:2rem">
            @php $sc = ['live'=>'status-live','published'=>'status-published','in_development'=>'status-dev','testing'=>'status-testing','archived'=>'status-archived'][$project->status] ?? 'status-draft'; @endphp
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:0.75rem;margin-bottom:1rem">
                <span class="status-badge {{ $sc }}" style="position:static;display:inline-flex">{{ $project->status_label }}</span>
                @if($project->progress > 0)
                <span style="font-size:0.78rem;color:var(--text-dim)">{{ $project->progress }}% complete</span>
                @endif
            </div>

            <h1 style="font-family:'Syne',sans-serif;font-size:clamp(1.8rem,4vw,3rem);font-weight:800;color:var(--text);line-height:1.1;margin-bottom:1rem">{{ $project->title }}</h1>
            <p style="font-size:1.05rem;color:var(--text-muted);line-height:1.75;max-width:680px;margin-bottom:1.5rem">{{ $project->short_description ?? $project->description }}</p>

            {{-- Actions --}}
            <div style="display:flex;flex-wrap:wrap;gap:0.65rem">
                @if($project->github_url)
                <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn btn-primary">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                    View Code
                </a>
                @endif
                @if($project->website_available && $project->website_url)
                <a href="{{ $project->website_url }}" target="_blank" class="btn btn-gradient">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Live Site
                </a>
                @elseif(!$project->website_available)
                <span class="btn btn-secondary" style="cursor:default;opacity:0.7">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Website Under Development
                </span>
                @endif
                @if($project->demo_video_url)
                <a href="{{ $project->demo_video_url }}" target="_blank" class="btn btn-secondary">▶ Demo Video</a>
                @endif
            </div>
        </div>

        {{-- Cover image --}}
        @if($project->cover_image)
        <div style="border-radius:var(--radius-xl);overflow:hidden;margin-bottom:2.5rem;border:1px solid var(--border);box-shadow:var(--shadow)">
            <img src="{{ Str::startsWith($project->cover_image,'projects/') ? asset('storage/'.$project->cover_image) : asset($project->cover_image) }}"
                 alt="{{ $project->title }}" style="width:100%;max-height:420px;object-fit:cover">
        </div>
        @endif

        {{-- Tech stack --}}
        <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:2.5rem">
            @foreach($project->tech_array as $tech)
            <span class="stack-tag" style="font-size:0.82rem;padding:0.3rem 0.85rem">{{ $tech }}</span>
            @endforeach
        </div>

        <div style="display:grid;grid-template-columns:1fr;gap:2rem">
            @media(min-width:900px){ style="grid-template-columns:1fr 320px" }

            {{-- Main content --}}
            <div style="display:flex;flex-direction:column;gap:1.5rem">

                {{-- Overview --}}
                <div class="glow-card" style="padding:1.75rem">
                    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.9rem">
                        <div style="width:20px;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:2px"></div>
                        <h2 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text)">Overview</h2>
                    </div>
                    <p style="font-size:0.9rem;color:var(--text-muted);line-height:1.75">{{ $project->description }}</p>
                </div>

                @if($project->problem)
                <div class="glow-card" style="padding:1.75rem">
                    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.9rem">
                        <div style="width:20px;height:3px;background:linear-gradient(90deg,#ef4444,#f97316);border-radius:2px"></div>
                        <h2 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text)">Problem</h2>
                    </div>
                    <p style="font-size:0.9rem;color:var(--text-muted);line-height:1.75">{{ $project->problem }}</p>
                </div>
                @endif

                @if($project->solution)
                <div class="glow-card" style="padding:1.75rem">
                    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.9rem">
                        <div style="width:20px;height:3px;background:linear-gradient(90deg,var(--success),#34d399);border-radius:2px"></div>
                        <h2 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text)">Solution</h2>
                    </div>
                    <p style="font-size:0.9rem;color:var(--text-muted);line-height:1.75">{{ $project->solution }}</p>
                </div>
                @endif

                @if($project->features && count((array)$project->features))
                <div class="glow-card" style="padding:1.75rem">
                    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.9rem">
                        <div style="width:20px;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:2px"></div>
                        <h2 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text)">Key Features</h2>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:0.6rem">
                        @foreach((array)$project->features as $feat)
                        <div style="display:flex;align-items:flex-start;gap:0.6rem">
                            <span style="width:20px;height:20px;border-radius:50%;background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.25);display:flex;align-items:center;justify-content:center;color:var(--success);font-size:0.65rem;flex-shrink:0;margin-top:0.1rem">✓</span>
                            <span style="font-size:0.855rem;color:var(--text-muted);line-height:1.55">{{ $feat }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($project->challenges)
                <div class="glow-card" style="padding:1.75rem">
                    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.9rem">
                        <div style="width:20px;height:3px;background:linear-gradient(90deg,var(--warning),#fbbf24);border-radius:2px"></div>
                        <h2 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text)">Challenges</h2>
                    </div>
                    <p style="font-size:0.9rem;color:var(--text-muted);line-height:1.75">{{ $project->challenges }}</p>
                </div>
                @endif

                @if($project->lessons_learned)
                <div class="glow-card" style="padding:1.75rem">
                    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.9rem">
                        <div style="width:20px;height:3px;background:linear-gradient(90deg,var(--accent),#a78bfa);border-radius:2px"></div>
                        <h2 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text)">Lessons Learned</h2>
                    </div>
                    <p style="font-size:0.9rem;color:var(--text-muted);line-height:1.75">{{ $project->lessons_learned }}</p>
                </div>
                @endif

                {{-- Screenshots --}}
                @if($project->screenshots->count())
                <div class="glow-card" style="padding:1.75rem">
                    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:1rem">
                        <div style="width:20px;height:3px;background:linear-gradient(90deg,var(--secondary),var(--primary));border-radius:2px"></div>
                        <h2 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text)">Screenshots</h2>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:0.75rem">
                        @foreach($project->screenshots as $ss)
                        <div style="border-radius:var(--radius);overflow:hidden;border:1px solid var(--border);background:var(--bg-alt)">
                            <img src="{{ $ss->image_url }}" alt="{{ $ss->caption ?? 'Screenshot' }}" style="width:100%;height:160px;object-fit:cover">
                            @if($ss->caption)
                            <div style="padding:0.5rem 0.75rem;font-size:0.75rem;color:var(--text-muted)">{{ $ss->caption }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Under development callout --}}
                @if(!$project->website_available)
                <div style="padding:1.75rem;background:rgba(245,158,11,0.06);border:1px solid rgba(245,158,11,0.25);border-left:4px solid var(--warning);border-radius:var(--radius-lg)">
                    <div style="display:flex;align-items:flex-start;gap:1rem">
                        <span style="font-size:2rem;flex-shrink:0">🚧</span>
                        <div>
                            <h3 style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text);margin-bottom:0.4rem">Website Under Development</h3>
                            <p style="font-size:0.875rem;color:var(--text-muted);line-height:1.65;margin-bottom:0.75rem">This project is actively being developed. The live website is not yet available.</p>
                            @if($project->roadmap && count((array)$project->roadmap))
                            <div>
                                <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-dim);margin-bottom:0.5rem">Upcoming Features:</div>
                                <div style="display:flex;flex-direction:column;gap:0.3rem">
                                    @foreach((array)$project->roadmap as $item)
                                    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--text-muted)">
                                        <span style="width:5px;height:5px;border-radius:50%;background:var(--warning);flex-shrink:0"></span>{{ $item }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- Related projects --}}
        @if($related->count())
        <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--border)">
            <h3 style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:700;color:var(--text);margin-bottom:1.25rem">Other Projects</h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem">
                @foreach($related as $rel)
                @php $rsc = ['live'=>'status-live','published'=>'status-published','in_development'=>'status-dev','testing'=>'status-testing'][$rel->status] ?? 'status-draft'; @endphp
                <a href="{{ route('projects.show',$rel->slug) }}" class="glow-card" style="display:flex;gap:0.9rem;align-items:center;padding:1rem;text-decoration:none">
                    <div style="width:48px;height:40px;border-radius:var(--radius-sm);overflow:hidden;flex-shrink:0;background:var(--bg-alt)">
                        @if($rel->cover_image)
                        <img src="{{ Str::startsWith($rel->cover_image,'projects/') ? asset('storage/'.$rel->cover_image) : asset($rel->cover_image) }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:1.1rem">🚀</div>
                        @endif
                    </div>
                    <div style="min-width:0">
                        <div style="font-family:'Syne',sans-serif;font-size:0.875rem;font-weight:700;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $rel->title }}</div>
                        <span class="status-badge {{ $rsc }}" style="position:static;display:inline-flex;margin-top:0.25rem">{{ $rel->status_label }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
