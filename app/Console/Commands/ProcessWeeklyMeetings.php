<?php

namespace App\Console\Commands;

use App\Models\MeetingInvitation;
use App\Models\Notification;
use App\Models\WeeklyMeetingInvitation;
use App\Services\WeeklyMeetingService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessWeeklyMeetings extends Command
{
    protected $signature = 'weekly:process';

    protected $description = 'Generate weekly meeting sessions, kirim undangan, dan notifikasi meeting mulai';

    public function handle(WeeklyMeetingService $service): void
    {
        $service->completeExpiredSessions();
        $service->generateTodaySessions();

        $this->notifyMeetingStarts();

        $this->info('Weekly meetings processed.');
    }

    private function notifyMeetingStarts(): void
    {
        $now = Carbon::now();
        $today = $now->toDateString();
        $since = $now->copy()->subMinutes(2)->format('H:i:s');
        $until = $now->format('H:i:s');

        // ── Meeting biasa yang baru mulai (dalam 2 menit terakhir) ──
        $started = MeetingInvitation::whereHas('meeting', function ($q) use ($today, $since, $until) {
            $q->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                ->where('meeting_date', $today)
                ->where('start_time', '<=', $until)
                ->where('start_time', '>=', $since);
        })
            ->with('meeting.room')
            ->get();

        foreach ($started as $inv) {
            $m = $inv->meeting;
            $key = 'meeting_start_'.$m->id;

            $already = Notification::where('user_id', $inv->user_id)
                ->where('type', 'meeting')
                ->where('message', 'LIKE', '%'.$key.'%')
                ->exists();

            if (! $already) {
                Notification::send($inv->user_id, 'meeting',
                    'Meeting Dimulai 🟢',
                    $m->title.' di '.$m->room->name.' sudah dimulai! ['.$key.']',
                    route('invitation.index')
                );
            }
        }

        // ── Meeting mingguan yang baru mulai (dalam 2 menit terakhir) ──
        $startedWeekly = WeeklyMeetingInvitation::whereHas('session', function ($q) use ($today, $since, $until) {
            $q->whereIn('status', ['active', 'extended'])
                ->where('session_date', $today)
                ->where('start_time', '<=', $until)
                ->where('start_time', '>=', $since);
        })
            ->with('session.weeklyMeeting.room')
            ->get();

        foreach ($startedWeekly as $inv) {
            $s = $inv->session;
            $key = 'weekly_start_'.$s->id;

            $already = Notification::where('user_id', $inv->user_id)
                ->where('type', 'meeting')
                ->where('message', 'LIKE', '%'.$key.'%')
                ->exists();

            if (! $already) {
                Notification::send($inv->user_id, 'meeting',
                    'Meeting Mingguan Dimulai 🔁',
                    $s->weeklyMeeting->title.' di '.$s->weeklyMeeting->room->name.' sudah dimulai! ['.$key.']',
                    route('weekly.index')
                );
            }
        }
    }
}
