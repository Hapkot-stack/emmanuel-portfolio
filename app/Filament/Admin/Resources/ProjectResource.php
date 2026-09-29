<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProjectResource\Pages;
use App\Filament\Admin\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon  = 'heroicon-o-code-bracket';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Project')->columnSpanFull()->tabs([

                Forms\Components\Tabs\Tab::make('Basic Info')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()->live(onBlur: true)
                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    Forms\Components\Select::make('status')
                        ->options(Project::STATUSES)->required()->default('draft'),
                    Forms\Components\TextInput::make('progress')
                        ->numeric()->minValue(0)->maxValue(100)->suffix('%')->default(0),
                    Forms\Components\Textarea::make('short_description')->rows(2)->columnSpanFull(),
                    Forms\Components\Textarea::make('description')->rows(4)->required()->columnSpanFull(),
                    Forms\Components\TextInput::make('technologies')
                        ->placeholder('Laravel, PHP, MySQL')->columnSpanFull(),
                    Forms\Components\Toggle::make('featured')->inline()->default(false),
                    Forms\Components\Toggle::make('website_available')->inline()->label('Website is live')->default(false),
                    Forms\Components\TextInput::make('github_url')->url()->prefixIcon('heroicon-o-link'),
                    Forms\Components\TextInput::make('website_url')->url()->prefixIcon('heroicon-o-globe-alt'),
                    Forms\Components\TextInput::make('demo_video_url')->url()->label('Demo Video URL'),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\FileUpload::make('cover_image')
                        ->image()->directory('projects')->visibility('public')
                        ->columnSpanFull()->imagePreviewHeight('200'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Details')->schema([
                    Forms\Components\Textarea::make('problem')->rows(4)->label('Problem Statement'),
                    Forms\Components\Textarea::make('solution')->rows(4)->label('Solution'),
                    Forms\Components\Textarea::make('challenges')->rows(4),
                    Forms\Components\Textarea::make('lessons_learned')->rows(4),
                    Forms\Components\TagsInput::make('features')->label('Key Features (press Enter)')->columnSpanFull(),
                    Forms\Components\TagsInput::make('roadmap')->label('Roadmap Items (press Enter)')->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Publish')->schema([
                    Forms\Components\Select::make('status')
                        ->options(Project::STATUSES)->required(),
                    Forms\Components\DateTimePicker::make('published_at')->label('Publish Date'),
                ])->columns(2),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->circular(false)->height(40)->width(60)->defaultImageUrl(asset('placeholder.png')),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->weight('bold'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => fn($state) => in_array($state, ['published', 'live']),
                        'warning' => 'in_development',
                        'info'    => 'testing',
                        'danger'  => 'archived',
                        'gray'    => 'draft',
                    ]),
                Tables\Columns\TextColumn::make('progress')->suffix('%')->sortable(),
                Tables\Columns\IconColumn::make('featured')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(Project::STATUSES),
                Tables\Filters\TernaryFilter::make('featured'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->url(fn(Project $p) => route('projects.show', $p->slug))
                    ->openUrlInNewTab()->icon('heroicon-o-eye')->color('gray'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()])
            ->defaultSort('sort_order');
    }

    public static function getRelationManagers(): array
    {
        return [RelationManagers\ScreenshotsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
