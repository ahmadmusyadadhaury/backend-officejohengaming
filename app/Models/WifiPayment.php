<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WifiPayment extends Model
{
    protected $table = 'wifi_payments';

    protected $fillable = [
        'nama_internet',
        'provider',
        'pic',
        'jabatan',
        'masa_tenggang',
        'biaya',
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
            'masa_tenggang' => 'date:d/m/Y',
            'tanggal_bayar' => 'date:d/m/Y',
            'approved_at' => 'datetime',
            'biaya' => 'decimal:2',
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

    public function getStatusInternetAttribute(): string
    {
        if (in_array($this->status, ['lunas', 'pending', 'rejected'])) {
            return $this->status;
        }

        $now = now();
        $batasJatuhTempo = now()->addDays(7);
        $batasSegera = now()->addDays(3);

        if (! $this->masa_tenggang) {
            return 'nonaktif';
        }

        if ($this->masa_tenggang > $batasJatuhTempo) {
            return 'aktif';
        }

        if ($this->masa_tenggang > $batasSegera) {
            return 'jatuh_tempo';
        }

        if ($this->masa_tenggang > $now) {
            return 'segera_habis';
        }

        return 'mati';
    }

    public function getHariInternetAttribute(): string
    {
        $now = now()->startOfDay();
        $due = $this->masa_tenggang?->startOfDay();

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
