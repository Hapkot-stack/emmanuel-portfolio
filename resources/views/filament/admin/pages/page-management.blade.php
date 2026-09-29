<x-filament-panels::page>
    @php($section = $this->sectionContent())
    @php($cards = $this->sectionCards())
    @php($actions = $this->pageActions())
    @php($status = $this->pageStatus())

    <div class="mb-6 flex flex-wrap items-start justify-between gap-5">
        <div class="max-w-3xl">
            <h2 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">{{ $section['title'] }}</h2>
            <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-300">{{ $section['description'] }}</p>
        </div>
        <span @class([ 'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold' , 'bg-warning-50 text-warning-700 ring-1 ring-inset ring-warning-600/20'=> $status === 'Draft changes',
            'bg-success-50 text-success-700 ring-1 ring-inset ring-success-600/20' => in_array($status, ['Published', 'Live'], true),
            ])>{{ $status }}</span>
    </div>

    @if(count($cards))
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach($cards as $card)
        <section class="cms-section-card rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-base font-semibold text-gray-950 dark:text-white">{{ $card['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-300">{{ $card['description'] }}</p>
                </div>
            </div>
            <div class="mt-5 flex flex-wrap gap-2">
                @if($card['edit_url'])
                <x-filament::button tag="a" href="{{ $card['edit_url'] }}" size="sm" color="gray" icon="heroicon-o-pencil-square">
                    Edit Section
                </x-filament::button>
                @endif
                @if($card['preview_url'])
                <x-filament::button tag="a" href="{{ $card['preview_url'] }}" target="_blank" rel="noopener" size="sm" color="gray" outlined icon="heroicon-o-eye">
                    Preview Section
                </x-filament::button>
                @endif
            </div>
        </section>
        @endforeach
    </div>
    @endif

    <div class="mt-8 flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 pt-5 dark:border-gray-700">
        @if($actions['save_draft_url'])
        <x-filament::button tag="a" href="{{ $actions['save_draft_url'] }}" color="gray" outlined icon="heroicon-o-document-check">
            Save Draft
        </x-filament::button>
        @else
        <x-filament::button disabled color="gray" outlined icon="heroicon-o-document-check" title="Draft editing is not available for this page yet.">
            Save Draft
        </x-filament::button>
        @endif

        @if($actions['preview_url'])
        <x-filament::button tag="a" href="{{ $actions['preview_url'] }}" target="_blank" rel="noopener" color="gray" outlined icon="heroicon-o-eye">
            Preview Page
        </x-filament::button>
        @endif

        @if($actions['can_publish'])
        <x-filament::button tag="a" href="{{ $actions['publish_url'] }}" icon="heroicon-o-paper-airplane">
            Publish Page
        </x-filament::button>
        @else
        <x-filament::button disabled icon="heroicon-o-paper-airplane" title="Page-level publishing is not available for this page yet.">
            Publish Page
        </x-filament::button>
        @endif
    </div>
</x-filament-panels::page>