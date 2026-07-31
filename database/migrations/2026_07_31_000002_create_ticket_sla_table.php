<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_sla', function (Blueprint $table) {
            $table->id();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->unique();
            $table->unsignedInteger('duration_minutes');
            $table->string('label')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_sla');
    }
};
