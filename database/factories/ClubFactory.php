<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Club>
 */
class ClubFactory extends Factory
{
    protected $model = Club::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' Voleibol',
            'description' => fake()->sentence(12),
            'logo_path' => 'clubs/'.fake()->uuid().'.png',
            'show_as_collaborator' => fake()->boolean(70),
            'sort' => fake()->numberBetween(1, 20),
        ];
    }
}
