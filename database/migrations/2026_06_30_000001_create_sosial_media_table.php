<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sosial_media', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('nama');
            $table->string('followers')->nullable();
            $table->string('platform');
            $table->string('divisi');
            $table->string('pic');
            $table->text('ket')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sosial_media');
    }
};
