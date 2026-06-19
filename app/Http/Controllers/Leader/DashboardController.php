<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Meeting;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'pending' => Meeting::where('requested_by', $user->id)->where('status', 'pending')->count(),
            'approved' => Meeting::where('requested_by', $user->id)->where('status', 'approved')->count(),
            'completed' => Meeting::where('requested_by', $user->id)->where('status', 'completed')->count(),
            'cancelled' => Meeting::where('requested_by', $user->id)->where('status', 'cancelled')->count(),
        ];

        $upcomingMeetings = Meeting::with(['room', 'team'])
            ->where('requested_by', $user->id)
            ->whereIn('status', ['approved', 'confirmed'])
            ->where('meeting_date', '>=', today())
            ->orderBy('meeting_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        $recentMeetings = Meeting::with(['room', 'team'])
            ->where('requested_by', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('leader.dashboard', compact('stats', 'upcomingMeetings', 'recentMeetings'));
    }
}
