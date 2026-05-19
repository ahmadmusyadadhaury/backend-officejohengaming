<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$count = DB::table('push_subscriptions')->count();
echo "Push subscriptions: $count\n";
if ($count > 0) {
    $subs = DB::table('push_subscriptions')->get();
    foreach ($subs as $s) {
        echo "  User {$s->user_id}: endpoint\n";
    }
}
