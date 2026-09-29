<?php
namespace App\Filament\Admin\Resources\ProjectResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ScreenshotsRelationManager extends RelationManager
{
    protected static string $relationship = 'screenshots';
    protected static ?string $title = 'Screenshots';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('image')
                ->image()->directory('screenshots')->visibility('public')->required()->columnSpanFull(),
            Forms\Components\TextInput::make('caption'),
            Forms\Components\Select::make('device_type')
                ->options(['desktop'=>'Desktop','tablet'=>'Tablet','mobile'=>'Mobile','architecture'=>'Architecture'])
                ->default('desktop'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->height(50)->width(80),
            Tables\Columns\TextColumn::make('caption'),
            Tables\Columns\BadgeColumn::make('device_type'),
            Tables\Columns\TextColumn::make('sort_order')->sortable(),
        ])->defaultSort('sort_order')
        ->headerActions([Tables\Actions\CreateAction::make()])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
