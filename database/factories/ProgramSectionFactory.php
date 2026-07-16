<?php

namespace Database\Factories;

use App\Models\ProgramSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramSection>
 */
class ProgramSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'sort' => fake()->numberBetween(1, 1000),
            'beach_volleyball_enabled' => false,
        ];
    }
}
