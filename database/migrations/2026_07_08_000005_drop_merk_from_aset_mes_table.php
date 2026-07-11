<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('aset_mes', 'merk')) {
            Schema::table('aset_mes', function (Blueprint $table) {
                $table->dropColumn('merk');
            });
        }
    }

    public function down(): void
    {
        Schema::table('aset_mes', function (Blueprint $table) {
            $table->string('merk')->nullable();
        });
    }
};
