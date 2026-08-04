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
        Schema::table('aset_mes', function (Blueprint $table) {
            $table->enum('kategori', ['putra', 'putri'])->default('putra')->after('nama_aset');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aset_mes', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
