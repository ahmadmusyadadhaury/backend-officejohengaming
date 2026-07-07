<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_daya', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aset');
            $table->string('daya')->nullable();
            $table->string('unit')->nullable();
            $table->foreignId('penanggung_jawab')->nullable()->constrained('users')->nullOnDelete();
            $table->string('pic')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_daya');
    }
};
