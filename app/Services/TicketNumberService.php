<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketNumberService
{
    /**
     * Format: TK-YYYYMMDD-0001 — nomor di-reset setiap hari.
     */
    public function generate(?string $date = null): string
    {
        $date = $date ?: now()->format('Ymd');
        $prefix = 'TK-'.$date.'-';

        return DB::transaction(function () use ($prefix) {
            $last = Ticket::withTrashed()
                ->where('ticket_number', 'like', $prefix.'%')
                ->lockForUpdate()
                ->latest('id')
                ->value('ticket_number');

            $sequence = 1;

            if ($last && preg_match('/-(\d+)$/', $last, $matches)) {
                $sequence = ((int) $matches[1]) + 1;
            } else {
                $sequence = Ticket::withTrashed()->where('ticket_number', 'like', $prefix.'%')->count() + 1;
            }

            return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
        });
    }
}
