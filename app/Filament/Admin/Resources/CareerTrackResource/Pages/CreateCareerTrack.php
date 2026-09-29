<?php

namespace App\Filament\Admin\Resources\CareerTrackResource\Pages;

use App\Filament\Admin\Resources\CareerTrackResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCareerTrack extends CreateRecord
{
    protected static string $resource = CareerTrackResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['published'] = [];
        $data['version'] = 0;

        return $data;
    }
}
