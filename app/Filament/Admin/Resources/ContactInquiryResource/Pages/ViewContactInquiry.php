<?php
namespace App\Filament\Admin\Resources\ContactInquiryResource\Pages;
use App\Filament\Admin\Resources\ContactInquiryResource;
use Filament\Actions; use Filament\Resources\Pages\ViewRecord;
class ViewContactInquiry extends ViewRecord {
    protected static string $resource = ContactInquiryResource::class;
    protected function getHeaderActions(): array { return [Actions\EditAction::make()]; }
    protected function mutateFormDataBeforeFill(array $data): array {
        \App\Models\ContactInquiry::where('id', $this->record->id)->where('status','new')->update(['status'=>'read']);
        return $data;
    }
}
