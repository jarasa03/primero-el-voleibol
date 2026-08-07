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
            'leader_title' => 'árbitro internacional, exárbitro de Superliga 1 y entrenador FIVB 2',
            'leader_description' => 'Francisco Sabroso es una persona con mucha experiencia en el voleibol. Ha sido árbitro internacional, ha pitado un total de 638 partidos de Superliga 1 y es entrenador FIVB 2. Además, ha estado designando durante muchos años a árbitros madrileños de toda la comunidad, lo que le da un conocimiento directo del cuerpo arbitral y de los problemas de cada club, porque habla con ellos todos los fines de semana y conoce desde dentro los retos de organización.',
            'show_leader_section' => true,
            'show_proposed_clubs_section' => true,
            'show_proposed_referees_section' => true,
            'show_proposed_coaches_section' => true,
            'show_proposed_players_section' => true,
            'proposed_clubs_minimum_count' => 3,
            'proposed_referees_minimum_count' => 3,
            'proposed_coaches_minimum_count' => 3,
            'proposed_players_minimum_count' => 3,
        ];
    }
}
