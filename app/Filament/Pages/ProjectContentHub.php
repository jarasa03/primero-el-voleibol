<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Clubs\ClubResource;
use App\Filament\Resources\Coaches\CoachResource;
use App\Filament\Resources\Players\PlayerResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Referees\RefereeResource;
use App\Models\Club;
use App\Models\Coach;
use App\Models\Player;
use App\Models\Project;
use App\Models\Referee;
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
        $makeStatus = function (Collection $items, string $typeLabel): string {
            $collaborators = $items->where('show_as_collaborator', true)->count();
            $proposed = $items->where('show_as_proposed_for_assembly', true)->count();

            if ($collaborators === 0 && $proposed === 0) {
                return 'Vacío';
            }

            return sprintf('%s · %d colaboradores · %d propuestos', $typeLabel, $collaborators, $proposed);
        };

        return $table
            ->records(function () use ($project, $makeStatus): Collection {
                $clubs = Club::query()->orderBy('sort')->orderBy('id')->get();
                $referees = Referee::query()->orderBy('sort')->orderBy('id')->get();
                $coaches = Coach::query()->orderBy('sort')->orderBy('id')->get();
                $players = Player::query()->orderBy('sort')->orderBy('id')->get();

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
                        'id' => 'clubs',
                        'section' => 'Clubes',
                        'description' => 'Catálogo de clubes con su presencia como colaboradores y como propuestos para la asamblea.',
                        'status' => $makeStatus($clubs, 'Catálogo'),
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => ClubResource::getUrl('index'),
                    ],
                    [
                        'id' => 'referees',
                        'section' => 'Árbitros',
                        'description' => 'Catálogo de árbitros con sus dos casillas de visibilidad.',
                        'status' => $makeStatus($referees, 'Catálogo'),
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => RefereeResource::getUrl('index'),
                    ],
                    [
                        'id' => 'coaches',
                        'section' => 'Entrenadores',
                        'description' => 'Catálogo de entrenadores con opciones de colaborador y propuesto.',
                        'status' => $makeStatus($coaches, 'Catálogo'),
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => CoachResource::getUrl('index'),
                    ],
                    [
                        'id' => 'players',
                        'section' => 'Jugadores',
                        'description' => 'Catálogo de jugadores con opciones de colaborador y propuesto.',
                        'status' => $makeStatus($players, 'Catálogo'),
                        'primary_action_label' => 'Editar',
                        'primary_action_url' => PlayerResource::getUrl('index'),
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
                        'Visible', 'Catálogo' => 'success',
                        'Oculto' => 'gray',
                        default => str_contains($state, 'propuestos') ? 'success' : 'warning',
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
