<x-filament-panels::page>
    @php($pendingSections = $this->pendingSections())
    @php($pendingResumes = $this->pendingResumes())
    @php($pendingCareerTracks = $this->pendingCareerTracks())
    @php($recentVersions = $this->recentVersions())
    @php($recentResumeVersions = $this->recentResumeVersions())
    @php($recentCareerTrackVersions = $this->recentCareerTrackVersions())
    @php($pendingCount = $pendingSections->count() + $pendingResumes->count() + $pendingCareerTracks->count())

    <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending changes</p>
                <p class="mt-1 text-3xl font-semibold text-gray-950 dark:text-white">{{ $pendingCount }}</p>
            </div>
            <x-filament::button wire:click="publishAll" icon="heroicon-o-paper-airplane" :disabled="$pendingCount === 0">
                Publish Entire Website
            </x-filament::button>
        </div>
    </section>

    <section class="mt-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <h2 class="text-base font-semibold text-gray-950 dark:text-white">Career Track Drafts</h2>
        @if($pendingCareerTracks->isEmpty())
        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">No career track drafts are waiting to publish.</p>
        @else
        <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
            @foreach($pendingCareerTracks as $track)
            <div class="flex flex-wrap items-center justify-between gap-3 py-4 first:pt-0 last:pb-0">
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ data_get($track->draft, 'title') }}</p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $track->slug }} · {{ data_get($track->draft, 'category') }}</p>
                </div>
                <x-filament::button wire:click="publishCareerTrack({{ $track->id }})" size="sm">Publish</x-filament::button>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    <section class="mt-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <h2 class="text-base font-semibold text-gray-950 dark:text-white">Draft Changes</h2>
        @if($pendingSections->isEmpty())
        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Everything is published.</p>
        @else
        <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
            @foreach($pendingSections as $section)
            <div class="flex flex-wrap items-center justify-between gap-3 py-4 first:pt-0 last:pb-0">
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $section->label }}</p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ data_get($section->draft, 'title') }}</p>
                </div>
                <x-filament::button wire:click="publishSection({{ $section->id }})" size="sm">Publish</x-filament::button>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    <section class="mt-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <h2 class="text-base font-semibold text-gray-950 dark:text-white">Resume Drafts</h2>
        @if($pendingResumes->isEmpty())
        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">No resume drafts are waiting to publish.</p>
        @else
        <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
            @foreach($pendingResumes as $resumeType)
            <div class="flex flex-wrap items-center justify-between gap-3 py-4 first:pt-0 last:pb-0">
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ data_get($resumeType->draft, 'label') }}</p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $resumeType->type_key }} · {{ data_get($resumeType->draft, 'headline') }}</p>
                </div>
                <x-filament::button wire:click="publishResume({{ $resumeType->id }})" size="sm">Publish</x-filament::button>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    <section class="mt-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <h2 class="text-base font-semibold text-gray-950 dark:text-white">Version History</h2>
        <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($recentVersions as $version)
            <div class="flex flex-wrap items-center justify-between gap-3 py-4 first:pt-0 last:pb-0">
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $version->section?->label ?? 'Homepage section' }} · v{{ $version->version }}</p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $version->created_at->format('M j, Y g:i A') }} · {{ data_get($version->content, 'title') }}</p>
                </div>
                <x-filament::button wire:click="rollbackVersion({{ $version->id }})" size="sm" color="gray">Rollback</x-filament::button>
            </div>
            @empty
            <p class="py-4 text-sm text-gray-500 dark:text-gray-400">No published versions yet.</p>
            @endforelse
        </div>
    </section>

    <section class="mt-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <h2 class="text-base font-semibold text-gray-950 dark:text-white">Resume Versions</h2>
        <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($recentResumeVersions as $version)
            <div class="flex flex-wrap items-center justify-between gap-3 py-4 first:pt-0 last:pb-0">
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ data_get($version->resumeType?->published, 'label', 'Resume') }} · v{{ $version->version }}</p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $version->created_at->format('M j, Y g:i A') }} · {{ data_get($version->content, 'headline') }}</p>
                </div>
                <x-filament::button wire:click="rollbackResumeVersion({{ $version->id }})" size="sm" color="gray">Rollback</x-filament::button>
            </div>
            @empty
            <p class="py-4 text-sm text-gray-500 dark:text-gray-400">No resume versions have been published yet.</p>
            @endforelse
        </div>
    </section>

    <section class="mt-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <h2 class="text-base font-semibold text-gray-950 dark:text-white">Career Track Versions</h2>
        <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($recentCareerTrackVersions as $version)
            <div class="flex flex-wrap items-center justify-between gap-3 py-4 first:pt-0 last:pb-0">
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ data_get($version->careerTrack?->published, 'title', 'Career Track') }} · v{{ $version->version }}</p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $version->created_at->format('M j, Y g:i A') }}</p>
                </div>
                <x-filament::button wire:click="rollbackCareerTrackVersion({{ $version->id }})" size="sm" color="gray">Rollback</x-filament::button>
            </div>
            @empty
            <p class="py-4 text-sm text-gray-500 dark:text-gray-400">No career track versions have been published yet.</p>
            @endforelse
        </div>
    </section>
</x-filament-panels::page>