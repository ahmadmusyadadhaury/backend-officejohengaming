<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Meeting;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $myMeetings = $user->participatingMeetings()
            ->with(['room', 'team', 'requester'])
            ->whereIn('meetings.status', ['approved', 'confirmed', 'in_progress'])
            ->where('meeting_date', '>=', today())
            ->orderBy('meeting_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        $todayMeetings = Meeting::with(['room', 'team', 'requester'])
            ->whereDate('meeting_date', today())
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->orderBy('start_time')
            ->get();

        return view('user.dashboard', compact('myMeetings', 'todayMeetings'));
    }
}
