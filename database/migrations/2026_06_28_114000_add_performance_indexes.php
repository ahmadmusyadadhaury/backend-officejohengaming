<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Notifications: dedup_key untuk cek duplikat cepat ──
        if (! Schema::hasColumn('notifications', 'dedup_key')) {
            Schema::table('notifications', function (Blueprint $t) {
                $t->string('dedup_key', 100)->nullable()->after('url');
                $t->index(['dedup_key', 'user_id']);
            });
        }

        // ── Payments: index untuk query status+jatuh_tempo ──
        Schema::table('payments', function (Blueprint $t) {
            $t->index(['status', 'jenis', 'jatuh_tempo'], 'idx_payments_status_jenis_jatuh');
        });

        // ── Wifi Payments: index untuk query status+masa_tenggang ──
        Schema::table('wifi_payments', function (Blueprint $t) {
            $t->index(['status', 'masa_tenggang'], 'idx_wifi_status_masa');
        });

        // ── Pembayaran Aset Digital ──
        Schema::table('pembayaran_aset_digital', function (Blueprint $t) {
            $t->index(['status', 'jatuh_tempo'], 'idx_aset_status_jatuh');
        });

        // ── Pembayaran IPL Ruko ──
        Schema::table('pembayaran_ipl_ruko', function (Blueprint $t) {
            $t->index(['status', 'jatuh_tempo'], 'idx_ipl_status_jatuh');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $t) {
            $t->dropIndex(['dedup_key', 'user_id']);
            $t->dropColumn('dedup_key');
        });

        Schema::table('payments', fn (Blueprint $t) => $t->dropIndex('idx_payments_status_jenis_jatuh'));
        Schema::table('wifi_payments', fn (Blueprint $t) => $t->dropIndex('idx_wifi_status_masa'));
        Schema::table('pembayaran_aset_digital', fn (Blueprint $t) => $t->dropIndex('idx_aset_status_jatuh'));
        Schema::table('pembayaran_ipl_ruko', fn (Blueprint $t) => $t->dropIndex('idx_ipl_status_jatuh'));
    }
};
