<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'jenis',
        'periode',
        'tanggal_tagihan',
        'jatuh_tempo',
        'nominal',
        'status',
        'tanggal_bayar',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_tagihan' => 'date:d/m/Y',
            'jatuh_tempo' => 'date:d/m/Y',
            'tanggal_bayar' => 'date:d/m/Y',
            'nominal' => 'decimal:2',
        ];
    }
}
