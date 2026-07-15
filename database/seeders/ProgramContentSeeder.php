<?php

namespace Database\Seeders;

use App\Models\ProgramProposal;
use App\Models\ProgramSection;
use Illuminate\Database\Seeder;

class ProgramContentSeeder extends Seeder
{
    public function run(): void
    {
        ProgramProposal::query()->delete();
        ProgramSection::query()->delete();

        $sections = [
            [
                'name' => 'Clubes',
                'sort' => 1,
                'proposals' => [
                    [
                        'title' => 'Lorem ipsum dolor sit amet',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.',
                        'sort' => 1,
                    ],
                    [
                        'title' => 'Sed do eiusmod tempor',
                        'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.',
                        'sort' => 2,
                    ],
                ],
            ],
            [
                'name' => 'Federación',
                'sort' => 2,
                'proposals' => [
                    [
                        'title' => 'Lorem ipsum dolor sit amet',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae.',
                        'sort' => 1,
                    ],
                    [
                        'title' => 'Sed do eiusmod tempor',
                        'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.',
                        'sort' => 2,
                    ],
                ],
            ],
            [
                'name' => 'Árbitros',
                'sort' => 3,
                'proposals' => [
                    [
                        'title' => 'Reuniones y clínics regulares durante la temporada',
                        'description' => 'Habrá una reunión al inicio de temporada para actualizar la información sobre nuevas normas y directrices, y para ver cómo afrontar esta nueva etapa. Al finalizar la temporada se celebrará otra reunión para hacer un resumen de lo vivido y detectar mejoras de cara al curso siguiente. Además, durante la temporada se realizarán clínics opcionales a los que los árbitros podrán asistir para recibir información sobre temas concretos y seguir formándose en su carrera arbitral.',
                        'sort' => 1,
                    ],
                    [
                        'title' => 'Sistema de mentoring piramidal',
                        'description' => 'Los árbitros de Superliga 1 tendrán a su cargo a dos árbitros de Superliga 2; estos, a su vez, acompañarán a dos árbitros nacionales. Cada árbitro nacional hará lo propio con dos árbitros de nivel 2, y cada árbitro de nivel 2 con dos de nivel 1. El objetivo es que los niveles superiores formen a los inferiores, se preocupen por su asistencia a reuniones y eventos, les hagan llegar nuevas directrices y piten con ellos al menos una vez cada mes y medio para dar feedback constante. Así construiremos un equipo arbitral fuerte, unificado y capaz de crecer junto.',
                        'sort' => 2,
                    ],
                ],
            ],
            [
                'name' => 'Entrenadores',
                'sort' => 4,
                'proposals' => [
                    [
                        'title' => 'Lorem ipsum dolor sit amet',
                        'description' => 'Morbi leo risus, porta ac consectetur ac, vestibulum at eros.',
                        'sort' => 1,
                    ],
                    [
                        'title' => 'Consectetur adipiscing elit',
                        'description' => 'Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.',
                        'sort' => 2,
                    ],
                ],
            ],
            [
                'name' => 'Voley playa',
                'sort' => 5,
                'proposals' => [
                    [
                        'title' => 'Lorem ipsum dolor sit amet',
                        'description' => 'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.',
                        'sort' => 1,
                    ],
                    [
                        'title' => 'Ut labore et dolore magna aliqua',
                        'description' => 'Donec sed odio dui. Nulla vitae elit libero, a pharetra augue.',
                        'sort' => 2,
                    ],
                ],
            ],
        ];

        foreach ($sections as $sectionData) {
            $section = ProgramSection::query()->create([
                'name' => $sectionData['name'],
                'sort' => $sectionData['sort'],
            ]);

            foreach ($sectionData['proposals'] as $proposalData) {
                $section->proposals()->create([
                    'title' => $proposalData['title'],
                    'description' => $proposalData['description'],
                    'sort' => $proposalData['sort'],
                ]);
            }
        }
    }
}
