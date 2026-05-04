<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
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
                        default       => '#1e3a5f',
                    },
                    'extendedProps' => [
                        'room'            => $m->room->name,
                        'team'            => $m->team->name,
                        'status'          => $m->status,
                        'start_time'      => $startTime,
                        'end_time'        => substr($m->end_time, 0, 5),
                        'actual_end_time' => $m->actual_end_time ? substr($m->actual_end_time, 0, 5) : null,
                    ],
                ];
            });

        return response()->json($meetings);
    }
}
