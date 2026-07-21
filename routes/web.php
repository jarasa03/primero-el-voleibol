<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ParticipationController;
use App\Models\ProgramSection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::view('/', 'home')->name('home');

Route::get('/proyecto', function () {
    return view('page', [
        'title' => 'Proyecto',
        'eyebrow' => 'Proyecto',
        'description' => 'Una página interior para desarrollar el marco general del proyecto.',
        'intro' => 'Aquí iremos desarrollando el planteamiento general del proyecto con más detalle.',
        'hero_image' => asset('images/programa-hero.webp'),
        'show_hero' => true,
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
        $programSections = $programSectionsFromDatabase->map(function (ProgramSection $section, int $index): array {
            return [
                'anchor' => Str::slug($section->name),
                'title' => $section->name,
                'eyebrow' => sprintf('Bloque %02d', $index + 1),
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
                'eyebrow' => 'Bloque 01',
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
                'title' => 'Federación',
                'eyebrow' => 'Bloque 02',
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
                'title' => 'Árbitros',
                'eyebrow' => 'Bloque 03',
                'description' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'items' => [
                    [
                        'title' => 'Reuniones y clínics regulares durante la temporada',
                        'summary' => 'Una reunión de inicio de temporada, otra de cierre y clínics opcionales para seguir creciendo.',
                        'details' => 'Habrá una reunión al inicio de temporada para actualizar la información sobre nuevas normas y directrices, y para ver cómo afrontar esta nueva etapa. Al finalizar la temporada se celebrará otra reunión para hacer un resumen de lo vivido y detectar mejoras de cara al curso siguiente. Además, durante la temporada se realizarán clínics opcionales a los que los árbitros podrán asistir para recibir información sobre temas concretos y seguir formándose en su carrera arbitral.',
                    ],
                    [
                        'title' => 'Sistema de mentoring piramidal',
                        'summary' => 'Un modelo escalonado para que cada nivel acompañe, forme y haga crecer al siguiente.',
                        'details' => 'Los árbitros de Superliga 1 tendrán a su cargo a dos árbitros de Superliga 2; estos, a su vez, acompañarán a dos árbitros nacionales. Cada árbitro nacional hará lo propio con dos árbitros de nivel 2, y cada árbitro de nivel 2 con dos de nivel 1. El objetivo es que los niveles superiores formen a los inferiores, se preocupen por su asistencia a reuniones y eventos, les hagan llegar nuevas directrices y piten con ellos al menos una vez cada mes y medio para dar feedback constante. Así construiremos un equipo arbitral fuerte, unificado y capaz de crecer junto.',
                    ],
                ],
                'beach_volleyball_enabled' => false,
                'beach_proposals' => [],
            ],
            [
                'anchor' => 'entrenadores',
                'title' => 'Entrenadores',
                'eyebrow' => 'Bloque 04',
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
                'eyebrow' => 'Bloque 05',
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
