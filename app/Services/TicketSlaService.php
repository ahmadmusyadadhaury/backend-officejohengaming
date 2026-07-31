<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketSla;
use Illuminate\Support\Carbon;

class TicketSlaService
{
    /**
     * Batas waktu SLA (datetime) untuk sebuah prioritas.
     */
    public function dueAt(string $priority, $from = null): ?Carbon
    {
        $minutes = $this->minutesFor($priority);

        if ($minutes === null) {
            return null;
        }

        return Carbon::parse($from ?? now())->addMinutes($minutes);
    }

    public function minutesFor(string $priority): ?int
    {
        $minutes = TicketSla::where('priority', $priority)->value('duration_minutes');

        return $minutes !== null ? (int) $minutes : null;
    }

    public function durationLabel(string $priority): string
    {
        $sla = TicketSla::where('priority', $priority)->first();

        return $sla ? $sla->durationLabel() : '-';
    }

    public function isOverSla(Ticket $ticket): bool
    {
        return $ticket->isOverSla();
    }

    /**
     * Jumlah ticket yang sudah melewati SLA (untuk dashboard).
     */
    public function countOverSla($query = null): int
    {
        $tickets = $query ?? Ticket::query();

        return $tickets->active()->whereNotNull('sla_due_at')->where('sla_due_at', '<', now())->count();
    }
}
