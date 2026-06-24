<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('wifi_payments');
        Schema::dropIfExists('payments');

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->default('listrik'); // listrik, aset_digital, ipl_ruko
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
        Schema::dropIfExists('payments');
    }
};
