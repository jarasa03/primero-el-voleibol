<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\ProjectCollaboratorSubmissionController;
use App\Models\BlogPost;
use App\Models\Club;
use App\Models\Coach;
use App\Models\Player;
use App\Models\ProgramSection;
use App\Models\Project;
use App\Models\Referee;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

Route::get('/', function () {
    $homeProposals = [
        [
            'category' => 'Clubes',
            'title' => 'Transparencia en las sanciones y reinversión en el juego limpio',
            'description' => 'Impulsaremos un modelo de sanciones transparente, coherente y útil para el voleibol madrileño. Las normas deben aplicarse por igual para todos, las sanciones deben cumplirse y su gestión debe ser completamente transparente.',
        ],
        [
            'category' => 'Árbitros',
            'title' => 'Programa de Mentoría Arbitral',
            'description' => 'Implantaremos un modelo de mentoría estructurado en el que cada árbitro acompañe y forme a los niveles inferiores.',
        ],
        [
            'category' => 'Federación',
            'title' => 'Permitir la incorporación de patrocinadores en la equipación oficial de la Federación',
            'description' => 'La Federación de Madrid debe impulsar la incorporación de patrocinadores comerciales en la equipación oficial de aquellos colectivos cuya uniformidad depende directamente de la propia Federación, tanto en voleibol como en vóley playa.',
        ],
    ];

    $latestPosts = Schema::hasTable('blog_posts')
        ? BlogPost::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(4)
            ->get()
        : collect();

    return view('home', [
        'homeProposals' => $homeProposals,
        'latestPosts' => $latestPosts,
    ]);
})->name('home');

Route::get('/proyecto', function () {
    $hasSupporterTypeColumn = Schema::hasColumn('project_club_supporters', 'supporter_type');

    $project = Project::ensureSingleton()->load([
        'images' => fn ($query) => $query->orderBy('sort')->orderBy('id'),
        'supporters' => fn ($query) => $query->with('club')->orderBy('sort')->orderBy('id'),
        'proposedPeople' => fn ($query) => $query->with('club')->orderBy('sort')->orderBy('id'),
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

    $projectSupporters = [];

    $buildCatalogSupporters = function ($catalogItems, string $label, string $badgeClass, array $fallback, ?Closure $shieldResolver = null) use ($makeInitials): array {
        if ($catalogItems->isEmpty()) {
            return [];
        }

        return $catalogItems->map(function ($catalogItem) use ($label, $badgeClass, $makeInitials, $shieldResolver): array {
            return [
                'name' => $catalogItem->name,
                'label' => $label,
                'description' => $catalogItem->description,
                'image' => ! empty($catalogItem->logo_path) ? asset('storage/'.$catalogItem->logo_path) : null,
                'shield' => $shieldResolver instanceof Closure ? $shieldResolver($catalogItem) : null,
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
        ->with('club')
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $playerCatalogSupporters = Player::query()
        ->where('show_as_collaborator', true)
        ->with('club')
        ->orderBy('sort')
        ->orderBy('id')
        ->get();

    $supportSections = [
        [
            'eyebrow' => 'Apoyos',
            'title' => 'Clubes que suman',
            'description' => 'Clubes que aportan experiencia de gestión, competición y trabajo diario en el voleibol madrileño.',
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
            'title' => 'Árbitros que suman',
            'description' => 'Árbitros con experiencia en competición y una visión directa de lo que ocurre dentro y fuera de la pista.',
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
            'title' => 'Entrenadores que suman',
            'description' => 'Entrenadores que aportan conocimiento técnico, experiencia de equipo y contacto directo con jugadores y competición.',
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
                fn ($catalogItem): ?string => $catalogItem->club instanceof Club && filled($catalogItem->club->logo_path)
                    ? asset('storage/'.$catalogItem->club->logo_path)
                    : null,
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
            'title' => 'Jugadores que suman',
            'description' => 'Jugadores que aportan la perspectiva de quienes viven la competición desde dentro.',
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
                fn ($catalogItem): ?string => $catalogItem->club instanceof Club && filled($catalogItem->club->logo_path)
                    ? asset('storage/'.$catalogItem->club->logo_path)
                    : null,
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

    $buildProposedItems = function ($catalogItems, int $minimum, ?Closure $shieldResolver = null) use ($makeInitials): array {
        $items = $catalogItems
            ->filter(function ($catalogItem): bool {
                return (bool) $catalogItem->show_as_proposed_for_assembly;
            })
            ->map(function ($catalogItem) use ($makeInitials, $shieldResolver): array {
                return [
                    'name' => $catalogItem->name,
                    'title' => filled($catalogItem->description) ? $catalogItem->description : 'Pendiente de completar',
                    'description' => null,
                    'image' => ! empty($catalogItem->logo_path) ? asset('storage/'.$catalogItem->logo_path) : null,
                    'shield' => $shieldResolver instanceof Closure ? $shieldResolver($catalogItem) : null,
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
    $coachProposalCatalog = Coach::query()->with('club')->orderBy('sort')->orderBy('id')->get();
    $playerProposalCatalog = Player::query()->with('club')->orderBy('sort')->orderBy('id')->get();

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
            'items' => $coachesSectionVisible ? $buildProposedItems($coachProposalCatalog, 8, fn ($catalogItem): ?string => $catalogItem->club instanceof Club && filled($catalogItem->club->logo_path)
                ? asset('storage/'.$catalogItem->club->logo_path)
                : null) : [],
            'visible' => $coachesSectionVisible,
        ],
        [
            'title' => 'Jugadores propuestos para la asamblea',
            'items' => $playersSectionVisible ? $buildProposedItems($playerProposalCatalog, 15, fn ($catalogItem): ?string => $catalogItem->club instanceof Club && filled($catalogItem->club->logo_path)
                ? asset('storage/'.$catalogItem->club->logo_path)
                : null) : [],
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

Route::get('/programa', function () {
    $attachBeachSubsections = function (array $sections): array {
        return collect($sections)
            ->map(function (array $section): array {
                $section['subsections'] = [];

                if (($section['beach_volleyball_enabled'] ?? false) === true && $section['anchor'] !== 'voley-playa') {
                    $section['subsections'] = [
                        [
                            'anchor' => sprintf('%s-voley-playa', $section['anchor']),
                            'title' => 'Vóley playa',
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
                'description' => 'Aún no hay propuestas publicadas en esta sección.',
                'items' => [
                    [
                        'title' => 'Sin propuestas publicadas',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Publicaremos aquí las propuestas cuando estén revisadas y disponibles.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'federacion',
                'title' => 'Federación',
                'description' => 'Aún no hay propuestas publicadas en esta sección.',
                'items' => [
                    [
                        'title' => 'Sin propuestas publicadas',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Publicaremos aquí las propuestas cuando estén revisadas y disponibles.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'arbitros',
                'title' => 'Árbitros',
                'description' => 'Aún no hay propuestas publicadas en esta sección.',
                'items' => [
                    [
                        'title' => 'Sin propuestas publicadas',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Publicaremos aquí las propuestas cuando estén revisadas y disponibles.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'entrenadores',
                'title' => 'Entrenadores',
                'description' => 'Aún no hay propuestas publicadas en esta sección.',
                'items' => [
                    [
                        'title' => 'Sin propuestas publicadas',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Publicaremos aquí las propuestas cuando estén revisadas y disponibles.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'voley-playa',
                'title' => 'Vóley playa',
                'description' => 'Aún no hay propuestas publicadas en esta sección.',
                'items' => [
                    [
                        'title' => 'Sin propuestas publicadas',
                        'summary' => 'Estamos preparando esta parte del programa.',
                        'details' => 'Publicaremos aquí las propuestas cuando estén revisadas y disponibles.',
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

Route::get('/sitemap.xml', function () {
    $staticUrls = collect([
        route('home'),
        route('proyecto'),
        route('programa'),
        route('blog'),
        route('participa'),
    ])->map(fn (string $url): array => [
        'loc' => $url,
        'lastmod' => null,
    ]);

    $articleUrls = BlogPost::query()
        ->published()
        ->whereNotNull('published_at')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->get(['slug', 'updated_at'])
        ->map(fn (BlogPost $blogPost): array => [
            'loc' => route('blog.show', $blogPost),
            'lastmod' => $blogPost->updated_at?->toAtomString(),
        ]);

    return response()
        ->view('sitemap', ['urls' => $staticUrls->concat($articleUrls)])
        ->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

Route::get('/blog/{blogPost:slug}', [BlogPostController::class, 'show'])->name('blog.show');

Route::get('/participa', [ParticipationController::class, 'show'])->name('participa');
Route::post('/participa', [ParticipationController::class, 'store'])->name('participa.store');
Route::post('/proyecto/colaboradores', [ProjectCollaboratorSubmissionController::class, 'store'])->name('proyecto.colaboradores.store');

Route::view('/aviso-legal', 'legal.aviso-legal')->name('legal.aviso-legal');
Route::view('/politica-de-privacidad', 'legal.politica-de-privacidad')->name('legal.politica-de-privacidad');
Route::view('/politica-de-cookies', 'legal.politica-de-cookies')->name('legal.politica-de-cookies');
