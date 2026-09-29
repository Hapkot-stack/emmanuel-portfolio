<?php

namespace App\Filament\Admin\Resources\ResumeTypeResource\Pages;

use App\Filament\Admin\Resources\ResumeTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResumeType extends EditRecord
{
    protected static string $resource = ResumeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
