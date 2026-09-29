<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Emmanuel Tokpah – Data Officer CV</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11pt;
      color: #1e1b4b;
      line-height: 1.5;
    }

    .page {
      max-width: 800px;
      margin: 0 auto;
      padding: 32px 40px;
    }

    .cv-header {
      background: linear-gradient(135deg, #4c1d95, #5b21b6);
      color: white;
      padding: 24px;
      border-radius: 8px;
      margin-bottom: 20px;
      display: flex;
      gap: 20px;
      align-items: center;
    }

    .cv-name {
      font-size: 22pt;
      font-weight: 800;
      letter-spacing: -0.5px;
    }

    .cv-title {
      font-size: 11pt;
      color: #c4b5fd;
      margin-top: 2px;
    }

    .cv-contact {
      font-size: 8.5pt;
      color: #ddd6fe;
      margin-top: 8px;
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
    }

    .section {
      margin-bottom: 18px;
    }

    .section-title {
      font-size: 10.5pt;
      font-weight: 700;
      color: #5b21b6;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      border-left: 3px solid #8b5cf6;
      padding-left: 8px;
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
      color: #7c3aed;
      font-weight: 600;
      background: #ede9fe;
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
      grid-template-columns: 1fr 1fr;
      gap: 20px;
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
      color: #333;
    }

    .skill-bar {
      flex: 1;
      height: 5px;
      background: #ede9fe;
      border-radius: 3px;
    }

    .skill-fill {
      height: 100%;
      background: linear-gradient(90deg, #7c3aed, #a855f7);
      border-radius: 3px;
    }

    .tag {
      display: inline-block;
      font-size: 8.5pt;
      background: #f5f3ff;
      color: #6d28d9;
      padding: 2px 8px;
      border-radius: 3px;
      margin: 2px;
      border: 1px solid #ddd6fe;
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
      <div style="flex:1">
        <div class="cv-name">{{ $profile->name }}</div>
        <div class="cv-title">{{ $cvMeta['headline'] ?? 'Data Officer' }}</div>
        <div class="cv-contact">
          <span>✉ {{ $profile->email }}</span>
          <span>📞 {{ $profile->phone }}</span>
          <span>📍 {{ $profile->location }}</span>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-title">Professional Profile</div>
      <p class="entry-desc">Detail-oriented Information Systems student with practical experience in national data collection, digital records management, and database administration. Skilled in translating raw data into actionable insights using various software tools. Seeking to contribute accurate, efficient data management to drive evidence-based decision making.</p>
    </div>

    <div class="two-col">
      <div>
        <div class="section">
          <div class="section-title">Data & Technical Skills</div>
          @foreach($skills->whereIn('category',['technical','tool']) as $skill)
          <div class="skill-row">
            <span class="skill-name">{{ $skill->name }}</span>
            <div class="skill-bar">
              <div class="skill-fill" style="width:{{ $skill->proficiency }}%"></div>
            </div>
            <span style="font-size:8pt;color:#7c3aed;font-weight:600">{{ $skill->proficiency }}%</span>
          </div>
          @endforeach
        </div>
      </div>

      <div>
        <div class="section">
          <div class="section-title">Education</div>
          @foreach($educations as $edu)
          <div class="entry">
            <div class="entry-title">{{ $edu->degree }}</div>
            <div class="entry-sub">{{ $edu->institution }} · {{ $edu->period }}</div>
          </div>
          @endforeach
        </div>
        <div class="section">
          <div class="section-title">Certifications</div>
          @foreach($certificates as $cert)
          <div class="entry">
            <div class="entry-title">{{ $cert->title }}</div>
            <div class="entry-sub">{{ $cert->issuer }} · {{ $cert->year }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="section">
      <div class="section-title">Relevant Experience</div>
      @foreach($experiences as $exp)
      <div class="entry">
        <div class="entry-header">
          <div><span class="entry-title">{{ $exp->title }}</span><span class="entry-sub"> — {{ $exp->company }}@if($exp->location), {{ $exp->location }}@endif</span></div>
          <span class="entry-date">{{ $exp->period }}</span>
        </div>
        <p class="entry-desc">{{ $exp->description }}</p>
      </div>
      @endforeach
    </div>

    <div class="section">
      <div class="section-title">Database & Analytics Projects</div>
      @foreach($projects->take(3) as $p)
      <div class="entry">
        <div class="entry-title">{{ $p->title }}</div>
        <p class="entry-desc">{{ $p->description }}</p>
        <div style="margin-top:4px">@foreach($p->tech_array as $t)<span class="tag">{{ $t }}</span>@endforeach</div>
      </div>
      @endforeach
    </div>

    <footer-note>Data Officer CV — {{ $profile->name }} · {{ date('F Y') }}</footer-note>
  </div>
</body>

</html>