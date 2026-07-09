<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranAsetDigital extends Model
{
    protected $table = 'pembayaran_aset_digital';

    protected $fillable = [
        'digital_asset_id',
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

    public function digitalAsset()
    {
        return $this->belongsTo(DigitalAsset::class, 'digital_asset_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusDigitalAttribute(): string
    {
        if (in_array($this->status, ['lunas', 'pending', 'rejected'])) {
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

    public function getHariDigitalAttribute(): string
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
