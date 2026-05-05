<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\WeeklyMeetingSession;
use App\Services\MeetingQueueService;
use App\Services\WeeklyMeetingService;
use Carbon\Carbon;

class RealtimeController extends Controller
{
    public function meetings()
    {
        $meetings = Meeting::with(['room', 'team', 'requester'])
            ->whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])
            ->whereDate('meeting_date', '>=', today()->subDay())
            ->get()
            ->map(function ($m) {
                $rt = MeetingQueueService::realtimeStatus($m);
                return [
                    'id'          => $m->id,
                    'title'       => $m->title,
                    'requester'   => $m->requester->name,
                    'room'        => $m->room->name,
                    'team'        => $m->team->name,
                    'date'        => $m->meeting_date->format('Y-m-d'),
                    'start_time'  => substr($m->start_time, 0, 5),
                    'end_time'    => substr($m->actual_end_time ?? $m->end_time, 0, 5),
                    'status'      => $m->status,
                    'rt_label'    => $rt['label'],
                    'rt_color'    => $rt['color'],
                    'rt_dot'      => $rt['dot'],
                    'queue_pos'   => $m->queue_position,
                ];
            });

        return response()->json($meetings);
    }

    public function weeklySessions()
    {
        // Auto-generate & complete expired sessions
        $service = app(WeeklyMeetingService::class);
        $service->generateTodaySessions();
        $service->completeExpiredSessions();

        $now = Carbon::now();

        $sessions = WeeklyMeetingSession::with(['weeklyMeeting.room'])
            ->whereDate('session_date', today())
            ->get()
            ->map(function ($s) use ($now) {
                $startDt = Carbon::parse($s->session_date->format('Y-m-d') . ' ' . $s->start_time);
                $endDt   = Carbon::parse($s->session_date->format('Y-m-d') . ' ' . $s->end_time);

                if ($s->status === 'completed') {
                    $rtLabel = 'Selesai';
                    $rtDot   = '#6b7280';
                } elseif ($now->gte($startDt) && $now->lte($endDt)) {
                    $rtLabel = 'Sedang Berlangsung';
                    $rtDot   = '#0891b2';
                } elseif ($now->lt($startDt)) {
                    $rtLabel = 'Akan Dimulai ' . $startDt->format('H:i');
                    $rtDot   = '#0891b2';
                } else {
                    $rtLabel = 'Selesai';
                    $rtDot   = '#6b7280';
                    // Auto complete jika belum
                    if ($s->status !== 'completed') {
                        $s->update(['status' => 'completed', 'actual_end_time' => $s->end_time]);
                        $s->invitations()->update(['is_read' => true, 'read_at' => now()]);
                    }
                }

                return [
                    'id'         => $s->id,
                    'title'      => $s->weeklyMeeting->title,
                    'room'       => $s->weeklyMeeting->room->name,
                    'date'       => $s->session_date->format('Y-m-d'),
                    'start_time' => substr($s->start_time, 0, 5),
                    'end_time'   => substr($s->end_time, 0, 5),
                    'status'     => $s->status,
                    'rt_label'   => $rtLabel,
                    'rt_dot'     => $rtDot,
                ];
            });

        return response()->json($sessions);
    }
}
