<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('second_team_id')->nullable()->constrained('teams')->nullOnDelete();
            // 5W1H
            $table->text('why');
            $table->text('what');
            $table->date('meeting_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('actual_end_time')->nullable();
            $table->string('where_detail')->nullable();
            $table->text('who_summary')->nullable();
            $table->text('how_expected');
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'confirmed', 'cancelled', 'in_progress', 'completed'])->default('pending');
            $table->text('reject_reason')->nullable();
            // Weekly meeting
            $table->boolean('is_weekly')->default(false);
            $table->tinyInteger('weekly_day')->nullable()->comment('0=Sunday, 1=Monday, ..., 6=Saturday');
            $table->time('weekly_time')->nullable();
            // Approval
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('meeting_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['invited', 'confirmed', 'attended', 'absent'])->default('invited');
            $table->timestamps();

            $table->unique(['meeting_id', 'user_id']);
        });

        Schema::create('meeting_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();
        });

        Schema::create('meeting_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->enum('type', ['h1_day', 'h1_hour']);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('moms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->unique()->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->text('summary');
            $table->text('decisions');
            $table->text('action_plan');
            $table->string('pic')->comment('Penanggung jawab');
            $table->string('file_path')->nullable();
            $table->enum('status', ['draft', 'sent'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('weekly_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->string('title')->default('Weekly Meeting');
            $table->tinyInteger('day_of_week')->comment('1=Monday, ..., 7=Sunday');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_meetings');
        Schema::dropIfExists('moms');
        Schema::dropIfExists('meeting_reminders');
        Schema::dropIfExists('meeting_assets');
        Schema::dropIfExists('meeting_participants');
        Schema::dropIfExists('meetings');
    }
};
