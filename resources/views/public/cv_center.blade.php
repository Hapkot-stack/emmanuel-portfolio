@extends('layouts.app')
@section('title', 'CV Center | Emmanuel Tokpah — Career Management Platform')

@section('content')
<div style="padding-top:2rem;padding-bottom:5rem">
    <div class="container">

        {{-- Header --}}
        <div class="section-header" style="margin-top:2rem">
            <div class="section-pill">Resume Center</div>
            <h1 class="section-title">Career <span class="grad-text">CV Center</span></h1>
            <p class="section-sub">All CVs are generated live from one database. Updating your profile automatically updates every version.</p>
        </div>

        {{-- Auto-updated notice --}}
        <div style="display:flex;align-items:center;gap:0.75rem;padding:1rem 1.25rem;background:rgba(6,182,212,0.07);border:1px solid rgba(6,182,212,0.22);border-radius:var(--radius);margin-bottom:2.5rem">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--secondary)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span style="font-size:0.875rem;color:var(--text-muted)">
                <strong style="color:var(--secondary)">Auto-updated:</strong>
                Edit your profile in the <a href="/cms" style="color:var(--primary);font-weight:600">Admin Panel</a> and all CVs update instantly.
                Last updated: <strong style="color:var(--text)">{{ now()->format('M Y') }}</strong>
            </span>
        </div>

        @php
        $allTracks = [
            // IT & Software
            ['type'=>'developer',    'icon'=>'💻','track'=>'IT & Software',      'color'=>'#2563EB','title'=>'Software Developer CV',       'desc'=>'Full-stack development, Laravel, PHP, MySQL, APIs, system design. Ideal for software engineering roles.'],
            ['type'=>'web',          'icon'=>'🌐','track'=>'IT & Software',      'color'=>'#0284C7','title'=>'Web Developer CV',            'desc'=>'Frontend and responsive web development using HTML, CSS, JavaScript, and UI/UX principles.'],
            ['type'=>'ngo',          'icon'=>'🌍','track'=>'NGO & Humanitarian', 'color'=>'#059669','title'=>'NGO Technology CV',           'desc'=>'Information systems for humanitarian work. Reporting, documentation, Excel, community impact.'],
            ['type'=>'data-officer', 'icon'=>'📊','track'=>'Data & Analytics',  'color'=>'#7C3AED','title'=>'Data Officer CV',             'desc'=>'Data collection, analytics, LISGIS experience, statistical reporting, Excel, documentation.'],
            ['type'=>'ict-officer',  'icon'=>'🖥️','track'=>'ICT & Systems',     'color'=>'#D97706','title'=>'ICT Officer CV',              'desc'=>'Networking, cybersecurity (Cisco), IT support, information systems management.'],
            ['type'=>'electrical',   'icon'=>'⚡','track'=>'Electrical',         'color'=>'#B45309','title'=>'Electrical Technician CV',    'desc'=>'Electrical installation, maintenance, fault diagnosis, safety procedures, residential and industrial.'],
        ];
        @endphp

        {{-- IT & Software group --}}
        <div style="margin-bottom:2.5rem">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                <div style="width:3px;height:28px;background:linear-gradient(180deg,var(--primary),var(--secondary));border-radius:2px"></div>
                <h2 style="font-family:'Syne',sans-serif;font-size:1.15rem;font-weight:700;color:var(--text)">IT & Software Track</h2>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.25rem">
                @foreach(array_filter($allTracks, fn($t) => in_array($t['track'],['IT & Software','NGO & Humanitarian','Data & Analytics','ICT & Systems'])) as $track)
                <div class="glow-card" style="overflow:hidden">
                    <div style="height:4px;background:linear-gradient(90deg,{{ $track['color'] }},{{ $track['color'] }}99)"></div>
                    <div style="padding:1.4rem">
                        <div style="display:flex;align-items:flex-start;gap:0.9rem;margin-bottom:1rem">
                            <div style="width:46px;height:46px;border-radius:12px;background:{{ $track['color'] }}18;border:1px solid {{ $track['color'] }}30;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">{{ $track['icon'] }}</div>
                            <div>
                                <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:var(--text-dim);margin-bottom:0.2rem">{{ $track['track'] }}</div>
                                <div style="font-family:'Syne',sans-serif;font-size:0.97rem;font-weight:700;color:var(--text);line-height:1.3">{{ $track['title'] }}</div>
                            </div>
                        </div>
                        <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.65;margin-bottom:0.75rem">{{ $track['desc'] }}</p>
                        <div style="font-size:0.72rem;color:var(--text-dim);margin-bottom:1rem">
                            Updated: <span style="color:var(--text-muted)">{{ now()->format('d M Y') }}</span>
                        </div>
                        <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
                            <a href="{{ route('cv.preview',$track['type']) }}" target="_blank"
                               class="btn btn-secondary btn-sm">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Preview CV
                            </a>
                            <a href="{{ route('cv.download',$track['type']) }}"
                               class="btn btn-sm" style="background:{{ $track['color'] }};color:#fff;box-shadow:0 2px 10px {{ $track['color'] }}44;flex:1;justify-content:center">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Electrical track --}}
        <div style="margin-bottom:2.5rem">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                <div style="width:3px;height:28px;background:linear-gradient(180deg,#B45309,#FDE68A);border-radius:2px"></div>
                <h2 style="font-family:'Syne',sans-serif;font-size:1.15rem;font-weight:700;color:var(--text)">Electrical Track</h2>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.25rem">
                @foreach(array_filter($allTracks, fn($t) => $t['track']==='Electrical') as $track)
                <div class="glow-card" style="overflow:hidden">
                    <div style="height:4px;background:linear-gradient(90deg,{{ $track['color'] }},{{ $track['color'] }}99)"></div>
                    <div style="padding:1.4rem">
                        <div style="display:flex;align-items:flex-start;gap:0.9rem;margin-bottom:1rem">
                            <div style="width:46px;height:46px;border-radius:12px;background:{{ $track['color'] }}18;border:1px solid {{ $track['color'] }}30;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">{{ $track['icon'] }}</div>
                            <div>
                                <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:var(--text-dim);margin-bottom:0.2rem">{{ $track['track'] }}</div>
                                <div style="font-family:'Syne',sans-serif;font-size:0.97rem;font-weight:700;color:var(--text);line-height:1.3">{{ $track['title'] }}</div>
                            </div>
                        </div>
                        <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.65;margin-bottom:0.75rem">{{ $track['desc'] }}</p>
                        <div style="font-size:0.72rem;color:var(--text-dim);margin-bottom:1rem">Updated: <span style="color:var(--text-muted)">{{ now()->format('d M Y') }}</span></div>
                        <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
                            <a href="{{ route('cv.preview',$track['type']) }}" target="_blank" class="btn btn-secondary btn-sm">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Preview
                            </a>
                            <a href="{{ route('cv.download',$track['type']) }}" class="btn btn-sm" style="background:{{ $track['color'] }};color:#fff;box-shadow:0 2px 10px {{ $track['color'] }}44;flex:1;justify-content:center">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Coming soon cards --}}
                @foreach([
                    ['⚙️','Maintenance Technician','Preventive maintenance, troubleshooting, facilities management.'],
                    ['🏭','Industrial Electrical','Industrial systems, motor controls, switchgear, safety compliance.'],
                ] as [$icon,$title,$desc])
                <div class="glow-card" style="overflow:hidden;opacity:0.65">
                    <div style="height:4px;background:linear-gradient(90deg,#9CA3AF,#D1D5DB)"></div>
                    <div style="padding:1.4rem">
                        <div style="display:flex;align-items:flex-start;gap:0.9rem;margin-bottom:1rem">
                            <div style="width:46px;height:46px;border-radius:12px;background:rgba(100,116,139,0.10);border:1px solid rgba(100,116,139,0.20);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">{{ $icon }}</div>
                            <div>
                                <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:var(--text-dim);margin-bottom:0.2rem">Electrical</div>
                                <div style="font-family:'Syne',sans-serif;font-size:0.97rem;font-weight:700;color:var(--text)">{{ $title }}</div>
                            </div>
                        </div>
                        <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.65;margin-bottom:1rem">{{ $desc }}</p>
                        <span style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.75rem;font-weight:600;padding:0.35rem 0.85rem;border-radius:9999px;background:rgba(100,116,139,0.10);color:var(--text-dim);border:1px solid rgba(100,116,139,0.20)">
                            🕒 Coming Soon
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Future track --}}
        <div>
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.25rem">
                <div style="width:3px;height:28px;background:linear-gradient(180deg,#0369a1,#38BDF8);border-radius:2px"></div>
                <h2 style="font-family:'Syne',sans-serif;font-size:1.15rem;font-weight:700;color:var(--text)">Future Tracks</h2>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem">
                @foreach([
                    ['🔧','Plumbing Technician','Planned plumbing track for future expansion.'],
                    ['🏗️','Building Services','Facilities and building services management.'],
                    ['📡','Network Engineer','Advanced networking and infrastructure roles.'],
                ] as [$icon,$title,$desc])
                <div style="padding:1.35rem;background:var(--bg-alt);border:1px dashed var(--border);border-radius:var(--radius-lg);display:flex;align-items:center;gap:1rem;opacity:0.55">
                    <div style="font-size:1.75rem">{{ $icon }}</div>
                    <div>
                        <div style="font-family:'Syne',sans-serif;font-size:0.9rem;font-weight:700;color:var(--text)">{{ $title }}</div>
                        <div style="font-size:0.78rem;color:var(--text-dim);margin-top:0.15rem">{{ $desc }}</div>
                        <span style="display:inline-block;margin-top:0.4rem;font-size:0.68rem;font-weight:700;color:var(--text-dim);text-transform:uppercase;letter-spacing:0.1em">Planned</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
