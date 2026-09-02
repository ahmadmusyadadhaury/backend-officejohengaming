<?php

namespace App\Services;

use App\Models\AsetMes;
use App\Models\AsetTim;
use App\Models\Notification;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranAsetMes;
use App\Models\PembayaranAsetTim;
use App\Models\PembayaranIplRuko;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehiclePajakRequest;
use App\Models\WifiPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class TagihanService
{
    public const JENIS_MODELS = [
        'internet' => WifiPayment::class,
        'aset_digital' => PembayaranAsetDigital::class,
        'pajak_kendaraan' => VehiclePajakRequest::class,
        'ipl_ruko' => PembayaranIplRuko::class,
        'aset_tim' => PembayaranAsetTim::class,
        'aset_mes' => PembayaranAsetMes::class,
    ];

    private const TABLE_TO_CLASS = [
        'wifi_payments' => WifiPayment::class,
        'pembayaran_aset_digital' => PembayaranAsetDigital::class,
        'pembayaran_ipl_ruko' => PembayaranIplRuko::class,
        'pembayaran_aset_tim' => PembayaranAsetTim::class,
        'pembayaran_aset_mes' => PembayaranAsetMes::class,
        'vehicle_pajak_requests' => VehiclePajakRequest::class,
    ];

    public static function syncVehiclePajakRequests(): void
    {
        $expiringVehicles = Vehicle::where(function ($q) {
            $q->whereDate('pajak_tahunan', '<=', now()->addDays(7))
                ->orWhereDate('pajak_5_tahun', '<=', now()->addDays(7));
        })->get();

        foreach ($expiringVehicles as $vehicle) {
            $jenisPajakList = [];
            if ($vehicle->pajak_tahunan && $vehicle->pajak_tahunan->lte(now()->addDays(7))) {
                $jenisPajakList[] = 'tahunan';
            }
            if ($vehicle->pajak_5_tahun && $vehicle->pajak_5_tahun->lte(now()->addDays(7))) {
                $jenisPajakList[] = '5_tahunan';
            }
            foreach ($jenisPajakList as $jenisPajak) {
                $hasPending = VehiclePajakRequest::where('vehicle_id', $vehicle->id)
                    ->where('jenis', $jenisPajak)
                    ->whereNotIn('status', ['approved', 'rejected'])
                    ->exists();
                if (! $hasPending) {
                    $nominal = $jenisPajak === 'tahunan'
                        ? ($vehicle->biaya_pajak_tahunan ?? $vehicle->biaya_kendaraan)
                        : ($vehicle->biaya_pajak_5_tahun ?? $vehicle->biaya_kendaraan);
                    VehiclePajakRequest::create([
                        'vehicle_id' => $vehicle->id,
                        'jenis' => $jenisPajak,
                        'nominal' => $nominal,
                        'status' => 'pending',
                        'requested_by' => null,
                        'bukti_bayar' => null,
                    ]);
                }
            }
        }
    }

    public static function itemsQuery(string $jenis): Builder
    {
        $class = self::JENIS_MODELS[$jenis];
        $dateField = $jenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';

        $query = $class::whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected']);

        if ($jenis === 'aset_digital') {
            $query->where($dateField, '<=', Carbon::today()->addDays(7));
            if (! in_array(auth()->user()->role, User::FULL_ACCESS_ROLES)) {
                $userName = auth()->user()->name;
                $query->where(function ($q) use ($userName) {
                    $q->where('pic', $userName)
                        ->orWhereHas('digitalAsset', fn ($q2) => $q2->where('pic', $userName));
                });
            }
        } elseif ($jenis === 'pajak_kendaraan') {
            if (! in_array(auth()->user()->role, User::FULL_ACCESS_ROLES)) {
                $userName = auth()->user()->name;
                $query->whereHas('vehicle', fn ($q) => $q->where('pic', $userName));
            }
        } else {
            $query->where($dateField, '<=', Carbon::today()->addDays(7));
        }

        if ($jenis === 'aset_tim') {
            $query->whereIn('aset_tim_id', AsetTim::where('penanggung_jawab', auth()->id())->pluck('id'));
        } elseif ($jenis === 'aset_mes') {
            $query->whereIn('aset_mes_id', AsetMes::where('penanggung_jawab', auth()->id())->pluck('id'));
        }

        return $query;
    }

    public static function tagihanCount(): int
    {
        $total = 0;
        foreach (array_keys(self::JENIS_MODELS) as $jenis) {
            $total += self::itemsQuery($jenis)->count();
        }

        return $total;
    }

    public static function approvalCount(): int
    {
        $total = 0;
        foreach (self::JENIS_MODELS as $class) {
            $total += $class::where('status', 'pending')->count();
        }

        return $total;
    }

    public static function cleanupStaleNotifications(int $userId): void
    {
        $staleIds = [];

        Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->whereIn('type', ['tagihan', 'approval'])
            ->get(['id', 'type', 'dedup_key'])
            ->each(function (Notification $n) use (&$staleIds) {
                if (! $n->dedup_key || ! preg_match('/^(tagihan|approval)_([a-z_]+)_(\d+)$/', $n->dedup_key, $m)) {
                    $staleIds[] = $n->id;

                    return;
                }

                $class = self::TABLE_TO_CLASS[$m[2]] ?? null;
                if (! $class) {
                    return;
                }

                $record = $class::find($m[3]);
                $stillRelevant = $record && ($n->type === 'approval'
                    ? $record->status === 'pending'
                    : is_null($record->requested_by) && ! in_array($record->status, ['lunas', 'rejected']));

                if (! $stillRelevant) {
                    $staleIds[] = $n->id;
                }
            });

        if ($staleIds) {
            Notification::whereIn('id', $staleIds)->update(['is_read' => true, 'read_at' => now()]);
        }
    }
}
