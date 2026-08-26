<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternetQuotaReading extends Model
{
    protected $fillable = [
        'wifi_payment_id',
        'remaining_gb',
        'status',
        'checked_date',
        'checked_by',
        'notes',
        'bukti_foto',
    ];

    protected function casts(): array
    {
        return [
            'remaining_gb' => 'decimal:2',
            'checked_date' => 'date',
        ];
    }

    public function wifiPayment()
    {
        return $this->belongsTo(WifiPayment::class);
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
