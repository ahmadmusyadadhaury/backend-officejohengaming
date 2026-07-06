<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetRuko;
use App\Models\Asset;
use App\Models\DigitalAsset;
use App\Models\ElectricityTokenReading;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\Payment;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\PeralatanKantor;
use App\Models\Room;
use App\Models\SimCard;
use App\Models\Team;
use App\Models\TokenPayment;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\WeeklyMeetingSession;
use App\Models\WifiPayment;
use App\Services\WeeklyMeetingService;
use Carbon\Carbon;
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
            'total_koordinator' => User::where('role', 'koordinator')->count(),
            'total_karyawan' => User::where('role', 'user')->where('is_active', true)->count(),
            'total_team' => Team::count(),
            'total_teams' => Team::count(),
            'total_rooms' => Room::count(),
            // Asset stats — dari semua tabel data aset
            'total_assets' => Vehicle::count() + DigitalAsset::count() + SimCard::count() + PeralatanKantor::count() + AsetRuko::count(),
            'digital_assets' => Asset::where('is_active', true)->count(),
            'assets_near_expire' => Schema::hasColumn('assets', 'expire_date')
                ? Asset::whereNotNull('expire_date')->where('expire_date', '>=', today())->where('expire_date', '<=', today()->addDays(30))->count()
                : 0,
            // Meeting stats
            'total_meetings' => Meeting::count(),
            'meetings_this_week' => Meeting::whereBetween('meeting_date', [now()->startOfWeek(), now()->endOfWeek()])->count()
                + WeeklyMeetingSession::whereBetween('session_date', [now()->startOfWeek(), now()->endOfWeek()])->whereIn('status', ['active', 'extended', 'completed'])->count(),
            'pending' => Meeting::where('status', 'pending')->count(),
            'today_meetings' => Meeting::whereDate('meeting_date', today())->whereIn('status', ['approved', 'confirmed', 'in_progress'])->count()
                + WeeklyMeetingSession::whereDate('session_date', today())->whereIn('status', ['active', 'extended'])->count(),
            'this_month' => Meeting::whereMonth('meeting_date', now()->month)->whereYear('meeting_date', now()->year)->count(),
            // Payment stats — dari semua tabel pembayaran
            'total_payments' => Payment::where('jenis', 'listrik')->count() + PembayaranAsetDigital::count() + PembayaranIplRuko::count() + WifiPayment::count() + TokenPayment::count(),
            'pending_payments' => Payment::where('jenis', 'listrik')->whereNull('requested_by')->whereNotIn('status', ['lunas', 'rejected'])->where('jatuh_tempo', '<=', today()->addDays(7))->count() + PembayaranAsetDigital::whereNull('requested_by')->whereNotIn('status', ['lunas', 'rejected'])->where('jatuh_tempo', '<=', today()->addDays(7))->count() + PembayaranIplRuko::whereNull('requested_by')->whereNotIn('status', ['lunas', 'rejected'])->where('jatuh_tempo', '<=', today()->addDays(7))->count() + WifiPayment::whereNull('requested_by')->whereNotIn('status', ['lunas', 'rejected'])->where('masa_tenggang', '<=', today()->addDays(7))->count(),
            'approval_pending_payments' => Payment::where('jenis', 'listrik')->where('status', 'pending')->count() + PembayaranAsetDigital::where('status', 'pending')->count() + PembayaranIplRuko::where('status', 'pending')->count() + WifiPayment::where('status', 'pending')->count(),
        ];

        app(WeeklyMeetingService::class)->generateTodaySessions();

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

        $todayMeetings = $todayMeetings->merge($weeklySessions)->sortBy('start_time');

        $today = today();
        $sevenDaysFromNow = today()->addDays(7);

        $jenisLabels = [
            'listrik' => 'Listrik',
            'aset_digital' => 'Aset Digital',
            'ipl_ruko' => 'IPL Ruko',
        ];

        $mapPayment = function ($p, $jenisKey, $jenisName) {
            return [
                'id' => $p->id,
                'label' => $jenisName.' · '.$p->periode,
                'due_date' => $p->jatuh_tempo instanceof Carbon ? $p->jatuh_tempo->format('Y-m-d') : $p->jatuh_tempo,
                'amount' => $p->nominal,
                'status' => $p->status,
                'jenis' => $jenisName,
                'type' => $jenisKey,
                'periode' => $p->periode,
                'tanggal_tagihan' => $p->tanggal_tagihan instanceof Carbon ? $p->tanggal_tagihan->format('Y-m-d') : $p->tanggal_tagihan,
                'jatuh_tempo' => $p->jatuh_tempo instanceof Carbon ? $p->jatuh_tempo->format('Y-m-d') : $p->jatuh_tempo,
                'nominal' => (int) $p->nominal,
            ];
        };

        $allPayments = collect()
            ->merge(
                Payment::where('jenis', 'listrik')
                    ->whereNull('requested_by')
                    ->whereNotIn('status', ['lunas', 'rejected'])
                    ->where('jatuh_tempo', '<=', $sevenDaysFromNow)
                    ->orderBy('jatuh_tempo')
                    ->get()
                    ->map(fn ($p) => $mapPayment($p, 'listrik', $jenisLabels['listrik'] ?? 'Listrik'))
            )
            ->merge(
                PembayaranAsetDigital::whereNull('requested_by')
                    ->whereNotIn('status', ['lunas', 'rejected'])
                    ->where('jatuh_tempo', '<=', $sevenDaysFromNow)
                    ->orderBy('jatuh_tempo')
                    ->get()
                    ->map(fn ($p) => $mapPayment($p, 'aset_digital', $jenisLabels['aset_digital'] ?? 'Aset Digital'))
            )
            ->merge(
                PembayaranIplRuko::whereNull('requested_by')
                    ->whereNotIn('status', ['lunas', 'rejected'])
                    ->where('jatuh_tempo', '<=', $sevenDaysFromNow)
                    ->orderBy('jatuh_tempo')
                    ->get()
                    ->map(fn ($p) => $mapPayment($p, 'ipl_ruko', $jenisLabels['ipl_ruko'] ?? 'IPL Ruko'))
            );

        $allWifi = collect(WifiPayment::whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected'])
            ->where('masa_tenggang', '<=', $sevenDaysFromNow)
            ->orderBy('masa_tenggang')
            ->get()
            ->map(fn ($w) => [
                'id' => $w->id,
                'label' => $w->nama_internet.' ('.$w->provider.')',
                'due_date' => $w->masa_tenggang instanceof Carbon ? $w->masa_tenggang->format('Y-m-d') : $w->masa_tenggang,
                'amount' => (int) $w->biaya,
                'status' => $w->status,
                'jenis' => 'Internet',
                'type' => 'wifi',
                'nama_internet' => $w->nama_internet,
                'provider' => $w->provider,
                'pic' => $w->pic,
                'jabatan' => $w->jabatan,
                'masa_tenggang' => $w->masa_tenggang instanceof Carbon ? $w->masa_tenggang->format('Y-m-d') : $w->masa_tenggang,
                'biaya' => (int) $w->biaya,
            ]));

        $allMerged = $allPayments->merge($allWifi)->sortBy('due_date');
        $paymentDataJson = $allMerged->values()->toJson();

        $todayStr = $today->format('Y-m-d');
        $sevenDaysStr = $sevenDaysFromNow->format('Y-m-d');

        $overduePayments = $allMerged->filter(fn ($p) => $p['due_date'] < $todayStr);
        $todayPayments = $allMerged->filter(fn ($p) => $p['due_date'] === $todayStr);
        $warningPayments = $allMerged->filter(fn ($p) => $p['due_date'] > $todayStr && $p['due_date'] <= $sevenDaysStr);

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
        if ($latestTokenReading && $latestTokenReading->remaining_kwh < 500) {
            $tokenAlertDashboard = [
                'level' => 'danger',
                'message' => "Sisa token listrik tinggal {$latestTokenReading->remaining_kwh} KWH — Segera Isi Token!",
                'kwh' => (float) $latestTokenReading->remaining_kwh,
            ];
        } elseif ($latestTokenReading && $latestTokenReading->remaining_kwh < 1000) {
            $tokenAlertDashboard = [
                'level' => 'warning',
                'message' => "Sisa token listrik {$latestTokenReading->remaining_kwh} KWH — Warning, segera persiapkan isi token.",
                'kwh' => (float) $latestTokenReading->remaining_kwh,
            ];
        } elseif ($latestTokenReading && $latestTokenReading->remaining_kwh < 2000) {
            $tokenAlertDashboard = [
                'level' => 'info',
                'message' => "Sisa token listrik {$latestTokenReading->remaining_kwh} KWH — Perhatian, lakukan pengecekan rutin.",
                'kwh' => (float) $latestTokenReading->remaining_kwh,
            ];
        } elseif (! $latestTokenReading) {
            $tokenAlertDashboard = [
                'level' => 'warning',
                'message' => 'Belum ada pengecekan token listrik. Lakukan pengecekan setiap minggu.',
                'kwh' => 0,
            ];
        }

        // Monthly chart data (last 6 months)
        $monthlyLabels = [];
        $monthlyTagihan = [];
        $monthlyBayar = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->isoFormat('MMM Y');
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $tagihan = Payment::where('jenis', 'listrik')->where('status', '!=', 'rejected')->whereBetween('tanggal_tagihan', [$start, $end])->sum('nominal')
                + PembayaranAsetDigital::where('status', '!=', 'rejected')->whereBetween('tanggal_tagihan', [$start, $end])->sum('nominal')
                + PembayaranIplRuko::where('status', '!=', 'rejected')->whereBetween('tanggal_tagihan', [$start, $end])->sum('nominal')
                + WifiPayment::where('status', '!=', 'rejected')->whereBetween('created_at', [$start, $end])->sum('biaya');

            $bayar = Payment::where('jenis', 'listrik')->where('status', 'lunas')->whereBetween('tanggal_tagihan', [$start, $end])->sum('nominal')
                + PembayaranAsetDigital::where('status', 'lunas')->whereBetween('tanggal_tagihan', [$start, $end])->sum('nominal')
                + PembayaranIplRuko::where('status', 'lunas')->whereBetween('tanggal_tagihan', [$start, $end])->sum('nominal')
                + WifiPayment::where('status', 'lunas')->whereBetween('created_at', [$start, $end])->sum('biaya');

            $monthlyTagihan[] = (int) $tagihan;
            $monthlyBayar[] = (int) $bayar;
        }
        $chartLabels = $monthlyLabels;
        $chartTagihan = $monthlyTagihan;
        $chartBayar = $monthlyBayar;

        $jabatanList = Vehicle::distinct()->pluck('jabatan')
            ->merge(DigitalAsset::distinct()->pluck('jabatan'))
            ->merge(SimCard::distinct()->pluck('jabatan'))
            ->merge(PeralatanKantor::distinct()->pluck('jabatan'))
            ->merge(WifiPayment::distinct()->pluck('jabatan'))
            ->unique()
            ->filter()
            ->sort()
            ->values();

        return view('admin.dashboard', compact('stats', 'pendingMeetings', 'todayMeetings', 'overduePayments', 'todayPayments', 'warningPayments', 'allMerged', 'paymentDataJson', 'approvalWaitingMeetings', 'myInvitations', 'allAlertAssets', 'expiringAssets', 'expiredAssets', 'digitalAssetsNeedMaintenance', 'tokenAlertDashboard', 'latestTokenReading', 'chartLabels', 'chartTagihan', 'chartBayar', 'jabatanList'));
    }
}
