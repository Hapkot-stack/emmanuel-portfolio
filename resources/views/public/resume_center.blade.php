@extends('layouts.app')
@section('title', 'Resume Center | Emmanuel Tokpah')
@section('description', 'View and download Emmanuel Tokpah’s role-focused resumes.')

@section('content')
<style>
    .public-cv-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
        gap: 18px;
    }

    .public-cv-card {
        overflow: hidden;
        border: 1px solid var(--border);
        border-radius: 14px;
        background: var(--c);
        box-shadow: var(--sh);
        transition: transform 180ms ease, box-shadow 180ms ease;
    }

    .public-cv-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shh);
    }

    .public-cv-card::before {
        display: block;
        height: 4px;
        background: linear-gradient(90deg, var(--cv-color), color-mix(in srgb, var(--cv-color), #22D3EE 45%));
        content: '';
    }

    .public-cv-card-body {
        padding: 22px;
    }

    .public-cv-icon {
        display: grid;
        width: 46px;
        height: 46px;
        margin-bottom: 18px;
        place-items: center;
        border-radius: 12px;
        background: color-mix(in srgb, var(--cv-color), transparent 90%);
        font-size: 22px;
    }

    .public-cv-card h2 {
        margin-bottom: 8px;
        font-size: 1.1rem;
    }

    .public-cv-card p {
        min-height: 48px;
        margin-bottom: 18px;
        color: var(--t3);
        font-size: 0.88rem;
        line-height: 1.6;
    }

    .public-cv-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .public-cv-actions .btn {
        flex: 1;
    }
</style>

<section class="sec">
    <div class="container">
        <header class="sec-hd" style="margin-bottom:30px">
            <div class="pill">Resume Center</div>
            <h1>Choose a <span class="grad">Resume</span></h1>
            <p>Role-focused versions of Emmanuel’s professional experience, skills, and education.</p>
        </header>

        <div class="public-cv-grid">
            @foreach($cvTypes as $type => $cv)
            <article class="public-cv-card" style="--cv-color:{{ $cv['color'] }}">
                <div class="public-cv-card-body">
                    <div class="public-cv-icon" aria-hidden="true">{{ $cv['icon'] }}</div>
                    <h2>{{ $cv['label'] }}</h2>
                    <p>{{ $cv['focus'] }}</p>
                    <div class="public-cv-actions">
                        <a href="{{ route('cv.preview', $type) }}" target="_blank" rel="noopener" class="btn btn-s btn-sm">View Resume</a>
                        <a href="{{ route('cv.download', $type) }}" class="btn btn-p btn-sm">Download Resume</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection