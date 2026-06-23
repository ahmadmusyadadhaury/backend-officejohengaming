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
            'mulai'     => 'date',
            'berakhir'  => 'date',
            'biaya'     => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
