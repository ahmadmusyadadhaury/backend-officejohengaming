<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TokenPayment extends Model
{
    protected $fillable = ['amount_kwh', 'payment_date', 'period', 'notes', 'created_by'];

    protected function casts(): array
    {
        return [
            'amount_kwh' => 'decimal:2',
            'payment_date' => 'date',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getNotesDisplay(): string
    {
        return $this->notes ?: 'Tidak ada catatan';
    }
}
