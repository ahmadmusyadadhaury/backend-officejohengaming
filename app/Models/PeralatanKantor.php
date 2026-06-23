<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeralatanKantor extends Model
{
    protected $table = 'peralatan_kantor';

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'detail',
        'sub_kategori',
        'keterangan',
        'lokasi_unit',
        'ruangan',
        'milik',
        'pengadaan_tahun',
        'tanggal_pembelian',
        'kategori_nilai',
        'kategori_ukuran',
        'nilai',
        'waktu_pakai_per_hari',
        'estimasi_waktu_barang',
        'pengurangan_harga_per_hari',
        'harga_per_hari_ini',
        'pic',
        'jabatan',
        'atasan',
        'jabatan_atasan',
        'kondisi',
    ];

    protected function casts(): array
    {
        return [
            'jumlah'                     => 'integer',
            'pengadaan_tahun'            => 'integer',
            'tanggal_pembelian'          => 'date',
            'nilai'                      => 'decimal:2',
            'waktu_pakai_per_hari'       => 'integer',
            'estimasi_waktu_barang'      => 'integer',
            'pengurangan_harga_per_hari' => 'decimal:2',
            'harga_per_hari_ini'         => 'decimal:2',
        ];
    }
}
