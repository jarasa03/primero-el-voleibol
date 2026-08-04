<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectImage>
 */
class ProjectImageFactory extends Factory
{
    protected $model = ProjectImage::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'image_path' => 'project/leader/'.fake()->uuid().'.jpg',
            'alt_text' => 'Fotografía de Francisco Sabroso',
            'sort' => fake()->numberBetween(1, 9),
        ];
    }
}
