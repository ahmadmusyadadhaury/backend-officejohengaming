<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peralatan_kantor', function (Blueprint $table) {
            $table->boolean('barcode_ditempel')->default(false)->after('barcode');
        });
    }

    public function down(): void
    {
        Schema::table('peralatan_kantor', function (Blueprint $table) {
            $table->dropColumn('barcode_ditempel');
        });
    }
};
