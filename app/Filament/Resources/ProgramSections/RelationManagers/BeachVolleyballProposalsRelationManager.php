<?php

namespace App\Filament\Resources\ProgramSections\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BeachVolleyballProposalsRelationManager extends RelationManager
{
    protected static bool $isLazy = false;

    protected static string $relationship = 'beachProposals';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'propuesta';

    protected static ?string $pluralModelLabel = 'propuestas';

    protected static ?string $title = 'Voley playa';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return (bool) $ownerRecord->beach_volleyball_enabled;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('description')
                    ->label('Descripción')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'bulletList',
                        'orderedList',
                    ])
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(90)
                    ->wrap(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->headerActions([
                CreateAction::make()
                    ->label('Crear propuesta')
                    ->modalHeading('Crear propuesta')
                    ->modalSubmitActionLabel('Crear propuesta')
                    ->mutateDataUsing(function (array $data): array {
                        $data['is_beach_volleyball'] = true;

                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
