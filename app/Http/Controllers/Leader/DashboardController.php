<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetDaya;
use App\Models\AsetTim;
use App\Models\DigitalAsset;
use App\Models\Meeting;
use App\Models\PembayaranAsetDaya;
use App\Models\PembayaranAsetTim;
use App\Models\PeralatanKantor;
use App\Models\SimCard;
use App\Models\Vehicle;
use App\Models\WifiPayment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalMeeting = Meeting::where('requested_by', $user->id)->count();
        $disetujui = Meeting::where('requested_by', $user->id)->whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])->count();
        $menunggu = Meeting::where('requested_by', $user->id)->where('status', 'pending')->count();
        $ditolak = Meeting::where('requested_by', $user->id)->where('status', 'rejected')->count();

        // Meeting hari ini
        $todayMeetings = Meeting::with(['room', 'team'])
            ->where('requested_by', $user->id)
            ->whereDate('meeting_date', today())
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->orderBy('start_time')
            ->get();

        // Pembayaran mendatang — hanya tagihan yang penanggung_jawab-nya user
        $sevenDays = Carbon::today()->addDays(7);
        $today = Carbon::today();
        $userId = $user->id;

        $myAsetDayaIds = AsetDaya::where('penanggung_jawab', $userId)->pluck('id');
        $myAsetTimIds = AsetTim::where('penanggung_jawab', $userId)->pluck('id');

        $allPayments = collect();

        if ($myAsetDayaIds->isNotEmpty()) {
            $allPayments = $allPayments->merge(
                PembayaranAsetDaya::whereNull('requested_by')
                    ->whereNotIn('status', ['lunas', 'rejected'])
                    ->whereIn('aset_daya_id', $myAsetDayaIds)
                    ->where('jatuh_tempo', '<=', $sevenDays)
                    ->orderBy('jatuh_tempo')
                    ->get()
                    ->map(fn ($p) => $this->mapPayment($p, 'aset_daya', 'Aset Daya'))
            );
        }

        if ($myAsetTimIds->isNotEmpty()) {
            $allPayments = $allPayments->merge(
                PembayaranAsetTim::whereNull('requested_by')
                    ->whereNotIn('status', ['lunas', 'rejected'])
                    ->whereIn('aset_tim_id', $myAsetTimIds)
                    ->where('jatuh_tempo', '<=', $sevenDays)
                    ->orderBy('jatuh_tempo')
                    ->get()
                    ->map(fn ($p) => $this->mapPayment($p, 'aset_tim', 'Aset TIM'))
            );
        }

        $allMerged = $allPayments->sortBy('due_date');
        $todayStr = $today->format('Y-m-d');

        $overduePayments = $allMerged->filter(fn ($p) => $p['due_date'] < $todayStr);
        $todayPayments = $allMerged->filter(fn ($p) => $p['due_date'] === $todayStr);
        $warningPayments = $allMerged->filter(fn ($p) => $p['due_date'] > $todayStr && $p['due_date'] <= $sevenDays->format('Y-m-d'));

        $jabatanList = Vehicle::distinct()->pluck('jabatan')
            ->merge(DigitalAsset::distinct()->pluck('jabatan'))
            ->merge(SimCard::distinct()->pluck('jabatan'))
            ->merge(PeralatanKantor::distinct()->pluck('jabatan'))
            ->merge(WifiPayment::distinct()->pluck('jabatan'))
            ->unique()
            ->filter()
            ->sort()
            ->values();

        return view('leader.dashboard', compact(
            'totalMeeting', 'disetujui', 'menunggu', 'ditolak',
            'todayMeetings', 'overduePayments', 'todayPayments', 'warningPayments',
            'allMerged', 'jabatanList'
        ));
    }

    private function mapPayment($p, $jenisKey, $jenisName)
    {
        return [
            'id' => $p->id,
            'label' => $jenisName.' · '.$p->periode,
            'due_date' => $p->jatuh_tempo instanceof Carbon ? $p->jatuh_tempo->format('Y-m-d') : $p->jatuh_tempo,
            'amount' => (int) ($p->biaya ?? $p->nominal),
            'status' => $p->status,
            'jenis' => $jenisName,
            'type' => $jenisKey,
        ];
    }
}
