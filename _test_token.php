<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$jobs = Illuminate\Support\Facades\DB::table('jobs')->count();
echo "Queue jobs: {$jobs}\n";

$readings = Illuminate\Support\Facades\DB::table('electricity_token_readings')
    ->orderBy('checked_date', 'desc')
    ->limit(5)
    ->get();

foreach ($readings as $r) {
    echo "{$r->id}: {$r->remaining_kwh} KWH ({$r->checked_date} - {$r->status})\n";
}
