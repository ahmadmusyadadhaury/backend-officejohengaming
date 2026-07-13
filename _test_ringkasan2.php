<?php

use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\WifiPayment;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== All PembayaranAsetDigital ===\n";
$ads = PembayaranAsetDigital::orderBy('tanggal_tagihan')->get();
foreach ($ads as $a) {
    echo "  #{$a->id} status={$a->status} tanggal={$a->tanggal_tagihan} nominal={$a->nominal}\n";
}

echo "\n=== All PembayaranIplRuko ===\n";
$ipls = PembayaranIplRuko::orderBy('tanggal_tagihan')->get();
foreach ($ipls as $i) {
    echo "  #{$i->id} status={$i->status} tanggal={$i->tanggal_tagihan} nominal={$i->nominal}\n";
}

echo "\n=== All WifiPayment ===\n";
$wifis = WifiPayment::orderBy('created_at')->get();
foreach ($wifis as $w) {
    echo "  #{$w->id} status={$w->status} created_at={$w->created_at} biaya={$w->biaya}\n";
}
