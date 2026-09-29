<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SocialLinkResource\Pages;
use App\Models\SocialLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialLinkResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = SocialLink::class;
    protected static ?string $navigationIcon  = 'heroicon-o-share';
    protected static ?string $navigationGroup = 'Website';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $navigationLabel = 'Social Links';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('platform')->required()->placeholder('github'),
            Forms\Components\TextInput::make('label')->required()->placeholder('GitHub'),
            Forms\Components\TextInput::make('url')->required()->placeholder('https://…'),
            Forms\Components\TextInput::make('icon')->placeholder('github'),
            Forms\Components\ColorPicker::make('color'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('active')->inline()->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('platform')->weight('bold'),
            Tables\Columns\TextColumn::make('label'),
            Tables\Columns\TextColumn::make('url')->limit(40),
            Tables\Columns\IconColumn::make('active')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->sortable(),
        ])->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSocialLinks::route('/'),
            'create' => Pages\CreateSocialLink::route('/create'),
            'edit'   => Pages\EditSocialLink::route('/{record}/edit'),
        ];
    }
}
