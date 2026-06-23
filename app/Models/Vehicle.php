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
        $batasSegera = now()->addMonth();

        if ($this->pajak_tahunan < $now) {
            return 'mati';
        }

        if ($this->pajak_tahunan <= $batasSegera) {
            return 'segera_habis';
        }

        return 'aktif';
    }
}
