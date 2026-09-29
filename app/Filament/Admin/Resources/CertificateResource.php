<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CertificateResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = Certificate::class;
    protected static ?string $navigationIcon  = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'About Me';
    protected static ?string $navigationLabel = 'Certifications';
    protected static ?int    $navigationSort  = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('issuer')->required(),
            Forms\Components\TextInput::make('year')->required()->placeholder('2024'),
            Forms\Components\TextInput::make('credential_url')->url(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\FileUpload::make('image')->image()->directory('certificates')->visibility('public')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->height(40),
            Tables\Columns\TextColumn::make('title')->searchable()->weight('bold'),
            Tables\Columns\TextColumn::make('issuer'),
            Tables\Columns\TextColumn::make('year'),
            Tables\Columns\TextColumn::make('sort_order')->sortable(),
        ])->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit'   => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
