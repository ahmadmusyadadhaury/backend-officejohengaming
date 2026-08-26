<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class InternetQuotaLowMail extends Mailable
{
    public function __construct(
        public float $remainingGb,
        public string $level = 'danger',
    ) {}

    public function envelope(): Envelope
    {
        $icon = $this->level === 'danger' ? '🚨' : '⚠️';
        $label = $this->level === 'danger' ? 'SEGERA ISI' : 'WARNING';

        return new Envelope(
            subject: "{$icon} Kuota Internet {$label} — {$this->remainingGb} GB",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.internet-quota-low',
            with: [
                'remainingGb' => $this->remainingGb,
                'level' => $this->level,
                'url' => 'https://office.johengaming.store/',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
