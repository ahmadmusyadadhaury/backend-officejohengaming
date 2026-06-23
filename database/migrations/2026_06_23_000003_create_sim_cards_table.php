<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sim_cards', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sim_card');
            $table->string('pic');
            $table->string('jabatan');
            $table->date('masa_aktif');
            $table->date('masa_tenggang');
            $table->boolean('status_paket_kuota')->default(true);
            $table->boolean('status_kartu')->default(true);
            $table->text('keperluan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sim_cards');
    }
};
