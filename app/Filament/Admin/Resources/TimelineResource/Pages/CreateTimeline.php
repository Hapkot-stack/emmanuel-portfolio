<?php
namespace App\Filament\Admin\Resources\TimelineResource\Pages;
use App\Filament\Admin\Resources\TimelineResource;
use Filament\Resources\Pages\CreateRecord;
class CreateTimeline extends CreateRecord { protected static string $resource = TimelineResource::class; protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); } }
