<?php

namespace Database\Factories;

use App\Models\ProgramProposal;
use App\Models\ProgramSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramProposal>
 */
class ProgramProposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_section_id' => ProgramSection::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(2, true),
            'sort' => fake()->numberBetween(1, 1000),
            'is_beach_volleyball' => false,
        ];
    }
}
