<x-filament-panels::page>
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-primary-200 bg-primary-50 p-4 dark:border-primary-800 dark:bg-primary-950">
        <div>
            <h2 class="text-sm font-semibold text-gray-950 dark:text-white">Homepage content drafts</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Changes are private until published from Publish Center.</p>
        </div>
        <x-filament::button tag="a" href="{{ route('admin.homepage-preview') }}?draft=1" target="_blank" icon="heroicon-o-eye" color="gray">
            Preview Draft
        </x-filament::button>
    </div>

    <form wire:submit="saveDraft">
        {{ $this->form }}
        <div class="mt-6 flex justify-end">
            <x-filament::button type="submit" size="lg">Save Draft</x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals />
</x-filament-panels::page>