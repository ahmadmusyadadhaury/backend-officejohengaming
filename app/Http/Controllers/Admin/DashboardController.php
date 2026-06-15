<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\Room;
use App\Models\Team;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_karyawan' => User::where('role', 'user')->where('is_active', true)->count(),
            'total_koordinator' => User::where('role', 'koordinator')->where('is_active', true)->count(),
            'total_head_store' => User::where('role', 'head_of_store')->where('is_active', true)->count(),
            'total_gm' => User::where('role', 'gm')->where('is_active', true)->count(),
            'total_ceo' => User::where('role', 'ceo')->where('is_active', true)->count(),
            'total_hr' => User::where('role', 'hr')->where('is_active', true)->count(),
            'total_teams' => Team::count(),
            'total_rooms' => Room::count(),
            'pending' => Meeting::where('status', 'pending')->count(),
            'today_meetings' => Meeting::whereDate('meeting_date', today())
                ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
                ->count(),
            'this_month' => Meeting::whereMonth('meeting_date', now()->month)
                ->whereYear('meeting_date', now()->year)
                ->count(),
        ];

        $pendingMeetings = Meeting::with(['requester', 'team', 'room'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $todayMeetings = Meeting::with(['requester', 'team', 'room'])
            ->whereDate('meeting_date', today())
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->orderBy('start_time')
            ->get();

        // Undangan aktif untuk gm, head_of_store, hr
        $myInvitations = MeetingInvitation::where('user_id', auth()->id())
            ->whereHas('meeting', fn ($q) => $q->whereIn('status', ['approved', 'confirmed', 'in_progress']))
            ->with('meeting.room', 'meeting.team')
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingMeetings', 'todayMeetings', 'myInvitations'));
    }
}
