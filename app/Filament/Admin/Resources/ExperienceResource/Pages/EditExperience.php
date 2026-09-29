<?php
namespace App\Filament\Admin\Resources\ExperienceResource\Pages;
use App\Filament\Admin\Resources\ExperienceResource;
use Filament\Actions; use Filament\Resources\Pages\EditRecord;
class EditExperience extends EditRecord { protected static string $resource = ExperienceResource::class; protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; } protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); } }
