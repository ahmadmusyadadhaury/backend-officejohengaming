<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    protected $fillable = [
        'nomor_sim_card',
        'pic',
        'atasan',
        'jabatan',
        'masa_aktif',
        'masa_tenggang',
        'status_paket_kuota',
        'status_kartu',
        'keperluan',
    ];

    protected function casts(): array
    {
        return [
            'masa_aktif' => 'date',
            'masa_tenggang' => 'date',
            'status_paket_kuota' => 'boolean',
            'status_kartu' => 'boolean',
        ];
    }

    public function getStatusSimAttribute(): string
    {
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

    public function getHariSimAttribute(): string
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
