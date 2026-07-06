<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$now = now();
echo "Today: " . $now->toDateString() . PHP_EOL . PHP_EOL;

// Calculate exactly like the controller does
$totalTagihan = 0;
$totalBayar = 0;

for ($i = 5; $i >= 0; $i--) {
    $month = $now->copy()->subMonths($i);
    $start = $month->copy()->startOfMonth();
    $end = $month->copy()->endOfMonth();

    $tagihan = App\Models\Payment::where('jenis', 'listrik')
        ->where('status', '!=', 'rejected')
        ->whereBetween('tanggal_tagihan', [$start, $end])
        ->sum('nominal')
        + App\Models\PembayaranAsetDigital::where('status', '!=', 'rejected')
            ->whereBetween('tanggal_tagihan', [$start, $end])
            ->sum('nominal')
        + App\Models\PembayaranIplRuko::where('status', '!=', 'rejected')
            ->whereBetween('tanggal_tagihan', [$start, $end])
            ->sum('nominal')
        + App\Models\WifiPayment::where('status', '!=', 'rejected')
            ->whereBetween('created_at', [$start, $end])
            ->sum('biaya');

    $bayar = App\Models\Payment::where('jenis', 'listrik')
        ->where('status', 'lunas')
        ->whereBetween('tanggal_tagihan', [$start, $end])
        ->sum('nominal')
        + App\Models\PembayaranAsetDigital::where('status', 'lunas')
            ->whereBetween('tanggal_tagihan', [$start, $end])
            ->sum('nominal')
        + App\Models\PembayaranIplRuko::where('status', 'lunas')
            ->whereBetween('tanggal_tagihan', [$start, $end])
            ->sum('nominal')
        + App\Models\WifiPayment::where('status', 'lunas')
            ->whereBetween('created_at', [$start, $end])
            ->sum('biaya');

    echo $month->isoFormat('MMM Y') . ":\n";
    echo "  Tagihan: Rp " . number_format($tagihan, 0, ',', '.') . "\n";
    echo "  Bayar:   Rp " . number_format($bayar, 0, ',', '.') . "\n";
    echo "  Sisa:    Rp " . number_format($tagihan - $bayar, 0, ',', '.') . "\n\n";

    $totalTagihan += $tagihan;
    $totalBayar += $bayar;
}

$sisa = $totalTagihan - $totalBayar;
echo "=== TOTAL 6 BULAN ===\n";
echo "Tagihan: Rp " . number_format($totalTagihan, 0, ',', '.') . "\n";
echo "Dibayar: Rp " . number_format($totalBayar, 0, ',', '.') . "\n";
echo "Sisa:    Rp " . number_format($sisa, 0, ',', '.') . "\n";
