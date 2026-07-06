<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Payment;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\Team;
use App\Models\WeeklyMeetingSession;
use App\Models\WifiPayment;
use App\Services\WeeklyMeetingService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        $query = $user->participatingMeetings()
            ->with(['room', 'team', 'requester', 'assets'])
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

        app(WeeklyMeetingService::class)->generateTodaySessions();

        $todayMeetings = Meeting::with(['room', 'team', 'requester'])
            ->whereDate('meeting_date', today())
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->orderBy('start_time')
            ->get()
            ->map(function ($m) {
                $m->meeting_type = 'regular';

                return $m;
            });

        $weeklySessions = WeeklyMeetingSession::with('weeklyMeeting.room')
            ->whereDate('session_date', today())
            ->whereIn('status', ['active', 'extended'])
            ->get()
            ->map(function ($s) {
                $m = new Meeting;
                $m->title = $s->weeklyMeeting->title;
                $m->start_time = $s->start_time;
                $m->end_time = $s->end_time;
                $m->room = $s->weeklyMeeting->room;
                $team = new Team;
                $team->name = 'Weekly';
                $m->team = $team;
                $m->meeting_type = 'weekly';

                return $m;
            });

        foreach ($weeklySessions as $ws) {
            $todayMeetings->push($ws);
        }
        $todayMeetings = $todayMeetings->sortBy('start_time');

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

        $dueTagihanCount = Payment::where('jenis', 'listrik')->whereNull('requested_by')->whereNotIn('status', ['lunas', 'rejected'])->where('jatuh_tempo', '<=', today()->addDays(7))->count()
            + WifiPayment::whereNull('requested_by')->whereNotIn('status', ['lunas', 'rejected'])->where('masa_tenggang', '<=', today()->addDays(7))->count()
            + PembayaranAsetDigital::whereNull('requested_by')->whereNotIn('status', ['lunas', 'rejected'])->where('jatuh_tempo', '<=', today()->addDays(7))->count()
            + PembayaranIplRuko::whereNull('requested_by')->whereNotIn('status', ['lunas', 'rejected'])->where('jatuh_tempo', '<=', today()->addDays(7))->count();

        $meetingsJson = $myMeetings->map(fn ($m) => [
            'id' => $m->id,
            'title' => $m->title,
            'why' => $m->why,
            'what' => $m->what,
            'how_expected' => $m->how_expected,
            'status' => $m->status,
            'room' => $m->room ? ['name' => $m->room->name] : null,
            'requester' => $m->requester ? ['name' => $m->requester->name] : null,
            'team' => $m->team ? ['name' => $m->team->name] : null,
            'meeting_date' => $m->meeting_date?->format('d M Y'),
            'meeting_date_raw' => $m->meeting_date?->format('Y-m-d'),
            'start_time' => $m->start_time,
            'end_time' => $m->end_time,
            'assets' => $m->assets->map(fn ($a) => [
                'name' => $a->name,
                'quantity' => $a->pivot->quantity,
            ]),
        ]);

        return view('user.dashboard', compact(
            'myMeetings', 'todayMeetings', 'meetingsJson', 'search', 'status',
            'totalInvitations', 'mendatangCount', 'selesaiCount', 'dueTagihanCount'
        ));
    }
}
