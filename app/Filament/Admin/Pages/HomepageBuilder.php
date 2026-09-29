<?php

namespace App\Filament\Admin\Pages;

use App\Models\HomepageSection;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class HomepageBuilder extends Page implements HasForms
{
    protected static bool $shouldRegisterNavigation = false;

    use InteractsWithForms;

    protected static ?string $navigationGroup = 'Home Page';
    protected static ?string $navigationLabel = 'Homepage Sections';
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.admin.pages.homepage-builder';

    public ?array $data = [];

    public function getSubheading(): ?string
    {
        return 'Arrange homepage content, update section copy, and choose what visitors can see.';
    }

    public function mount(): void
    {
        $this->form->fill([
            'sections' => HomepageSection::all()
                ->sortBy(fn(HomepageSection $section) => data_get($section->draft, 'sort_order', 0))
                ->map(fn(HomepageSection $section) => [
                    'section_key' => $section->section_key,
                    'label' => $section->label,
                    'title' => data_get($section->draft, 'title'),
                    'description' => data_get($section->draft, 'description'),
                    'visible' => data_get($section->draft, 'visible', true),
                    'mobile_visible' => data_get($section->draft, 'mobile_visible', true),
                    'desktop_visible' => data_get($section->draft, 'desktop_visible', true),
                    'sort_order' => data_get($section->draft, 'sort_order', 0),
                ])
                ->values()
                ->all(),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('sections')
                    ->label('Homepage Sections')
                    ->schema([
                        Hidden::make('section_key'),
                        TextInput::make('label')->disabled()->dehydrated(),
                        TextInput::make('title')->required()->maxLength(160),
                        Textarea::make('description')->rows(2)->maxLength(500)->columnSpanFull(),
                        TextInput::make('sort_order')->numeric()->required()->minValue(0),
                        Toggle::make('visible')->label('Visible'),
                        Toggle::make('mobile_visible')->label('Show on mobile'),
                        Toggle::make('desktop_visible')->label('Show on desktop'),
                    ])
                    ->columns(2)
                    ->itemLabel(fn(array $state): ?string => $state['label'] ?? null)
                    ->collapsible()
                    ->collapsed()
                    ->addable(false)
                    ->deletable(false)
                    ->reorderable(false),
            ])
            ->statePath('data');
    }

    public function saveDraft(): void
    {
        foreach ($this->form->getState()['sections'] as $section) {
            HomepageSection::where('section_key', $section['section_key'])->update([
                'draft' => [
                    'title' => $section['title'],
                    'description' => $section['description'] ?? '',
                    'visible' => (bool) $section['visible'],
                    'mobile_visible' => (bool) $section['mobile_visible'],
                    'desktop_visible' => (bool) $section['desktop_visible'],
                    'sort_order' => (int) $section['sort_order'],
                ],
            ]);
        }

        Notification::make()->title('Homepage draft saved')->success()->send();
    }
}
