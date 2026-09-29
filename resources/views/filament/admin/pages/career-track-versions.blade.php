<div class="space-y-3">
    @forelse($versions as $version)
    <div class="rounded-lg border border-gray-200 p-3 dark:border-gray-700">
        <div class="font-medium">Version {{ $version->version }}</div>
        <div class="text-sm text-gray-500">{{ $version->created_at->format('M j, Y g:i A') }}</div>
        <div class="mt-1 text-sm">{{ data_get($version->content, 'title') }} · {{ data_get($version->content, 'category') }}</div>
    </div>
    @empty
    <p class="text-sm text-gray-500">No versions have been published yet.</p>
    @endforelse
</div>