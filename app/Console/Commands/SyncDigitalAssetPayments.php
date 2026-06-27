<?php

namespace App\Console\Commands;

use App\Models\DigitalAsset;
use App\Models\PembayaranAsetDigital;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('sync:digital-asset-payments')]
#[Description('Buat tagihan pembayaran untuk aset digital yang belum punya tagihan')]
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
        foreach ($assets as $asset) {
            PembayaranAsetDigital::create([
                'digital_asset_id' => $asset->id,
                'periode' => $asset->nama_aset,
                'tanggal_tagihan' => now()->toDateString(),
                'jatuh_tempo' => now()->addDays(30)->toDateString(),
                'nominal' => $asset->biaya,
                'status' => 'jatuh_tempo',
                'tanggal_bayar' => null,
            ]);
            $created++;
            $this->line("  [OK] {$asset->nama_aset}");
        }

        $this->info("Berhasil membuat {$created} tagihan.");
    }
}
