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
    ];

    protected function casts(): array
    {
        return [
            'masa_tenggang' => 'date:d/m/Y',
            'tanggal_bayar' => 'date:d/m/Y',
            'biaya'         => 'decimal:2',
        ];
    }
}
