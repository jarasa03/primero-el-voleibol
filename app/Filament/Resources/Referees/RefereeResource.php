<?php

namespace App\Filament\Resources\Referees;

use App\Filament\Resources\Referees\Pages\CreateReferee;
use App\Filament\Resources\Referees\Pages\EditReferee;
use App\Filament\Resources\Referees\Pages\ListReferees;
use App\Models\Referee;
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

class RefereeResource extends Resource
{
    protected static ?string $model = Referee::class;

    protected static ?string $modelLabel = 'árbitro';

    protected static ?string $pluralModelLabel = 'árbitros';

    protected static ?string $navigationLabel = 'Árbitros';

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
                    ->disk('public')
                    ->directory('referees')
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
                    ->label('Mostrar como árbitro colaborador')
                    ->helperText('Si está activado, este árbitro aparecerá en el carrusel público de árbitros colaboradores.')
                    ->default(false),
                Toggle::make('show_as_proposed_for_assembly')
                    ->label('Mostrar como árbitro propuesto')
                    ->helperText('Si está activado, este árbitro aparecerá en la sección pública de árbitros propuestos.')
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
            'index' => ListReferees::route('/'),
            'create' => CreateReferee::route('/create'),
            'edit' => EditReferee::route('/{record}/edit'),
        ];
    }
}
