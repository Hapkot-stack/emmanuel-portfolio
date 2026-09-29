<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SkillResource\Pages;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SkillResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = Skill::class;
    protected static ?string $navigationIcon  = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'About Me';
    protected static ?int    $navigationSort  = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\Select::make('category')
                ->options(array_combine(Skill::categories(), array_map('ucfirst', Skill::categories())))
                ->required(),
            Forms\Components\TextInput::make('proficiency')->numeric()->minValue(0)->maxValue(100)->suffix('%')->default(80),
            Forms\Components\TextInput::make('icon')->placeholder('e.g. html5, laravel, php'),
            Forms\Components\ColorPicker::make('color'),
            Forms\Components\TextInput::make('badge_label')->placeholder('Expert, Intermediate…'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('featured')->inline()->label('Show on homepage'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
            Tables\Columns\BadgeColumn::make('category')->colors(['info' => 'technical', 'success' => 'design', 'warning' => 'tool', 'gray' => 'soft']),
            Tables\Columns\TextColumn::make('proficiency')->suffix('%')->sortable(),
            Tables\Columns\IconColumn::make('featured')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->sortable(),
        ])
            ->filters([Tables\Filters\SelectFilter::make('category')->options(array_combine(Skill::categories(), array_map('ucfirst', Skill::categories())))])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit'   => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
