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
