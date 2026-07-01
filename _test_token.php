<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->handle(Request::capture());

$jobs = DB::table('jobs')->count();
echo "Queue jobs: {$jobs}\n";

$readings = DB::table('electricity_token_readings')
    ->orderBy('checked_date', 'desc')
    ->limit(5)
    ->get();

foreach ($readings as $r) {
    echo "{$r->id}: {$r->remaining_kwh} KWH ({$r->checked_date} - {$r->status})\n";
}
