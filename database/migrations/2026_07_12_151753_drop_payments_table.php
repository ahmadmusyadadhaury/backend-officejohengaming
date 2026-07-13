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
        Schema::dropIfExists('payments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->default('listrik');
            $table->string('periode');
            $table->date('tanggal_tagihan');
            $table->date('jatuh_tempo');
            $table->decimal('nominal', 15, 2);
            $table->string('pic')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('status')->default('pending');
            $table->date('tanggal_bayar')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->text('notes')->nullable();
            $table->string('period')->default('bulanan');
            $table->timestamps();
        });
    }
};
