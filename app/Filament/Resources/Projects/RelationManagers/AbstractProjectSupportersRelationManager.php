<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\ProjectSupporterType;
use App\Models\ProjectClubSupporter;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractProjectSupportersRelationManager extends RelationManager
{
    protected static bool $isLazy = false;

    protected static string $relationship = 'supporters';

    protected static ?string $recordTitleAttribute = 'name';

    public function isReadOnly(): bool
    {
        return false;
    }

    abstract protected static function supporterType(): ProjectSupporterType;

    abstract protected static function createActionLabel(): string;

    protected static function hasSupporterTypeColumn(): bool
    {
        return ProjectClubSupporter::hasSupporterTypeColumn();
    }

    public function form(Schema $schema): Schema
    {
        $components = [];

        if (static::hasSupporterTypeColumn()) {
            $components[] = Hidden::make('supporter_type')
                ->default(static::supporterType()->value);
        }

        $components = array_merge($components, [
            FileUpload::make('image_path')
                ->label('Imagen')
                ->image()
                ->imageEditor()
                ->required(static::supporterType() === ProjectSupporterType::Club)
                ->disk('public')
                ->directory('project/supporters')
                ->visibility('public')
                ->columnSpanFull(),
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            Textarea::make('description')
                ->label('Descripción')
                ->required()
                ->rows(4)
                ->columnSpanFull(),
        ]);

        return $schema
            ->columns(2)
            ->components($components);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                if (! static::hasSupporterTypeColumn()) {
                    return static::supporterType() === ProjectSupporterType::Club
                        ? $query
                        : $query->whereRaw('1 = 0');
                }

                return $query->where('supporter_type', static::supporterType()->value);
            })
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descripción')
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
                ...(
                    static::hasSupporterTypeColumn() || static::supporterType() === ProjectSupporterType::Club
                        ? [
                            CreateAction::make()
                                ->label(static::createActionLabel()),
                        ]
                        : []
                ),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
