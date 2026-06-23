<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_ruko', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aset');
            $table->string('lokasi');
            $table->unsignedInteger('jumlah')->default(1);
            $table->string('kondisi')->default('baik'); // baik, perlu_servis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_ruko');
    }
};
