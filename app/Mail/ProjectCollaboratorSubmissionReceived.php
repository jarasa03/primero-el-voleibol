<?php

namespace App\Mail;

use App\Mail\Concerns\UsesPublicFormRecipients;
use App\Models\ProjectCollaboratorSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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
        );
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
