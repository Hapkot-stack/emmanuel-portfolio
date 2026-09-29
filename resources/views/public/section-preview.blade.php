@extends('layouts.app')
@section('title', $content['title'] . ' Preview')

@section('content')
<section style="width:min(100% - 32px, 960px);margin:0 auto;padding:48px 0 72px">
    <header style="margin-bottom:28px">
        <p style="font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#2563eb">Section Preview</p>
        <h1 style="margin-top:8px;font-size:32px;font-weight:800;color:#111827">{{ $content['title'] }}</h1>
    </header>

    @if($content['type'] === 'records')
    <div style="display:grid;gap:16px">
        @forelse($content['items'] as $item)
        <article style="padding:20px;border:1px solid #dbe3ef;border-radius:12px;background:#fff">
            <h2 style="font-size:18px;font-weight:700;color:#111827">{{ $item->title ?? $item->degree }}</h2>
            <p style="margin-top:4px;color:#475569">{{ $item->company ?? $item->institution }} · {{ $item->period }}</p>
            @if($item->description)<p style="margin-top:12px;line-height:1.65;color:#475569">{{ $item->description }}</p>@endif
        </article>
        @empty
        <p style="color:#64748b">No content has been added to this section yet.</p>
        @endforelse
    </div>
    @elseif($content['type'] === 'certificates')
    <div style="display:grid;gap:16px;grid-template-columns:repeat(auto-fit,minmax(240px,1fr))">
        @forelse($content['items'] as $item)
        <article style="padding:20px;border:1px solid #dbe3ef;border-radius:12px;background:#fff">
            @if($item->image)<img src="{{ str_starts_with($item->image, 'certificates/') ? asset('storage/' . $item->image) : asset($item->image) }}" alt="{{ $item->title }}" style="width:100%;height:150px;object-fit:cover;border-radius:8px;margin-bottom:14px">@endif
            <h2 style="font-size:18px;font-weight:700;color:#111827">{{ $item->title }}</h2>
            <p style="margin-top:4px;color:#475569">{{ $item->issuer }} · {{ $item->year }}</p>
        </article>
        @empty
        <p style="color:#64748b">No certificates have been added yet.</p>
        @endforelse
    </div>
    @elseif($content['type'] === 'screenshots')
    <div style="display:grid;gap:16px;grid-template-columns:repeat(auto-fit,minmax(240px,1fr))">
        @forelse($content['items'] as $item)
        <figure style="padding:12px;border:1px solid #dbe3ef;border-radius:12px;background:#fff">
            <img src="{{ $item->image_url }}" alt="{{ $item->caption ?: $item->project?->title }}" style="width:100%;height:180px;object-fit:cover;border-radius:8px">
            <figcaption style="padding:10px 2px 2px;color:#475569">{{ $item->caption ?: $item->project?->title }}</figcaption>
        </figure>
        @empty
        <p style="color:#64748b">No project screenshots have been added yet.</p>
        @endforelse
    </div>
    @elseif($content['type'] === 'skills')
    <div style="display:grid;gap:16px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr))">
        @forelse($content['items'] as $item)
        <article style="padding:18px;border:1px solid #dbe3ef;border-radius:12px;background:#fff">
            <h2 style="font-size:16px;font-weight:700;color:#111827">{{ $item->name }}</h2>
            <p style="margin-top:6px;color:#475569">{{ \App\Models\Skill::categoryLabels()[$item->category] ?? ucfirst($item->category) }}</p>
        </article>
        @empty
        <p style="color:#64748b">No expertise items have been added yet.</p>
        @endforelse
    </div>
    @elseif($content['type'] === 'journey')
    <div style="display:grid;gap:20px">
        @foreach($content['items'] as $group)
        <article style="padding:20px;border:1px solid #dbe3ef;border-radius:12px;background:#fff">
            <h2 style="font-size:18px;font-weight:700;color:#111827">{{ $group['title'] }}</h2>
            @if(isset($group['description']))<p style="margin-top:8px;line-height:1.65;color:#475569">{{ $group['description'] }}</p>@endif
            @foreach($group['items'] ?? [] as $item)
            <p style="margin-top:12px;color:#475569"><strong>{{ $item->title ?? $item->degree }}</strong> · {{ $item->company ?? $item->institution ?? $item->issuer ?? $item->year }}</p>
            @endforeach
        </article>
        @endforeach
    </div>
    @elseif($content['type'] === 'connect')
    <div style="display:grid;gap:12px">
        @forelse($content['items'] as $item)
        <a href="{{ $item->url }}" style="display:block;padding:18px;border:1px solid #dbe3ef;border-radius:12px;background:#fff;color:#1d4ed8;font-weight:700">{{ $item->label }} <span style="font-weight:400;color:#475569">{{ $item->url }}</span></a>
        @empty
        <p style="color:#64748b">No contact links are active yet.</p>
        @endforelse
    </div>
    @elseif($content['type'] === 'hire-me')
    <div style="display:grid;gap:16px">
        @foreach($content['items'] as $item)
        <article style="padding:20px;border:1px solid #dbe3ef;border-radius:12px;background:#fff">
            <h2 style="font-size:18px;font-weight:700;color:#111827">{{ $item['title'] }}</h2>
            <p style="margin-top:8px;color:#475569">{{ $item['description'] }}</p>
            @if(!empty($item['phone']))<p style="margin-top:6px;color:#475569">{{ $item['phone'] }}</p>@endif
            @if(!empty($item['location']))<p style="margin-top:6px;color:#475569">{{ $item['location'] }}</p>@endif
        </article>
        @endforeach
    </div>
    @endif
</section>
@endsection