<?php

namespace Database\Factories;

use App\Models\Referee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Referee>
 */
class RefereeFactory extends Factory
{
    protected $model = Referee::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name().' Árbitro',
            'description' => fake()->sentence(12),
            'logo_path' => 'referees/'.fake()->uuid().'.png',
            'show_as_collaborator' => fake()->boolean(70),
            'show_as_proposed_for_assembly' => fake()->boolean(45),
            'sort' => fake()->numberBetween(1, 20),
        ];
    }
}
