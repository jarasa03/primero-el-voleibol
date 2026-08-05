<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Resources\Projects\Pages\ViewProject;
use App\Filament\Resources\Projects\RelationManagers\ProjectCoachSupportersRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ProjectImagesRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ProjectPlayerSupportersRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ProjectProposedCoachesRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ProjectProposedPlayersRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ProjectProposedRefereesRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ProjectRefereeSupportersRelationManager;
use App\Filament\Resources\Projects\Tables\ProjectsTable;
use App\Models\Project;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $modelLabel = 'proyecto';

    protected static ?string $pluralModelLabel = 'proyectos';

    protected static ?string $navigationLabel = 'Proyecto';

    protected static string|UnitEnum|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Liderazgo')
                    ->schema([
                        Toggle::make('show_leader_section')
                            ->label('Mostrar liderazgo')
                            ->helperText('Controla si la tarjeta de Francisco Sabroso aparece en la página pública de proyecto.'),
                    ]),
                Section::make('Árbitros propuestos')
                    ->schema([
                        Toggle::make('show_proposed_referees_section')
                            ->label('Mostrar árbitros propuestos')
                            ->helperText('Controla si el bloque de árbitros propuestos aparece en la página pública de proyecto.'),
                        TextInput::make('proposed_referees_minimum_count')
                            ->label('Mínimo de árbitros')
                            ->helperText('Las tarjetas vacías se completarán con "Aún por definir" hasta llegar a este número.')
                            ->numeric()
                            ->minValue(0)
                            ->default(3),
                    ])
                    ->columns(2),
                Section::make('Entrenadores propuestos')
                    ->schema([
                        Toggle::make('show_proposed_coaches_section')
                            ->label('Mostrar entrenadores propuestos')
                            ->helperText('Controla si el bloque de entrenadores propuestos aparece en la página pública de proyecto.'),
                        TextInput::make('proposed_coaches_minimum_count')
                            ->label('Mínimo de entrenadores')
                            ->helperText('Las tarjetas vacías se completarán con "Aún por definir" hasta llegar a este número.')
                            ->numeric()
                            ->minValue(0)
                            ->default(3),
                    ])
                    ->columns(2),
                Section::make('Jugadores propuestos')
                    ->schema([
                        Toggle::make('show_proposed_players_section')
                            ->label('Mostrar jugadores propuestos')
                            ->helperText('Controla si el bloque de jugadores propuestos aparece en la página pública de proyecto.'),
                        TextInput::make('proposed_players_minimum_count')
                            ->label('Mínimo de jugadores')
                            ->helperText('Las tarjetas vacías se completarán con "Aún por definir" hasta llegar a este número.')
                            ->numeric()
                            ->minValue(0)
                            ->default(3),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'images' => ProjectImagesRelationManager::class,
            'referees' => ProjectRefereeSupportersRelationManager::class,
            'coaches' => ProjectCoachSupportersRelationManager::class,
            'players' => ProjectPlayerSupportersRelationManager::class,
            'proposed_referees' => ProjectProposedRefereesRelationManager::class,
            'proposed_coaches' => ProjectProposedCoachesRelationManager::class,
            'proposed_players' => ProjectProposedPlayersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'view' => ViewProject::route('/view/{record}'),
            'edit' => EditProject::route('/{record}'),
        ];
    }
}
