<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreProjectCollaboratorSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'collaborator_type' => ['required', 'string', Rule::in(['club', 'referee', 'coach', 'player'])],
            'full_name' => ['required', 'string', 'max:120'],
            'club_locality' => ['required_if:collaborator_type,club', 'nullable', 'string', 'max:120'],
            'club_contact_name' => ['required_if:collaborator_type,club', 'nullable', 'string', 'max:120'],
            'club_contact_email' => ['required_if:collaborator_type,club', 'nullable', 'string', 'email', 'max:255'],
            'club_contact_phone' => ['required_if:collaborator_type,club', 'nullable', 'string', 'max:30'],
            'referee_volleyball_level' => [Rule::requiredIf(fn (): bool => $this->input('collaborator_type') === 'referee' && blank($this->input('referee_beach_level'))), 'nullable', 'string', Rule::in(['anotador', 'jdm', 'level_1', 'level_2', 'level_3', 'superliga_2', 'superliga_1'])],
            'referee_beach_level' => [Rule::requiredIf(fn (): bool => $this->input('collaborator_type') === 'referee' && blank($this->input('referee_volleyball_level'))), 'nullable', 'string', Rule::in(['vp_level_1', 'vp_level_2', 'vp_level_3'])],
            'referee_contact_email' => ['required_if:collaborator_type,referee', 'nullable', 'string', 'email', 'max:255'],
            'referee_contact_phone' => ['required_if:collaborator_type,referee', 'nullable', 'string', 'max:30'],
            'coach_volleyball_level' => [Rule::requiredIf(fn (): bool => $this->input('collaborator_type') === 'coach' && blank($this->input('coach_beach_level'))), 'nullable', 'string', Rule::in(['level_0', 'level_1', 'level_2', 'level_3', 'fivb_1', 'fivb_2', 'fivb_3'])],
            'coach_beach_level' => [Rule::requiredIf(fn (): bool => $this->input('collaborator_type') === 'coach' && blank($this->input('coach_volleyball_level'))), 'nullable', 'string', Rule::in(['vp_level_1', 'vp_level_2', 'vp_level_3'])],
            'coach_main_club' => ['required_if:collaborator_type,coach', 'nullable', 'string', 'max:120'],
            'coach_contact_email' => ['required_if:collaborator_type,coach', 'nullable', 'string', 'email', 'max:255'],
            'coach_contact_phone' => ['required_if:collaborator_type,coach', 'nullable', 'string', 'max:30'],
            'coach_show_club_on_profile' => ['required_if:collaborator_type,coach', 'nullable', Rule::in(['yes', 'no'])],
            'player_division' => ['required_if:collaborator_type,player', 'nullable', 'string', 'max:120'],
            'player_team' => ['required_if:collaborator_type,player', 'nullable', 'string', 'max:120'],
            'player_show_team_on_profile' => ['required_if:collaborator_type,player', 'nullable', Rule::in(['yes', 'no'])],
            'player_contact_email' => ['required_if:collaborator_type,player', 'nullable', 'string', 'email', 'max:255'],
            'player_contact_phone' => ['required_if:collaborator_type,player', 'nullable', 'string', 'max:30'],
            'photo' => [
                'required',
                File::image()
                    ->max('5mb'),
            ],
            'federated_team_confirmation' => ['accepted_if:collaborator_type,club'],
            'referee_license_confirmation' => ['accepted_if:collaborator_type,referee'],
            'coach_license_confirmation' => ['accepted_if:collaborator_type,coach'],
            'player_license_confirmation' => ['accepted_if:collaborator_type,player'],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }
}
