<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Emmanuel Tokpah – NGO CV</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Georgia, 'Times New Roman', serif;
      font-size: 11pt;
      color: #1a2e1a;
      line-height: 1.6;
      background: #fff;
    }

    .page {
      max-width: 800px;
      margin: 0 auto;
      padding: 32px 40px;
    }

    .cv-header {
      text-align: center;
      border-bottom: 2px solid #059669;
      padding-bottom: 18px;
      margin-bottom: 20px;
    }

    .cv-name {
      font-size: 24pt;
      font-weight: 700;
      color: #065f46;
    }

    .cv-title {
      font-size: 12pt;
      color: #059669;
      margin-top: 4px;
    }

    .cv-contact {
      font-size: 9pt;
      color: #555;
      margin-top: 8px;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 16px;
    }

    .section {
      margin-bottom: 18px;
    }

    .section-title {
      font-size: 11pt;
      font-weight: 700;
      color: #065f46;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      border-bottom: 1px solid #d1fae5;
      padding-bottom: 4px;
      margin-bottom: 10px;
      font-family: Arial, sans-serif;
    }

    .entry {
      margin-bottom: 13px;
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
      font-style: italic;
    }

    .entry-date {
      font-size: 9pt;
      color: #059669;
      font-weight: 600;
      background: #ecfdf5;
      padding: 2px 8px;
      border-radius: 20px;
      white-space: nowrap;
      font-family: Arial, sans-serif;
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

    .tag {
      display: inline-block;
      font-size: 8.5pt;
      background: #ecfdf5;
      color: #059669;
      padding: 2px 8px;
      border-radius: 20px;
      margin: 2px;
      font-family: Arial, sans-serif;
    }

    footer-note {
      display: block;
      margin-top: 30px;
      text-align: center;
      font-size: 8pt;
      color: #aaa;
      border-top: 1px solid #eee;
      padding-top: 8px;
      font-family: Arial, sans-serif;
    }
  </style>
</head>

<body>
  <div class="page">
    <div class="cv-header">
      <div class="cv-name">{{ $profile->name }}</div>
      <div class="cv-title">{{ $cvMeta['headline'] ?? 'NGO Technology Professional' }}</div>
      <div class="cv-contact">
        <span>✉ {{ $profile->email }}</span>
        <span>📞 {{ $profile->phone }}</span>
        <span>📍 {{ $profile->location }}</span>
      </div>
    </div>

    <div class="section">
      <div class="section-title">Objective Statement</div>
      <p class="entry-desc">Motivated Information Systems and Management student with hands-on experience in data collection, community support, and ICT applications. Committed to leveraging technology and analytical skills to support NGO missions, humanitarian programmes, and community development initiatives across Africa.</p>
    </div>

    <div class="two-col">
      <div>
        <div class="section">
          <div class="section-title">Education</div>
          @foreach($educations as $edu)
          <div class="entry">
            <div class="entry-header">
              <div>
                <div class="entry-title">{{ $edu->degree }}</div>
                <div class="entry-sub">{{ $edu->institution }}</div>
              </div>
              <span class="entry-date">{{ $edu->period }}</span>
            </div>
          </div>
          @endforeach
        </div>

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

      <div>
        <div class="section">
          <div class="section-title">Core Competencies</div>
          <p class="entry-desc">Community Engagement · Data Collection & Management · Report Writing · Microsoft Office · Web & Digital Communications · Cybersecurity Awareness · Team Leadership · Cross-cultural Communication</p>
        </div>
        <div class="section">
          <div class="section-title">Languages</div>
          <p class="entry-desc">English (Fluent) · Kinyarwanda (Basic) · French (Basic)</p>
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
      <div class="section-title">Digital & Technical Skills</div>
      <div>
        @foreach($skills->whereIn('category',['technical','tool']) as $skill)
        <span class="tag">{{ $skill->name }}</span>
        @endforeach
      </div>
    </div>

    <footer-note>Curriculum Vitae – {{ $profile->name }} · {{ date('F Y') }}</footer-note>
  </div>
</body>

</html>