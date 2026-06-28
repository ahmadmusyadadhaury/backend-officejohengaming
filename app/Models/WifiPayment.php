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
    ];

    protected function casts(): array
    {
        return [
            'masa_tenggang' => 'date:d/m/Y',
            'tanggal_bayar' => 'date:d/m/Y',
            'approved_at' => 'datetime',
            'biaya' => 'decimal:2',
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
}
