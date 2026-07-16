<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peralatan_kantor', function (Blueprint $table) {
            $table->string('pic')->nullable()->change();
            $table->string('atasan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('peralatan_kantor', function (Blueprint $table) {
            $table->string('pic')->nullable(false)->change();
            $table->string('atasan')->nullable(false)->change();
        });
    }
};
