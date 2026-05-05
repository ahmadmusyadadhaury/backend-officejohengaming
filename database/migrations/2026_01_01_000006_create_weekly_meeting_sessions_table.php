<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Instance meeting mingguan yang terjadi (per minggu)
        Schema::create('weekly_meeting_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_meeting_id')->constrained('weekly_meetings')->cascadeOnDelete();
            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('actual_end_time')->nullable();
            $table->enum('status', ['active', 'extended', 'completed'])->default('active');
            $table->timestamps();

            $table->unique(['weekly_meeting_id', 'session_date']);
        });

        // Kontribusi per user per sesi
        Schema::create('weekly_meeting_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('weekly_meeting_sessions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('what_to_discuss');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

        // Undangan per user per sesi
        Schema::create('weekly_meeting_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('weekly_meeting_sessions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->unique(['session_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_meeting_invitations');
        Schema::dropIfExists('weekly_meeting_contributions');
        Schema::dropIfExists('weekly_meeting_sessions');
    }
};
