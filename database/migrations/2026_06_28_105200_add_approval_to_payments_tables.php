<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Helper: tambah kolom approval ke tabel
        $addColumns = function (string $table, string $statusDefault = 'jatuh_tempo') {
            Schema::table($table, function (Blueprint $t) use ($statusDefault) {
                // Ubah status jadi string biasa (bisa pending, rejected, lunas, jatuh_tempo)
                $t->string('status', 20)->default($statusDefault)->change();
            });
            // Tambah kolom baru (kalau belum ada)
            if (! Schema::hasColumn($table, 'requested_by')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete()->after('status');
                    $t->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('requested_by');
                    $t->timestamp('approved_at')->nullable()->after('approved_by');
                    $t->string('bukti_bayar')->nullable()->after('approved_at');
                    $t->text('notes')->nullable()->after('bukti_bayar');
                });
            }
        };

        $addColumns('payments');
        $addColumns('wifi_payments');
        $addColumns('pembayaran_aset_digital');
        $addColumns('pembayaran_ipl_ruko');

        // Reset existing lunas jadi pending
        foreach (['payments', 'wifi_payments', 'pembayaran_aset_digital', 'pembayaran_ipl_ruko'] as $table) {
            DB::table($table)->where('status', 'lunas')->update([
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
            ]);
        }
    }

    public function down(): void
    {
        foreach (['payments', 'wifi_payments', 'pembayaran_aset_digital', 'pembayaran_ipl_ruko'] as $table) {
            try {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    $t->dropForeign([$table.'_requested_by_foreign']);
                    $t->dropForeign([$table.'_approved_by_foreign']);
                });
            } catch (Throwable $e) {
            }
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn(['requested_by', 'approved_by', 'approved_at', 'bukti_bayar', 'notes']);
            });
        }
    }
};
