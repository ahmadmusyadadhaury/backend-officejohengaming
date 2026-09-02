<?php

namespace App\Console\Commands;

use App\Models\DigitalAsset;
use App\Models\PembayaranAsetDigital;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('sync:digital-asset-payments')]
#[Description('Buat tagihan pembayaran untuk aset digital yang belum punya tagihan dan sudah mendekati jatuh tempo')]
class SyncDigitalAssetPayments extends Command
{
    public function handle()
    {
        $assets = DigitalAsset::doesntHave('pembayaran')->get();

        if ($assets->isEmpty()) {
            $this->info('Semua aset digital sudah punya tagihan.');

            return;
        }

        $created = 0;
        $skipped = 0;
        foreach ($assets as $asset) {
            $berakhir = $asset->berakhir;
            if ($asset->is_active && $berakhir && $berakhir->gt(now()->addDays(7))) {
                $skipped++;

                continue;
            }

            $jatuhTempo = $berakhir ?? now()->addDays(30);
            PembayaranAsetDigital::create([
                'digital_asset_id' => $asset->id,
                'periode' => $asset->nama_aset,
                'tanggal_tagihan' => now()->toDateString(),
                'jatuh_tempo' => $jatuhTempo->toDateString(),
                'nominal' => $asset->biaya,
                'status' => $jatuhTempo->lte(now()->addDays(7)) ? 'jatuh_tempo' : 'pending',
                'tanggal_bayar' => null,
            ]);
            $created++;
            $this->line("  [OK] {$asset->nama_aset}");
        }

        $this->info("Berhasil membuat {$created} tagihan.");
        if ($skipped > 0) {
            $this->line("  Dilewati {$skipped} aset yang belum mendekati jatuh tempo.");
        }
    }
}
