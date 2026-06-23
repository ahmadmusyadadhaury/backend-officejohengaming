<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peralatan_kantor', function (Blueprint $table) {
            $table->id();
            // Step 1
            $table->string('nama_barang');
            $table->unsignedInteger('jumlah')->default(1);
            $table->text('detail')->nullable();
            $table->string('sub_kategori')->default('Peralatan Kantor');
            $table->text('keterangan')->nullable();
            // Step 2
            $table->string('lokasi_unit');
            $table->string('ruangan');
            $table->string('milik')->default('Milik Perusahaan');
            // Step 3
            $table->year('pengadaan_tahun');
            $table->date('tanggal_pembelian');
            $table->string('kategori_nilai')->default('Rendah');
            $table->string('kategori_ukuran')->default('Kecil');
            $table->decimal('nilai', 15, 2)->default(0);
            // Step 4
            $table->integer('waktu_pakai_per_hari')->default(2);
            $table->integer('estimasi_waktu_barang')->default(2);
            $table->decimal('pengurangan_harga_per_hari', 15, 2)->default(0);
            $table->decimal('harga_per_hari_ini', 15, 2)->default(0);
            // Step 5
            $table->string('pic');
            $table->string('jabatan');
            $table->string('atasan');
            $table->string('jabatan_atasan');
            // Status
            $table->string('kondisi')->default('baik'); // baik, perlu_servis, rusak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peralatan_kantor');
    }
};
