<?php

namespace App\Filament\Resources\Clubs;

use App\Filament\Resources\Clubs\Pages\CreateClub;
use App\Filament\Resources\Clubs\Pages\EditClub;
use App\Filament\Resources\Clubs\Pages\ListClubs;
use App\Models\Club;
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

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static ?string $modelLabel = 'club';

    protected static ?string $pluralModelLabel = 'clubes';

    protected static ?string $navigationLabel = 'Clubes';

    protected static string|UnitEnum|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

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
                    ->directory('clubs')
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
                    ->label('Mostrar como club colaborador')
                    ->helperText('Si está activado, este club aparecerá en el carrusel público de clubes.')
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
            'index' => ListClubs::route('/'),
            'create' => CreateClub::route('/create'),
            'edit' => EditClub::route('/{record}/edit'),
        ];
    }
}
