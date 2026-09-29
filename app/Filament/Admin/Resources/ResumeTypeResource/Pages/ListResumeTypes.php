<?php

namespace App\Filament\Admin\Resources\ResumeTypeResource\Pages;

use App\Filament\Admin\Resources\ResumeTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResumeTypes extends ListRecords
{
    protected static string $resource = ResumeTypeResource::class;

    public function getSubheading(): ?string
    {
        return 'Manage public resumes, CVs, downloadable documents, and their display order.';
    }

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
