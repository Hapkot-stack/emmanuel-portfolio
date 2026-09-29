<?php

namespace App\Filament\Admin\Pages;

use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class BrandCenter extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.admin.pages.brand-center';

    public ?array $data = [];

    public function mount(): void
    {
        $profile = Profile::first() ?? new Profile();
        $this->form->fill(['avatar' => $profile->avatar]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile Image')
                    ->description('This image is used on the homepage, profile cards, resumes, and recruiter preview.')
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->label('Profile Picture')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->directory('avatars')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['1:1'])
                            ->imagePreviewHeight('220')
                            ->helperText('Upload JPG, PNG, or WebP. The uploaded file is preserved; optimized sizes are generated for the website.')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Profile::updateOrCreate(['id' => 1], $this->form->getState());
        Notification::make()->title('Profile image saved')->success()->send();
    }
}
