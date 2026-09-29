@extends('layouts.app')
@section('title','Emmanuel Tokpah | Software Developer · Career Platform')

@section('content')

@php
$titles = $profile->titles_array ?? ['Software Developer','Information Systems Student','Trading Systems Builder','Electrical Technician','Data & Reporting Professional'];
$chips = $profile->tech_stack_array ?? ['Laravel','PHP','MySQL','JavaScript','API Dev','Git','Figma','Excel','PowerPoint','Cybersecurity'];
$titlesJson = json_encode($titles, JSON_HEX_QUOT | JSON_HEX_TAG);
$identities = [
['color'=>'#4ade80','label'=>'Software Developer'],
['color'=>'#93c5fd','label'=>'BSc Info Systems · UNILAK'],
['color'=>'#fbbf24','label'=>'Trading Systems Builder'],
];
$homeSettings = $homepageSections ?? [];
$sectionPreview = $sectionPreview ?? null;
$homeTitle = fn (string $key, string $default): string => data_get($homeSettings, $key.'.title', $default);
$homeDescription = fn (string $key, string $default): string => data_get($homeSettings, $key.'.description', $default);
$homeVisible = fn (string $key): bool => ($sectionPreview === null || $sectionPreview === $key)
&& ($sectionPreview === $key || (bool) data_get($homeSettings, $key.'.visible', true));
$homeDevice = fn (string $key, string $device): string => data_get($homeSettings, $key.'.'.$device, true) ? 'true' : 'false';
$homeOrder = fn (string $key, int $default): int => (int) data_get($homeSettings, $key.'.sort_order', $default);
$heroName = explode(' ', $homeTitle('hero', 'Emmanuel Tokpah'), 2);
@endphp

@if($isDraftPreview ?? false)
<div style="position:relative;z-index:5;padding:9px 16px;text-align:center;background:#0F172A;color:#fff;font-size:12px;font-weight:700">Draft Preview · Not Published</div>
@endif

<div class="homepage-section-stack">
  {{-- ══════════ HERO ══════════════════════════════════════ --}}
  @if($homeVisible('hero'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('hero', 10) }}" data-mobile-visible="{{ $homeDevice('hero', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('hero', 'desktop_visible') }}">
    <section class="hero">
      <div class="hero-particles" aria-hidden="true"><span></span><span></span><span></span><span></div>
      <div class="hero-inner">
        <div class="hero-grid">

          {{-- Left: Text --}}
          <div>
            <div class="hero-eyebrow">
              <span class="eyebrow-dot"></span>
              Open to Opportunities &bull; Kigali, Rwanda
            </div>

            <h1 class="hero-h1">
              {{ $heroName[0] ?? 'Emmanuel' }}<br>
              <span class="hero-name-accent">{{ $heroName[1] ?? '' }}</span>
            </h1>

            <div class="hero-typed-line">
              <span id="typed" data-phrases="{{ htmlspecialchars($titlesJson, ENT_QUOTES) }}"></span><span class="cursor">|</span>
            </div>

            <p class="hero-bio">{{ $homeDescription('hero', 'Building software products, analytics platforms, business systems and trading technologies.') }}</p>

            <div class="chips">
              @foreach($chips as $chip)
              <span class="chip">{{ $chip }}</span>
              @endforeach
            </div>

            <div class="hero-btns">
              <a href="{{ route('resume') }}" class="btn btn-white btn-lg">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                View Resume
              </a>
              <a href="{{ route('cv.center') }}" class="btn hero-btn-download">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download CV
              </a>
              <a href="#contact" class="btn hero-btn-contact">
                Contact Me
              </a>
            </div>

            <div class="hero-links">
              @if($profile->linkedin_url)
              <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" class="s-pill">
                <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                </svg>
                LinkedIn
              </a>
              @endif
              @if($profile->github_url)
              <a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="s-pill">
                <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                </svg>
                GitHub
              </a>
              @endif
            </div>
          </div>

          {{-- Right: Profile Card --}}
          <div class="hero-profile-column">
            <div class="hero-card">
              <div class="hero-av-wrap">
                <div class="hero-av-glow"></div>
                @if($profile && $profile->avatar)
                <img class="hero-av-img"
                  src="{{ $profile->avatarUrl('large') }}"
                  alt="{{ $profile->name }}">
                @else
                <div class="hero-av-ph">ET</div>
                @endif
              </div>
              <div class="hero-card-name">{{ $profile->name ?? 'Emmanuel Tokpah' }}</div>
              <div class="hero-card-title">{{ $profile->title ?? 'Software Developer' }}</div>
              <div class="hero-card-location">{{ $profile->location ?? 'Kigali, Rwanda' }}</div>
              <div class="hero-card-badges">
                @foreach($identities as $id)
                <div class="hc-badge">
                  <span class="hc-dot" style="background:{{ $id['color'] }}"></span>
                  {{ $id['label'] }}
                </div>
                @endforeach
              </div>
              <div class="hero-card-stats">
                <div><strong>{{ $stats['projects'] }}+</strong><span>Projects</span></div>
                <div><strong>{{ $stats['skills'] }}+</strong><span>Skills</span></div>
                <div><strong>{{ $stats['certificates'] }}+</strong><span>Certificates</span></div>
              </div>
              <div class="hero-card-links">
                @if($profile->github_url)
                <a href="{{ $profile->github_url }}" target="_blank" rel="noopener">GitHub</a>
                @endif
                @if($profile->linkedin_url)
                <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener">LinkedIn</a>
                @endif
              </div>
              <div class="hero-card-actions">
                <a href="{{ route('resume') }}">View Resume</a>
                <a href="{{ route('cv.center') }}">Download CV</a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    {{-- ══════════ STATS STRIP ════════════════════════════════ --}}
    <div class="stats-strip">
      <div class="wrap">
        <div class="stats-grid">
          @foreach([
          [$stats['projects'], 'Projects'],
          [$stats['skills'], 'Skills'],
          [$stats['certificates'],'Certifications'],
          [6, 'Career Tracks'],
          [2, 'Years Experience'],
          ] as [$num, $lbl])
          <div class="stat-card">
            <div class="stat-num"><span data-count="{{ $num }}">0</span>+</div>
            <div class="stat-lbl">{{ $lbl }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  @endif

  {{-- ══════════ CAREER CENTER ══════════════════════════════ --}}
  @if($homeVisible('career-center'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('career-center', 20) }}" data-mobile-visible="{{ $homeDevice('career-center', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('career-center', 'desktop_visible') }}">
    <section class="sec career-center-section">
      <div class="wrap">
        <div class="sec-hd reveal">
          <div class="pill">Career Center</div>
          <h2><span class="grad">{{ $homeTitle('career-center', 'Specialized Career Tracks') }}</span></h2>
          <p>{{ $homeDescription('career-center', 'Tailored for product, data, infrastructure, and technical support roles across business and software environments.') }}</p>
        </div>
        <div class="career-grid">
          @foreach($careerTracks as $careerTrack)
          @php
          $track = $careerTrack->published;
          $icon = ['Software'=>'💻','ICT'=>'🖥️','Data'=>'📊','NGO & Impact'=>'🌍','Electrical'=>'⚡','Technical'=>'🔧','Data & Operations'=>'📝'][$track['category']] ?? '⚙️';
          @endphp
          <div class="cc reveal">
            <div class="cc-top-bar"></div>
            <div class="cc-head">
              <div class="cc-ico">{{ $icon }}</div>
              <div>
                <div class="cc-track">{{ $track['category'] }}</div>
                <div class="cc-title">{{ $track['title'] }}</div>
              </div>
            </div>
            <div class="cc-body">
              <p class="cc-desc">{{ $track['description'] }}</p>
            </div>
            <div class="cc-foot">
              <a href="{{ route('career.show', $careerTrack->slug) }}" class="btn btn-p btn-sm" style="flex:1;justify-content:center">Explore Track</a>
            </div>
          </div>
          @endforeach
        </div>
        <div style="text-align:center;margin-top:20px">
          <a href="{{ route('cv.center') }}" class="btn btn-p">View All CV Types →</a>
        </div>
      </div>
    </section>
  </div>
  @endif

  @if($homeVisible('resume-center'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('resume-center', 30) }}" data-mobile-visible="{{ $homeDevice('resume-center', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('resume-center', 'desktop_visible') }}">
    <section class="sec">
      <div class="wrap resume-home-callout">
        <div>
          <div class="pill">Resume Center</div>
          <h2><span class="grad">{{ $homeTitle('resume-center', 'Role-Focused Resumes') }}</span></h2>
          <p>{{ $homeDescription('resume-center', 'Explore and download a resume tailored to your next opportunity.') }}</p>
        </div>
        <div class="resume-home-actions">
          <a href="{{ route('cv.center') }}" class="btn btn-p">Explore Resumes</a>
          <a href="{{ route('resume') }}" class="btn btn-s">View One-Page Resume</a>
        </div>
      </div>
    </section>
  </div>
  @endif

  {{-- ══════════ SKILLS — alt background ═══════════════════ --}}
  @if($homeVisible('skills-preview'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('skills-preview', 40) }}" data-mobile-visible="{{ $homeDevice('skills-preview', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('skills-preview', 'desktop_visible') }}">
    <section class="sec sec-alt">
      <div class="wrap">
        <div class="sec-hd reveal">
          <div class="pill">Expertise</div>
          <h2><span class="grad">{{ $homeTitle('skills-preview', 'Skills & Competencies') }}</span></h2>
          <p>{{ $homeDescription('skills-preview', 'Professional skills across software, design, business, and technology.') }}</p>
        </div>
        @php
        $catDefs = [
        'technical' => ['⚙️','Backend Development'],
        'design' => ['🎨','Design & Frontend'],
        'tool' => ['🔧','Tools & Technology'],
        'soft' => ['🤝','Business & Professional'],
        ];
        @endphp
        <div class="skills-grid">
          @foreach($allSkills as $cat => $catSkills)
          @php $def = $catDefs[$cat] ?? ['⚡', ucfirst($cat)]; @endphp
          <div class="sk-cat reveal">
            <div class="sk-cat-top">
              <span class="sk-ico">{{ $def[0] }}</span>
              <div>
                <div class="sk-name">{{ $def[1] }}</div>
                <div class="sk-count">{{ $catSkills->count() }} skills</div>
              </div>
            </div>
            <div class="sk-tags">
              @foreach($catSkills as $skill)
              <span class="sk-tag">{{ $skill->name }}</span>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
  </div>
  @endif

  {{-- ══════════ PROJECTS ═══════════════════════════════════ --}}
  @if($homeVisible('featured-projects'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('featured-projects', 50) }}" data-mobile-visible="{{ $homeDevice('featured-projects', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('featured-projects', 'desktop_visible') }}">
    <section class="sec featured-projects-section">
      <div class="wrap">
        <div style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:12px;margin-bottom:28px">
          <div class="reveal">
            <div class="pill">Portfolio</div>
            <h2><span class="grad">{{ $homeTitle('featured-projects', 'Featured Product Work') }}</span></h2>
          </div>
          <a href="{{ route('projects') }}" class="btn btn-s btn-sm reveal">View All →</a>
        </div>
        @php $statusMap = ['live'=>'s-live','published'=>'s-pub','in_development'=>'s-dev','testing'=>'s-test','archived'=>'s-arch','draft'=>'s-dft']; @endphp
        <div class="proj-grid">
          @forelse($featuredProjects as $project)
          @php $sc = $statusMap[$project->status] ?? 's-dft'; @endphp
          <div class="pcard reveal">
            <div class="pcov">
              @if($project->cover_image)
              <img src="{{ Str::startsWith($project->cover_image,'projects/') ? asset('storage/'.$project->cover_image) : asset($project->cover_image) }}" alt="{{ $project->title }}">
              @else
              <div class="pcov-empty">🚀</div>
              @endif
              <span class="sbadge {{ $sc }}">{{ $project->status_label }}</span>
            </div>
            <div class="pbody">
              <h3 class="ptitle">{{ $project->title }}</h3>
              <p class="pdesc">{{ $project->short_description ?? $project->description }}</p>
              <div class="ptags">
                @foreach(array_slice($project->tech_array,0,5) as $t)
                <span class="ptag">{{ $t }}</span>
                @endforeach
              </div>
              @if(!$project->website_available)
              <div class="udev">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Website Under Development
              </div>
              @endif
              <div class="pfoot">
                <a href="{{ route('projects.show',$project->slug) }}" class="btn btn-p btn-sm">Case Study</a>
                @if($project->github_url)
                <a href="{{ $project->github_url }}" target="_blank" class="btn btn-s btn-sm">GitHub</a>
                @endif
                @if($project->website_available && $project->website_url)
                <a href="{{ $project->website_url }}" target="_blank" class="btn btn-s btn-sm">Live ↗</a>
                @endif
              </div>
            </div>
          </div>
          @empty
          <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--t3)">No published projects yet.</div>
          @endforelse
        </div>
      </div>
    </section>
  </div>
  @endif

  {{-- ══════════ WHAT I'M BUILDING — alt bg ════════════════ --}}
  @if($buildingProjects->count() && $homeVisible('building-projects'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('building-projects', 60) }}" data-mobile-visible="{{ $homeDevice('building-projects', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('building-projects', 'desktop_visible') }}">
    <section class="sec sec-alt">
      <div class="wrap">
        <div class="sec-hd reveal">
          <div class="pill">In Progress</div>
          <h2><span class="grad">{{ $homeTitle('building-projects', 'What I\'m Building') }}</span></h2>
          <p>{{ $homeDescription('building-projects', 'Active projects with live development status.') }}</p>
        </div>
        <div class="build-grid">
          @foreach($buildingProjects as $p)
          @php $sc = $statusMap[$p->status] ?? 's-dft'; @endphp
          <div class="bcard reveal">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px">
              <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:var(--t)">{{ $p->title }}</h3>
              <span style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;color:var(--b2);line-height:1;flex-shrink:0">{{ $p->progress }}<span style="font-size:.85rem">%</span></span>
            </div>
            <span class="sbadge {{ $sc }}" style="position:static;display:inline-flex;margin-bottom:10px">{{ $p->status_label }}</span>
            <p style="font-size:13px;color:var(--t3);line-height:1.6;margin-bottom:10px">{{ Str::limit($p->short_description ?? $p->description,100) }}</p>
            <div class="pbar mb3">
              <div class="pfill" data-w="{{ $p->progress }}"></div>
            </div>
            @if($p->features && count((array)$p->features))
            <div style="display:flex;flex-direction:column;gap:5px;margin-top:8px">
              @foreach(array_slice((array)$p->features,0,5) as $i=>$f)
              <div style="display:flex;align-items:center;gap:7px;font-size:12.5px;color:var(--t3)">
                <span style="width:6px;height:6px;border-radius:50%;flex-shrink:0;background:{{ $i<=2?'#10b981':($i==3?'#f59e0b':'var(--t3)') }}"></span>{{ $f }}
              </div>
              @endforeach
            </div>
            @endif
            <a href="{{ route('projects.show',$p->slug) }}" class="btn btn-p btn-full mt4" style="font-size:13px">View Details →</a>
          </div>
          @endforeach
        </div>
      </div>
    </section>
  </div>
  @endif

  {{-- ══════════ SOCIAL SHOWCASE ════════════════════════════ --}}
  @if($homeVisible('social-section'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('social-section', 70) }}" data-mobile-visible="{{ $homeDevice('social-section', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('social-section', 'desktop_visible') }}">
    <section class="sec">
      <div class="wrap">
        <div class="sec-hd reveal">
          <div class="pill">Connect</div>
          <h2><span class="grad">{{ $homeTitle('social-section', 'Find Me Online') }}</span></h2>
          <p>{{ $homeDescription('social-section', 'Connect professionally, explore code, or reach out directly.') }}</p>
        </div>
        @php
        $socMeta = [
        'github' => ['💻','GitHub', 'Explore projects, source code and repositories.','linear-gradient(135deg,#24292e,#555)','View GitHub'],
        'linkedin' => ['🔗','LinkedIn', 'Connect professionally and explore career journey.','linear-gradient(135deg,#0077B5,#0090d9)','View LinkedIn'],
        'email' => ['✉️','Email', 'Direct message for jobs, projects, collaborations.','linear-gradient(135deg,#EA4335,#f87171)','Email Me'],
        'whatsapp' => ['💬','WhatsApp', 'Chat directly for quick real-time communication.','linear-gradient(135deg,#25D366,#34d399)','Chat Now'],
        ];
        @endphp
        <div class="soc-grid">
          @foreach($socialLinks as $link)
          @php $m = $socMeta[$link->platform] ?? ['🌐',$link->label,'','linear-gradient(135deg,#64748b,#475569)','Visit']; @endphp
          <a href="{{ $link->url }}" target="_blank" rel="noopener" class="soc-card reveal">
            <div class="soc-top-bar" style="background:{{ $m[3] }}"></div>
            <div class="soc-ico" style="background:{{ $m[3] }}">{{ $m[0] }}</div>
            <div class="soc-title">{{ $m[1] }}</div>
            <p class="soc-desc">{{ $m[2] }}</p>
            <div class="btn btn-p btn-sm" style="background:{{ $m[3] }};margin-top:auto">{{ $m[4] }} →</div>
          </a>
          @endforeach
          <a href="{{ route('cv.center') }}" class="soc-card reveal">
            <div class="soc-top-bar" style="background:linear-gradient(135deg,var(--b2),var(--b4))"></div>
            <div class="soc-ico" style="background:linear-gradient(135deg,var(--b2),var(--b4))">📄</div>
            <div class="soc-title">Download CV</div>
            <p class="soc-desc">6 specialized CVs from one live database. Always up to date.</p>
            <div class="btn btn-p btn-sm" style="margin-top:auto">CV Center →</div>
          </a>
        </div>
      </div>
    </section>
  </div>
  @endif

  {{-- ══════════ TIMELINE — alt bg ══════════════════════════ --}}
  @if($timeline->count() && $homeVisible('timeline'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('timeline', 80) }}" data-mobile-visible="{{ $homeDevice('timeline', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('timeline', 'desktop_visible') }}">
    <section class="sec sec-alt">
      <div class="wrap">
        <div class="sec-hd reveal">
          <div class="pill">Journey</div>
          <h2><span class="grad">{{ $homeTitle('timeline', 'Professional Timeline') }}</span></h2>
        </div>
        <div class="tl-wrap">
          <div class="tl-line"></div>
          @foreach($timeline as $entry)
          <div class="tl-item reveal">
            <div class="tl-dot"></div>
            <div class="tl-yr">{{ $entry->year }}</div>
            <div class="tl-title">{{ $entry->title }}</div>
            @if($entry->description)
            <div class="tl-desc">{{ $entry->description }}</div>
            @endif
          </div>
          @endforeach
        </div>
      </div>
    </section>
  </div>
  @endif

  {{-- ══════════ CONTACT ════════════════════════════════════ --}}
  @if($homeVisible('contact-cta'))
  <div class="homepage-managed-section" style="order:{{ $homeOrder('contact-cta', 90) }}" data-mobile-visible="{{ $homeDevice('contact-cta', 'mobile_visible') }}" data-desktop-visible="{{ $homeDevice('contact-cta', 'desktop_visible') }}">
    <section class="sec" id="contact">
      <div class="wrap">
        <div class="sec-hd reveal">
          <div class="pill">Hire Me</div>
          <h2><span class="grad">{{ $homeTitle('contact-cta', 'Start a Conversation') }}</span></h2>
          <p>{{ $homeDescription('contact-cta', 'Open to jobs, freelance, internships, and collaborations.') }}</p>
        </div>

        @if(session('contact_success'))
        <div class="alert-ok reveal">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          {{ session('contact_success') }}
        </div>
        @endif

        <div class="ctact-grid">
          {{-- Info --}}
          <div style="display:flex;flex-direction:column;gap:10px" class="reveal">
            @foreach([
            ['✉️','Email', $profile->email ?? 'emmanueltokpah94@gmail.com','mailto:'.($profile->email??'emmanueltokpah94@gmail.com')],
            ['📞','Phone', $profile->phone ?? '+250 792 406 443', 'tel:+250792406443'],
            ['📍','Location', $profile->location ?? 'Kigali, Rwanda', '#'],
            ['💼','Open To', $profile->open_to ?? 'Fulltime, Freelance, Remote','#'],
            ] as [$icon,$lbl,$val,$href])
            <a href="{{ $href }}" class="cinfo-item">
              <div class="cico">{{ $icon }}</div>
              <div>
                <div class="clbl">{{ $lbl }}</div>
                <div class="cval">{{ $val }}</div>
              </div>
            </a>
            @endforeach
            <div style="padding:14px;background:linear-gradient(135deg,var(--b7),var(--b6));border:1.5px solid var(--b5);border-radius:var(--r);margin-top:4px">
              <div style="font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:var(--b2);margin-bottom:4px">Response Time</div>
              <p style="font-size:12.5px;color:var(--t3);line-height:1.6">Usually within 24 hours. Available for remote and on-site opportunities.</p>
            </div>
          </div>

          {{-- Form --}}
          <div class="cform reveal">
            <form action="{{ route('contact.store') }}" method="POST">
              @csrf
              <div class="mb4">
                <label class="flabel">Reason for Contact *</label>
                <div class="reason-grid">
                  @foreach(\App\Models\ContactInquiry::REASONS as $val => $lbl)
                  <div style="position:relative">
                    <input type="radio" name="reason" id="r_{{ $val }}" value="{{ $val }}" class="rinput"
                      {{ old('reason','job_opportunity')===$val?'checked':'' }}>
                    <label for="r_{{ $val }}" class="rlabel">
                      {{ \App\Models\ContactInquiry::REASON_ICONS[$val]??'💬' }} {{ $lbl }}
                    </label>
                  </div>
                  @endforeach
                </div>
                @error('reason')<p style="font-size:11px;color:#dc2626;margin-top:4px">{{ $message }}</p>@enderror
              </div>

              <div class="frow mb4">
                <div>
                  <label class="flabel" for="cn">Name *</label>
                  <input type="text" id="cn" name="name" value="{{ old('name') }}" placeholder="John Doe" class="finput" required>
                </div>
                <div>
                  <label class="flabel" for="ce">Email *</label>
                  <input type="email" id="ce" name="email" value="{{ old('email') }}" placeholder="you@company.com" class="finput" required>
                </div>
                <div>
                  <label class="flabel" for="cc2">Company</label>
                  <input type="text" id="cc2" name="company" value="{{ old('company') }}" placeholder="Optional" class="finput">
                </div>
                <div>
                  <label class="flabel" for="cp">Phone</label>
                  <input type="text" id="cp" name="phone" value="{{ old('phone') }}" placeholder="Optional" class="finput">
                </div>
              </div>

              <div class="mb4">
                <label class="flabel" for="cs">Subject</label>
                <input type="text" id="cs" name="subject" value="{{ old('subject') }}" placeholder="Brief subject line" class="finput">
              </div>

              <div class="mb4">
                <label class="flabel" for="cm">Message *</label>
                <textarea id="cm" name="message" placeholder="Tell me about the opportunity or project…" class="ftarea" required>{{ old('message') }}</textarea>
              </div>

              <button type="submit" class="btn btn-p btn-full btn-lg">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Send Message
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
  @endif
</div>

@endsection