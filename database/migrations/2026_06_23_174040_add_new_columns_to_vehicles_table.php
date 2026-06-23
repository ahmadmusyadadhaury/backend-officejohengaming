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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('merk_tipe')->nullable()->after('jenis_kendaraan');
            $table->string('warna')->nullable()->after('tahun');
            $table->string('nomor_rangka')->nullable()->after('warna');
            $table->string('nomor_mesin')->nullable()->after('nomor_rangka');
            $table->string('foto')->nullable()->after('nomor_mesin');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['merk_tipe', 'warna', 'nomor_rangka', 'nomor_mesin', 'foto']);
        });
    }
};
