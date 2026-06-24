<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('token_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount_kwh', 10, 2);
            $table->date('payment_date');
            $table->string('period', 7);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('token_payments');
    }
};
