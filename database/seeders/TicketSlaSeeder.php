<?php

namespace Database\Seeders;

use App\Models\TicketSla;
use Illuminate\Database\Seeder;

class TicketSlaSeeder extends Seeder
{
    public function run(): void
    {
        $slas = [
            'low' => 3 * 24 * 60,
            'medium' => 1 * 24 * 60,
            'high' => 4 * 60,
            'urgent' => 2 * 60,
        ];

        foreach ($slas as $priority => $minutes) {
            TicketSla::updateOrCreate(
                ['priority' => $priority],
                ['duration_minutes' => $minutes]
            );
        }
    }
}
