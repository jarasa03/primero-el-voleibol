<?php

use App\Enums\ProjectProposedPersonType;
use App\Enums\ProjectSupporterType;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ParticipationController;
use App\Models\Club;
use App\Models\ProgramSection;
use App\Models\Project;
use App\Models\ProjectClubSupporter;
use App\Models\ProjectProposedPerson;
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
            'supporters' => fn ($query) => $query->orderBy('sort')->orderBy('id'),
            'proposedPeople' => fn ($query) => $query->orderBy('sort')->orderBy('id'),
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
        ]
        : [
            'name' => 'Francisco Sabroso',
            'role' => 'árbitro internacional, exárbitro de Superliga 1 y entrenador FIVB 2',
            'description' => 'Francisco Sabroso es una persona con mucha experiencia en el voleibol. Ha sido árbitro internacional, ha pitado un total de 638 partidos de Superliga 1 y es entrenador FIVB 2. Además, ha estado designando durante muchos años a árbitros madrileños de toda la comunidad, lo que le da un conocimiento directo del cuerpo arbitral y de los problemas de cada club, porque habla con ellos todos los fines de semana y conoce desde dentro los retos de organización.',
            'show_leader_section' => true,
            'show_proposed_referees_section' => true,
            'show_proposed_coaches_section' => true,
            'show_proposed_players_section' => true,
            'initials' => 'FS',
            'photos' => [
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
            'name' => 'Árbitros que acompañan',
            'role' => 'Criterio y experiencia',
            'description' => 'Su mirada ayuda a ordenar el debate y a llevar propuestas realistas y bien medidas.',
            'initials' => 'AR',
        ],
        [
            'name' => 'Comunidad que suma',
            'role' => 'Apoyo transversal',
            'description' => 'Técnicos, familias y personas vinculadas al voleibol que quieren empujar en la misma dirección.',
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
            'label' => 'Formación y visión',
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
            'name' => 'Árbitro colaborador 01',
            'label' => 'Árbitro colaborador',
            'description' => 'árbitro autonómico',
            'initials' => 'A1',
            'badgeClass' => 'from-brand-950 via-brand-800 to-slate-900',
        ],
        [
            'name' => 'Árbitra colaboradora 02',
            'label' => 'Árbitra colaboradora',
            'description' => 'Juez árbitra con experiencia en cantera',
            'initials' => 'A2',
            'badgeClass' => 'from-slate-950 via-brand-900 to-brand-700',
        ],
        [
            'name' => 'Árbitro colaborador 03',
            'label' => 'Árbitro colaborador',
            'description' => 'Especialista en competición territorial',
            'initials' => 'A3',
            'badgeClass' => 'from-accent-900 via-accent-700 to-brand-950',
        ],
        [
            'name' => 'Árbitro colaborador 04',
            'label' => 'Árbitro colaborador',
            'description' => 'Referencia técnica y formativa',
            'initials' => 'A4',
            'badgeClass' => 'from-brand-800 via-slate-900 to-brand-950',
        ],
        [
            'name' => 'Árbitra colaboradora 05',
            'label' => 'Árbitra colaboradora',
            'description' => 'Competición y acompañamiento',
            'initials' => 'A5',
            'badgeClass' => 'from-slate-900 via-brand-800 to-accent-800',
        ],
    ];

    $coachSupportersFallback = [
        [
            'name' => 'Entrenador colaborador 01',
            'label' => 'Trabajo de base',
            'description' => 'Acompaña la iniciativa desde la formación y la dirección de equipos.',
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
            'description' => 'Entrenadores que aportan experiencia técnica y acompañan el proyecto.',
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
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'items' => [
                    [
                        'title' => 'Lorem ipsum dolor sit amet',
                        'summary' => 'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio.',
                        'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.',
                    ],
                    [
                        'title' => 'Sed do eiusmod tempor',
                        'summary' => 'Aliquam tincidunt mauris eu risus. Vestibulum auctor dapibus neque.',
                        'details' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'federacion',
                'title' => 'Federaci?n',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'items' => [
                    [
                        'title' => 'Lorem ipsum dolor sit amet',
                        'summary' => 'Curabitur pretium tincidunt lacus. Nulla gravida orci a odio.',
                        'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.',
                    ],
                    [
                        'title' => 'Sed do eiusmod tempor',
                        'summary' => 'Aliquam tincidunt mauris eu risus. Vestibulum auctor dapibus neque.',
                        'details' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'arbitros',
                'title' => 'árbitros',
                'description' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'items' => [
                    [
                        'title' => 'Reuniones y cl?nics regulares durante la temporada',
                        'summary' => 'Una reuni?n de inicio de temporada, otra de cierre y cl?nics opcionales para seguir creciendo.',
                        'details' => 'Habrá una reunión al inicio de temporada para actualizar la información sobre nuevas normas y directrices, y para ver cómo afrontar esta nueva etapa. Al finalizar la temporada se celebrará otra reunión para hacer un resumen de lo vivido y detectar mejoras de cara al curso siguiente. Además, durante la temporada se realizarán clinics opcionales a los que los árbitros podrán asistir para recibir información sobre temas concretos y seguir formándose en su carrera arbitral.',
                    ],
                    [
                        'title' => 'Sistema de mentoring piramidal',
                        'summary' => 'Un modelo escalonado para que cada nivel acompa?e, forme y haga crecer al siguiente.',
                        'details' => 'Los árbitros de Superliga 1 tendrán a su cargo a dos árbitros de Superliga 2; estos, a su vez, acompañarán a dos árbitros nacionales. Cada árbitro nacional hará lo propio con dos árbitros de nivel 2, y cada árbitro de nivel 2 con dos de nivel 1. El objetivo es que los niveles superiores formen a los inferiores, se preocupen por su asistencia a reuniones y eventos, les hagan llegar nuevas directrices y piten con ellos al menos una vez cada mes y medio para dar feedback constante. Así construiremos un equipo arbitral fuerte, unificado y capaz de crecer junto.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'entrenadores',
                'title' => 'Entrenadores',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.',
                'items' => [
                    [
                        'title' => 'Lorem ipsum dolor sit amet',
                        'summary' => 'Morbi leo risus, porta ac consectetur ac, vestibulum at eros.',
                        'details' => 'Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Maecenas sed diam eget risus varius blandit.',
                    ],
                    [
                        'title' => 'Consectetur adipiscing elit',
                        'summary' => 'Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.',
                        'details' => 'Nullam quis risus eget urna mollis ornare vel eu leo. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'voley-playa',
                'title' => 'Voley playa',
                'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.',
                'items' => [
                    [
                        'title' => 'Lorem ipsum dolor sit amet',
                        'summary' => 'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                        'details' => 'Etiam porta sem malesuada magna mollis euismod. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.',
                    ],
                    [
                        'title' => 'Ut labore et dolore magna aliqua',
                        'summary' => 'Donec sed odio dui. Nulla vitae elit libero, a pharetra augue.',
                        'details' => 'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Maecenas faucibus mollis interdum.',
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

