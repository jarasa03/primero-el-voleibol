<?php

use App\Enums\ProjectProposedPersonType;
use App\Enums\ProjectSupporterType;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ParticipationController;
use App\Models\Club;
use App\Models\Coach;
use App\Models\Player;
use App\Models\ProgramSection;
use App\Models\Project;
use App\Models\ProjectClubSupporter;
use App\Models\ProjectProposedPerson;
use App\Models\Referee;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

Route::view('/', 'home')->name('home');

Route::get('/proyecto', function () {
    $hasSupporterTypeColumn = Schema::hasColumn('project_club_supporters', 'supporter_type');

    $project = Project::query()
        ->with([
            'images' => fn ($query) => $query->orderBy('sort')->orderBy('id'),
            'supporters' => fn ($query) => $query->with('club')->orderBy('sort')->orderBy('id'),
            'proposedPeople' => fn ($query) => $query->orderBy('sort')->orderBy('id'),
        ])
        ->latest('id')
        ->first();

    if (! $project instanceof Project) {
        $project = Project::ensureSingleton()->load([
            'images' => fn ($query) => $query->orderBy('sort')->orderBy('id'),
        ]);
    }

    $makeInitials = function (string $value): string {
        return Str::of($value)
            ->trim()
            ->explode(' ')
            ->filter()
            ->map(fn (string $part): string => Str::upper(Str::substr($part, 0, 1)))
            ->take(2)
            ->implode('');
    };

    $projectLeader = [
        'name' => $project->leader_name,
        'role' => $project->leader_title,
        'description' => $project->leader_description,
        'show_leader_section' => $project->show_leader_section,
        'show_proposed_referees_section' => $project->show_proposed_referees_section,
        'show_proposed_coaches_section' => $project->show_proposed_coaches_section,
        'show_proposed_players_section' => $project->show_proposed_players_section,
        'initials' => $makeInitials($project->leader_name),
        'photos' => $project->images->isNotEmpty()
            ? $project->images->map(function ($image): array {
                return [
                    'image' => asset('storage/'.$image->image_path),
                    'name' => 'Francisco Sabroso',
                    'alt' => $image->alt_text ?: 'Fotografía de Francisco Sabroso',
                ];
            })->all()
            : [
                [
                    'image' => asset('images/programa-hero.webp'),
                    'name' => 'Francisco Sabroso',
                    'alt' => 'Fotografía de Francisco Sabroso',
                ],
                [
                    'image' => asset('images/programa-hero.webp'),
                    'name' => 'Francisco Sabroso',
                    'alt' => 'Fotografía de Francisco Sabroso',
                ],
                [
                    'image' => asset('images/programa-hero.webp'),
                    'name' => 'Francisco Sabroso',
                    'alt' => 'Fotografía de Francisco Sabroso',
                ],
            ],
    ];

    if (! $projectLeader['show_leader_section']) {
        $projectLeader['photos'] = [];
    }

    $projectSupporters = [
        [
            'name' => 'Contenido en construcción',
            'role' => 'Liderazgo',
            'description' => 'Mostraremos aquí la persona que impulsa el proyecto cuando esté publicada en la base de datos.',
            'initials' => 'PV',
        ],
        [
            'name' => 'Clubes en construcción',
            'role' => 'Clubes',
            'description' => 'Los clubes colaboradores reales aparecerán aquí cuando haya registros disponibles.',
            'initials' => 'CL',
        ],
        [
            'name' => 'Árbitros en construcción',
            'role' => 'Árbitros',
            'description' => 'Aquí aparecerán los árbitros colaboradores cuando se publiquen sus datos.',
            'initials' => 'AR',
        ],
    ];

    $buildCatalogSupporters = function ($catalogItems, string $label, string $badgeClass, array $fallback) use ($makeInitials): array {
        if ($catalogItems->isEmpty()) {
            return $fallback;
        }

        return $catalogItems->map(function ($catalogItem) use ($label, $badgeClass, $makeInitials): array {
            return [
                'name' => $catalogItem->name,
                'label' => $label,
                'description' => $catalogItem->description,
                'image' => ! empty($catalogItem->logo_path) ? asset('storage/'.$catalogItem->logo_path) : null,
                'initials' => $makeInitials($catalogItem->name),
                'badgeClass' => $badgeClass,
            ];
        })->all();
    };

    $clubCatalogSupporters = Club::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $refereeCatalogSupporters = Referee::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $coachCatalogSupporters = Coach::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $playerCatalogSupporters = Player::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $supportSections = [
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Clubes colaboradores',
            'description' => 'Clubes que respaldan la iniciativa y se muestran con un carrusel continuo de logos.',
            'items' => $buildCatalogSupporters(
                $clubCatalogSupporters,
                'Club colaborador',
                'from-brand-950 via-brand-800 to-slate-950',
                [
                    [
                        'name' => 'Clubes en construcción',
                        'label' => 'Club colaborador',
                        'description' => 'Los clubes colaboradores reales aparecerán aquí cuando haya registros disponibles.',
                        'initials' => 'CL',
                        'badgeClass' => 'from-brand-950 via-brand-800 to-slate-950',
                    ],
                ],
            ),
            'mode' => 'logos',
            'direction' => 'right',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Árbitros colaboradores',
            'description' => 'Árbitros que suman criterio y experiencia con el mismo formato visual que los clubes.',
            'items' => $buildCatalogSupporters(
                $refereeCatalogSupporters,
                'Árbitro colaborador',
                'from-brand-950 via-brand-800 to-slate-900',
                [
                    [
                        'name' => 'Árbitros en construcción',
                        'label' => 'Árbitro colaborador',
                        'description' => 'Aquí mostraremos los árbitros colaboradores cuando haya registros reales.',
                        'initials' => 'AR',
                        'badgeClass' => 'from-brand-950 via-brand-800 to-slate-900',
                    ],
                ],
            ),
            'mode' => 'logos',
            'direction' => 'left',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
            'autofillMultiplier' => 2.4,
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Entrenadores colaboradores',
            'description' => 'Entrenadores que aportan experiencia técnica y acompañan el proyecto.',
            'items' => $buildCatalogSupporters(
                $coachCatalogSupporters,
                'Entrenador colaborador',
                'from-slate-950 via-brand-900 to-brand-700',
                [
                    [
                        'name' => 'Entrenadores en construcción',
                        'label' => 'Entrenador colaborador',
                        'description' => 'Esta franja se completará con entrenadores reales en cuanto se publiquen.',
                        'initials' => 'EN',
                        'badgeClass' => 'from-slate-950 via-brand-900 to-brand-700',
                    ],
                ],
            ),
            'mode' => 'logos',
            'direction' => 'right',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
            'autofillMultiplier' => 2.4,
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Jugadores colaboradores',
            'description' => 'Jugadores que refuerzan la iniciativa desde la pista y la comunidad.',
            'items' => $buildCatalogSupporters(
                $playerCatalogSupporters,
                'Jugador colaborador',
                'from-accent-900 via-accent-700 to-brand-950',
                [
                    [
                        'name' => 'Jugadores en construcción',
                        'label' => 'Jugador colaborador',
                        'description' => 'Aquí aparecerán los jugadores colaboradores cuando haya datos reales.',
                        'initials' => 'JG',
                        'badgeClass' => 'from-brand-950 via-slate-900 to-brand-800',
                    ],
                ],
            ),
            'mode' => 'logos',
            'direction' => 'left',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
        ],
    ];

    $clubsSectionVisible = $project->show_proposed_clubs_section;
    $refereesSectionVisible = $project->show_proposed_referees_section;
    $coachesSectionVisible = $project->show_proposed_coaches_section;
    $playersSectionVisible = $project->show_proposed_players_section;

    $buildProposedItems = function ($catalogItems, int $minimum) use ($makeInitials): array {
        $items = $catalogItems
            ->filter(function ($catalogItem): bool {
                return (bool) $catalogItem->show_as_proposed_for_assembly;
            })
            ->map(function ($catalogItem) use ($makeInitials): array {
                return [
                    'name' => $catalogItem->name,
                    'title' => filled($catalogItem->description) ? $catalogItem->description : 'Pendiente de completar',
                    'description' => null,
                    'initials' => $makeInitials($catalogItem->name),
                ];
            })
            ->values();

        while ($items->count() < $minimum) {
            $items->push([
                'name' => 'Aún por definir',
                'title' => 'Pendiente de completar',
                'description' => null,
                'initials' => 'AD',
            ]);
        }

        return $items->take($minimum)->all();
    };

    $clubProposalCatalog = Club::query()->orderBy('sort')->orderBy('id')->get();
    $refereeProposalCatalog = Referee::query()->orderBy('sort')->orderBy('id')->get();
    $coachProposalCatalog = Coach::query()->orderBy('sort')->orderBy('id')->get();
    $playerProposalCatalog = Player::query()->orderBy('sort')->orderBy('id')->get();

    $proposedSections = [
        [
            'title' => 'Clubes propuestos para la asamblea',
            'items' => $clubsSectionVisible ? $buildProposedItems($clubProposalCatalog, 31) : [],
            'visible' => $clubsSectionVisible,
        ],
        [
            'title' => 'Árbitros propuestos para la asamblea',
            'items' => $refereesSectionVisible ? $buildProposedItems($refereeProposalCatalog, 3) : [],
            'visible' => $refereesSectionVisible,
        ],
        [
            'title' => 'Entrenadores propuestos para la asamblea',
            'items' => $coachesSectionVisible ? $buildProposedItems($coachProposalCatalog, 8) : [],
            'visible' => $coachesSectionVisible,
        ],
        [
            'title' => 'Jugadores propuestos para la asamblea',
            'items' => $playersSectionVisible ? $buildProposedItems($playerProposalCatalog, 15) : [],
            'visible' => $playersSectionVisible,
        ],
    ];

    return view('proyecto', [
        'projectLeader' => $projectLeader,
        'projectSupporters' => $projectSupporters,
        'supportSections' => $supportSections,
        'proposedSections' => $proposedSections,
    ]);

    $makeInitials = function (string $value): string {
        return Str::of($value)
            ->trim()
            ->explode(' ')
            ->filter()
            ->map(fn (string $part): string => Str::upper(Str::substr($part, 0, 1)))
            ->take(2)
            ->implode('');
    };

    $showLeaderSection = $project instanceof Project
        ? $project->show_leader_section
        : true;

    $projectLeader = $project instanceof Project
        ? [
            'name' => $project->leader_name,
            'role' => $project->leader_title,
            'description' => $project->leader_description,
            'show_leader_section' => $project->show_leader_section,
            'show_proposed_referees_section' => $project->show_proposed_referees_section,
            'show_proposed_coaches_section' => $project->show_proposed_coaches_section,
            'show_proposed_players_section' => $project->show_proposed_players_section,
            'initials' => $makeInitials($project->leader_name),
            'photos' => $project->images->isNotEmpty()
                ? $project->images->map(function ($image): array {
                    return [
                        'image' => asset('storage/'.$image->image_path),
                        'name' => 'Francisco Sabroso',
                        'alt' => $image->alt_text ?: 'Fotograf?a de Francisco Sabroso',
                    ];
                })->all()
                : [
                    [
                        'image' => asset('images/programa-hero.webp'),
                        'name' => 'Francisco Sabroso',
                        'alt' => 'Fotograf?a de Francisco Sabroso',
                    ],
                    [
                        'image' => asset('images/programa-hero.webp'),
                        'name' => 'Francisco Sabroso',
                        'alt' => 'Fotograf?a de Francisco Sabroso',
                    ],
                    [
                        'image' => asset('images/programa-hero.webp'),
                        'name' => 'Francisco Sabroso',
                        'alt' => 'Fotograf?a de Francisco Sabroso',
                    ],
                ],
        ]
        : [
            'name' => 'Francisco Sabroso',
            'role' => 'ÃƒÂ¡rbitro internacional, exÃƒÂ¡rbitro de Superliga 1 y entrenador FIVB 2',
            'description' => 'Francisco Sabroso es una persona con mucha experiencia en el voleibol. Ha sido ÃƒÂ¡rbitro internacional, ha pitado un total de 638 partidos de Superliga 1 y es entrenador FIVB 2. AdemÃƒÂ¡s, ha estado designando durante muchos aÃƒÂ±os a ÃƒÂ¡rbitros madrileÃƒÂ±os de toda la comunidad, lo que le da un conocimiento directo del cuerpo arbitral y de los problemas de cada club, porque habla con ellos todos los fines de semana y conoce desde dentro los retos de organizaciÃƒÂ³n.',
            'show_leader_section' => true,
            'show_proposed_referees_section' => true,
            'show_proposed_coaches_section' => true,
            'show_proposed_players_section' => true,
            'initials' => 'FS',
            'photos' => [
                [
                    'image' => asset('images/programa-hero.webp'),
                    'name' => 'Francisco Sabroso',
                    'alt' => 'Fotograf?a de Francisco Sabroso',
                ],
                [
                    'image' => asset('images/programa-hero.webp'),
                    'name' => 'Francisco Sabroso',
                    'alt' => 'Fotograf?a de Francisco Sabroso',
                ],
                [
                    'image' => asset('images/programa-hero.webp'),
                    'name' => 'Francisco Sabroso',
                    'alt' => 'Fotograf?a de Francisco Sabroso',
                ],
            ],
        ];

    if (! $showLeaderSection) {
        $projectLeader['photos'] = [];
    }

    $projectSupporters = [
        [
            'name' => 'Clubes que lo respaldan',
            'role' => 'Base del movimiento',
            'description' => 'La red de clubes da legitimidad, territorio y continuidad al proyecto desde la pista.',
            'initials' => 'CL',
        ],
        [
            'name' => 'ÃƒÂrbitros que acompaÃƒÂ±an',
            'role' => 'Criterio y experiencia',
            'description' => 'Su mirada ayuda a ordenar el debate y a llevar propuestas realistas y bien medidas.',
            'initials' => 'AR',
        ],
        [
            'name' => 'Comunidad que suma',
            'role' => 'Apoyo transversal',
            'description' => 'TÃƒÂ©cnicos, familias y personas vinculadas al voleibol que quieren empujar en la misma direcciÃƒÂ³n.',
            'initials' => 'CO',
        ],
    ];

    $clubSupporters = [
        [
            'name' => 'Club Voleibol Centro',
            'label' => 'Apoyo de la zona central',
            'initials' => 'CV',
            'badgeClass' => 'from-brand-950 via-brand-800 to-slate-950',
        ],
        [
            'name' => 'Club del Norte',
            'label' => 'Compromiso con la base',
            'initials' => 'CN',
            'badgeClass' => 'from-slate-950 via-brand-900 to-brand-700',
        ],
        [
            'name' => 'Club de la Sierra',
            'label' => 'Crecimiento territorial',
            'initials' => 'CS',
            'badgeClass' => 'from-brand-800 via-brand-600 to-accent-700',
        ],
        [
            'name' => 'Club del Este',
            'label' => 'Trabajo de cantera',
            'initials' => 'CE',
            'badgeClass' => 'from-slate-900 via-slate-700 to-brand-900',
        ],
        [
            'name' => 'Club del Sur',
            'label' => 'Pista y comunidad',
            'initials' => 'CS',
            'badgeClass' => 'from-accent-800 via-accent-600 to-brand-900',
        ],
        [
            'name' => 'Club Universidad',
            'label' => 'FormaciÃƒÂ³n y visiÃƒÂ³n',
            'initials' => 'CU',
            'badgeClass' => 'from-brand-950 via-slate-900 to-brand-800',
        ],
        [
            'name' => 'Club Valle',
            'label' => 'Apoyo estable',
            'initials' => 'CV',
            'badgeClass' => 'from-brand-700 via-brand-500 to-accent-500',
        ],
        [
            'name' => 'Club Horizonte',
            'label' => 'Impulso compartido',
            'initials' => 'CH',
            'badgeClass' => 'from-slate-950 via-brand-950 to-slate-800',
        ],
    ];

    $clubSupportersFallback = $clubSupporters;

    $clubSupporters = $project instanceof Project && $project->clubSupporters->isNotEmpty()
        ? $project->clubSupporters->map(function (ProjectClubSupporter $clubSupporter) use ($makeInitials): array {
            return [
                'name' => $clubSupporter->name,
                'description' => $clubSupporter->description,
                'label' => 'Club colaborador',
                'image' => ! empty($clubSupporter->image_path) ? asset('storage/'.$clubSupporter->image_path) : null,
                'initials' => $makeInitials($clubSupporter->name),
                'badgeClass' => 'from-brand-950 via-brand-800 to-slate-950',
            ];
        })->all()
        : $clubSupportersFallback;

    $clubSupportersFromCatalog = Club::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $clubSupporters = $clubSupportersFromCatalog->isNotEmpty()
        ? $clubSupportersFromCatalog->map(function (Club $club) use ($makeInitials): array {
            return [
                'name' => $club->name,
                'description' => $club->description,
                'label' => 'Club colaborador',
                'image' => ! empty($club->logo_path) ? asset('storage/'.$club->logo_path) : null,
                'initials' => $makeInitials($club->name),
                'badgeClass' => 'from-brand-950 via-brand-800 to-slate-950',
            ];
        })->all()
        : $clubSupportersFallback;

    $refereeSupporters = [
        [
            'name' => 'ÃƒÂrbitro colaborador 01',
            'label' => 'ÃƒÂrbitro colaborador',
            'description' => 'ÃƒÂ¡rbitro autonÃƒÂ³mico',
            'initials' => 'A1',
            'badgeClass' => 'from-brand-950 via-brand-800 to-slate-900',
        ],
        [
            'name' => 'ÃƒÂrbitra colaboradora 02',
            'label' => 'ÃƒÂrbitra colaboradora',
            'description' => 'Juez ÃƒÂ¡rbitra con experiencia en cantera',
            'initials' => 'A2',
            'badgeClass' => 'from-slate-950 via-brand-900 to-brand-700',
        ],
        [
            'name' => 'ÃƒÂrbitro colaborador 03',
            'label' => 'ÃƒÂrbitro colaborador',
            'description' => 'Especialista en competiciÃƒÂ³n territorial',
            'initials' => 'A3',
            'badgeClass' => 'from-accent-900 via-accent-700 to-brand-950',
        ],
        [
            'name' => 'ÃƒÂrbitro colaborador 04',
            'label' => 'ÃƒÂrbitro colaborador',
            'description' => 'Referencia tÃƒÂ©cnica y formativa',
            'initials' => 'A4',
            'badgeClass' => 'from-brand-800 via-slate-900 to-brand-950',
        ],
        [
            'name' => 'ÃƒÂrbitra colaboradora 05',
            'label' => 'ÃƒÂrbitra colaboradora',
            'description' => 'CompeticiÃƒÂ³n y acompaÃƒÂ±amiento',
            'initials' => 'A5',
            'badgeClass' => 'from-slate-900 via-brand-800 to-accent-800',
        ],
    ];

    $coachSupportersFallback = [
        [
            'name' => 'Entrenador colaborador 01',
            'label' => 'Trabajo de base',
            'description' => 'AcompaÃƒÂ±a la iniciativa desde la formaciÃƒÂ³n y la direcciÃƒÂ³n de equipos.',
            'initials' => 'E1',
            'badgeClass' => 'from-brand-950 via-brand-800 to-slate-950',
        ],
        [
            'name' => 'Entrenadora colaboradora 02',
            'label' => 'Experiencia de banquillo',
            'description' => 'Aporta visi?n t?ctica y conocimiento real de la competici?n.',
            'initials' => 'E2',
            'badgeClass' => 'from-slate-950 via-brand-900 to-brand-700',
        ],
        [
            'name' => 'Entrenador colaborador 03',
            'label' => 'Acompa?amiento t?cnico',
            'description' => 'Suma criterio en la construcci?n de propuestas s?lidas.',
            'initials' => 'E3',
            'badgeClass' => 'from-accent-900 via-accent-700 to-brand-950',
        ],
    ];

    $playerSupportersFallback = [
        [
            'name' => 'Jugador colaborador 01',
            'label' => 'Voz de pista',
            'description' => 'Representa la experiencia de quienes viven la competici?n desde dentro.',
            'initials' => 'J1',
            'badgeClass' => 'from-brand-800 via-slate-900 to-brand-950',
        ],
        [
            'name' => 'Jugadora colaboradora 02',
            'label' => 'Compromiso con el juego',
            'description' => 'Aporta una mirada cercana a la realidad diaria del voleibol.',
            'initials' => 'J2',
            'badgeClass' => 'from-slate-900 via-brand-800 to-accent-800',
        ],
        [
            'name' => 'Jugador colaborador 03',
            'label' => 'Cantera y presente',
            'description' => 'Refuerza la conexi?n entre la base y el futuro del proyecto.',
            'initials' => 'J3',
            'badgeClass' => 'from-brand-950 via-slate-900 to-brand-800',
        ],
    ];

    $projectSupporters = [
        [
            'name' => 'Contenido en construcción',
            'role' => 'Liderazgo',
            'description' => 'Mostraremos aquí la persona que impulsa el proyecto cuando esté publicada en la base de datos.',
            'initials' => 'PV',
        ],
        [
            'name' => 'Apoyos por confirmar',
            'role' => 'Clubes',
            'description' => 'Este bloque se completará con clubes reales en cuanto haya registros disponibles.',
            'initials' => 'CL',
        ],
        [
            'name' => 'Apoyo arbitral',
            'role' => 'Árbitros',
            'description' => 'Aquí aparecerán los árbitros colaboradores cuando se publiquen sus datos.',
            'initials' => 'AR',
        ],
    ];

    $clubSupportersFallback = [
        [
            'name' => 'Clubes en construcción',
            'description' => 'Los clubes colaboradores reales aparecerán aquí cuando estén disponibles.',
            'label' => 'Club colaborador',
            'initials' => 'CL',
            'badgeClass' => 'from-brand-950 via-brand-800 to-slate-950',
        ],
    ];

    $refereeSupporters = [
        [
            'name' => 'Árbitros en construcción',
            'label' => 'Árbitro colaborador',
            'description' => 'Aquí mostraremos los árbitros colaboradores cuando haya registros reales.',
            'initials' => 'AR',
            'badgeClass' => 'from-brand-950 via-brand-800 to-slate-900',
        ],
    ];

    $coachSupportersFallback = [
        [
            'name' => 'Entrenadores en construcción',
            'label' => 'Entrenador colaborador',
            'description' => 'Esta franja se completará con entrenadores reales en cuanto se publiquen.',
            'initials' => 'EN',
            'badgeClass' => 'from-slate-950 via-brand-900 to-brand-700',
        ],
    ];

    $playerSupportersFallback = [
        [
            'name' => 'Jugadores en construcción',
            'label' => 'Jugador colaborador',
            'description' => 'Aquí aparecerán los jugadores colaboradores cuando haya datos reales.',
            'initials' => 'JG',
            'badgeClass' => 'from-brand-950 via-slate-900 to-brand-800',
        ],
    ];

    $mapLogoSupporters = function (ProjectSupporterType $type, array $fallback, string $label, string $badgeClass) use ($project, $makeInitials, $hasSupporterTypeColumn): array {
        if (! $project instanceof Project || $project->supporters->isEmpty()) {
            return $fallback;
        }

        if (! $hasSupporterTypeColumn && $type !== ProjectSupporterType::Club) {
            return $fallback;
        }

        $supporters = $project->supporters->filter(function (ProjectClubSupporter $supporter) use ($type, $hasSupporterTypeColumn): bool {
            if (! $hasSupporterTypeColumn) {
                return $type === ProjectSupporterType::Club;
            }

            $supporterType = $supporter->supporter_type instanceof ProjectSupporterType
                ? $supporter->supporter_type
                : ProjectSupporterType::tryFrom((string) $supporter->supporter_type);

            return $supporterType === $type;
        });

        if ($supporters->isEmpty()) {
            return $fallback;
        }

        return $supporters->map(function (ProjectClubSupporter $supporter) use ($label, $badgeClass, $makeInitials): array {
            return [
                'name' => $supporter->name,
                'description' => $supporter->description,
                'label' => $label,
                'image' => ! empty($supporter->image_path) ? asset('storage/'.$supporter->image_path) : null,
                'shield' => $supporter->club instanceof Club && ! empty($supporter->club->logo_path)
                    ? asset('storage/'.$supporter->club->logo_path)
                    : (! empty($supporter->shield_path) ? asset('storage/'.$supporter->shield_path) : null),
                'initials' => $makeInitials($supporter->name),
                'badgeClass' => $badgeClass,
            ];
        })->all();
    };

    $mapCardSupporters = function (ProjectSupporterType $type, array $fallback, string $label, string $backgroundClass) use ($project, $makeInitials, $hasSupporterTypeColumn): array {
        if (! $project instanceof Project || $project->supporters->isEmpty() || ! $hasSupporterTypeColumn) {
            return $fallback;
        }

        $supporters = $project->supporters->filter(function (ProjectClubSupporter $supporter) use ($type): bool {
            $supporterType = $supporter->supporter_type instanceof ProjectSupporterType
                ? $supporter->supporter_type
                : ProjectSupporterType::tryFrom((string) $supporter->supporter_type);

            return $supporterType === $type;
        });

        if ($supporters->isEmpty()) {
            return $fallback;
        }

        return $supporters->map(function (ProjectClubSupporter $supporter) use ($label, $backgroundClass, $makeInitials): array {
            return [
                'name' => $supporter->name,
                'title' => $supporter->description,
                'description' => null,
                'label' => $label,
                'image' => ! empty($supporter->image_path) ? asset('storage/'.$supporter->image_path) : null,
                'initials' => $makeInitials($supporter->name),
                'backgroundClass' => $backgroundClass,
            ];
        })->all();
    };

    if ($clubSupportersFromCatalog->isEmpty()) {
        $clubSupporters = $mapLogoSupporters(
            ProjectSupporterType::Club,
            $clubSupportersFallback,
            'Club colaborador',
            'from-brand-950 via-brand-800 to-slate-950',
        );
    }

    $refereeSupporters = $mapLogoSupporters(
        ProjectSupporterType::Referee,
        $refereeSupporters,
        'Árbitro colaborador',
        'from-brand-950 via-brand-800 to-slate-900',
    );

    $coachSupporters = $mapLogoSupporters(
        ProjectSupporterType::Coach,
        $coachSupportersFallback,
        'Entrenador colaborador',
        'from-slate-950 via-brand-900 to-brand-700',
    );

    $playerSupporters = $mapLogoSupporters(
        ProjectSupporterType::Player,
        $playerSupportersFallback,
        'Jugador colaborador',
        'from-accent-900 via-accent-700 to-brand-950',
    );

    $supportSections = [
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Clubes colaboradores',
            'description' => 'Clubes que respaldan la iniciativa y se muestran con un carrusel continuo de logos.',
            'items' => $clubSupporters,
            'mode' => 'logos',
            'direction' => 'right',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Árbitros colaboradores',
            'description' => 'Árbitros que suman criterio y experiencia con el mismo formato visual que los clubes.',
            'items' => $refereeSupporters,
            'mode' => 'logos',
            'direction' => 'left',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
            'autofillMultiplier' => 2.4,
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Entrenadores colaboradores',
            'description' => 'Entrenadores que aportan experiencia t?cnica y acompa?an el proyecto.',
            'items' => $coachSupporters,
            'mode' => 'logos',
            'direction' => 'right',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
            'autofillMultiplier' => 2.4,
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Jugadores colaboradores',
            'description' => 'Jugadores que refuerzan la iniciativa desde la pista y la comunidad.',
            'items' => $playerSupporters,
            'mode' => 'logos',
            'direction' => 'left',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
        ],
    ];

    $makePlaceholderProposedPerson = function (): array {
        return [
            'name' => 'Aún por definir',
            'title' => 'Pendiente de completar',
            'description' => 'Esta tarjeta se completará más adelante.',
            'initials' => 'AD',
        ];
    };

    $clubsSectionVisible = $project instanceof Project ? $project->show_proposed_clubs_section : true;
    $refereesSectionVisible = $project instanceof Project ? $project->show_proposed_referees_section : true;
    $coachesSectionVisible = $project instanceof Project ? $project->show_proposed_coaches_section : true;
    $playersSectionVisible = $project instanceof Project ? $project->show_proposed_players_section : true;

    $mapProposedPeople = function (ProjectProposedPersonType $type, int $minimum) use ($project, $makePlaceholderProposedPerson): array {
        $proposedPeople = $project->proposedPeople->filter(function (ProjectProposedPerson $proposedPerson) use ($type): bool {
            $proposedType = $proposedPerson->proposed_type instanceof ProjectProposedPersonType
                ? $proposedPerson->proposed_type
                : ProjectProposedPersonType::tryFrom((string) $proposedPerson->proposed_type);

            return $proposedType === $type;
        });

        $items = $proposedPeople->map(function (ProjectProposedPerson $proposedPerson) use ($makePlaceholderProposedPerson): array {
            $placeholder = $makePlaceholderProposedPerson();

            return [
                'name' => filled($proposedPerson->name) ? $proposedPerson->name : $placeholder['name'],
                'title' => filled($proposedPerson->title) ? $proposedPerson->title : $placeholder['title'],
                'description' => filled($proposedPerson->description) ? $proposedPerson->description : $placeholder['description'],
                'initials' => filled($proposedPerson->initials) ? $proposedPerson->initials : $placeholder['initials'],
            ];
        })->values();

        while ($items->count() < max(0, $minimum)) {
            $items->push($makePlaceholderProposedPerson());
        }

        return $items->all();
    };

    $proposedSections = [
        [
            'title' => 'Clubes propuestos para la asamblea',
            'items' => $clubsSectionVisible ? $mapProposedPeople(ProjectProposedPersonType::Club, $project->proposed_clubs_minimum_count) : [],
            'visible' => $clubsSectionVisible,
        ],
        [
            'title' => 'Árbitros propuestos para la asamblea',
            'items' => $refereesSectionVisible ? $mapProposedPeople(ProjectProposedPersonType::Referee, $project->proposed_referees_minimum_count) : [],
            'visible' => $refereesSectionVisible,
        ],
        [
            'title' => 'Entrenadores propuestos para la asamblea',
            'items' => $coachesSectionVisible ? $mapProposedPeople(ProjectProposedPersonType::Coach, $project->proposed_coaches_minimum_count) : [],
            'visible' => $coachesSectionVisible,
        ],
        [
            'title' => 'Jugadores propuestos para la asamblea',
            'items' => $playersSectionVisible ? $mapProposedPeople(ProjectProposedPersonType::Player, $project->proposed_players_minimum_count) : [],
            'visible' => $playersSectionVisible,
        ],
    ];

    $clubCatalogSupporters = Club::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $refereeCatalogSupporters = Referee::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $coachCatalogSupporters = Coach::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $playerCatalogSupporters = Player::query()
        ->where('show_as_collaborator', true)
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $catalogSupporterItem = function ($catalogItem, string $label, string $badgeClass) use ($makeInitials): array {
        return [
            'name' => $catalogItem->name,
            'label' => $label,
            'description' => $catalogItem->description,
            'image' => ! empty($catalogItem->logo_path) ? asset('storage/'.$catalogItem->logo_path) : null,
            'shield' => null,
            'initials' => $makeInitials($catalogItem->name),
            'badgeClass' => $badgeClass,
        ];
    };

    $catalogProposalItem = function ($catalogItem) use ($makeInitials): array {
        return [
            'name' => $catalogItem->name,
            'title' => filled($catalogItem->description) ? $catalogItem->description : 'Pendiente de completar',
            'description' => null,
            'initials' => $makeInitials($catalogItem->name),
        ];
    };

    $makeFixedProposalItems = function ($catalogItems, int $minimum) use ($catalogProposalItem): array {
        $items = $catalogItems
            ->filter(fn ($catalogItem): bool => (bool) $catalogItem->show_as_proposed_for_assembly)
            ->sortBy('sort')
            ->sortBy('id')
            ->take($minimum)
            ->map($catalogProposalItem)
            ->values();

        while ($items->count() < $minimum) {
            $items->push([
                'name' => 'Aún por definir',
                'title' => 'Pendiente de completar',
                'description' => null,
                'initials' => 'AD',
            ]);
        }

        return $items->all();
    };

    $projectSupporters = [
        [
            'name' => 'Contenido en construcción',
            'role' => 'Liderazgo',
            'description' => 'Mostraremos aquí la persona que impulsa el proyecto cuando esté publicada en la base de datos.',
            'initials' => 'PV',
        ],
        [
            'name' => 'Apoyos por confirmar',
            'role' => 'Clubes',
            'description' => 'Este bloque se completará con clubes reales en cuanto haya registros disponibles.',
            'initials' => 'CL',
        ],
        [
            'name' => 'Apoyo arbitral',
            'role' => 'Árbitros',
            'description' => 'Aquí aparecerán los árbitros colaboradores cuando se publiquen sus datos.',
            'initials' => 'AR',
        ],
    ];

    $supportSections = [
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Clubes colaboradores',
            'description' => 'Clubes que respaldan la iniciativa y se muestran con un carrusel continuo de logos.',
            'items' => $clubCatalogSupporters->isNotEmpty()
                ? $clubCatalogSupporters->map(fn ($catalogItem): array => $catalogSupporterItem($catalogItem, 'Club colaborador', 'from-brand-950 via-brand-800 to-slate-950'))->all()
                : [],
            'mode' => 'logos',
            'direction' => 'right',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Árbitros colaboradores',
            'description' => 'Árbitros que suman criterio y experiencia con el mismo formato visual que los clubes.',
            'items' => $refereeCatalogSupporters->isNotEmpty()
                ? $refereeCatalogSupporters->map(fn ($catalogItem): array => $catalogSupporterItem($catalogItem, 'Árbitro colaborador', 'from-brand-950 via-brand-800 to-slate-900'))->all()
                : [],
            'mode' => 'logos',
            'direction' => 'left',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
            'autofillMultiplier' => 2.4,
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Entrenadores colaboradores',
            'description' => 'Entrenadores que aportan experiencia técnica y acompañan el proyecto.',
            'items' => $coachCatalogSupporters->isNotEmpty()
                ? $coachCatalogSupporters->map(fn ($catalogItem): array => $catalogSupporterItem($catalogItem, 'Entrenador colaborador', 'from-slate-950 via-brand-900 to-brand-700'))->all()
                : [],
            'mode' => 'logos',
            'direction' => 'right',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
            'autofillMultiplier' => 2.4,
        ],
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Jugadores colaboradores',
            'description' => 'Jugadores que refuerzan la iniciativa desde la pista y la comunidad.',
            'items' => $playerCatalogSupporters->isNotEmpty()
                ? $playerCatalogSupporters->map(fn ($catalogItem): array => $catalogSupporterItem($catalogItem, 'Jugador colaborador', 'from-accent-900 via-accent-700 to-brand-950'))->all()
                : [],
            'mode' => 'logos',
            'direction' => 'left',
            'speed' => 50,
            'gap' => 1.1,
            'fadeColor' => '#f8fafc',
            'imageFit' => 'cover',
        ],
    ];

    $proposedSections = [
        [
            'title' => 'Clubes propuestos para la asamblea',
            'items' => $makeFixedProposalItems($clubCatalogSupporters, 31),
            'visible' => true,
        ],
        [
            'title' => 'Árbitros propuestos para la asamblea',
            'items' => $makeFixedProposalItems($refereeCatalogSupporters, 3),
            'visible' => true,
        ],
        [
            'title' => 'Entrenadores propuestos para la asamblea',
            'items' => $makeFixedProposalItems($coachCatalogSupporters, 8),
            'visible' => true,
        ],
        [
            'title' => 'Jugadores propuestos para la asamblea',
            'items' => $makeFixedProposalItems($playerCatalogSupporters, 15),
            'visible' => true,
        ],
    ];

    return view('proyecto', [
        'projectLeader' => $projectLeader,
        'projectSupporters' => $projectSupporters,
        'supportSections' => $supportSections,
        'proposedSections' => $proposedSections,
    ]);
})->name('proyecto');

Route::get('/principios', function () {
    return view('page', [
        'title' => 'Principios',
        'eyebrow' => 'Principios',
        'description' => 'Una página interior para explicar los principios que guían el proyecto.',
        'intro' => 'Aquí quedarán recogidos los principios que sostienen la forma de trabajar y proponer.',
        'hero_image' => asset('images/programa-hero.webp'),
        'show_hero' => true,
    ]);
})->name('principios');

Route::get('/programa', function () {
    $attachBeachSubsections = function (array $sections): array {
        return collect($sections)
            ->map(function (array $section): array {
                $section['subsections'] = [];

                if (($section['beach_volleyball_enabled'] ?? false) === true && $section['anchor'] !== 'voley-playa') {
                    $section['subsections'] = [
                        [
                            'anchor' => sprintf('%s-voley-playa', $section['anchor']),
                            'title' => 'Voley playa',
                            'description' => null,
                            'items' => $section['beach_proposals'] ?? [],
                        ],
                    ];
                }

                return $section;
            })
            ->values()
            ->all();
    };

    $programSectionsFromDatabase = ProgramSection::query()
        ->with([
            'mainProposals' => fn ($query) => $query->orderBy('sort'),
            'beachProposals' => fn ($query) => $query->orderBy('sort'),
        ])
        ->orderBy('sort')
        ->get();

    if ($programSectionsFromDatabase->isNotEmpty()) {
        $programSections = $programSectionsFromDatabase->map(function (ProgramSection $section): array {
            return [
                'anchor' => Str::slug($section->name),
                'title' => $section->name,
                'description' => null,
                'beach_volleyball_enabled' => $section->beach_volleyball_enabled,
                'items' => $section->mainProposals->map(function ($proposal): array {
                    return [
                        'title' => $proposal->title,
                        'summary' => (string) Str::of($proposal->description)->stripTags()->squish()->limit(90),
                        'details' => $proposal->description,
                    ];
                })->all(),
                'beach_proposals' => $section->beachProposals->map(function ($proposal): array {
                    return [
                        'title' => $proposal->title,
                        'summary' => (string) Str::of($proposal->description)->stripTags()->squish()->limit(90),
                        'details' => $proposal->description,
                    ];
                })->all(),
            ];
        })->all();

        $programSections = $attachBeachSubsections($programSections);
    } else {
        $programSections = [
            [
                'anchor' => 'clubes',
                'title' => 'Clubes',
                'description' => 'Contenido en construccion. Esta seccion se completara con propuestas reales cuando haya datos publicados.',
                'items' => [
                    [
                        'title' => 'Contenido en construccion',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Aqui publicaremos las propuestas definitivas cuando esten disponibles en la base de datos.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'federacion',
                'title' => 'Federacion',
                'description' => 'Contenido en construccion. Esta seccion se completara con propuestas reales cuando haya datos publicados.',
                'items' => [
                    [
                        'title' => 'Contenido en construccion',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Aqui publicaremos las propuestas definitivas cuando esten disponibles en la base de datos.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'arbitros',
                'title' => 'Arbitros',
                'description' => 'Contenido en construccion. Esta seccion se completara con propuestas reales cuando haya datos publicados.',
                'items' => [
                    [
                        'title' => 'Contenido en construccion',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Aqui publicaremos las propuestas definitivas cuando esten disponibles en la base de datos.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'entrenadores',
                'title' => 'Entrenadores',
                'description' => 'Contenido en construccion. Esta seccion se completara con propuestas reales cuando haya datos publicados.',
                'items' => [
                    [
                        'title' => 'Contenido en construccion',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Aqui publicaremos las propuestas definitivas cuando esten disponibles en la base de datos.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'voley-playa',
                'title' => 'Voley playa',
                'description' => 'Contenido en construccion. Esta seccion se completara con propuestas reales cuando haya datos publicados.',
                'items' => [
                    [
                        'title' => 'Contenido en construccion',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Aqui publicaremos las propuestas definitivas cuando esten disponibles en la base de datos.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
        ];

        $programSections = $attachBeachSubsections($programSections);
    }

    return view('programa', [
        'programSections' => $programSections,
    ])->with('body_class', 'page-interior page-programa');
})->name('programa');

Route::get('/blog', [BlogPostController::class, 'index'])->name('blog');
Route::get('/blog/{blogPost:slug}', [BlogPostController::class, 'show'])->name('blog.show');

Route::get('/participa', [ParticipationController::class, 'show'])->name('participa');
Route::post('/participa', [ParticipationController::class, 'store'])->name('participa.store');

Route::view('/aviso-legal', 'legal.aviso-legal')->name('legal.aviso-legal');
Route::view('/politica-de-privacidad', 'legal.politica-de-privacidad')->name('legal.politica-de-privacidad');
Route::view('/politica-de-cookies', 'legal.politica-de-cookies')->name('legal.politica-de-cookies');
