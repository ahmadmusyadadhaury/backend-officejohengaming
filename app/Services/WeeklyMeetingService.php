<?php

namespace App\Services;

use App\Models\User;
use App\Models\WeeklyMeeting;
use App\Models\WeeklyMeetingInvitation;
use App\Models\WeeklyMeetingSession;
use Carbon\Carbon;

class WeeklyMeetingService
{
    public function generateTodaySessions(): void
    {
        $today   = Carbon::today();
        $dayOfWeek = $today->isoWeekday(); // 1=Senin ... 7=Minggu

        $weeklyMeetings = WeeklyMeeting::with('room')
            ->where('is_active', true)
            ->where('day_of_week', $dayOfWeek)
            ->get();

        foreach ($weeklyMeetings as $wm) {
            // Buat sesi jika belum ada untuk hari ini
            $session = WeeklyMeetingSession::firstOrCreate(
                ['weekly_meeting_id' => $wm->id, 'session_date' => $today->toDateString()],
                [
                    'start_time' => $wm->start_time,
                    'end_time'   => $wm->end_time,
                    'status'     => 'active',
                ]
            );

            // Kirim undangan ke semua user aktif
            $users = User::where('is_active', true)->get();
            foreach ($users as $user) {
                WeeklyMeetingInvitation::firstOrCreate(
                    ['session_id' => $session->id, 'user_id' => $user->id],
                    ['is_read' => false]
                );
            }
        }
    }

    public function completeExpiredSessions(): void
    {
        WeeklyMeetingSession::whereIn('status', ['active', 'extended'])
            ->where(function ($q) {
                $q->where('session_date', '<', today())
                  ->orWhere(function ($q2) {
                      $q2->where('session_date', today())
                         ->where('end_time', '<=', now()->format('H:i:s'));
                  });
            })
            ->update(['status' => 'completed', 'actual_end_time' => now()->format('H:i:s')]);
    }
}
