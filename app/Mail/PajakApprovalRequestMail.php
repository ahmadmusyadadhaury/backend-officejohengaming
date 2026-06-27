<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehiclePajakRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PajakApprovalRequestMail extends Mailable
{
    public function __construct(
        public VehiclePajakRequest $request,
        public Vehicle $vehicle,
        public User $requester,
    ) {}

    public function envelope(): Envelope
    {
        $jenisLabel = $this->request->jenis === 'tahunan' ? 'Tahunan' : '5 Tahunan';

        return new Envelope(
            subject: "Pengajuan Pembayaran Pajak {$jenisLabel} — {$this->vehicle->nama_kendaraan} ({$this->vehicle->plat_nomor})",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pajak-approval',
            with: [
                'request' => $this->request,
                'vehicle' => $this->vehicle,
                'requester' => $this->requester,
                'url' => 'https://office.johengaming.store/',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
