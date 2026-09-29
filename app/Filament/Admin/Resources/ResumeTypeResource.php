<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ResumeTypeResource\Pages;
use App\Models\ResumeType;
use App\Models\ResumeTypeVersion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResumeTypeResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = ResumeType::class;
    protected static ?string $navigationGroup = 'Resume Center';
    protected static ?string $navigationLabel = 'Resume Types';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('type_key')
                ->required()
                ->alphaDash()
                ->unique(ignoreRecord: true)
                ->disabled(fn(?ResumeType $record) => $record !== null)
                ->dehydrated(),
            Forms\Components\Select::make('draft.template')
                ->required()
                ->options([
                    'developer' => 'Developer',
                    'ict_officer' => 'ICT Officer',
                    'data_officer' => 'Data Officer',
                    'ngo' => 'NGO Technology',
                    'electrical' => 'Electrical / Maintenance',
                    'one_page' => 'One Page Resume',
                ]),
            Forms\Components\TextInput::make('draft.sort_order')->numeric()->required()->default(0),
            Forms\Components\TextInput::make('draft.label')->required()->maxLength(120),
            Forms\Components\TextInput::make('draft.headline')->required()->maxLength(160),
            Forms\Components\Textarea::make('draft.focus')->required()->rows(2)->columnSpanFull(),
            Forms\Components\Textarea::make('draft.summary')->rows(3)->columnSpanFull(),
            Forms\Components\TextInput::make('draft.icon')->maxLength(8),
            Forms\Components\ColorPicker::make('draft.color'),
            Forms\Components\Toggle::make('draft.is_public')->label('Show in public Resume Center'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type_key')->label('Key')->searchable(),
                Tables\Columns\TextColumn::make('label')
                    ->state(fn(ResumeType $record) => data_get($record->draft, 'label'))
                    ->searchable(query: fn($query, string $search) => $query->where('draft->label', 'like', "%{$search}%")),
                Tables\Columns\TextColumn::make('status')
                    ->state(fn(ResumeType $record) => $record->hasPendingChanges() ? 'Draft' : 'Published')
                    ->badge()
                    ->color(fn(string $state) => $state === 'Draft' ? 'warning' : 'success'),
                Tables\Columns\IconColumn::make('public')
                    ->state(fn(ResumeType $record) => (bool) data_get($record->published, 'is_public', false))
                    ->boolean(),
                Tables\Columns\TextColumn::make('version')->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn(ResumeType $record) => route('admin.resume.preview', $record->type_key))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('download')
                    ->label('Generate / Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(ResumeType $record) => route('admin.resume.download', $record->type_key)),
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-paper-airplane')
                    ->visible(fn(ResumeType $record) => $record->hasPendingChanges())
                    ->action(function (ResumeType $record): void {
                        DB::transaction(function () use ($record): void {
                            $record->version++;
                            $record->published = $record->draft;
                            $record->template = data_get($record->draft, 'template', $record->template);
                            $record->sort_order = (int) data_get($record->draft, 'sort_order', $record->sort_order);
                            $record->published_at = now();
                            $record->save();
                            $record->versions()->create([
                                'version' => $record->version,
                                'content' => $record->published,
                                'published_by' => auth()->id(),
                            ]);
                        });

                        Notification::make()->title('Resume published')->success()->send();
                    }),
                Tables\Actions\Action::make('versions')
                    ->icon('heroicon-o-clock')
                    ->modalHeading(fn(ResumeType $record) => data_get($record->published, 'label') . ' versions')
                    ->modalContent(fn(ResumeType $record) => view('filament.admin.pages.resume-versions', [
                        'versions' => $record->versions()->latest()->get(),
                    ])),
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->requiresConfirmation()
                    ->action(function (ResumeType $record): void {
                        $draft = $record->draft;
                        $draft['label'] = data_get($draft, 'label') . ' Copy';
                        $draft['is_public'] = false;
                        $draft['sort_order'] = (int) data_get($draft, 'sort_order', $record->sort_order) + 1;

                        ResumeType::create([
                            'type_key' => Str::slug($record->type_key . '-copy'),
                            'template' => $record->template,
                            'sort_order' => $draft['sort_order'],
                            'draft' => $draft,
                            'published' => [],
                            'version' => 0,
                        ]);

                        Notification::make()->title('Resume duplicated as a draft')->success()->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResumeTypes::route('/'),
            'create' => Pages\CreateResumeType::route('/create'),
            'edit' => Pages\EditResumeType::route('/{record}/edit'),
        ];
    }
}
