<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name().' Jugador',
            'description' => fake()->sentence(12),
            'logo_path' => 'players/'.fake()->uuid().'.png',
            'show_as_collaborator' => fake()->boolean(70),
            'show_as_proposed_for_assembly' => fake()->boolean(45),
            'sort' => fake()->numberBetween(1, 20),
        ];
    }
}
