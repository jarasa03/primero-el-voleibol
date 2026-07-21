<?php

namespace Database\Factories;

use App\Models\ParticipationIdea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<ParticipationIdea>
 */
class ParticipationIdeaFactory extends Factory
{
    protected $model = ParticipationIdea::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'club_or_role' => fake()->optional()->jobTitle(),
            'topic' => fake()->randomElement(['clubes', 'arbitraje', 'formacion', 'competicion', 'comunicacion', 'otro']),
            'idea' => fake()->paragraphs(2, true),
            'source' => 'participa-page',
            'is_anonymous' => false,
            'consented_at' => Carbon::now()->subHour(),
        ];
    }

    public function anonymous(): static
    {
        return $this->state(fn (): array => [
            'name' => null,
            'email' => null,
            'is_anonymous' => true,
        ]);
    }
}
