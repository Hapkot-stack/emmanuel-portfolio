<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TimelineResource\Pages;
use App\Models\TimelineEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TimelineResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = TimelineEntry::class;
    protected static ?string $navigationIcon  = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Timeline';
    protected static ?string $navigationLabel = 'Timeline Events';
    protected static ?int    $navigationSort  = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('year')->required()->placeholder('2024'),
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Select::make('type')->options(['milestone' => 'Milestone', 'education' => 'Education', 'work' => 'Work', 'project' => 'Project', 'achievement' => 'Achievement'])->default('milestone'),
            Forms\Components\ColorPicker::make('color'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('year')->sortable()->weight('bold'),
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\BadgeColumn::make('type'),
            Tables\Columns\TextColumn::make('sort_order')->sortable(),
        ])->defaultSort('sort_order', 'desc')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTimelines::route('/'),
            'create' => Pages\CreateTimeline::route('/create'),
            'edit'   => Pages\EditTimeline::route('/{record}/edit'),
        ];
    }
}
