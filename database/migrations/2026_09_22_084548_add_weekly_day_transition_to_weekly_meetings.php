<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom transisi hari mingguan agar kalender bisa menampilkan
     * riwayat (hari lama, mis. Senin) dan jadwal baru (mis. Selasa) sekaligus.
     */
    public function up(): void
    {
        Schema::table('weekly_meetings', function (Blueprint $table) {
            $table->tinyInteger('day_of_week_old')->nullable()->after('day_of_week')
                ->comment('Hari yang berlaku sebelum transisi, mis. 1=Senin');
            $table->date('day_of_week_changed_on')->nullable()->after('day_of_week_old')
                ->comment('Tanggal efektif pindah ke day_of_week baru');
        });
    }

    public function down(): void
    {
        Schema::table('weekly_meetings', function (Blueprint $table) {
            $table->dropColumn(['day_of_week_old', 'day_of_week_changed_on']);
        });
    }
};
