<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->unsignedInteger('queue_position')->nullable()->after('status')
                ->comment('null = tidak antri, 0 = sedang berlangsung, 1,2,3... = antrian ke-n');
        });
    }

    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn('queue_position');
        });
    }
};
