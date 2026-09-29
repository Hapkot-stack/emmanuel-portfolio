@php
$parent = match (true) {
request()->routeIs('filament.admin.pages.homepage-builder') => ['home', 'Home'],
request()->routeIs('filament.admin.resources.career-tracks.*') => ['career-center', 'Career Center'],
request()->routeIs('filament.admin.resources.resume-types.*') => ['resume-center', 'Resume Center'],
request()->routeIs('filament.admin.resources.skills.*') => ['expertise', 'Expertise'],
request()->routeIs('filament.admin.resources.projects.*') => ['portfolio', 'Portfolio'],
request()->routeIs('filament.admin.pages.manage-profile'),
request()->routeIs('filament.admin.resources.experiences.*'),
request()->routeIs('filament.admin.resources.education.*'),
request()->routeIs('filament.admin.resources.certificates.*'),
request()->routeIs('filament.admin.resources.timelines.*') => ['journey', 'Journey'],
request()->routeIs('filament.admin.resources.social-links.*'),
request()->routeIs('filament.admin.resources.contact-inquiries.*') => ['connect', 'Connect'],
request()->routeIs('filament.admin.pages.brand-center') => ['brand-center', 'Brand Center'],
request()->routeIs('filament.admin.pages.publish-center') => ['publish-center', 'Publish Center'],
request()->routeIs('filament.admin.pages.analytics-dashboard') => ['analytics', 'Analytics'],
default => null,
};
@endphp

@if($parent)
<div class="mb-5">
    <a class="cms-back-link" href="{{ url('/cms/page-management?section=' . $parent[0]) }}">
        <x-filament::icon icon="heroicon-o-arrow-left" class="h-4 w-4" />
        <span>Back to {{ $parent[1] }}</span>
    </a>
</div>
@endif