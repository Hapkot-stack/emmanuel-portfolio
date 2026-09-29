<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Emmanuel Tokpah – Electrical Technician CV</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11pt;
      color: #1c1917;
      line-height: 1.55;
      background: #fff;
    }

    .page {
      max-width: 800px;
      margin: 0 auto;
      padding: 32px 40px;
    }

    .cv-header {
      background: linear-gradient(135deg, #B45309, #D97706);
      color: #fff;
      padding: 24px 28px;
      border-radius: 6px;
      margin-bottom: 22px;
    }

    .cv-name {
      font-size: 22pt;
      font-weight: 800;
      letter-spacing: -0.5px;
    }

    .cv-title {
      font-size: 11pt;
      color: rgba(255, 255, 255, 0.88);
      margin-top: 3px;
    }

    .cv-contact {
      font-size: 8.5pt;
      color: rgba(255, 255, 255, 0.80);
      margin-top: 8px;
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
    }

    .section {
      margin-bottom: 18px;
    }

    .section-title {
      font-size: 10.5pt;
      font-weight: 700;
      color: #B45309;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      border-left: 3px solid #D97706;
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
      color: #B45309;
      font-weight: 600;
      background: #fef3c7;
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
      gap: 22px;
    }

    .tag {
      display: inline-block;
      font-size: 8.5pt;
      background: #fef3c7;
      color: #B45309;
      padding: 2px 8px;
      border-radius: 3px;
      margin: 2px;
      border: 1px solid #fde68a;
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
      <div class="cv-name">{{ $profile->name }}</div>
      <div class="cv-title">{{ $cvMeta['headline'] ?? 'Electrical Technician' }} | Maintenance | Installation | Systems</div>
      <div class="cv-contact">
        <span>✉ {{ $profile->email }}</span>
        <span>📞 {{ $profile->phone }}</span>
        <span>📍 {{ $profile->location }}</span>
      </div>
    </div>

    <div class="section">
      <div class="section-title">Professional Profile</div>
      <p class="entry-desc">{{ $cvMeta['summary'] ?? 'Qualified Electrical Technician with a National Diploma in Electricity and hands-on experience in residential and institutional electrical installations, maintenance, and fault diagnosis. Committed to safety standards, efficient troubleshooting, and high-quality workmanship. Also holds Information Systems expertise, enabling effective documentation and reporting.' }}</p>
    </div>

    <div class="two-col">
      <div>
        <div class="section">
          <div class="section-title">Electrical Skills</div>
          <div style="display:flex;flex-direction:column;gap:5px;">
            @foreach(['Residential Wiring','Industrial Systems','Fault Diagnosis','Electrical Maintenance','Safety Procedures','Equipment Troubleshooting','Electrical Installation','Panel Wiring'] as $s)
            <div style="display:flex;align-items:center;gap:6px;font-size:9.5pt;color:#333">
              <span style="width:8px;height:8px;background:#D97706;border-radius:50%;flex-shrink:0"></span>{{ $s }}
            </div>
            @endforeach
          </div>
        </div>

        <div class="section">
          <div class="section-title">Digital & IT Skills</div>
          <div style="margin-top:4px">
            @foreach($skills->whereIn('category',['tool','technical']) as $skill)
            <span class="tag">{{ $skill->name }}</span>
            @endforeach
          </div>
        </div>
      </div>

      <div>
        <div class="section">
          <div class="section-title">Education</div>
          @foreach($educations as $edu)
          <div class="entry">
            <div class="entry-title" style="font-size:10pt">{{ $edu->degree }}</div>
            <div class="entry-sub">{{ $edu->institution }}</div>
            <div style="font-size:9pt;color:#B45309;font-weight:600">{{ $edu->period }}</div>
            @if($edu->description)<p class="entry-desc" style="margin-top:3px">{{ Str::limit($edu->description,100) }}</p>@endif
          </div>
          @endforeach
        </div>

        @if($certificates->count())
        <div class="section">
          <div class="section-title">Certifications</div>
          @foreach($certificates as $cert)
          <div class="entry">
            <div class="entry-title" style="font-size:10pt">{{ $cert->title }}</div>
            <div class="entry-sub">{{ $cert->issuer }} · {{ $cert->year }}</div>
          </div>
          @endforeach
        </div>
        @endif
      </div>
    </div>

    <div class="section">
      <div class="section-title">Work Experience</div>
      @foreach($experiences as $exp)
      <div class="entry">
        <div class="entry-header">
          <div>
            <span class="entry-title">{{ $exp->title }}</span>
            <span class="entry-sub"> — {{ $exp->company }}@if($exp->location), {{ $exp->location }}@endif</span>
          </div>
          <span class="entry-date">{{ $exp->period }}</span>
        </div>
        <p class="entry-desc">{{ $exp->description }}</p>
      </div>
      @endforeach
    </div>

    <div class="section">
      <div class="section-title">Key Competencies</div>
      <p class="entry-desc">Electrical Safety · Fault Finding · Preventive Maintenance · Client Relations · Technical Reporting · Team Collaboration · Information Systems · Microsoft Office</p>
    </div>

    <footer-note>Electrical Technician CV — {{ $profile->name }} · {{ date('F Y') }}</footer-note>
  </div>
</body>

</html>