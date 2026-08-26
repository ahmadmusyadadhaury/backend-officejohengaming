<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internet_quota_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wifi_payment_id')->constrained('wifi_payments')->cascadeOnDelete();
            $table->decimal('remaining_gb', 10, 2);
            $table->string('status', 20)->nullable();
            $table->date('checked_date');
            $table->foreignId('checked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->string('bukti_foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internet_quota_readings');
    }
};
