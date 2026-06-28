<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['payments', 'pembayaran_aset_digital', 'pembayaran_ipl_ruko'];
        foreach ($tables as $tbl) {
            Schema::table($tbl, function (Blueprint $table) {
                $table->string('pic', 255)->nullable()->after('nominal');
                $table->string('jabatan', 255)->nullable()->after('pic');
            });
        }
    }

    public function down(): void
    {
        $tables = ['payments', 'pembayaran_aset_digital', 'pembayaran_ipl_ruko'];
        foreach ($tables as $tbl) {
            Schema::table($tbl, function (Blueprint $table) {
                $table->dropColumn(['pic', 'jabatan']);
            });
        }
    }
};
