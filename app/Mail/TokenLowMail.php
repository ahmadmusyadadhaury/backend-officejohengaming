<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class TokenLowMail extends Mailable
{
    public function __construct(
        public float $remainingKwh,
        public string $level = 'danger',
    ) {}

    public function envelope(): Envelope
    {
        $icon = $this->level === 'danger' ? '🚨' : '⚠️';
        $label = $this->level === 'danger' ? 'SEGERA ISI' : 'WARNING';

        return new Envelope(
            subject: "{$icon} Token Listrik {$label} — {$this->remainingKwh} KWH",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.token-low',
            with: [
                'remainingKwh' => $this->remainingKwh,
                'usedKwh' => 7000 - $this->remainingKwh,
                'capacityKwh' => 7000,
                'level' => $this->level,
                'url' => 'https://meetingroom.johengaming.store/login',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
