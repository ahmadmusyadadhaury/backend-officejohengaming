<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DigitalAsset extends Model
{
    protected $fillable = [
        'nama_aset',
        'email',
        'mulai',
        'berakhir',
        'biaya',
        'pic',
        'jabatan',
        'keperluan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'mulai' => 'date',
            'berakhir' => 'date',
            'biaya' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pembayaran()
    {
        return $this->hasOne(PembayaranAsetDigital::class, 'digital_asset_id');
    }

    public function getStatusAsetAttribute(): string
    {
        $now = now();
        $batasJatuhTempo = now()->addDays(7);
        $batasSegera = now()->addDays(3);

        if (! $this->berakhir) {
            return 'nonaktif';
        }

        if ($this->berakhir > $batasJatuhTempo) {
            return 'aktif';
        }

        if ($this->berakhir > $batasSegera) {
            return 'jatuh_tempo';
        }

        if ($this->berakhir > $now) {
            return 'segera_habis';
        }

        return 'mati';
    }

    public function getHariAsetAttribute(): string
    {
        $now = now()->startOfDay();
        $due = $this->berakhir?->startOfDay();

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
