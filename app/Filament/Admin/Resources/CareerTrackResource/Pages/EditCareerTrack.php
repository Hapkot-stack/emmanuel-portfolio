<?php

namespace App\Filament\Admin\Resources\CareerTrackResource\Pages;

use App\Filament\Admin\Resources\CareerTrackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareerTrack extends EditRecord
{
    protected static string $resource = CareerTrackResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
