<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ContactInquiryResource\Pages;
use App\Models\ContactInquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactInquiryResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = ContactInquiry::class;
    protected static ?string $navigationIcon  = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Contact';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $navigationLabel = 'Inquiries';

    public static function getNavigationBadge(): ?string
    {
        return (string) ContactInquiry::where('status', 'new')->count() ?: null;
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->disabled(),
            Forms\Components\TextInput::make('email')->email()->disabled(),
            Forms\Components\TextInput::make('company')->disabled(),
            Forms\Components\TextInput::make('phone')->disabled(),
            Forms\Components\Select::make('reason')->options(ContactInquiry::REASONS)->disabled(),
            Forms\Components\Select::make('status')->options(['new' => 'New', 'read' => 'Read', 'replied' => 'Replied', 'archived' => 'Archived'])->required(),
            Forms\Components\Textarea::make('message')->disabled()->rows(5)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\BadgeColumn::make('reason')
                ->formatStateUsing(fn($state) => ContactInquiry::REASONS[$state] ?? $state),
            Tables\Columns\BadgeColumn::make('status')
                ->colors(['warning' => 'new', 'gray' => 'read', 'success' => 'replied', 'danger' => 'archived']),
            Tables\Columns\TextColumn::make('created_at')->since()->sortable(),
        ])->defaultSort('created_at', 'desc')
            ->filters([Tables\Filters\SelectFilter::make('status')->options(['new' => 'New', 'read' => 'Read', 'replied' => 'Replied', 'archived' => 'Archived'])])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListContactInquiries::route('/'),
            'view'   => Pages\ViewContactInquiry::route('/{record}'),
            'edit'   => Pages\EditContactInquiry::route('/{record}/edit'),
        ];
    }
}
