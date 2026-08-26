<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internet_quota_topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wifi_payment_id')->constrained('wifi_payments')->cascadeOnDelete();
            $table->decimal('amount_gb', 10, 2);
            $table->decimal('nominal', 15, 2)->nullable();
            $table->date('payment_date');
            $table->string('period', 7);
            $table->text('notes')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internet_quota_topups');
    }
};
