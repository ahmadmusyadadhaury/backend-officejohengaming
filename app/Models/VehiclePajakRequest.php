<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiclePajakRequest extends Model
{
    protected $fillable = [
        'vehicle_id',
        'requested_by',
        'jenis',
        'nominal',
        'bukti_bayar',
        'status',
        'approved_by',
        'approved_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'approved_at' => 'datetime',
        ];
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
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
