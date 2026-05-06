<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\WeeklyMeetingInvitation;
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

    public function notifCount()
    {
        $activeInvitations = MeetingInvitation::where('user_id', auth()->id())
            ->whereHas('meeting', function($q) {
                $q->whereIn('status', ['approved','confirmed','in_progress'])
                  ->where(function($q2) {
                      $q2->where('meeting_date', '>', today())
                         ->orWhere(function($q3) {
                             $q3->where('meeting_date', today())
                                ->where('end_time', '>', Carbon::now()->format('H:i:s'));
                         });
                  });
            })->count();

        $activeWeeklyInvitations = WeeklyMeetingInvitation::where('user_id', auth()->id())
            ->whereHas('session', fn($q) => $q->whereIn('status', ['active','extended']))
            ->count();

        $pendingInvitations = MeetingInvitation::where('user_id', auth()->id())
            ->where('is_read', false)
            ->whereHas('meeting', function($q) {
                $q->whereIn('status', ['approved','confirmed','in_progress'])
                  ->where(function($q2) {
                      $q2->where('meeting_date', '>', today())
                         ->orWhere(function($q3) {
                             $q3->where('meeting_date', today())
                                ->where('end_time', '>', Carbon::now()->format('H:i:s'));
                         });
                  });
            })->count();

        $pendingWeeklyInvitations = WeeklyMeetingInvitation::where('user_id', auth()->id())
            ->where('is_read', false)
            ->whereHas('session', fn($q) => $q->whereIn('status', ['active','extended']))
            ->count();

        return response()->json([
            'total_active'  => $activeInvitations + $activeWeeklyInvitations,
            'total_pending' => $pendingInvitations + $pendingWeeklyInvitations,
        ]);
    }

    public function dashboardStats()
    {
        $role = auth()->user()->role;

        if (in_array($role, \App\Models\User::FULL_ACCESS_ROLES)) {
            // Admin stats
            return response()->json([
                'pending'        => Meeting::where('status', 'pending')->count(),
                'today_meetings' => Meeting::whereDate('meeting_date', today())
                                        ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                                        ->count(),
            ]);
        }

        if ($role === 'koordinator' || in_array($role, ['head_of_store', 'gm', 'hr'])) {
            // Leader stats
            return response()->json([
                'pending'   => Meeting::where('requested_by', auth()->id())->where('status', 'pending')->count(),
                'approved'  => Meeting::where('requested_by', auth()->id())->where('status', 'approved')->count(),
                'completed' => Meeting::where('requested_by', auth()->id())->where('status', 'completed')->count(),
            ]);
        }

        return response()->json([]);
    }
}
