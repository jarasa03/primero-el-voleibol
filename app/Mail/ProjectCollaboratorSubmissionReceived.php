<?php

namespace App\Mail;

use App\Mail\Concerns\UsesPublicFormRecipients;
use App\Models\ProjectCollaboratorSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProjectCollaboratorSubmissionReceived extends Mailable
{
    use Queueable, SerializesModels, UsesPublicFormRecipients;

    public function __construct(public ProjectCollaboratorSubmission $submission) {}

    public function envelope(): Envelope
    {
        return $this->publicFormEnvelope(
            'Nueva solicitud de colaboración desde la web',
            $this->replyToAddress(),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.project-collaborator-submission-received',
            with: [
                'labels' => $this->displayLabels(),
                'photoPath' => $this->photoPath(),
            ],
        );
    }

    /**
     * @return array<string, string|null>
     */
    private function displayLabels(): array
    {
        return [
            'collaboratorType' => match ($this->submission->collaborator_type) {
                'club' => 'Clubes colaboradores',
                'referee' => 'Árbitros colaboradores',
                'coach' => 'Entrenadores colaboradores',
                'player' => 'Jugadores colaboradores',
                default => $this->submission->collaborator_type,
            },
            'refereeVolleyballLevel' => $this->volleyballLevelLabel($this->submission->referee_volleyball_level),
            'refereeBeachLevel' => $this->beachLevelLabel($this->submission->referee_beach_level),
            'coachVolleyballLevel' => $this->volleyballLevelLabel($this->submission->coach_volleyball_level),
            'coachBeachLevel' => $this->beachLevelLabel($this->submission->coach_beach_level),
        ];
    }

    private function volleyballLevelLabel(?string $level): ?string
    {
        return match ($level) {
            'anotador' => 'Anotador',
            'jdm' => 'Árbitro municipal (JDM)',
            'level_0' => 'Nivel 0',
            'level_1' => 'Nivel 1',
            'level_2' => 'Nivel 2',
            'level_3' => 'Nivel 3',
            'superliga_2' => 'Superliga 2',
            'superliga_1' => 'Superliga 1',
            'fivb_1' => 'FIVB 1',
            'fivb_2' => 'FIVB 2',
            'fivb_3' => 'FIVB 3',
            default => $level,
        };
    }

    private function beachLevelLabel(?string $level): ?string
    {
        return match ($level) {
            'vp_level_1' => 'VP Nivel 1',
            'vp_level_2' => 'VP Nivel 2',
            'vp_level_3' => 'VP Nivel 3',
            default => $level,
        };
    }

    private function photoPath(): ?string
    {
        if (! $this->submission->photo_path) {
            return null;
        }

        $disk = Storage::disk('local');

        return $disk->exists($this->submission->photo_path)
            ? $disk->path($this->submission->photo_path)
            : null;
    }

    private function replyToAddress(): ?string
    {
        return match ($this->submission->collaborator_type) {
            'club' => $this->submission->club_contact_email,
            'referee' => $this->submission->referee_contact_email,
            'coach' => $this->submission->coach_contact_email,
            'player' => $this->submission->player_contact_email,
            default => null,
        };
    }
}
