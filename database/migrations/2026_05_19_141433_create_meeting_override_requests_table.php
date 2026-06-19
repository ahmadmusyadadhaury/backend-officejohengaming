<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_override_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('target_meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->text('reason');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_override_requests');
    }
};
