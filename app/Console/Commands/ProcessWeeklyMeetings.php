<?php

namespace App\Console\Commands;

use App\Services\WeeklyMeetingService;
use Illuminate\Console\Command;

class ProcessWeeklyMeetings extends Command
{
    protected $signature   = 'weekly:process';
    protected $description = 'Generate weekly meeting sessions dan kirim undangan otomatis';

    public function handle(WeeklyMeetingService $service): void
    {
        $service->completeExpiredSessions();
        $service->generateTodaySessions();
        $this->info('Weekly meetings processed.');
    }
}
