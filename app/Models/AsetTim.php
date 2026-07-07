<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetTim extends Model
{
    protected $table = 'aset_tim';

    protected $fillable = [
        'nama_aset',
        'tim',
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
        return $this->hasOne(PembayaranAsetTim::class, 'aset_tim_id');
    }
}
