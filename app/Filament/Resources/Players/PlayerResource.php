<?php

namespace App\Filament\Resources\Players;

use App\Filament\Resources\Players\Pages\CreatePlayer;
use App\Filament\Resources\Players\Pages\EditPlayer;
use App\Filament\Resources\Players\Pages\ListPlayers;
use App\Models\Player;
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

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static ?string $modelLabel = 'jugador';

    protected static ?string $pluralModelLabel = 'jugadores';

    protected static ?string $navigationLabel = 'Jugadores';

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
                    ->directory('players')
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
                    ->label('Mostrar como jugador colaborador')
                    ->helperText('Si está activado, este jugador aparecerá en el carrusel público de jugadores colaboradores.')
                    ->default(false),
                Toggle::make('show_as_proposed_for_assembly')
                    ->label('Mostrar como jugador propuesto')
                    ->helperText('Si está activado, este jugador aparecerá en la sección pública de jugadores propuestos.')
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
            'index' => ListPlayers::route('/'),
            'create' => CreatePlayer::route('/create'),
            'edit' => EditPlayer::route('/{record}/edit'),
        ];
    }
}
