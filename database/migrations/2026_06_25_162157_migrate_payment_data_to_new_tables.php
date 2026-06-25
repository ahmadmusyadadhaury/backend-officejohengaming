<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $asetDigital = DB::table('payments')->where('jenis', 'aset_digital')->get();
        foreach ($asetDigital as $row) {
            DB::table('pembayaran_aset_digital')->insert([
                'id'              => $row->id,
                'periode'         => $row->periode,
                'tanggal_tagihan' => $row->tanggal_tagihan,
                'jatuh_tempo'     => $row->jatuh_tempo,
                'nominal'         => $row->nominal,
                'status'          => $row->status,
                'tanggal_bayar'   => $row->tanggal_bayar,
                'created_at'      => $row->created_at,
                'updated_at'      => $row->updated_at,
            ]);
        }

        $iplRuko = DB::table('payments')->where('jenis', 'ipl_ruko')->get();
        foreach ($iplRuko as $row) {
            DB::table('pembayaran_ipl_ruko')->insert([
                'id'              => $row->id,
                'periode'         => $row->periode,
                'tanggal_tagihan' => $row->tanggal_tagihan,
                'jatuh_tempo'     => $row->jatuh_tempo,
                'nominal'         => $row->nominal,
                'status'          => $row->status,
                'tanggal_bayar'   => $row->tanggal_bayar,
                'created_at'      => $row->created_at,
                'updated_at'      => $row->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('pembayaran_aset_digital')->truncate();
        DB::table('pembayaran_ipl_ruko')->truncate();
    }
};
