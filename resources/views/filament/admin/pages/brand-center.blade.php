<x-filament-panels::page>
    <div class="mb-5 max-w-3xl">
        <p class="text-sm leading-6 text-gray-600 dark:text-gray-300">Manage the profile image used throughout the public website. The original upload is kept and responsive versions are generated automatically.</p>
    </div>

    <form wire:submit="save">
        {{ $this->form }}
        <div class="mt-6 flex justify-end">
            <x-filament::button type="submit">Save Image</x-filament::button>
        </div>
    </form>

    <x-filament-actions::modals />
</x-filament-panels::page>