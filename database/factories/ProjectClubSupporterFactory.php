<?php

namespace Database\Factories;

use App\Enums\ProjectSupporterType;
use App\Models\Project;
use App\Models\ProjectClubSupporter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;

/**
 * @extends Factory<ProjectClubSupporter>
 */
class ProjectClubSupporterFactory extends Factory
{
    protected $model = ProjectClubSupporter::class;

    public function definition(): array
    {
        $definition = [
            'project_id' => Project::factory(),
            'name' => fake()->company().' Vóley',
            'description' => fake()->sentence(12),
            'image_path' => 'project/clubs/'.fake()->uuid().'.jpg',
            'sort' => fake()->numberBetween(1, 9),
        ];

        if (Schema::hasColumn('project_club_supporters', 'supporter_type')) {
            $definition['supporter_type'] = ProjectSupporterType::Club;
        }

        return $definition;
    }
}
