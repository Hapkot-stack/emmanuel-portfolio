<?php

namespace App\Filament\Admin\Resources\CareerTrackResource\Pages;

use App\Filament\Admin\Resources\CareerTrackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareerTracks extends ListRecords
{
    protected static string $resource = CareerTrackResource::class;

    public function getSubheading(): ?string
    {
        return 'Manage career paths and the specialized resume categories shown to visitors.';
    }

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
