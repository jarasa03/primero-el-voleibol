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
                'proposals' => [],
            ],
            [
                'name' => 'Federación',
                'sort' => 2,
                'proposals' => [],
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
                'proposals' => [],
            ],
            [
                'name' => 'Vóley playa',
                'sort' => 5,
                'proposals' => [],
            ],
        ];

        foreach ($sections as $sectionData) {
            $section = ProgramSection::query()->create([
                'name' => $sectionData['name'],
                'sort' => $sectionData['sort'],
                'beach_volleyball_enabled' => $sectionData['beach_volleyball_enabled'] ?? false,
            ]);

            foreach ($sectionData['proposals'] as $proposalData) {
                $section->proposals()->create([
                    'title' => $proposalData['title'],
                    'description' => $proposalData['description'],
                    'sort' => $proposalData['sort'],
                    'is_beach_volleyball' => false,
                ]);
            }
        }
    }
}
