<?php
namespace App\Filament\Admin\Resources\ExperienceResource\Pages;
use App\Filament\Admin\Resources\ExperienceResource;
use Filament\Resources\Pages\CreateRecord;
class CreateExperience extends CreateRecord { protected static string $resource = ExperienceResource::class; protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); } }
