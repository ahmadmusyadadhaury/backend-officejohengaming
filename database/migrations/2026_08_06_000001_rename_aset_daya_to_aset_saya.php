<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran_aset_daya', function (Blueprint $table) {
            $table->dropForeign(['aset_daya_id']);
        });

        Schema::rename('pembayaran_aset_daya', 'pembayaran_aset_saya');
        Schema::rename('aset_daya', 'aset_saya');

        Schema::table('pembayaran_aset_saya', function (Blueprint $table) {
            $table->dropIndex('pembayaran_aset_daya_aset_daya_id_foreign');
            $table->renameColumn('aset_daya_id', 'aset_saya_id');
            $table->foreign('aset_saya_id')->references('id')->on('aset_saya')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran_aset_saya', function (Blueprint $table) {
            $table->dropForeign(['aset_saya_id']);
            $table->dropIndex('pembayaran_aset_saya_aset_saya_id_foreign');
            $table->renameColumn('aset_saya_id', 'aset_daya_id');
        });

        Schema::rename('aset_saya', 'aset_daya');
        Schema::rename('pembayaran_aset_saya', 'pembayaran_aset_daya');

        Schema::table('pembayaran_aset_daya', function (Blueprint $table) {
            $table->foreign('aset_daya_id')->references('id')->on('aset_daya')->nullOnDelete();
        });
    }
};
