@extends('layouts.app')
@section('title', 'Resume | Emmanuel Tokpah')
@section('description', 'Professional resume of Emmanuel Tokpah — Software Developer, Kigali, Rwanda.')

@section('content')
<div style="padding:3rem 0 5rem">
    <div class="container" style="max-width:860px">

        {{-- Header --}}
        <div class="section-header" style="margin-top:1rem">
            <div class="section-pill">One-Page Resume</div>
            <h1 class="section-title">Professional <span class="grad-text">Resume</span></h1>
        </div>

        {{-- Action buttons --}}
        <div style="display:flex;flex-wrap:wrap;gap:0.75rem;justify-content:center;margin-bottom:2.5rem" class="no-print">
            <a href="{{ route('cv.center') }}" class="btn btn-primary btn-lg">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download CV
            </a>
            <button onclick="window.print()" class="btn btn-secondary btn-lg">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print PDF
            </button>
        </div>

        {{-- Resume card --}}
        <div class="glow-card" style="padding:2.5rem 2.75rem;overflow:hidden">

            {{-- Profile header --}}
            <div style="display:flex;flex-wrap:wrap;gap:1.5rem;align-items:flex-start;padding-bottom:1.75rem;border-bottom:2px solid var(--border);margin-bottom:2rem">
                @if($profile && $profile->avatar)
                <img src="{{ $profile->avatarUrl('large') }}"
                    alt="{{ $profile->name }}"
                    style="width:88px;height:88px;border-radius:var(--radius-lg);object-fit:cover;object-position:center;border:2px solid var(--border);flex-shrink:0">
                @endif
                <div style="flex:1;min-width:200px">
                    <h2 style="font-family:'Syne',sans-serif;font-size:1.9rem;font-weight:800;color:var(--text);line-height:1.1">{{ $profile->name ?? 'Emmanuel Tokpah' }}</h2>
                    <p class="grad-text" style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;margin:0.35rem 0 0.75rem">{{ $profile->title ?? 'Software Developer & Information Systems Student' }}</p>
                    <div style="display:flex;flex-wrap:wrap;gap:1rem 2rem">
                        @foreach([['✉',$profile->email??'emmanueltokpah94@gmail.com'],['📞',$profile->phone??'+250 792 406 443'],['📍',$profile->location??'Kigali, Rwanda']] as [$icon,$val])
                        <span style="font-size:0.82rem;color:var(--text-muted);display:flex;align-items:center;gap:0.35rem">{{ $icon }} {{ $val }}</span>
                        @endforeach
                        @if($profile->github_url)<span style="font-size:0.82rem;color:var(--primary)">⌥ GitHub</span>@endif
                        @if($profile->linkedin_url)<span style="font-size:0.82rem;color:var(--primary)">in LinkedIn</span>@endif
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            @if($profile->bio)
            <div style="margin-bottom:2rem">
                <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.75rem">
                    <div style="width:24px;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:2px"></div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--text);text-transform:uppercase;letter-spacing:0.06em">Professional Summary</h3>
                </div>
                <p style="font-size:0.9rem;color:var(--text-muted);line-height:1.75">{{ $profile->bio }}</p>
            </div>
            @endif

            {{-- Experience --}}
            <div style="margin-bottom:2rem">
                <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:1rem">
                    <div style="width:24px;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:2px"></div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--text);text-transform:uppercase;letter-spacing:0.06em">Work Experience</h3>
                </div>
                <div style="position:relative;padding-left:1.75rem">
                    <div style="position:absolute;left:0.35rem;top:0.5rem;bottom:0.5rem;width:2px;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></div>
                    <div style="display:flex;flex-direction:column;gap:1.5rem">
                        @foreach($experiences as $exp)
                        <div style="position:relative">
                            <div style="position:absolute;left:-1.4rem;top:0.35rem;width:10px;height:10px;border-radius:50%;background:var(--primary);border:2px solid var(--bg)"></div>
                            <div style="display:flex;flex-wrap:wrap;align-items:flex-start;justify-content:space-between;gap:0.5rem;margin-bottom:0.3rem">
                                <div>
                                    <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.95rem;color:var(--text)">{{ $exp->title }}</span>
                                    <span style="font-size:0.85rem;color:var(--text-muted)"> · {{ $exp->company }}</span>
                                    @if($exp->location)<span style="font-size:0.82rem;color:var(--text-dim)">, {{ $exp->location }}</span>@endif
                                </div>
                                <span style="font-size:0.72rem;font-weight:700;padding:0.2rem 0.75rem;border-radius:9999px;background:rgba(37,99,235,0.09);color:var(--primary);border:1px solid rgba(37,99,235,0.20);white-space:nowrap">{{ $exp->period }}</span>
                            </div>
                            <p style="font-size:0.855rem;color:var(--text-muted);line-height:1.7">{{ $exp->description }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Education --}}
            <div style="margin-bottom:2rem">
                <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:1rem">
                    <div style="width:24px;height:3px;background:linear-gradient(90deg,var(--accent),var(--primary));border-radius:2px"></div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--text);text-transform:uppercase;letter-spacing:0.06em">Education</h3>
                </div>
                <div style="display:flex;flex-direction:column;gap:1rem">
                    @foreach($educations as $edu)
                    <div style="display:flex;flex-wrap:wrap;align-items:flex-start;justify-content:space-between;gap:0.5rem">
                        <div>
                            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.95rem;color:var(--text)">{{ $edu->degree }}</div>
                            <div style="font-size:0.85rem;color:var(--text-muted)">{{ $edu->institution }}</div>
                        </div>
                        <span style="font-size:0.72rem;font-weight:700;padding:0.2rem 0.75rem;border-radius:9999px;background:rgba(139,92,246,0.09);color:var(--accent);border:1px solid rgba(139,92,246,0.20);white-space:nowrap">{{ $edu->period }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Skills --}}
            <div style="margin-bottom:2rem">
                <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:1rem">
                    <div style="width:24px;height:3px;background:linear-gradient(90deg,var(--secondary),var(--primary));border-radius:2px"></div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--text);text-transform:uppercase;letter-spacing:0.06em">Skills</h3>
                </div>
                @php $grouped = $skills->groupBy('category'); @endphp
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem">
                    @foreach($grouped as $cat => $catSkills)
                    <div>
                        <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-dim);margin-bottom:0.5rem">
                            {{ \App\Models\Skill::categoryLabels()[$cat] ?? ucfirst($cat) }}
                        </div>
                        <div style="display:flex;flex-wrap:wrap;gap:0.35rem">
                            @foreach($catSkills as $skill)
                            <span class="skill-tag">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Projects --}}
            @if($projects->count())
            <div style="margin-bottom:2rem">
                <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:1rem">
                    <div style="width:24px;height:3px;background:linear-gradient(90deg,var(--primary),var(--accent));border-radius:2px"></div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--text);text-transform:uppercase;letter-spacing:0.06em">Key Projects</h3>
                </div>
                <div style="display:flex;flex-direction:column;gap:0.9rem">
                    @foreach($projects->take(4) as $project)
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;justify-content:space-between;align-items:flex-start">
                        <div style="flex:1;min-width:200px">
                            <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.9rem;color:var(--text)">{{ $project->title }}</span>
                            <p style="font-size:0.82rem;color:var(--text-muted);margin-top:0.2rem;line-height:1.6">{{ Str::limit($project->short_description ?? $project->description, 120) }}</p>
                            <div style="display:flex;flex-wrap:wrap;gap:0.3rem;margin-top:0.35rem">
                                @foreach(array_slice($project->tech_array,0,4) as $t)
                                <span class="stack-tag">{{ $t }}</span>
                                @endforeach
                            </div>
                        </div>
                        @php $sc = ['live'=>'status-live','published'=>'status-published','in_development'=>'status-dev','testing'=>'status-testing'][$project->status] ?? 'status-draft'; @endphp
                        <span class="status-badge {{ $sc }}" style="position:static;display:inline-flex">{{ $project->status_label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Certificates --}}
            @if($certificates->count())
            <div>
                <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.75rem">
                    <div style="width:24px;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:2px"></div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:0.95rem;font-weight:700;color:var(--text);text-transform:uppercase;letter-spacing:0.06em">Certifications</h3>
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:0.75rem">
                    @foreach($certificates as $cert)
                    <div style="display:flex;align-items:center;gap:0.75rem;padding:0.65rem 1rem;background:var(--bg-alt);border:1px solid var(--border);border-radius:var(--radius)">
                        <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.85rem;flex-shrink:0">🏆</div>
                        <div>
                            <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;color:var(--text)">{{ $cert->title }}</div>
                            <div style="font-size:0.75rem;color:var(--text-muted)">{{ $cert->issuer }} · {{ $cert->year }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    obs.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.09
        });
        document.querySelectorAll('.reveal').forEach(function(e) {
            obs.observe(e);
        });
    });
</script>
@endsection