<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'leader_name' => 'Francisco Sabroso',
            'leader_title' => 'Ã¡rbitro internacional, exÃ¡rbitro de Superliga 1 y entrenador FIVB 2',
            'leader_description' => 'Francisco Sabroso es una persona con mucha experiencia en el voleibol. Ha sido Ã¡rbitro internacional, ha pitado un total de 638 partidos de Superliga 1 y es entrenador FIVB 2. Adem?s, ha estado designando durante muchos a?os a Ã¡rbitros madrileÃ±os de toda la comunidad, lo que le da un conocimiento directo del cuerpo arbitral y de los problemas de cada club, porque habla con ellos todos los fines de semana y conoce desde dentro los retos de organizaci?n.',
            'show_leader_section' => true,
            'show_proposed_referees_section' => true,
            'show_proposed_coaches_section' => true,
            'show_proposed_players_section' => true,
            'proposed_referees_minimum_count' => 3,
            'proposed_coaches_minimum_count' => 3,
            'proposed_players_minimum_count' => 3,
        ];
    }
}
