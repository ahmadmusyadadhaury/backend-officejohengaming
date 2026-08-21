<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('electricity_token_readings', function (Blueprint $table) {
            $table->string('bukti_foto')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('electricity_token_readings', function (Blueprint $table) {
            $table->dropColumn('bukti_foto');
        });
    }
};
