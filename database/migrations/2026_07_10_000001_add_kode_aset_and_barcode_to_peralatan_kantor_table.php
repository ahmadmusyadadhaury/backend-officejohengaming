<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peralatan_kantor', function (Blueprint $table) {
            $table->string('kode_aset')->unique()->after('id');
            $table->string('barcode')->unique()->after('kode_aset');
        });

        $year = date('Y');
        $items = DB::table('peralatan_kantor')->orderBy('id')->get();
        foreach ($items as $index => $item) {
            $kode = 'PK-'.$year.'-'.str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            DB::table('peralatan_kantor')
                ->where('id', $item->id)
                ->update([
                    'kode_aset' => $kode,
                    'barcode' => $kode,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('peralatan_kantor', function (Blueprint $table) {
            $table->dropColumn(['kode_aset', 'barcode']);
        });
    }
};
