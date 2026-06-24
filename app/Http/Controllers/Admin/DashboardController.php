<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\ElectricityTokenReading;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Team;
use App\Models\User;
use App\Models\WifiPayment;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_ceo' => User::where('role', 'ceo')->where('is_active', true)->count(),
            'total_gm' => User::where('role', 'gm')->where('is_active', true)->count(),
            'total_head_store' => User::where('role', 'head_of_store')->where('is_active', true)->count(),
            'total_hr' => User::where('role', 'hr')->where('is_active', true)->count(),
            'total_koordinator' => User::where('role', 'koordinator')->where('is_active', true)->count(),
            'total_karyawan' => User::where('role', 'user')->where('is_active', true)->count(),
            'total_team' => Team::count(),
            'total_teams' => Team::count(),
            'total_rooms' => Room::count(),
            // Asset stats
            'total_assets' => Asset::count(),
            'digital_assets' => Asset::where('is_active', true)->count(),
            'assets_near_expire' => Schema::hasColumn('assets', 'expire_date')
                ? Asset::whereNotNull('expire_date')->where('expire_date', '>=', today())->where('expire_date', '<=', today()->addDays(30))->count()
                : 0,
            // Meeting stats
            'total_meetings' => Meeting::count(),
            'meetings_this_week' => Meeting::whereBetween('meeting_date', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'pending' => Meeting::where('status', 'pending')->count(),
            'today_meetings' => Meeting::whereDate('meeting_date', today())->whereIn('status', ['approved', 'confirmed', 'in_progress'])->count(),
            'this_month' => Meeting::whereMonth('meeting_date', now()->month)->whereYear('meeting_date', now()->year)->count(),
            // Payment stats
            'total_payments' => Payment::count() + WifiPayment::count(),
            'pending_payments' => Payment::where('status', 'jatuh_tempo')->count() + WifiPayment::where('status', 'jatuh_tempo')->count(),
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

        $today = today();
        $threeDaysFromNow = today()->addDays(3);

        $jenisLabels = [
            'listrik' => 'Listrik',
            'aset_digital' => 'Aset Digital',
            'ipl_ruko' => 'IPL Ruko',
        ];

        $allPayments = collect(Payment::where('status', 'jatuh_tempo')
            ->orWhere(function ($q) use ($today, $threeDaysFromNow) {
                $q->where('jatuh_tempo', '>=', $today)
                    ->where('jatuh_tempo', '<=', $threeDaysFromNow);
            })
            ->orderBy('jatuh_tempo')
            ->get()
            ->map(function ($p) use ($jenisLabels) {
                $jenisName = $jenisLabels[$p->jenis] ?? ucfirst($p->jenis);
                return [
                    'id' => $p->id,
                    'label' => $jenisName . ' · ' . $p->periode,
                    'due_date' => $p->jatuh_tempo instanceof \Carbon\Carbon ? $p->jatuh_tempo->format('Y-m-d') : $p->jatuh_tempo,
                    'amount' => $p->nominal,
                    'status' => $p->status,
                    'jenis' => $jenisName,
                    'type' => 'payment',
                    'periode' => $p->periode,
                    'tanggal_tagihan' => $p->tanggal_tagihan instanceof \Carbon\Carbon ? $p->tanggal_tagihan->format('Y-m-d') : $p->tanggal_tagihan,
                    'jatuh_tempo' => $p->jatuh_tempo instanceof \Carbon\Carbon ? $p->jatuh_tempo->format('Y-m-d') : $p->jatuh_tempo,
                    'nominal' => (int) $p->nominal,
                ];
            }));

        $allWifi = collect(WifiPayment::where('status', 'jatuh_tempo')
            ->orWhere(function ($q) use ($today, $threeDaysFromNow) {
                $q->where('masa_tenggang', '>=', $today)
                    ->where('masa_tenggang', '<=', $threeDaysFromNow);
            })
            ->orderBy('masa_tenggang')
            ->get()
            ->map(fn ($w) => [
                'id' => $w->id,
                'label' => $w->nama_internet.' ('.$w->provider.')',
                'due_date' => $w->masa_tenggang instanceof \Carbon\Carbon ? $w->masa_tenggang->format('Y-m-d') : $w->masa_tenggang,
                'amount' => (int) $w->biaya,
                'status' => $w->status,
                'jenis' => 'Internet',
                'type' => 'wifi',
                'nama_internet' => $w->nama_internet,
                'provider' => $w->provider,
                'pic' => $w->pic,
                'jabatan' => $w->jabatan,
                'masa_tenggang' => $w->masa_tenggang instanceof \Carbon\Carbon ? $w->masa_tenggang->format('Y-m-d') : $w->masa_tenggang,
                'biaya' => (int) $w->biaya,
            ]));

        $allMerged = $allPayments->merge($allWifi)->sortBy('due_date');

        $todayStr = $today->format('Y-m-d');
        $threeDaysStr = $threeDaysFromNow->format('Y-m-d');

        $overduePayments = $allMerged->filter(fn ($p) => $p['due_date'] < $todayStr);
        $todayPayments = $allMerged->filter(fn ($p) => $p['due_date'] === $todayStr);
        $warningPayments = $allMerged->filter(fn ($p) => $p['due_date'] > $todayStr && $p['due_date'] <= $threeDaysStr);

        $approvalWaitingMeetings = Meeting::with(['requester', 'team', 'room'])
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        // Asset expiration data
        $expiringAssets = collect();
        $expiredAssets = collect();
        $digitalAssetsNeedMaintenance = collect();

        if (Schema::hasColumn('assets', 'expire_date')) {
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

        // Token listrik
        $latestTokenReading = ElectricityTokenReading::orderBy('checked_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();
        $tokenAlertDashboard = null;
        if ($latestTokenReading && $latestTokenReading->remaining_kwh < 50) {
            $tokenAlertDashboard = [
                'level' => 'danger',
                'message' => "Token listrik tinggal {$latestTokenReading->remaining_kwh} KWH — Segera bayar!",
            ];
        } elseif ($latestTokenReading && $latestTokenReading->remaining_kwh < 100) {
            $tokenAlertDashboard = [
                'level' => 'warning',
                'message' => "Token listrik tersisa {$latestTokenReading->remaining_kwh} KWH — Segera isi token.",
            ];
        } elseif (! $latestTokenReading) {
            $tokenAlertDashboard = [
                'level' => 'warning',
                'message' => 'Belum ada pengecekan token listrik. Lakukan pengecekan setiap hari Senin.',
            ];
        }

        return view('admin.dashboard', compact('stats', 'pendingMeetings', 'todayMeetings', 'overduePayments', 'todayPayments', 'warningPayments', 'allMerged', 'approvalWaitingMeetings', 'myInvitations', 'allAlertAssets', 'expiringAssets', 'expiredAssets', 'digitalAssetsNeedMaintenance', 'tokenAlertDashboard'));
    }
}
