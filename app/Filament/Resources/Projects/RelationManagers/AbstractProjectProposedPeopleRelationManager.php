<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectProposedPersonType;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractProjectProposedPeopleRelationManager extends RelationManager
{
    protected static bool $isLazy = false;

    protected static string $relationship = 'proposedPeople';

    protected static ?string $recordTitleAttribute = 'name';

    public function isReadOnly(): bool
    {
        return false;
    }

    abstract protected static function proposedType(): ProjectProposedPersonType;

    abstract protected static function createActionLabel(): string;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Hidden::make('proposed_type')
                    ->default(static::proposedType()->value),
                TextInput::make('initials')
                    ->label('Iniciales')
                    ->maxLength(10)
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->maxLength(255)
                    ->helperText('Puedes dejarlo vacío si todavía está por definir.')
                    ->columnSpanFull(),
                TextInput::make('title')
                    ->label('Cargo o titulación')
                    ->maxLength(255)
                    ->helperText('Si aún no está cerrado, puedes dejarlo en blanco.')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Descripción')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->where('proposed_type', static::proposedType()->value);
            })
            ->columns([
                TextColumn::make('initials')
                    ->label('Iniciales')
                    ->placeholder('Pendiente')
                    ->badge(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->placeholder('Pendiente de definir')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Cargo o titulación')
                    ->placeholder('Pendiente de definir')
                    ->wrap(),
                TextColumn::make('description')
                    ->label('Descripción')
                    ->placeholder('Sin descripción')
                    ->limit(90)
                    ->wrap(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->headerActions([
                CreateAction::make()
                    ->label(static::createActionLabel()),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
