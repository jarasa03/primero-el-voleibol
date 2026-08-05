<?php

namespace App\Filament\Pages;

use App\Enums\ProjectProposedPersonType;
use App\Enums\ProjectSupporterType;
use App\Filament\Resources\Clubs\ClubResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Club;
use App\Models\Project;
use App\Models\ProjectClubSupporter;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use UnitEnum;

class ProjectContentHub extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = 'Proyecto';

    protected static string|UnitEnum|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected string $view = 'filament.pages.project-content-hub';

    public function getTitle(): string
    {
        return 'Proyecto';
    }

    public function getHeading(): string
    {
        return 'Proyecto';
    }

    public function getSubheading(): string
    {
        return 'Contenido editable de la página de proyecto.';
    }

    public function table(Table $table): Table
    {
        $project = Project::ensureSingleton();
        $buildProjectUrl = function (?string $relation = null) use ($project): string {
            $parameters = ['record' => $project];

            if (filled($relation)) {
                $parameters['relation'] = $relation;
            }

            return ProjectResource::getUrl('edit', $parameters);
        };

        return $table
            ->records(function () use ($project, $buildProjectUrl): Collection {
                return collect([
                    [
                        'id' => 'leadership',
                        'section' => 'Liderazgo',
                        'description' => 'Bloque de Francisco Sabroso, con visibilidad del liderazgo y acceso directo a sus fotos.',
                        'status' => $project->show_leader_section ? 'Visible' : 'Oculto',
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => ProjectResource::getUrl('edit', ['record' => $project]),
                    ],
                    [
                        'id' => ProjectSupporterType::Club->value,
                        'section' => ProjectSupporterType::Club->sectionLabel(),
                        'description' => 'Clubes del proyecto con logo propio y un interruptor para mostrarlos o no como colaboradores.',
                        'status' => Club::query()->exists() ? 'Con registros' : 'Vacío',
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => ClubResource::getUrl('index'),
                    ],
                    [
                        'id' => ProjectSupporterType::Referee->value,
                        'section' => ProjectSupporterType::Referee->sectionLabel(),
                        'description' => 'Árbitros que suman criterio y experiencia al proyecto.',
                        'status' => $project->refereeSupporters()->exists() ? 'Con registros' : 'Vacío',
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => ProjectClubSupporter::hasSupporterTypeColumn() ? $buildProjectUrl('referees') : null,
                    ],
                    [
                        'id' => ProjectSupporterType::Coach->value,
                        'section' => ProjectSupporterType::Coach->sectionLabel(),
                        'description' => 'Entrenadores que acompañan y refuerzan la propuesta.',
                        'status' => $project->coachSupporters()->exists() ? 'Con registros' : 'Vacío',
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => ProjectClubSupporter::hasSupporterTypeColumn() ? $buildProjectUrl('coaches') : null,
                    ],
                    [
                        'id' => ProjectSupporterType::Player->value,
                        'section' => ProjectSupporterType::Player->sectionLabel(),
                        'description' => 'Jugadores que se identifican con la iniciativa y la impulsan.',
                        'status' => $project->playerSupporters()->exists() ? 'Con registros' : 'Vacío',
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => ProjectClubSupporter::hasSupporterTypeColumn() ? $buildProjectUrl('players') : null,
                    ],
                    [
                        'id' => ProjectProposedPersonType::Referee->value,
                        'section' => ProjectProposedPersonType::Referee->sectionLabel(),
                        'description' => 'Tarjetas de árbitros que todavía pueden estar por definir o cerrar.',
                        'status' => $project->show_proposed_referees_section
                            ? ($project->proposedReferees()->exists() ? sprintf('Visible · %d tarjetas', $project->proposedReferees()->count()) : 'Visible')
                            : 'Oculto',
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => $buildProjectUrl('proposed_referees'),
                    ],
                    [
                        'id' => ProjectProposedPersonType::Coach->value,
                        'section' => ProjectProposedPersonType::Coach->sectionLabel(),
                        'description' => 'Tarjetas de entrenadores propuestos para la asamblea.',
                        'status' => $project->show_proposed_coaches_section
                            ? ($project->proposedCoaches()->exists() ? sprintf('Visible · %d tarjetas', $project->proposedCoaches()->count()) : 'Visible')
                            : 'Oculto',
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => $buildProjectUrl('proposed_coaches'),
                    ],
                    [
                        'id' => ProjectProposedPersonType::Player->value,
                        'section' => ProjectProposedPersonType::Player->sectionLabel(),
                        'description' => 'Tarjetas de jugadores propuestos para la asamblea.',
                        'status' => $project->show_proposed_players_section
                            ? ($project->proposedPlayers()->exists() ? sprintf('Visible · %d tarjetas', $project->proposedPlayers()->count()) : 'Visible')
                            : 'Oculto',
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => $buildProjectUrl('proposed_players'),
                    ],
                ]);
            })
            ->columns([
                TextColumn::make('section')
                    ->label('Sección')
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descripción')
                    ->wrap(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Visible', 'Con registros' => 'success',
                        'Oculto' => 'gray',
                        default => str_contains($state, 'tarjetas') ? 'success' : 'warning',
                    }),
            ])
            ->recordActions([
                Action::make('primaryAction')
                    ->label(fn (array $record): ?string => $record['primary_action_label'])
                    ->icon(Heroicon::PencilSquare)
                    ->color('gray')
                    ->url(fn (array $record): ?string => $record['primary_action_url'])
                    ->iconButton()
                    ->visible(fn (array $record): bool => filled($record['primary_action_url'] ?? null)),
            ])
            ->paginated(false);
    }
}
