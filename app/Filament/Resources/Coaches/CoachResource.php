<?php

namespace App\Filament\Resources\Coaches;

use App\Filament\Resources\Coaches\Pages\CreateCoach;
use App\Filament\Resources\Coaches\Pages\EditCoach;
use App\Filament\Resources\Coaches\Pages\ListCoaches;
use App\Models\Coach;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class CoachResource extends Resource
{
    protected static ?string $model = Coach::class;

    protected static ?string $modelLabel = 'entrenador';

    protected static ?string $pluralModelLabel = 'entrenadores';

    protected static ?string $navigationLabel = 'Entrenadores';

    protected static string|UnitEnum|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                FileUpload::make('logo_path')
                    ->label('Logotipo')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->disk('public')
                    ->directory('coaches')
                    ->visibility('public')
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Descripción')
                    ->rows(4)
                    ->columnSpanFull(),
                Toggle::make('show_as_collaborator')
                    ->label('Mostrar como entrenador colaborador')
                    ->helperText('Si está activado, este entrenador aparecerá en el carrusel público de entrenadores colaboradores.')
                    ->default(false),
                Toggle::make('show_as_proposed_for_assembly')
                    ->label('Mostrar como entrenador propuesto')
                    ->helperText('Si está activado, este entrenador aparecerá en la sección pública de entrenadores propuestos.')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('show_as_collaborator')
                    ->label('Colaborador')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => $state ? 'Sí' : 'No')
                    ->color(fn (mixed $state): string => $state ? 'success' : 'gray'),
                TextColumn::make('show_as_proposed_for_assembly')
                    ->label('Propuesto')
                    ->badge()
                    ->formatStateUsing(fn (mixed $state): string => $state ? 'Sí' : 'No')
                    ->color(fn (mixed $state): string => $state ? 'success' : 'gray'),
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
            ->reorderable('sort');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCoaches::route('/'),
            'create' => CreateCoach::route('/create'),
            'edit' => EditCoach::route('/{record}/edit'),
        ];
    }
}
