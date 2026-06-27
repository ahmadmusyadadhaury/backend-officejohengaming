<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('wifi_payments')) {
            Schema::create('wifi_payments', function (Blueprint $table) {
                $table->id();
                $table->string('nama_internet');
                $table->string('provider');
                $table->string('pic');
                $table->string('jabatan');
                $table->date('masa_tenggang');
                $table->decimal('biaya', 15, 2);
                $table->enum('status', ['lunas', 'jatuh_tempo'])->default('jatuh_tempo');
                $table->date('tanggal_bayar')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('wifi_payments');
    }
};
