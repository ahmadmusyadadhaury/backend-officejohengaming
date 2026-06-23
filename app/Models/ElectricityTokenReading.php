<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectricityTokenReading extends Model
{
    protected $fillable = [
        'remaining_kwh',
        'status',
        'checked_date',
        'checked_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'remaining_kwh' => 'decimal:2',
            'status' => 'string',
            'checked_date' => 'date',
        ];
    }

    public function checker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
