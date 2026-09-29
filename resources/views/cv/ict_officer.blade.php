<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Emmanuel Tokpah – ICT Officer CV</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Helvetica Neue', Arial, sans-serif;
      font-size: 11pt;
      color: #0c1a2e;
      line-height: 1.5;
    }

    .page {
      max-width: 800px;
      margin: 0 auto;
      padding: 32px 40px;
    }

    .cv-header {
      display: flex;
      align-items: flex-start;
      gap: 0;
      margin-bottom: 20px;
    }

    .cv-accent {
      width: 8px;
      background: linear-gradient(180deg, #0ea5e9, #06b6d4);
      border-radius: 4px;
      margin-right: 18px;
      min-height: 100px;
    }

    .cv-name {
      font-size: 22pt;
      font-weight: 800;
      color: #0c4a6e;
    }

    .cv-title {
      font-size: 11.5pt;
      color: #0ea5e9;
      font-weight: 600;
      margin-top: 2px;
    }

    .cv-contact {
      font-size: 9pt;
      color: #555;
      margin-top: 8px;
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
    }

    hr {
      border: none;
      border-top: 2px solid #e0f2fe;
      margin-bottom: 16px;
    }

    .section {
      margin-bottom: 18px;
    }

    .section-title {
      font-size: 10.5pt;
      font-weight: 700;
      color: #0369a1;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .section-title::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e0f2fe;
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
      color: #0369a1;
      font-weight: 600;
      background: #e0f2fe;
      padding: 2px 8px;
      border-radius: 20px;
      white-space: nowrap;
    }

    .entry-desc {
      font-size: 9.5pt;
      color: #444;
      margin-top: 4px;
    }

    .two-col {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 24px;
    }

    .skill-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 6px;
    }

    .skill-name {
      font-size: 9.5pt;
      min-width: 130px;
    }

    .skill-bar {
      flex: 1;
      height: 5px;
      background: #e0f2fe;
      border-radius: 3px;
    }

    .skill-fill {
      height: 100%;
      background: linear-gradient(90deg, #0369a1, #06b6d4);
      border-radius: 3px;
    }

    .tag {
      display: inline-block;
      font-size: 8.5pt;
      background: #f0f9ff;
      color: #0369a1;
      padding: 2px 8px;
      border-radius: 3px;
      margin: 2px;
      border: 1px solid #bae6fd;
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
    <div class="cv-header">
      <div class="cv-accent"></div>
      <div style="flex:1">
        <div class="cv-name">{{ $profile->name }}</div>
        <div class="cv-title">{{ $cvMeta['headline'] ?? 'ICT Officer' }}</div>
        <div class="cv-contact">
          <span>✉ {{ $profile->email }}</span>
          <span>📞 {{ $profile->phone }}</span>
          <span>📍 {{ $profile->location }}</span>
          @if($profile->github_url)<span>⌥ {{ $profile->github_url }}</span>@endif
        </div>
      </div>
    </div>
    <hr>

    <div class="section">
      <div class="section-title">Professional Summary</div>
      <p class="entry-desc">Results-driven ICT professional and Information Systems student with expertise in web development, network security awareness, and technical troubleshooting. Experienced in maintaining digital systems, supporting end-users, and implementing ICT solutions for both institutional and individual clients. Passionate about using technology to improve operational efficiency.</p>
    </div>

    <div class="two-col">
      <div>
        <div class="section">
          <div class="section-title">Work Experience</div>
          @foreach($experiences as $exp)
          <div class="entry">
            <div class="entry-header">
              <div>
                <div class="entry-title">{{ $exp->title }}</div>
                <div class="entry-sub">{{ $exp->company }}@if($exp->location) · {{ $exp->location }}@endif</div>
              </div>
              <span class="entry-date">{{ $exp->period }}</span>
            </div>
            <p class="entry-desc">{{ $exp->description }}</p>
          </div>
          @endforeach
        </div>

        <div class="section">
          <div class="section-title">Key Projects</div>
          @foreach($projects->take(2) as $p)
          <div class="entry">
            <div class="entry-title">{{ $p->title }}</div>
            <p class="entry-desc">{{ Str::limit($p->description, 120) }}</p>
            <div style="margin-top:4px">@foreach($p->tech_array as $t)<span class="tag">{{ $t }}</span>@endforeach</div>
          </div>
          @endforeach
        </div>
      </div>

      <div>
        <div class="section">
          <div class="section-title">ICT Competencies</div>
          @foreach($skills->whereIn('category',['technical','tool']) as $skill)
          <div class="skill-row">
            <span class="skill-name">{{ $skill->name }}</span>
            <div class="skill-bar">
              <div class="skill-fill" style="width:{{ $skill->proficiency }}%"></div>
            </div>
          </div>
          @endforeach
        </div>

        <div class="section">
          <div class="section-title">Education</div>
          @foreach($educations as $edu)
          <div class="entry">
            <div class="entry-title">{{ $edu->degree }}</div>
            <div class="entry-sub">{{ $edu->institution }}</div>
            <div class="entry-sub">{{ $edu->period }}</div>
          </div>
          @endforeach
        </div>

        @if($certificates->count())
        <div class="section">
          <div class="section-title">Certificates</div>
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

    <footer-note>ICT Officer CV — {{ $profile->name }} · {{ date('F Y') }}</footer-note>
  </div>
</body>

</html>