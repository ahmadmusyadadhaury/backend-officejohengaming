<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\WeeklyMeeting;
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
            ->map(fn($m) => [
                'id'    => $m->id,
                'title' => $m->requester->name . ' — ' . $m->title,
                'start' => $m->meeting_date->format('Y-m-d') . 'T' . $m->start_time,
                'end'   => $m->meeting_date->format('Y-m-d') . 'T' . ($m->actual_end_time ?? $m->end_time),
                'color' => match($m->status) {
                    'in_progress' => '#7c3aed',
                    'completed'   => '#6b7280',
                    default       => '#1e3a5f',
                },
                'extendedProps' => [
                    'room'   => $m->room->name,
                    'team'   => $m->team->name,
                    'status' => $m->status,
                ],
            ]);

        return response()->json($meetings);
    }
}
