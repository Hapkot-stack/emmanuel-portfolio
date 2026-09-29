<?php

namespace App\Filament\Admin\Resources\ProjectResource\Pages;

use App\Filament\Admin\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;
    public function getSubheading(): ?string
    {
        return 'Create and manage projects displayed publicly in your portfolio.';
    }
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
