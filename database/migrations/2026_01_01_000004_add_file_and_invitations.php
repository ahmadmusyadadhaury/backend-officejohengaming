<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah file_path ke meetings
        Schema::table('meetings', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('how_expected');
        });

        // Tabel undangan per user
        Schema::create('meeting_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->unique(['meeting_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_invitations');
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
