<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeeklyMeeting;
use App\Models\WeeklyMeetingSession;
use Illuminate\Http\Request;

class WeeklyMeetingApiController extends Controller
{
    public function index(Request $request)
    {
        $query = WeeklyMeeting::with('room');

        if ($request->has('active_only') && $request->boolean('active_only')) {
            $query->where('is_active', true);
        }

        $weeklyMeetings = $query->orderBy('day_of_week')->orderBy('start_time')->get();

        $data = $weeklyMeetings->map(function (WeeklyMeeting $wm) use ($request) {
            $sessionsQuery = WeeklyMeetingSession::where('weekly_meeting_id', $wm->id);

            if ($request->filled('date_from')) {
                $sessionsQuery->whereDate('session_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $sessionsQuery->whereDate('session_date', '<=', $request->date_to);
            }

            return [
                'id' => $wm->id,
                'title' => $wm->title,
                'day_of_week' => $wm->day_of_week,
                'start_time' => $wm->start_time,
                'end_time' => $wm->end_time,
                'is_active' => (bool) $wm->is_active,
                'room' => $wm->room ? [
                    'id' => $wm->room->id,
                    'name' => $wm->room->name,
                    'location' => $wm->room->location,
                ] : null,
                'sessions' => $sessionsQuery
                    ->orderBy('session_date', 'desc')
                    ->limit(90)
                    ->get()
                    ->map(fn (WeeklyMeetingSession $s) => [
                        'id' => $s->id,
                        'session_date' => $s->session_date?->format('Y-m-d'),
                        'start_time' => $s->start_time,
                        'end_time' => $s->end_time,
                        'actual_end_time' => $s->actual_end_time,
                        'status' => $s->status,
                    ]),
            ];
        });

        return response()->json($data);
    }
}
