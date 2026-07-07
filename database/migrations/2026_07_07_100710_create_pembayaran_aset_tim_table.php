<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_aset_tim', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_tim_id')->nullable()->constrained('aset_tim')->nullOnDelete();
            $table->string('periode');
            $table->date('tanggal_tagihan');
            $table->date('jatuh_tempo');
            $table->decimal('nominal', 12, 2);
            $table->string('pic')->nullable();
            $table->string('jabatan')->nullable();
            $table->enum('status', ['pending', 'jatuh_tempo', 'lunas', 'rejected'])->default('pending');
            $table->date('tanggal_bayar')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->text('notes')->nullable();
            $table->string('period')->default('bulanan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_aset_tim');
    }
};
