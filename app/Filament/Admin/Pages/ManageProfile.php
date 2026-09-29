<?php

namespace App\Filament\Admin\Pages;

use App\Models\Profile;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageProfile extends Page implements HasForms
{
    protected static bool $shouldRegisterNavigation = false;

    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'About Me';
    protected static ?string $navigationLabel = 'Profile & Bio';
    protected static ?int    $navigationSort  = 2;
    protected static string  $view            = 'filament.admin.pages.manage-profile';

    public function getSubheading(): ?string
    {
        return 'Update the public biography and portrait used across your website and resumes.';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $profile = Profile::first() ?? new Profile();
        $this->form->fill($profile->toArray());
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Personal Info')->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('title')->required()->label('Professional Title'),
                Forms\Components\TextInput::make('subtitle')->label('Tagline'),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('phone'),
                Forms\Components\TextInput::make('location'),
                Forms\Components\TextInput::make('years_experience')->label('Years of Experience'),
                Forms\Components\TextInput::make('open_to')->label('Open To')->placeholder('Fulltime, Freelance, Remote'),
            ])->columns(2),

            Forms\Components\Section::make('Bio')->schema([
                Forms\Components\Textarea::make('bio')->rows(4)->label('Full Bio')->columnSpanFull(),
                Forms\Components\Textarea::make('bio_short')->rows(2)->label('Short Bio (for CV header)')->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Links')->schema([
                Forms\Components\TextInput::make('github_url')->url()->label('GitHub URL'),
                Forms\Components\TextInput::make('linkedin_url')->url()->label('LinkedIn URL'),
                Forms\Components\TextInput::make('whatsapp')->label('WhatsApp Number'),
            ])->columns(2),

            Forms\Components\Section::make('Homepage Data')->schema([
                Forms\Components\TagsInput::make('titles')
                    ->label('Typed Titles (for hero animation)')
                    ->placeholder('Add a title and press Enter')
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('tech_stack')
                    ->label('Tech Stack Chips')
                    ->placeholder('Add a tech and press Enter')
                    ->columnSpanFull(),
            ]),

        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        Profile::updateOrCreate(['id' => 1], $data);
        Notification::make()->title('Profile saved!')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [Action::make('save')->label('Save Profile')->action('save')];
    }
}
