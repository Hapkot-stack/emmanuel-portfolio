<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CareerTrackResource\Pages;
use App\Models\CareerTrack;
use App\Models\Project;
use App\Models\ResumeType;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CareerTrackResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = CareerTrack::class;
    protected static ?string $navigationGroup = 'Career Center';
    protected static ?string $navigationLabel = 'Career Paths';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('slug')
                ->required()
                ->alphaDash()
                ->unique(ignoreRecord: true)
                ->disabled(fn(?CareerTrack $record) => $record !== null)
                ->dehydrated(),
            Forms\Components\TextInput::make('draft.title')->required()->maxLength(140),
            Forms\Components\TextInput::make('draft.category')->required()->maxLength(80),
            Forms\Components\Textarea::make('draft.description')->required()->rows(3)->columnSpanFull(),
            Forms\Components\Select::make('draft.resume_type')
                ->label('Connected Resume')
                ->options(ResumeType::query()->get()->mapWithKeys(fn(ResumeType $type) => [$type->type_key => data_get($type->draft, 'label')]))
                ->searchable(),
            Forms\Components\Select::make('draft.featured_skill_ids')
                ->label('Featured Skills')
                ->multiple()
                ->options(Skill::orderBy('name')->pluck('name', 'id'))
                ->searchable(),
            Forms\Components\Select::make('draft.featured_project_ids')
                ->label('Featured Projects')
                ->multiple()
                ->options(Project::orderBy('title')->pluck('title', 'id'))
                ->searchable(),
            Forms\Components\TextInput::make('draft.sort_order')->numeric()->required()->default(0),
            Forms\Components\Toggle::make('draft.is_public')->label('Publish on Career Center'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->state(fn(CareerTrack $record) => data_get($record->draft, 'title'))
                    ->searchable(query: fn($query, string $search) => $query->where('draft->title', 'like', "%{$search}%")),
                Tables\Columns\TextColumn::make('category')->state(fn(CareerTrack $record) => data_get($record->draft, 'category')),
                Tables\Columns\TextColumn::make('status')
                    ->state(fn(CareerTrack $record) => $record->hasPendingChanges() ? 'Draft' : 'Published')
                    ->badge()
                    ->color(fn(string $state) => $state === 'Draft' ? 'warning' : 'success'),
                Tables\Columns\IconColumn::make('public')->state(fn(CareerTrack $record) => (bool) data_get($record->published, 'is_public'))->boolean(),
                Tables\Columns\TextColumn::make('version')->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn(CareerTrack $record) => route('admin.career.preview', $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-paper-airplane')
                    ->visible(fn(CareerTrack $record) => $record->hasPendingChanges())
                    ->action(function (CareerTrack $record): void {
                        DB::transaction(function () use ($record): void {
                            $record->version++;
                            $record->published = $record->draft;
                            $record->published_at = now();
                            $record->save();
                            $record->versions()->create([
                                'version' => $record->version,
                                'content' => $record->published,
                                'published_by' => auth()->id(),
                            ]);
                        });

                        Notification::make()->title('Career track published')->success()->send();
                    }),
                Tables\Actions\Action::make('versions')
                    ->icon('heroicon-o-clock')
                    ->modalHeading(fn(CareerTrack $record) => data_get($record->published, 'title') . ' versions')
                    ->modalContent(fn(CareerTrack $record) => view('filament.admin.pages.career-track-versions', [
                        'versions' => $record->versions()->latest()->get(),
                    ])),
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->requiresConfirmation()
                    ->action(function (CareerTrack $record): void {
                        $draft = $record->draft;
                        $draft['title'] .= ' Copy';
                        $draft['is_public'] = false;

                        CareerTrack::create([
                            'slug' => Str::slug($record->slug . '-copy'),
                            'draft' => $draft,
                            'published' => [],
                            'version' => 0,
                        ]);

                        Notification::make()->title('Career track duplicated as a draft')->success()->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('slug');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCareerTracks::route('/'),
            'create' => Pages\CreateCareerTrack::route('/create'),
            'edit' => Pages\EditCareerTrack::route('/{record}/edit'),
        ];
    }
}
