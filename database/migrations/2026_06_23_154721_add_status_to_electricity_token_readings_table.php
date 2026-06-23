<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('electricity_token_readings', function (Blueprint $table) {
            $table->string('status', 20)->nullable()->after('remaining_kwh');
        });

        DB::statement("
            UPDATE electricity_token_readings
            SET status = CASE
                WHEN remaining_kwh < 50 THEN 'kritis'
                WHEN remaining_kwh < 100 THEN 'warning'
                WHEN remaining_kwh < 200 THEN 'perhatian'
                ELSE 'aman'
            END
        ");
    }

    public function down(): void
    {
        Schema::table('electricity_token_readings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
