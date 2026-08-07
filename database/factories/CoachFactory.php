<?php

namespace Database\Factories;

use App\Models\Coach;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coach>
 */
class CoachFactory extends Factory
{
    protected $model = Coach::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name().' Entrenador',
            'description' => fake()->sentence(12),
            'logo_path' => 'coaches/'.fake()->uuid().'.png',
            'show_as_collaborator' => fake()->boolean(70),
            'show_as_proposed_for_assembly' => fake()->boolean(45),
            'sort' => fake()->numberBetween(1, 20),
        ];
    }
}
