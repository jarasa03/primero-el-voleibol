<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCollaboratorSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_type',
        'full_name',
        'club_locality',
        'club_contact_name',
        'club_contact_email',
        'club_contact_phone',
        'referee_volleyball_level',
        'referee_beach_level',
        'referee_contact_email',
        'referee_contact_phone',
        'coach_volleyball_level',
        'coach_beach_level',
        'coach_main_club',
        'coach_contact_email',
        'coach_contact_phone',
        'coach_show_club_on_profile',
        'coach_license_confirmation',
        'player_division',
        'player_team',
        'player_show_team_on_profile',
        'player_contact_email',
        'player_contact_phone',
        'player_license_confirmation',
        'photo_path',
        'federated_team_confirmation',
        'referee_license_confirmation',
        'status',
        'source',
        'consented_at',
        'adult_confirmed_at',
        'publication_consented_at',
    ];

    protected function casts(): array
    {
        return [
            'federated_team_confirmation' => 'boolean',
            'referee_license_confirmation' => 'boolean',
            'coach_show_club_on_profile' => 'boolean',
            'coach_license_confirmation' => 'boolean',
            'player_show_team_on_profile' => 'boolean',
            'player_license_confirmation' => 'boolean',
            'consented_at' => 'datetime',
            'adult_confirmed_at' => 'datetime',
            'publication_consented_at' => 'datetime',
        ];
    }
}
