<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExperienceResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = Experience::class;
    protected static ?string $navigationIcon  = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'About Me';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('company')->required(),
            Forms\Components\TextInput::make('location'),
            Forms\Components\TextInput::make('period')->required()->placeholder('2023 – Present'),
            Forms\Components\Select::make('type')->options(['work' => 'Work', 'freelance' => 'Freelance', 'volunteer' => 'Volunteer'])->required()->default('work'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('current')->inline()->label('Current role'),
            Forms\Components\Textarea::make('description')->rows(4)->required()->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->weight('bold'),
            Tables\Columns\TextColumn::make('company')->searchable(),
            Tables\Columns\TextColumn::make('period'),
            Tables\Columns\BadgeColumn::make('type')->colors(['info' => 'work', 'success' => 'freelance', 'warning' => 'volunteer']),
            Tables\Columns\IconColumn::make('current')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->sortable(),
        ])->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit'   => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
