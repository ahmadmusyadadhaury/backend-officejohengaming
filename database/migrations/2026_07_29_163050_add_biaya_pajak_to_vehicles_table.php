<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->decimal('biaya_pajak_tahunan', 15, 2)->nullable()->after('biaya_kendaraan');
            $table->decimal('biaya_pajak_5_tahun', 15, 2)->nullable()->after('biaya_pajak_tahunan');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('biaya_pajak_tahunan');
            $table->dropColumn('biaya_pajak_5_tahun');
        });
    }
};
