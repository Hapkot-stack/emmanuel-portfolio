<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Emmanuel Tokpah – Developer CV</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11pt;
      color: #1a1a2e;
      line-height: 1.5;
      background: #fff;
    }

    .page {
      max-width: 800px;
      margin: 0 auto;
      padding: 32px 40px;
    }

    /* Header */
    .cv-header {
      display: flex;
      align-items: flex-start;
      gap: 24px;
      border-bottom: 3px solid #2563eb;
      padding-bottom: 20px;
      margin-bottom: 20px;
    }

    .cv-avatar {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      object-fit: cover;
      border: 2px solid #2563eb;
    }

    .cv-name {
      font-size: 22pt;
      font-weight: 800;
      color: #2563eb;
      letter-spacing: -0.5px;
    }

    .cv-title {
      font-size: 12pt;
      color: #06b6d4;
      font-weight: 600;
      margin-top: 2px;
    }

    .cv-contact {
      font-size: 9pt;
      color: #555;
      margin-top: 6px;
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
    }

    .cv-contact span {
      display: flex;
      align-items: center;
      gap: 4px;
    }

    /* Sections */
    .section {
      margin-bottom: 18px;
    }

    .section-title {
      font-size: 11pt;
      font-weight: 700;
      color: #2563eb;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      border-bottom: 1px solid #dbeafe;
      padding-bottom: 4px;
      margin-bottom: 10px;
    }

    .entry {
      margin-bottom: 12px;
    }

    .entry-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .entry-title {
      font-weight: 700;
      font-size: 10.5pt;
      color: #111;
    }

    .entry-sub {
      font-size: 9.5pt;
      color: #555;
    }

    .entry-date {
      font-size: 9pt;
      color: #2563eb;
      font-weight: 600;
      background: #eff6ff;
      padding: 2px 8px;
      border-radius: 20px;
      white-space: nowrap;
    }

    .entry-desc {
      font-size: 9.5pt;
      color: #444;
      margin-top: 4px;
    }

    .tags {
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
      margin-top: 6px;
    }

    .tag {
      font-size: 8.5pt;
      background: #eff6ff;
      color: #2563eb;
      padding: 2px 8px;
      border-radius: 20px;
      border: 1px solid #bfdbfe;
    }

    .skills-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
    }

    .skill-row {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .skill-name {
      font-size: 9.5pt;
      color: #333;
      min-width: 130px;
    }

    .skill-bar {
      flex: 1;
      height: 6px;
      background: #e2e8f0;
      border-radius: 3px;
      overflow: hidden;
    }

    .skill-fill {
      height: 100%;
      background: linear-gradient(90deg, #2563eb, #06b6d4);
      border-radius: 3px;
    }

    .two-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    footer-note {
      display: block;
      margin-top: 30px;
      text-align: center;
      font-size: 8pt;
      color: #aaa;
      border-top: 1px solid #eee;
      padding-top: 8px;
    }
  </style>
</head>

<body>
  <div class="page">

    {{-- Header --}}
    <div class="cv-header">
      @if($profile->avatar)
      <img src="{{ $profile->avatarFilePath('large') }}" class="cv-avatar" alt="{{ $profile->name }}">
      @endif
      <div style="flex:1">
        <div class="cv-name">{{ $profile->name }}</div>
        <div class="cv-title">{{ $cvMeta['headline'] ?? 'Software Developer' }}</div>
        <div class="cv-contact">
          <span>✉ {{ $profile->email }}</span>
          <span>📞 {{ $profile->phone }}</span>
          <span>📍 {{ $profile->location }}</span>
          @if($profile->github_url)<span>⌥ {{ $profile->github_url }}</span>@endif
          @if($profile->linkedin_url)<span>in {{ $profile->linkedin_url }}</span>@endif
        </div>
      </div>
    </div>

    {{-- Summary --}}
    <div class="section">
      <div class="section-title">Professional Summary</div>
      <p class="entry-desc">{{ $profile->bio }}</p>
    </div>

    <div class="two-col">
      <div>
        {{-- Technical Skills --}}
        <div class="section">
          <div class="section-title">Technical Skills</div>
          <div class="skills-grid">
            @foreach($skills->whereIn('category',['technical','design']) as $skill)
            <div class="skill-row">
              <span class="skill-name">{{ $skill->name }}</span>
              <div class="skill-bar">
                <div class="skill-fill" style="width:{{ $skill->proficiency }}%"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        {{-- Tools --}}
        <div class="section">
          <div class="section-title">Tools & Technologies</div>
          <div class="tags">
            @foreach($skills->where('category','tool') as $skill)
            <span class="tag">{{ $skill->name }}</span>
            @endforeach
          </div>
        </div>
      </div>

      <div>
        {{-- Education --}}
        <div class="section">
          <div class="section-title">Education</div>
          @foreach($educations as $edu)
          <div class="entry">
            <div class="entry-header">
              <div>
                <div class="entry-title">{{ $edu->degree }}</div>
                <div class="entry-sub">{{ $edu->institution }}</div>
                @if($edu->location)<div class="entry-sub">{{ $edu->location }}</div>@endif
              </div>
              <span class="entry-date">{{ $edu->period }}</span>
            </div>
          </div>
          @endforeach
        </div>

        {{-- Certificates --}}
        @if($certificates->count())
        <div class="section">
          <div class="section-title">Certifications</div>
          @foreach($certificates as $cert)
          <div class="entry">
            <div class="entry-title">{{ $cert->title }}</div>
            <div class="entry-sub">{{ $cert->issuer }} · {{ $cert->year }}</div>
          </div>
          @endforeach
        </div>
        @endif
      </div>
    </div>

    {{-- Experience --}}
    <div class="section">
      <div class="section-title">Work Experience</div>
      @foreach($experiences->whereIn('type',['work','freelance']) as $exp)
      <div class="entry">
        <div class="entry-header">
          <div>
            <span class="entry-title">{{ $exp->title }}</span>
            <span class="entry-sub"> · {{ $exp->company }}@if($exp->location), {{ $exp->location }}@endif</span>
          </div>
          <span class="entry-date">{{ $exp->period }}</span>
        </div>
        <p class="entry-desc">{{ $exp->description }}</p>
      </div>
      @endforeach
    </div>

    {{-- Projects --}}
    <div class="section">
      <div class="section-title">Key Projects</div>
      @foreach($projects->take(3) as $project)
      <div class="entry">
        <div class="entry-header">
          <span class="entry-title">{{ $project->title }}</span>
          @if($project->github_url)<span style="font-size:8.5pt;color:#2563eb;">{{ $project->github_url }}</span>@endif
        </div>
        <p class="entry-desc">{{ $project->description }}</p>
        <div class="tags">@foreach($project->tech_array as $t)<span class="tag">{{ $t }}</span>@endforeach</div>
      </div>
      @endforeach
    </div>

    <footer-note>Generated from emmanueltokpah.com · {{ date('F Y') }}</footer-note>
  </div>
</body>

</html>