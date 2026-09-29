@extends('layouts.recruiter-preview')
@section('title', 'Emmanuel Tokpah — Recruiter View')

@section('content')
<div style="width:min(100%, 1180px); margin:0 auto; padding: 3.5rem 20px 5rem; display:flex; flex-direction:column; gap:3rem;">

    {{-- ═══ PROFILE HEADER ═══════════════════════════════ --}}
    <section class="glass-card p-8 flex flex-col sm:flex-row items-center sm:items-start gap-8">
        {{-- Avatar --}}
        <div style="flex-shrink:0">
            @if($profile && $profile->avatar)
            <img src="{{ $profile->avatarUrl('large') }}"
                alt="{{ $profile->name }}"
                style="width:120px;height:120px;border-radius:50%;object-fit:cover;object-position:center;border:3px solid var(--primary);box-shadow:0 0 30px var(--primary-glow)">
            @else
            <div style="width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;color:#fff">ET</div>
            @endif
        </div>
        {{-- Info --}}
        <div style="flex:1;min-width:0">
            <h1 style="font-family:'Syne',sans-serif;font-size:clamp(1.6rem,4vw,2.2rem);font-weight:800;color:var(--text);margin-bottom:0.3rem">
                {{ $profile->name ?? 'Emmanuel Tokpah' }}
            </h1>
            <p style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:600;background:linear-gradient(135deg,var(--primary),var(--secondary));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:0.75rem">
                {{ $profile->title ?? 'Software Developer & Information Systems Student' }}
            </p>
            <p style="font-size:0.9rem;color:var(--text-muted);line-height:1.7;max-width:560px;margin-bottom:1rem">
                {{ $profile?->bio_short ?? $profile?->bio ?? 'Software developer building practical business and technology systems.' }}
            </p>
            {{-- Contact row --}}
            <div style="display:flex;flex-wrap:wrap;gap:0.75rem 1.5rem">
                @foreach([
                ['✉', $profile->email ?? 'emmanueltokpah94@gmail.com', 'mailto:'.($profile->email??'')],
                ['📞', $profile->phone ?? '+250 792 406 443', 'tel:'.($profile->phone??'')],
                ['📍', $profile->location ?? 'Kigali, Rwanda', '#'],
                ] as [$icon, $value, $href])
                <a href="{{ $href }}" style="display:flex;align-items:center;gap:0.4rem;font-size:0.85rem;color:var(--text-muted);text-decoration:none;transition:color 0.15s"
                    onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                    <span>{{ $icon }}</span><span>{{ $value }}</span>
                </a>
                @endforeach
            </div>
            {{-- Action buttons --}}
            <div style="display:flex;flex-wrap:wrap;gap:0.75rem;margin-top:1.25rem">
                <a href="{{ route('cv.center') }}" class="btn-primary" style="font-size:0.85rem;padding:0.6rem 1.3rem">
                    <svg style="width:1rem;height:1rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download CV
                </a>
                <a href="{{ route('resume') }}" class="btn-outline-solid" style="font-size:0.85rem;padding:0.6rem 1.3rem">
                    <svg style="width:1rem;height:1rem" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    View Resume
                </a>
                @if($profile && $profile->github_url)
                <a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="btn-outline-solid" style="font-size:0.85rem;padding:0.6rem 1.3rem">
                    GitHub ↗
                </a>
                @endif
                @if($profile && $profile->linkedin_url)
                <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" class="btn-outline-solid" style="font-size:0.85rem;padding:0.6rem 1.3rem">
                    LinkedIn ↗
                </a>
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ CAREER CENTER ═══════════════════════════════════ --}}
    @if($careerTracks->isNotEmpty())
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:2px;display:inline-block"></span>
            Career Center
        </h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1rem">
            @foreach($careerTracks as $careerTrack)
            @php
            $track = $careerTrack->published;
            @endphp
            <article class="glass-card" style="padding:1.25rem">
                <p style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--secondary)">{{ data_get($track, 'category') }}</p>
                <h3 style="margin-top:.35rem;font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--text)">{{ data_get($track, 'title') }}</h3>
                <p style="margin-top:.55rem;font-size:.84rem;line-height:1.6;color:var(--text-muted)">{{ data_get($track, 'description') }}</p>
                <a href="{{ route('career.show', $careerTrack->slug) }}" class="btn-outline-solid" style="display:inline-flex;margin-top:1rem;font-size:.8rem;padding:.5rem .85rem">Explore Career Path</a>
            </article>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ RESUME CENTER ═══════════════════════════════════ --}}
    @if($resumeTypes->isNotEmpty())
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--accent),var(--primary));border-radius:2px;display:inline-block"></span>
            Resume Center
        </h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1rem">
            @foreach($resumeTypes as $resumeType)
            @php
            $resume = $resumeType->published;
            @endphp
            <article class="glass-card" style="padding:1.15rem;display:flex;align-items:center;justify-content:space-between;gap:1rem">
                <div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:.92rem;font-weight:700;color:var(--text)">{{ data_get($resume, 'label') }}</h3>
                    <p style="margin-top:.3rem;font-size:.8rem;color:var(--text-muted)">{{ data_get($resume, 'headline') }}</p>
                </div>
                <a href="{{ route('cv.download', $resumeType->type_key) }}" class="btn-primary" style="flex-shrink:0;font-size:.78rem;padding:.5rem .75rem">Download</a>
            </article>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ SKILLS ═════════════════════════════════════════ --}}
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:2px;display:inline-block"></span>
            Skills & Competencies
        </h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">
            @foreach($skills as $category => $catSkills)
            <div class="glass-card" style="padding:1.25rem">
                <div style="font-family:'Syne',sans-serif;font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:var(--secondary);margin-bottom:0.9rem">
                    {{ \App\Models\Skill::categoryIcons()[$category] ?? '⚙️' }}
                    {{ \App\Models\Skill::categoryLabels()[$category] ?? ucfirst($category) }}
                </div>
                <div style="display:flex;flex-direction:column;gap:0.55rem">
                    @foreach($catSkills as $skill)
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.25rem">
                            <span style="color:var(--text);font-weight:500">{{ $skill->name }}</span>
                            <span style="color:var(--primary);font-weight:700;font-size:0.75rem">{{ $skill->proficiency }}%</span>
                        </div>
                        <div class="skill-track">
                            <div class="skill-fill" data-width="{{ $skill->proficiency }}" style="width:0%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ═══ EXPERIENCE ══════════════════════════════════════ --}}
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--primary),var(--secondary));border-radius:2px;display:inline-block"></span>
            Work Experience
        </h2>
        <div style="display:flex;flex-direction:column;gap:0.9rem">
            @foreach($experiences as $exp)
            <div class="glass-card" style="padding:1.25rem 1.5rem;display:flex;gap:1rem;align-items:flex-start">
                <div style="width:40px;height:40px;border-radius:0.6rem;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    @if($exp->type === 'work') <span style="font-size:1.1rem">💼</span>
                    @elseif($exp->type === 'freelance') <span style="font-size:1.1rem">🚀</span>
                    @else <span style="font-size:1.1rem">🤝</span>
                    @endif
                </div>
                <div style="flex:1;min-width:0">
                    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.5rem;margin-bottom:0.3rem">
                        <div>
                            <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.95rem;color:var(--text)">{{ $exp->title }}</span>
                            <span style="font-size:0.85rem;color:var(--text-muted)"> · {{ $exp->company }}</span>
                            @if($exp->location)<span style="font-size:0.82rem;color:var(--text-dim)">, {{ $exp->location }}</span>@endif
                        </div>
                        <span style="font-size:0.75rem;font-weight:600;padding:0.2rem 0.75rem;border-radius:9999px;background:rgba(37,99,235,0.10);color:var(--primary);white-space:nowrap;border:1px solid rgba(37,99,235,0.2)">{{ $exp->period }}</span>
                    </div>
                    <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.6">{{ $exp->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ═══ EDUCATION ═══════════════════════════════════════ --}}
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--accent),var(--primary));border-radius:2px;display:inline-block"></span>
            Education
        </h2>
        <div style="display:flex;flex-direction:column;gap:0.9rem">
            @foreach($educations as $edu)
            <div class="glass-card" style="padding:1.25rem 1.5rem;display:flex;gap:1rem;align-items:flex-start">
                <div style="width:40px;height:40px;border-radius:0.6rem;background:linear-gradient(135deg,var(--accent),var(--primary));display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.1rem">🎓</div>
                <div style="flex:1;min-width:0">
                    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.5rem;margin-bottom:0.3rem">
                        <div>
                            <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.95rem;color:var(--text)">{{ $edu->degree }}</span>
                            <span style="font-size:0.85rem;color:var(--text-muted)"> · {{ $edu->institution }}</span>
                        </div>
                        <span style="font-size:0.75rem;font-weight:600;padding:0.2rem 0.75rem;border-radius:9999px;background:rgba(139,92,246,0.10);color:var(--accent);white-space:nowrap;border:1px solid rgba(139,92,246,0.2)">{{ $edu->period }}</span>
                    </div>
                    @if($edu->description)
                    <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.6">{{ $edu->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ═══ PROJECTS ════════════════════════════════════════ --}}
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--secondary),var(--accent));border-radius:2px;display:inline-block"></span>
            Projects
        </h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.1rem">
            @foreach($projects as $project)
            <div class="glass-card" style="overflow:hidden;display:flex;flex-direction:column">
                @if($project->cover_image)
                <img src="{{ Str::startsWith($project->cover_image,'projects/') ? asset('storage/'.$project->cover_image) : asset($project->cover_image) }}"
                    alt="{{ $project->title }}"
                    style="width:100%;height:160px;object-fit:cover">
                @else
                <div style="height:80px;background:linear-gradient(135deg,rgba(37,99,235,0.15),rgba(139,92,246,0.15));display:flex;align-items:center;justify-content:center;font-size:2rem">🚀</div>
                @endif
                <div style="padding:1.1rem 1.25rem;flex:1;display:flex;flex-direction:column;gap:0.5rem">
                    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.4rem">
                        <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.95rem;color:var(--text)">{{ $project->title }}</span>
                        <span style="font-size:0.72rem;font-weight:700;padding:0.18rem 0.65rem;border-radius:9999px;border:1px solid;{{ $project->status_badge_class }}">{{ $project->status_label }}</span>
                    </div>
                    <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.6;flex:1">{{ $project->short_description ?? Str::limit($project->description,100) }}</p>
                    <div style="display:flex;flex-wrap:wrap;gap:0.35rem;margin-top:0.25rem">
                        @foreach(array_slice($project->tech_array,0,4) as $tech)
                        <span style="font-size:0.7rem;padding:0.18rem 0.6rem;border-radius:9999px;background:rgba(6,182,212,0.10);color:var(--secondary);border:1px solid rgba(6,182,212,0.22)">{{ $tech }}</span>
                        @endforeach
                    </div>
                    <div style="display:flex;gap:0.5rem;margin-top:0.6rem">
                        <a href="{{ route('projects.show', $project->slug) }}"
                            style="flex:1;display:flex;align-items:center;justify-content:center;gap:0.3rem;font-size:0.78rem;font-weight:600;padding:0.45rem 0;border-radius:0.5rem;background:var(--primary-glow);color:var(--primary);border:1px solid rgba(37,99,235,0.25);text-decoration:none;transition:all 0.15s"
                            onmouseover="this.style.background='var(--primary)';this.style.color='#fff'"
                            onmouseout="this.style.background='var(--primary-glow)';this.style.color='var(--primary)'">
                            View Details
                        </a>
                        @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank"
                            style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:0.5rem;border:1px solid var(--border);color:var(--text-muted);text-decoration:none;transition:all 0.15s;font-size:0.8rem"
                            onmouseover="this.style.borderColor='var(--primary)';this.style.color='var(--primary)'"
                            onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-muted)'"
                            title="GitHub">
                            <svg style="width:1rem;height:1rem" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        @endif
                    </div>
                    @if(!$project->website_available)
                    <div style="font-size:0.72rem;color:#f59e0b;display:flex;align-items:center;gap:0.3rem">
                        <svg style="width:0.85rem;height:0.85rem;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Website Under Development
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ═══ CERTIFICATES ════════════════════════════════════ --}}
    @if($certificates->count())
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--primary),var(--accent));border-radius:2px;display:inline-block"></span>
            Certificates
        </h2>
        <div style="display:flex;flex-wrap:wrap;gap:0.85rem">
            @foreach($certificates as $cert)
            <div class="glass-card" style="display:flex;align-items:center;gap:0.85rem;padding:0.85rem 1.25rem">
                <div style="width:36px;height:36px;border-radius:0.5rem;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;flex-shrink:0">🏆</div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;color:var(--text)">{{ $cert->title }}</div>
                    <div style="font-size:0.78rem;color:var(--text-muted)">{{ $cert->issuer }} · {{ $cert->year }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ JOURNEY TIMELINE ════════════════════════════════ --}}
    @if($timeline->isNotEmpty())
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--secondary),var(--accent));border-radius:2px;display:inline-block"></span>
            Journey
        </h2>
        <div style="display:grid;gap:.75rem">
            @foreach($timeline as $entry)
            <article class="glass-card" style="padding:1rem 1.25rem;display:flex;gap:1rem;align-items:flex-start">
                <span style="min-width:3.5rem;font-weight:700;color:var(--primary)">{{ $entry->year }}</span>
                <div>
                    <h3 style="font-weight:700;color:var(--text)">{{ $entry->title }}</h3>
                    @if($entry->description)<p style="margin-top:.25rem;font-size:.84rem;line-height:1.6;color:var(--text-muted)">{{ $entry->description }}</p>@endif
                </div>
            </article>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ SOCIAL / CONTACT ═══════════════════════════════ --}}
    <section>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:800;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.6rem">
            <span style="width:28px;height:3px;background:linear-gradient(90deg,var(--secondary),var(--primary));border-radius:2px;display:inline-block"></span>
            Connect & Download
        </h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:0.85rem">
            @foreach($socialLinks as $link)
            @php
            $socGrad = [
            'github' => 'linear-gradient(135deg,#24292e,#444)',
            'linkedin' => 'linear-gradient(135deg,#0077B5,#006097)',
            'email' => 'linear-gradient(135deg,#EA4335,#C5221F)',
            'whatsapp' => 'linear-gradient(135deg,#25D366,#128C7E)',
            ][$link->platform] ?? 'linear-gradient(135deg,#6B7280,#4B5563)';
            $socIcon = ['github'=>'💻','linkedin'=>'🔗','email'=>'✉️','whatsapp'=>'💬'][$link->platform] ?? '🌐';
            @endphp
            <a href="{{ $link->url }}" target="_blank" rel="noopener"
                class="glass-card"
                style="display:flex;flex-direction:column;align-items:center;gap:0.6rem;padding:1.2rem;text-decoration:none;transition:transform 0.2s,box-shadow 0.2s"
                onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(37,99,235,0.18)'"
                onmouseout="this.style.transform='';this.style.boxShadow=''">
                <div style="width:44px;height:44px;border-radius:0.75rem;background:{{ $socGrad }};display:flex;align-items:center;justify-content:center;font-size:1.3rem;box-shadow:0 4px 12px rgba(0,0,0,0.2)">{{ $socIcon }}</div>
                <div style="text-align:center">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;color:var(--text)">{{ $link->label }}</div>
                    <div style="font-size:0.72rem;color:var(--text-dim);margin-top:0.1rem;text-transform:capitalize">{{ $link->platform }}</div>
                </div>
            </a>
            @endforeach

            {{-- CV download card --}}
            <a href="{{ route('cv.center') }}"
                class="glass-card"
                style="display:flex;flex-direction:column;align-items:center;gap:0.6rem;padding:1.2rem;text-decoration:none;transition:transform 0.2s,box-shadow 0.2s"
                onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(37,99,235,0.18)'"
                onmouseout="this.style.transform='';this.style.boxShadow=''">
                <div style="width:44px;height:44px;border-radius:0.75rem;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;font-size:1.3rem;box-shadow:0 4px 12px rgba(0,0,0,0.2)">📄</div>
                <div style="text-align:center">
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;color:var(--text)">Download CV</div>
                    <div style="font-size:0.72rem;color:var(--text-dim);margin-top:0.1rem">6 versions</div>
                </div>
            </a>
        </div>
    </section>

</div>

{{-- Skill bar observer --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var bars = document.querySelectorAll('.skill-fill[data-width]');
        if (!('IntersectionObserver' in window)) {
            bars.forEach(function(b) {
                b.style.width = b.dataset.width + '%';
            });
            return;
        }
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    setTimeout(function() {
                        e.target.style.width = e.target.dataset.width + '%';
                    }, 200);
                    obs.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.3
        });
        bars.forEach(function(b) {
            obs.observe(b);
        });
    });
</script>

@endsection