<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectCollaboratorSubmissionRequest;
use App\Mail\ProjectCollaboratorSubmissionReceived;
use App\Models\ProjectCollaboratorSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ProjectCollaboratorSubmissionController extends Controller
{
    public function store(StoreProjectCollaboratorSubmissionRequest $request): RedirectResponse
    {
        $photoPath = $request->file('photo')->store('project-collaborator-submissions');

        $submission = ProjectCollaboratorSubmission::create([
            'collaborator_type' => $request->string('collaborator_type')->toString(),
            'full_name' => $request->string('full_name')->toString(),
            'club_locality' => $request->filled('club_locality')
                ? $request->string('club_locality')->toString()
                : null,
            'club_contact_name' => $request->filled('club_contact_name')
                ? $request->string('club_contact_name')->toString()
                : null,
            'club_contact_email' => $request->filled('club_contact_email')
                ? $request->string('club_contact_email')->toString()
                : null,
            'club_contact_phone' => $request->filled('club_contact_phone')
                ? $request->string('club_contact_phone')->toString()
                : null,
            'referee_volleyball_level' => $request->filled('referee_volleyball_level')
                ? $request->string('referee_volleyball_level')->toString()
                : null,
            'referee_beach_level' => $request->filled('referee_beach_level')
                ? $request->string('referee_beach_level')->toString()
                : null,
            'referee_contact_email' => $request->filled('referee_contact_email')
                ? $request->string('referee_contact_email')->toString()
                : null,
            'referee_contact_phone' => $request->filled('referee_contact_phone')
                ? $request->string('referee_contact_phone')->toString()
                : null,
            'coach_volleyball_level' => $request->filled('coach_volleyball_level')
                ? $request->string('coach_volleyball_level')->toString()
                : null,
            'coach_beach_level' => $request->filled('coach_beach_level')
                ? $request->string('coach_beach_level')->toString()
                : null,
            'coach_main_club' => $request->filled('coach_main_club')
                ? $request->string('coach_main_club')->toString()
                : null,
            'coach_contact_email' => $request->filled('coach_contact_email')
                ? $request->string('coach_contact_email')->toString()
                : null,
            'coach_contact_phone' => $request->filled('coach_contact_phone')
                ? $request->string('coach_contact_phone')->toString()
                : null,
            'coach_show_club_on_profile' => $request->has('coach_show_club_on_profile')
                ? $request->boolean('coach_show_club_on_profile')
                : false,
            'player_division' => $request->filled('player_division')
                ? $request->string('player_division')->toString()
                : null,
            'player_team' => $request->filled('player_team')
                ? $request->string('player_team')->toString()
                : null,
            'player_show_team_on_profile' => $request->has('player_show_team_on_profile')
                ? $request->boolean('player_show_team_on_profile')
                : false,
            'player_contact_email' => $request->filled('player_contact_email')
                ? $request->string('player_contact_email')->toString()
                : null,
            'player_contact_phone' => $request->filled('player_contact_phone')
                ? $request->string('player_contact_phone')->toString()
                : null,
            'photo_path' => $photoPath,
            'federated_team_confirmation' => $request->boolean('federated_team_confirmation'),
            'referee_license_confirmation' => $request->boolean('referee_license_confirmation'),
            'coach_license_confirmation' => $request->boolean('coach_license_confirmation'),
            'player_license_confirmation' => $request->boolean('player_license_confirmation'),
            'status' => 'pending',
            'source' => 'proyecto-page',
            'consented_at' => now(),
        ]);

        Mail::send(new ProjectCollaboratorSubmissionReceived($submission));

        return redirect()
            ->route('proyecto')
            ->with('status', 'Gracias. Hemos recibido tu solicitud y la revisaremos con calma.');
    }
}
