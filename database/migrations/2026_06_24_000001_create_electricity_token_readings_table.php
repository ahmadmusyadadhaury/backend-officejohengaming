<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('electricity_token_readings', function (Blueprint $table) {
            $table->id();
            $table->decimal('remaining_kwh', 10, 2);
            $table->date('checked_date');
            $table->foreignId('checked_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electricity_token_readings');
    }
};
