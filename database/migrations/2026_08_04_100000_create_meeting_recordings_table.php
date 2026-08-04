<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_recordings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->string('audio_path')->nullable();
            $table->longText('transcript')->nullable();
            $table->longText('summary')->nullable();
            $table->integer('duration')->default(0)->comment('durasi dalam detik');
            $table->enum('status', ['draft', 'finalized'])->default('draft');
            $table->timestamp('finalized_at')->nullable();
            $table->timestamps();

            $table->unique('meeting_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_recordings');
    }
};
