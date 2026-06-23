<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kendaraan');
            $table->string('jenis_kendaraan');
            $table->string('plat_nomor')->unique();
            $table->year('tahun');
            $table->date('pajak_tahunan');
            $table->date('pajak_5_tahun');
            $table->string('kepemilikan_status')->default('Milik Perusahaan');
            $table->decimal('biaya_kendaraan', 15, 2)->default(0);
            $table->string('pic');
            $table->string('jabatan');
            $table->text('keperluan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
