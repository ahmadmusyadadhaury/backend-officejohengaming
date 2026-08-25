<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peralatan_kantor', function (Blueprint $table) {
            $table->string('tim')->nullable()->index()->after('sub_kategori');
        });
    }

    public function down(): void
    {
        Schema::table('peralatan_kantor', function (Blueprint $table) {
            $table->dropIndex(['tim']);
            $table->dropColumn('tim');
        });
    }
};
