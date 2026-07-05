<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['payments', 'wifi_payments', 'pembayaran_aset_digital', 'pembayaran_ipl_ruko'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->string('period', 20)->default('bulanan')->after('notes');
            });
        }
    }

    public function down(): void
    {
        foreach (['payments', 'wifi_payments', 'pembayaran_aset_digital', 'pembayaran_ipl_ruko'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('period');
            });
        }
    }
};
