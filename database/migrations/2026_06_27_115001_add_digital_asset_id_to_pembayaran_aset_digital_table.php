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
        Schema::table('pembayaran_aset_digital', function (Blueprint $table) {
            $table->foreignId('digital_asset_id')->nullable()->constrained('digital_assets')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran_aset_digital', function (Blueprint $table) {
            $table->dropForeign(['digital_asset_id']);
            $table->dropColumn('digital_asset_id');
        });
    }
};
