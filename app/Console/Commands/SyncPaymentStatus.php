<?php

namespace App\Console\Commands;

use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\WifiPayment;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('payments:sync-status')]
#[Description('Sinkronisasi status pembayaran berdasarkan tanggal jatuh tempo (H-7)')]
class SyncPaymentStatus extends Command
{
    public function handle()
    {
        $today = Carbon::today();
        $threshold = $today->copy()->addDays(7);
        $updated = 0;

        $this->line('Memperbarui status pembayaran...');
        $this->line("Hari ini: {$today->format('Y-m-d')}, threshold H-7: {$threshold->format('Y-m-d')}");
        $this->line('');

        // Internet
        foreach (WifiPayment::whereNotIn('status', ['lunas', 'rejected'])->cursor() as $item) {
            $newStatus = Carbon::parse($item->masa_tenggang)->lte($threshold) ? 'jatuh_tempo' : 'pending';
            if ($item->status !== $newStatus) {
                $item->update(['status' => $newStatus]);
                $this->line("  [Internet] #{$item->id} {$item->nama_internet}: {$item->status} → {$newStatus}");
                $updated++;
            }
        }

        // Aset Digital
        foreach (PembayaranAsetDigital::whereNotIn('status', ['lunas', 'rejected'])->cursor() as $item) {
            $newStatus = Carbon::parse($item->jatuh_tempo)->lte($threshold) ? 'jatuh_tempo' : 'pending';
            if ($item->status !== $newStatus) {
                $item->update(['status' => $newStatus]);
                $this->line("  [Aset Digital] #{$item->id} {$item->periode}: {$item->status} → {$newStatus}");
                $updated++;
            }
        }

        // IPL Ruko
        foreach (PembayaranIplRuko::whereNotIn('status', ['lunas', 'rejected'])->cursor() as $item) {
            $newStatus = Carbon::parse($item->jatuh_tempo)->lte($threshold) ? 'jatuh_tempo' : 'pending';
            if ($item->status !== $newStatus) {
                $item->update(['status' => $newStatus]);
                $this->line("  [IPL Ruko] #{$item->id} {$item->periode}: {$item->status} → {$newStatus}");
                $updated++;
            }
        }

        $this->line('');
        $this->info("Selesai. {$updated} record diperbarui.");
    }
}
