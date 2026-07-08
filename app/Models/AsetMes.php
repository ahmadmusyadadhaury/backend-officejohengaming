<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetMes extends Model
{
    protected $table = 'aset_mes';

    protected $fillable = [
        'nama_aset',
        'jumlah',
        'penanggung_jawab',
        'pic',
        'jabatan',
        'keterangan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab');
    }

    public function pembayaran()
    {
        return $this->hasOne(PembayaranAsetMes::class, 'aset_mes_id');
    }
}
