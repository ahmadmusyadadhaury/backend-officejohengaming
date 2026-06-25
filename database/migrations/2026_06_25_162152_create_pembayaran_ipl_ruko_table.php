<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_ipl_ruko', function (Blueprint $table) {
            $table->id();
            $table->string('periode');
            $table->date('tanggal_tagihan');
            $table->date('jatuh_tempo');
            $table->decimal('nominal', 15, 2);
            $table->enum('status', ['lunas', 'jatuh_tempo'])->default('jatuh_tempo');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_ipl_ruko');
    }
};
