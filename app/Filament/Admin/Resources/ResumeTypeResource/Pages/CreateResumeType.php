<?php

namespace App\Filament\Admin\Resources\ResumeTypeResource\Pages;

use App\Filament\Admin\Resources\ResumeTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateResumeType extends CreateRecord
{
    protected static string $resource = ResumeTypeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sort_order'] = (int) data_get($data, 'draft.sort_order', 0);
        $data['template'] = data_get($data, 'draft.template', 'developer');
        $data['published'] = [];
        $data['version'] = 0;

        return $data;
    }
}
