<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
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
            'total_ceo'         => User::where('role', 'ceo')->where('is_active', true)->count(),
            'total_gm'          => User::where('role', 'gm')->where('is_active', true)->count(),
            'total_head_store'  => User::where('role', 'head_of_store')->where('is_active', true)->count(),
            'total_hr'          => User::where('role', 'hr')->where('is_active', true)->count(),
            'total_koordinator' => User::where('role', 'koordinator')->where('is_active', true)->count(),
            'total_karyawan'    => User::where('role', 'user')->where('is_active', true)->count(),
            'total_team'        => Team::count(),
            'total_teams'       => Team::count(),
            'total_rooms'       => Room::count(),
            // Asset stats
            'total_assets'      => Asset::count(),
            'digital_assets'    => Asset::where('is_active', true)->count(),
            'assets_near_expire'=> \Illuminate\Support\Facades\Schema::hasColumn('assets','expire_date')
                ? Asset::whereNotNull('expire_date')->where('expire_date','>=',today())->where('expire_date','<=',today()->addDays(30))->count()
                : 0,
            // Meeting stats
            'total_meetings'        => Meeting::count(),
            'meetings_this_week'    => Meeting::whereBetween('meeting_date',[now()->startOfWeek(),now()->endOfWeek()])->count(),
            'pending'               => Meeting::where('status','pending')->count(),
            'today_meetings'        => Meeting::whereDate('meeting_date',today())->whereIn('status',['approved','confirmed','in_progress'])->count(),
            'this_month'            => Meeting::whereMonth('meeting_date',now()->month)->whereYear('meeting_date',now()->year)->count(),
            // Payment stats - based on meetings
            'total_payments'        => Meeting::whereIn('status',['approved','confirmed','in_progress','completed'])->count(),
            'pending_payments'      => Meeting::where('status','pending')->count(),
        ];

        // Data untuk tampilan
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

        $upcomingPayments = Meeting::with(['requester', 'room', 'team'])
            ->where('status', 'pending')
            ->orderBy('meeting_date')
            ->take(5)
            ->get();

        $approvalWaitingMeetings = Meeting::with(['requester', 'team', 'room'])
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        // Asset expiration data
        $expiringAssets = collect();
        $expiredAssets  = collect();
        $digitalAssetsNeedMaintenance = collect();

        if (\Illuminate\Support\Facades\Schema::hasColumn('assets', 'expire_date')) {
            $expiringAssets = Asset::whereNotNull('expire_date')
                ->where('expire_date', '>=', today())
                ->where('expire_date', '<=', today()->addDays(30))
                ->orderBy('expire_date')
                ->take(5)
                ->get();

            $expiredAssets = Asset::whereNotNull('expire_date')
                ->where('expire_date', '<', today())
                ->orderBy('expire_date')
                ->take(3)
                ->get();

            $digitalAssetsNeedMaintenance = Asset::where('is_active', true)
                ->whereNotNull('expire_date')
                ->where('expire_date', '<=', today()->addDays(30))
                ->orderBy('expire_date')
                ->get();
        }

        $allAlertAssets = $expiredAssets->merge($expiringAssets);

        // Undangan aktif
        $myInvitations = MeetingInvitation::where('user_id', auth()->id())
            ->whereHas('meeting', fn ($q) => $q->whereIn('status', ['approved', 'confirmed', 'in_progress']))
            ->with('meeting.room', 'meeting.team')
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingMeetings', 'todayMeetings', 'upcomingPayments', 'approvalWaitingMeetings', 'myInvitations', 'allAlertAssets', 'expiringAssets', 'expiredAssets', 'digitalAssetsNeedMaintenance'));
    }
}
