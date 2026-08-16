<?php

namespace Database\Factories;

use App\Enums\ProjectProposedPersonType;
use App\Models\Project;
use App\Models\ProjectProposedPerson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectProposedPerson>
 */
class ProjectProposedPersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'proposed_type' => ProjectProposedPersonType::Referee,
            'name' => fake()->name(),
            'title' => fake()->jobTitle(),
            'description' => fake()->sentence(),
            'initials' => strtoupper(fake()->lexify('??')),
            'logo_path' => 'project/proposed-people/'.fake()->uuid().'.png',
            'sort' => fake()->numberBetween(0, 10),
        ];
    }
}
