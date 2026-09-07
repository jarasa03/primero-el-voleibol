<?php

namespace App\Mail\Concerns;

use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;

trait UsesPublicFormRecipients
{
    protected function publicFormEnvelope(string $subject, ?string $replyTo = null): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('mail.from.name'),
            ),
            to: [new Address(config('public_forms.contact_email'))],
            cc: array_map(
                static fn (string $email): Address => new Address($email),
                config('public_forms.cc_emails', []),
            ),
            replyTo: filled($replyTo) ? [new Address($replyTo)] : [],
            subject: $subject,
        );
    }
}
