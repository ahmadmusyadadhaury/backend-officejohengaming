<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    protected $fillable = [
        'nomor_sim_card',
        'pic',
        'jabatan',
        'masa_aktif',
        'masa_tenggang',
        'status_kartu',
        'keperluan',
    ];

    protected function casts(): array
    {
        return [
            'masa_aktif'         => 'date',
            'masa_tenggang'      => 'date',
            'status_kartu'       => 'boolean',
        ];
    }
}
