<?php

namespace Database\Factories;

use App\Models\ProjectCollaboratorSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectCollaboratorSubmission>
 */
class ProjectCollaboratorSubmissionFactory extends Factory
{
    protected $model = ProjectCollaboratorSubmission::class;

    public function definition(): array
    {
        return [
            'collaborator_type' => $this->faker->randomElement(['club', 'referee', 'coach', 'player']),
            'full_name' => $this->faker->name(),
            'club_locality' => $this->faker->city(),
            'club_contact_name' => $this->faker->name(),
            'club_contact_email' => $this->faker->safeEmail(),
            'club_contact_phone' => $this->faker->numerify('6########'),
            'referee_volleyball_level' => $this->faker->randomElement(['anotador', 'jdm', 'level_1', 'level_2', 'level_3', 'superliga_2', 'superliga_1']),
            'referee_beach_level' => $this->faker->randomElement(['vp_level_1', 'vp_level_2', 'vp_level_3']),
            'referee_contact_email' => $this->faker->safeEmail(),
            'referee_contact_phone' => $this->faker->numerify('6########'),
            'coach_volleyball_level' => $this->faker->randomElement(['level_0', 'level_1', 'level_2', 'level_3', 'fivb_1', 'fivb_2', 'fivb_3']),
            'coach_beach_level' => $this->faker->randomElement(['vp_level_1', 'vp_level_2', 'vp_level_3']),
            'coach_main_club' => $this->faker->company(),
            'coach_contact_email' => $this->faker->safeEmail(),
            'coach_contact_phone' => $this->faker->numerify('6########'),
            'coach_show_club_on_profile' => $this->faker->boolean(),
            'player_division' => $this->faker->randomElement(['Primera', 'Segunda', 'Juvenil']),
            'player_team' => $this->faker->company(),
            'player_show_team_on_profile' => $this->faker->boolean(),
            'player_contact_email' => $this->faker->safeEmail(),
            'player_contact_phone' => $this->faker->numerify('6########'),
            'photo_path' => 'project-collaborator-submissions/' . $this->faker->uuid() . '.jpg',
            'federated_team_confirmation' => $this->faker->boolean(),
            'referee_license_confirmation' => $this->faker->boolean(),
            'coach_license_confirmation' => $this->faker->boolean(),
            'player_license_confirmation' => $this->faker->boolean(),
            'status' => 'pending',
            'source' => 'proyecto-page',
            'consented_at' => now(),
        ];
    }
}
