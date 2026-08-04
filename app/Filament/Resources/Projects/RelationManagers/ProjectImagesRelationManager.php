<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectImagesRelationManager extends RelationManager
{
    protected static bool $isLazy = false;

    protected static string $relationship = 'images';

    protected static ?string $recordTitleAttribute = 'alt_text';

    protected static ?string $modelLabel = 'imagen';

    protected static ?string $pluralModelLabel = 'imágenes';

    protected static ?string $title = 'Imágenes de Francisco Sabroso';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                FileUpload::make('image_path')
                    ->label('Imagen')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->disk('public')
                    ->directory('project/leader')
                    ->visibility('public')
                    ->imageAspectRatio('4:5')
                    ->columnSpanFull(),
                TextInput::make('alt_text')
                    ->label('Texto alternativo')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->square(),
                TextColumn::make('alt_text')
                    ->label('Texto alternativo')
                    ->placeholder('Sin texto alternativo')
                    ->wrap(),
                TextColumn::make('updated_at')
                    ->label('Actualizada')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->headerActions([
                CreateAction::make()
                    ->label('Añadir imagen'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
