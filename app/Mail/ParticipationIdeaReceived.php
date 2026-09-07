<?php

namespace App\Mail;

use App\Mail\Concerns\UsesPublicFormRecipients;
use App\Models\ParticipationIdea;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ParticipationIdeaReceived extends Mailable
{
    use Queueable, SerializesModels, UsesPublicFormRecipients;

    public function __construct(public ParticipationIdea $idea) {}

    public function envelope(): Envelope
    {
        return $this->publicFormEnvelope(
            'Nueva idea recibida desde la web',
            $this->idea->email,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.participation-idea-received',
        );
    }
}
