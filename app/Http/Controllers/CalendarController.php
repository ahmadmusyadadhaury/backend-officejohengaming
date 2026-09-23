<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Meeting;
use App\Models\Room;
use App\Models\WeeklyMeeting;
use App\Models\WeeklyMeetingSession;
use App\Services\MeetingQueueService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        // Jadwal meeting terdekat
        $upcomingMeetings = Meeting::with(['requester', 'team', 'room'])
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->where('meeting_date', '>=', today())
            ->orderBy('meeting_date')
            ->orderBy('start_time')
            ->take(3)
            ->get();

        // Pembayaran Mendatang
        $upcomingPayments = Meeting::with(['requester', 'room'])
            ->where('status', 'pending')
            ->orderBy('meeting_date')
            ->take(3)
            ->get();

        // Peringatan Kadaluarsa (Aset dengan stock rendah)
        $upcomingAlerts = Asset::where('quantity', '<=', 2)
            ->orderBy('quantity')
            ->take(3)
            ->get();

        $weeklyMeetings = WeeklyMeeting::with('room')->get();
        $roomsQuery = Room::where('is_active', true);
        if (auth()->user()->role === 'koordinator') {
            $roomsQuery->where(function ($q) {
                $q->where('team_id', auth()->user()->team_id)
                    ->orWhereNull('team_id');
            });
        }
        $rooms = $roomsQuery->get();
        $days = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];

        $weeklyData = $weeklyMeetings->map(fn ($w) => [
            'id' => $w->id,
            'title' => $w->title,
            'room_id' => $w->room_id,
            'day_of_week' => $w->day_of_week,
            'start_time' => substr($w->start_time, 0, 5),
            'end_time' => substr($w->end_time, 0, 5),
            'is_active' => $w->is_active,
            'room_name' => $w->room->name ?? '',
        ])->values();

        return view('calendar', compact('upcomingMeetings', 'upcomingPayments', 'upcomingAlerts', 'weeklyMeetings', 'rooms', 'days', 'weeklyData'));
    }

    public function events(Request $request)
    {
        $meetings = Meeting::with(['room', 'team', 'requester'])
            ->whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])
            ->get()
            ->map(function ($m) {
                $date = $m->meeting_date->format('Y-m-d');
                $startTime = substr($m->start_time, 0, 5);

                // Jika completed dan ada actual_end_time, pakai itu
                $endTime = $m->actual_end_time
                    ? substr($m->actual_end_time, 0, 5)
                    : substr($m->end_time, 0, 5);

                $title = $m->requester->name.' ΓÇö '.$m->title;
                if ($m->status === 'completed' && $m->actual_end_time) {
                    $title .= ' (Selesai '.substr($m->actual_end_time, 0, 5).')';
                }

                return [
                    'id' => $m->id,
                    'title' => $title,
                    'start' => $date.'T'.$startTime,
                    'end' => $date.'T'.$endTime,
                    'color' => match ($m->status) {
                        'completed' => '#6b7280',
                        'in_progress' => '#7c3aed',
                        'confirmed' => '#4f46e5',
                        default => MeetingQueueService::realtimeStatus($m)['dot'],
                    },
                    'extendedProps' => [
                        'room' => $m->room->name,
                        'team' => $m->team->name,
                        'status' => $m->status,
                        'start_time' => $startTime,
                        'end_time' => substr($m->end_time, 0, 5),
                        'actual_end_time' => $m->actual_end_time ? substr($m->actual_end_time, 0, 5) : null,
                        'queue_label' => $m->queue_position !== null ? MeetingQueueService::queueLabel($m->queue_position) : null,
                        'rt_label' => MeetingQueueService::realtimeStatus($m)['label'],
                        'meeting_id' => $m->id,
                    ],
                ];
            });

        // Generate weekly meeting events mengikuti rentang tampilan (start/end dari FullCalendar)
        $weeklyMeetings = WeeklyMeeting::with('room')->where('is_active', true)->get();
        $weeklyEvents = collect();
        $now = Carbon::now();
        $renderedKeys = collect();

        // 1) Sesi yang SUDAH tersimpan ditampilkan apa adanya (hari aslinya, mis. Senin)
        //    sehingga riwayat minggu/bulan sebelumnya yang sudah di-generate TETAP tampil
        //    di kalender sesuai tanggal aktualnya (bukan digenerate ulang di hari baru).
        $storedSessions = WeeklyMeetingSession::with(['weeklyMeeting.room'])->get();
        foreach ($storedSessions as $session) {
            if (! $session->weeklyMeeting || ! $session->weeklyMeeting->room) {
                continue;
            }
            $wm = $session->weeklyMeeting;
            $dateStr = $session->session_date->format('Y-m-d');
            $startTime = substr($session->start_time, 0, 5);
            $endTime = substr($session->end_time, 0, 5);

            $color = '#0891b2';
            $rtLabel = 'ðŸ” '.$wm->title;

            if ($session->status === 'completed') {
                $color = '#6b7280';
                $rtLabel = 'ðŸ” '.$wm->title.' (Selesai)';
            } else {
                $startDt = Carbon::parse($dateStr.' '.$session->start_time);
                $endDt = Carbon::parse($dateStr.' '.$session->end_time);
                if ($now->gte($startDt) && $now->lte($endDt)) {
                    $color = '#0e7490';
                    $rtLabel = 'ðŸ” '.$wm->title.' â€” Sedang Berlangsung';
                }
            }

            if ($session->actual_end_time) {
                $endTime = substr($session->actual_end_time, 0, 5);
            }

            $weeklyEvents->push([
                'id' => 'weekly-'.$wm->id.'-'.$session->session_date->format('Ymd'),
                'title' => $rtLabel,
                'start' => $dateStr.'T'.$startTime,
                'end' => $dateStr.'T'.$endTime,
                'color' => $color,
                'extendedProps' => [
                    'room' => $wm->room->name,
                    'team' => 'Semua Tim',
                    'status' => $session->status ?? 'weekly',
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'actual_end_time' => $session->actual_end_time ? substr($session->actual_end_time, 0, 5) : null,
                    'queue_label' => null,
                    'rt_label' => $rtLabel,
                    'rt_dot' => $color,
                    'meeting_id' => null,
                    'weekly_id' => 'weekly-'.$wm->id.'-'.$session->session_date->format('Ymd'),
                ],
            ]);
            $renderedKeys->push($wm->id.'-'.$session->session_date->format('Ymd'));
        }

        // 2) Event berulang untuk rentang yang sedang dilihat (start/end dari FullCalendar),
        //    mengikuti aturan transisi hari: sebelum day_of_week_changed_on event dirender
        //    di hari lama (day_of_week_old, mis. Senin); mulai tanggal itu di hari baru
        //    (day_of_week, mis. Selasa). Dengan begitu riwayat minggu/bulan sebelumnya
        //    yang jatuh di Senin TETAP tampil, dan ke depan jadi Selasa.
        $rangeStart = $request->filled('start')
            ? Carbon::parse($request->input('start'))
            : now()->startOfWeek(Carbon::MONDAY);
        $rangeEnd = $request->filled('end')
            ? Carbon::parse($request->input('end'))
            : now()->addWeeks(8);

        foreach ($weeklyMeetings as $wm) {
            $current = $rangeStart->copy();

            while ($current->lte($rangeEnd)) {
                $hasTransition = $wm->day_of_week_changed_on !== null && $wm->day_of_week_old !== null;
                $effectiveDay = ($hasTransition && $current->lt(Carbon::parse($wm->day_of_week_changed_on)))
                    ? (int) $wm->day_of_week_old
                    : (int) $wm->day_of_week;

                if ($current->isoWeekday() === $effectiveDay) {
                    $dateStr = $current->format('Y-m-d');
                    $key = $wm->id.'-'.$current->format('Ymd');

                    if (! $renderedKeys->contains($key)) {
                        $startTime = substr($wm->start_time, 0, 5);
                        $endTime = substr($wm->end_time, 0, 5);

                        $session = WeeklyMeetingSession::where('weekly_meeting_id', $wm->id)
                            ->where('session_date', $dateStr)
                            ->first();

                        $color = '#0891b2';
                        $rtLabel = 'ðŸ” '.$wm->title;

                        if ($session) {
                            if ($session->status === 'completed') {
                                $color = '#6b7280';
                                $rtLabel = 'ðŸ” '.$wm->title.' (Selesai)';
                            } else {
                                $startDt = Carbon::parse($dateStr.' '.$session->start_time);
                                $endDt = Carbon::parse($dateStr.' '.$session->end_time);
                                if ($now->gte($startDt) && $now->lte($endDt)) {
                                    $color = '#0e7490';
                                    $rtLabel = 'ðŸ” '.$wm->title.' â€” Sedang Berlangsung';
                                }
                            }
                            if ($session->actual_end_time) {
                                $endTime = substr($session->actual_end_time, 0, 5);
                            }
                        }

                        $weeklyEvents->push([
                            'id' => 'weekly-'.$wm->id.'-'.$current->format('Ymd'),
                            'title' => $rtLabel,
                            'start' => $dateStr.'T'.$startTime,
                            'end' => $dateStr.'T'.$endTime,
                            'color' => $color,
                            'extendedProps' => [
                                'room' => $wm->room->name,
                                'team' => 'Semua Tim',
                                'status' => $session?->status ?? 'weekly',
                                'start_time' => $startTime,
                                'end_time' => $endTime,
                                'actual_end_time' => $session?->actual_end_time ? substr($session->actual_end_time, 0, 5) : null,
                                'queue_label' => null,
                                'rt_label' => $rtLabel,
                                'rt_dot' => $color,
                                'meeting_id' => null,
                                'weekly_id' => 'weekly-'.$wm->id.'-'.$current->format('Ymd'),
                            ],
                        ]);
                    }
                }
                $current->addDay();
            }
        }
        return response()->json($meetings->merge($weeklyEvents)->values());
    }
}
