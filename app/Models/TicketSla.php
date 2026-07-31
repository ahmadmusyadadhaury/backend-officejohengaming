<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketSla extends Model
{
    protected $table = 'ticket_sla';

    protected $fillable = ['priority', 'duration_minutes', 'label'];

    public function durationLabel(?int $minutes = null): string
    {
        $minutes = (int) ($minutes ?? $this->duration_minutes);

        if ($minutes % (24 * 60) === 0) {
            return $minutes / (24 * 60).' hari';
        }

        if ($minutes % 60 === 0) {
            return $minutes / 60 .' jam';
        }

        return $minutes.' menit';
    }
}
