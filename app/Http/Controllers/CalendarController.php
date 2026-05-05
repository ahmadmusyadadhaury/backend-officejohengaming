<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\WeeklyMeeting;
use App\Services\MeetingQueueService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function events(Request $request)
    {
        $meetings = Meeting::with(['room', 'team', 'requester'])
            ->whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])
            ->get()
            ->map(function ($m) {
                $date      = $m->meeting_date->format('Y-m-d');
                $startTime = substr($m->start_time, 0, 5);

                // Jika completed dan ada actual_end_time, pakai itu
                $endTime = $m->actual_end_time
                    ? substr($m->actual_end_time, 0, 5)
                    : substr($m->end_time, 0, 5);

                $title = $m->requester->name . ' — ' . $m->title;
                if ($m->status === 'completed' && $m->actual_end_time) {
                    $title .= ' (Selesai ' . substr($m->actual_end_time, 0, 5) . ')';
                }

                return [
                    'id'    => $m->id,
                    'title' => $title,
                    'start' => $date . 'T' . $startTime,
                    'end'   => $date . 'T' . $endTime,
                    'color' => match($m->status) {
                        'completed'   => '#6b7280',
                        'in_progress' => '#7c3aed',
                        'confirmed'   => '#4f46e5',
                        default       => MeetingQueueService::realtimeStatus($m)['dot'],
                    },
                    'extendedProps' => [
                        'room'            => $m->room->name,
                        'team'            => $m->team->name,
                        'status'          => $m->status,
                        'start_time'      => $startTime,
                        'end_time'        => substr($m->end_time, 0, 5),
                        'actual_end_time' => $m->actual_end_time ? substr($m->actual_end_time, 0, 5) : null,
                        'queue_label'     => $m->queue_position !== null ? MeetingQueueService::queueLabel($m->queue_position) : null,
                        'rt_label'        => MeetingQueueService::realtimeStatus($m)['label'],
                        'meeting_id'      => $m->id,
                    ],
                ];
            });

        // Generate weekly meeting events untuk 8 minggu ke depan
        $weeklyMeetings = WeeklyMeeting::with('room')->where('is_active', true)->get();
        $weeklyEvents   = collect();
        $now            = Carbon::now();

        foreach ($weeklyMeetings as $wm) {
            $startDate = now()->startOfWeek(Carbon::MONDAY);
            $endDate   = now()->addWeeks(8);
            $current   = $startDate->copy();

            while ($current->lte($endDate)) {
                if ($current->isoWeekday() === (int) $wm->day_of_week) {
                    $dateStr   = $current->format('Y-m-d');
                    $startTime = substr($wm->start_time, 0, 5);
                    $endTime   = substr($wm->end_time, 0, 5);

                    // Cek session yang sudah ada untuk status real-time
                    $session = \App\Models\WeeklyMeetingSession::where('weekly_meeting_id', $wm->id)
                        ->where('session_date', $dateStr)
                        ->first();

                    $rtLabel = '🔁 ' . $wm->title;
                    $color   = '#0891b2';

                    if ($session) {
                        $startDt = Carbon::parse($dateStr . ' ' . $session->start_time);
                        $endDt   = Carbon::parse($dateStr . ' ' . $session->end_time);

                        if ($session->status === 'completed') {
                            $color   = '#6b7280';
                            $rtLabel = '🔁 ' . $wm->title . ' (Selesai)';
                        } elseif ($now->gte($startDt) && $now->lte($endDt)) {
                            $color   = '#0e7490';
                            $rtLabel = '🔁 ' . $wm->title . ' — Sedang Berlangsung';
                        }

                        $endTime = substr($session->end_time, 0, 5);
                    }

                    $weeklyEvents->push([
                        'id'    => 'weekly-' . $wm->id . '-' . $current->format('Ymd'),
                        'title' => $rtLabel,
                        'start' => $dateStr . 'T' . $startTime,
                        'end'   => $dateStr . 'T' . $endTime,
                        'color' => $color,
                        'extendedProps' => [
                            'room'            => $wm->room->name,
                            'team'            => 'Semua Tim',
                            'status'          => $session ? $session->status : 'weekly',
                            'start_time'      => $startTime,
                            'end_time'        => $endTime,
                            'actual_end_time' => $session?->actual_end_time ? substr($session->actual_end_time, 0, 5) : null,
                            'queue_label'     => null,
                            'rt_label'        => $session ? ($session->status === 'completed' ? 'Selesai' : ($now->gte(Carbon::parse($dateStr . ' ' . $session->start_time)) ? 'Sedang Berlangsung' : 'Akan Dimulai')) : 'Meeting Mingguan',
                            'rt_dot'          => $color,
                            'meeting_id'      => null,
                            'weekly_id'       => 'weekly-' . $wm->id . '-' . $current->format('Ymd'),
                        ],
                    ]);
                }
                $current->addDay();
            }
        }

        return response()->json($meetings->merge($weeklyEvents)->values());
    }
}
