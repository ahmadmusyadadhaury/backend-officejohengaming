<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranIplRuko extends Model
{
    protected $table = 'pembayaran_ipl_ruko';

    protected $fillable = [
        'periode',
        'tanggal_tagihan',
        'jatuh_tempo',
        'nominal',
        'pic',
        'jabatan',
        'status',
        'tanggal_bayar',
        'requested_by',
        'approved_by',
        'approved_at',
        'bukti_bayar',
        'notes',
        'period',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_tagihan' => 'date:d/m/Y',
            'jatuh_tempo' => 'date:d/m/Y',
            'tanggal_bayar' => 'date:d/m/Y',
            'approved_at' => 'datetime',
            'nominal' => 'decimal:2',
            'period' => 'string',
        ];
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusIplAttribute(): string
    {
        if (in_array($this->status, ['lunas', 'pending', 'rejected', 'menunggu'])) {
            return $this->status;
        }

        $now = now();
        $batasJatuhTempo = now()->addDays(7);
        $batasSegera = now()->addDays(3);

        if (! $this->jatuh_tempo) {
            return 'nonaktif';
        }

        if ($this->jatuh_tempo > $batasJatuhTempo) {
            return 'aktif';
        }

        if ($this->jatuh_tempo > $batasSegera) {
            return 'jatuh_tempo';
        }

        if ($this->jatuh_tempo > $now) {
            return 'segera_habis';
        }

        return 'mati';
    }

    public function getHariIplAttribute(): string
    {
        $now = now()->startOfDay();
        $due = $this->jatuh_tempo?->startOfDay();

        if (! $due) {
            return '-';
        }

        $diff = $now->diffInDays($due, false);

        if ($diff > 0) {
            return "H-{$diff}";
        }

        if ($diff === 0) {
            return 'H-0';
        }

        return 'H+'.abs($diff);
    }
}
