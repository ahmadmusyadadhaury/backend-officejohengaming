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
        Schema::table('vehicle_pajak_requests', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
            $table->foreignId('requested_by')->nullable()->change();
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('bukti_bayar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_pajak_requests', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
            $table->foreignId('requested_by')->nullable(false)->change();
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('bukti_bayar')->nullable(false)->change();
        });
    }
};
