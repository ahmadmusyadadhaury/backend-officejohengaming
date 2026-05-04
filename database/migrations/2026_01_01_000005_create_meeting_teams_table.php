<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel pivot meeting <-> teams (multi-tim)
        Schema::create('meeting_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['meeting_id', 'team_id']);
        });

        // Hapus kolom yang tidak dipakai lagi
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropForeign(['second_team_id']);
            $table->dropColumn(['second_team_id', 'where_detail', 'who_summary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_teams');
        Schema::table('meetings', function (Blueprint $table) {
            $table->foreignId('second_team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->string('where_detail')->nullable();
            $table->text('who_summary')->nullable();
        });
    }
};
