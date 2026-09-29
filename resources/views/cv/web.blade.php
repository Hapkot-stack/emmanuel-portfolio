<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Emmanuel Tokpah – Web Developer CV</title>
<style>
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:Arial,Helvetica,sans-serif;font-size:11pt;color:#0f172a;line-height:1.5;background:#fff;}
  .page{max-width:800px;margin:0 auto;padding:32px 40px;}
  .cv-header{border-bottom:3px solid #0284C7;padding-bottom:18px;margin-bottom:20px;}
  .cv-name{font-size:22pt;font-weight:800;color:#0284C7;letter-spacing:-0.5px;}
  .cv-title{font-size:11pt;color:#38BDF8;font-weight:600;margin-top:3px;}
  .cv-contact{font-size:9pt;color:#555;margin-top:7px;display:flex;flex-wrap:wrap;gap:14px;}
  .section{margin-bottom:18px;}
  .section-title{font-size:10.5pt;font-weight:700;color:#0284C7;text-transform:uppercase;letter-spacing:1.5px;border-bottom:1px solid #e0f2fe;padding-bottom:4px;margin-bottom:10px;}
  .entry{margin-bottom:12px;}
  .entry-header{display:flex;justify-content:space-between;align-items:flex-start;}
  .entry-title{font-weight:700;font-size:10.5pt;color:#111;}
  .entry-sub{font-size:9.5pt;color:#555;}
  .entry-date{font-size:9pt;color:#0284C7;font-weight:600;background:#e0f2fe;padding:2px 8px;border-radius:20px;white-space:nowrap;}
  .entry-desc{font-size:9.5pt;color:#444;margin-top:4px;}
  .two-col{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
  .skill-row{display:flex;align-items:center;gap:8px;margin-bottom:6px;}
  .skill-name{font-size:9.5pt;min-width:130px;color:#333;}
  .skill-bar{flex:1;height:5px;background:#e0f2fe;border-radius:3px;}
  .skill-fill{height:100%;background:linear-gradient(90deg,#0284C7,#38BDF8);border-radius:3px;}
  .tag{display:inline-block;font-size:8.5pt;background:#f0f9ff;color:#0284C7;padding:2px 8px;border-radius:3px;margin:2px;border:1px solid #bae6fd;}
  footer-note{display:block;margin-top:30px;text-align:center;font-size:8pt;color:#aaa;border-top:1px solid #eee;padding-top:8px;}
</style>
</head>
<body>
<div class="page">
  <div class="cv-header">
    <div class="cv-name">{{ $profile->name }}</div>
    <div class="cv-title">Web Developer | HTML · CSS · JavaScript · PHP</div>
    <div class="cv-contact">
      <span>✉ {{ $profile->email }}</span>
      <span>📞 {{ $profile->phone }}</span>
      <span>📍 {{ $profile->location }}</span>
      @if($profile->github_url)<span>⌥ {{ $profile->github_url }}</span>@endif
    </div>
  </div>

  <div class="section">
    <div class="section-title">Profile</div>
    <p class="entry-desc">Results-driven Web Developer with expertise in building responsive, accessible, and visually compelling web interfaces. Proficient in modern HTML5, CSS3, JavaScript, and PHP. Passionate about delivering pixel-perfect designs and seamless user experiences.</p>
  </div>

  <div class="two-col">
    <div>
      <div class="section">
        <div class="section-title">Web Skills</div>
        @foreach($skills->whereIn('category',['technical','design']) as $skill)
        <div class="skill-row">
          <span class="skill-name">{{ $skill->name }}</span>
          <div class="skill-bar"><div class="skill-fill" style="width:{{ $skill->proficiency }}%"></div></div>
          <span style="font-size:8pt;color:#0284C7;font-weight:700;min-width:32px;text-align:right">{{ $skill->proficiency }}%</span>
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
          <div class="entry-sub">{{ $edu->institution }}</div>
          <div class="entry-sub" style="color:#0284C7">{{ $edu->period }}</div>
        </div>
        @endforeach
      </div>
      <div class="section">
        <div class="section-title">Certificates</div>
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
    <div class="section-title">Projects</div>
    @foreach($projects->take(4) as $p)
    <div class="entry">
      <div class="entry-header">
        <span class="entry-title">{{ $p->title }}</span>
        @if($p->github_url)<span style="font-size:8.5pt;color:#0284C7">{{ $p->github_url }}</span>@endif
      </div>
      <p class="entry-desc">{{ $p->short_description ?? Str::limit($p->description,120) }}</p>
      <div style="margin-top:4px">@foreach($p->tech_array as $t)<span class="tag">{{ $t }}</span>@endforeach</div>
    </div>
    @endforeach
  </div>

  <div class="section">
    <div class="section-title">Experience</div>
    @foreach($experiences->whereIn('type',['work','freelance']) as $exp)
    <div class="entry">
      <div class="entry-header">
        <div><span class="entry-title">{{ $exp->title }}</span><span class="entry-sub"> · {{ $exp->company }}</span></div>
        <span class="entry-date">{{ $exp->period }}</span>
      </div>
      <p class="entry-desc">{{ $exp->description }}</p>
    </div>
    @endforeach
  </div>

  <div class="section">
    <div class="section-title">Tools</div>
    @foreach($skills->where('category','tool') as $skill)<span class="tag">{{ $skill->name }}</span>@endforeach
  </div>

  <footer-note>Web Developer CV — {{ $profile->name }} · {{ date('F Y') }}</footer-note>
</div>
</body>
</html>
