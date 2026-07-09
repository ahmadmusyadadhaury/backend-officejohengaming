<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'nama_kendaraan',
        'jenis_kendaraan',
        'merk_tipe',
        'plat_nomor',
        'tahun',
        'warna',
        'nomor_rangka',
        'nomor_mesin',
        'foto',
        'pajak_tahunan',
        'pajak_5_tahun',
        'kepemilikan_status',
        'biaya_kendaraan',
        'pic',
        'jabatan',
        'keperluan',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'pajak_tahunan' => 'date',
            'pajak_5_tahun' => 'date',
            'biaya_kendaraan' => 'decimal:2',
        ];
    }

    public function getStatusPajakAttribute(): string
    {
        $now = now();
        $batasJatuhTempo = now()->addDays(7);
        $batasSegera = now()->addDays(3);

        if ($this->pajak_tahunan > $batasJatuhTempo) {
            return 'aktif';
        }

        if ($this->pajak_tahunan > $batasSegera) {
            return 'jatuh_tempo';
        }

        if ($this->pajak_tahunan > $now) {
            return 'segera_habis';
        }

        return 'mati';
    }

    public function getHariPajakAttribute(): string
    {
        $now = now()->startOfDay();
        $due = $this->pajak_tahunan?->startOfDay();

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
