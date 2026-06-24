<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        $query = $user->participatingMeetings()
            ->with(['room', 'team', 'requester'])
            ->whereIn('meetings.status', ['approved', 'confirmed', 'in_progress']);

        if ($search) {
            $query->where('meetings.title', 'like', "%{$search}%");
        }

        if ($status && $status !== 'all') {
            $query->where('meetings.status', $status);
        }

        $myMeetings = $query->orderBy('meeting_date')
            ->orderBy('start_time')
            ->paginate(10)
            ->withQueryString();

        $todayMeetings = Meeting::with(['room', 'team', 'requester'])
            ->whereDate('meeting_date', today())
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->orderBy('start_time')
            ->get();

        $totalInvitations = $user->participatingMeetings()
            ->whereIn('meetings.status', ['approved', 'confirmed', 'in_progress'])
            ->count();

        $mendatangCount = $user->participatingMeetings()
            ->whereIn('meetings.status', ['approved', 'confirmed', 'in_progress'])
            ->where('meeting_date', '>=', today())
            ->count();

        $selesaiCount = $user->participatingMeetings()
            ->where('meetings.status', 'completed')
            ->count();

        return view('user.dashboard', compact(
            'myMeetings', 'todayMeetings', 'search', 'status',
            'totalInvitations', 'mendatangCount', 'selesaiCount'
        ));
    }
}
