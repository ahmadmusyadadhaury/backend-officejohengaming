<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('payments', 'jenis')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('jenis')->default('listrik')->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('payments', 'jenis')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('jenis');
            });
        }
    }
};
