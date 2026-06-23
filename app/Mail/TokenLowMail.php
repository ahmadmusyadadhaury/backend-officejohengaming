<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class TokenLowMail extends Mailable
{
    public function __construct(
        public float $remainingKwh,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Token Listrik Hampir Habis — '.$this->remainingKwh.' KWH',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.token-low',
            with: [
                'remainingKwh' => $this->remainingKwh,
                'usedKwh' => 500 - $this->remainingKwh,
                'url' => 'https://meetingroom.johengaming.store/login',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
