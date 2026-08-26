<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternetQuotaTopup extends Model
{
    protected $fillable = [
        'wifi_payment_id',
        'amount_gb',
        'nominal',
        'payment_date',
        'period',
        'notes',
        'bukti_bayar',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'amount_gb' => 'decimal:2',
            'nominal' => 'decimal:2',
            'payment_date' => 'date',
        ];
    }

    public function wifiPayment()
    {
        return $this->belongsTo(WifiPayment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
