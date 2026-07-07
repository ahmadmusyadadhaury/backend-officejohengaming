<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetDaya extends Model
{
    protected $table = 'aset_daya';

    protected $fillable = [
        'nama_aset',
        'daya',
        'unit',
        'penanggung_jawab',
        'pic',
        'jabatan',
        'keterangan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab');
    }

    public function pembayaran()
    {
        return $this->hasOne(PembayaranAsetDaya::class, 'aset_daya_id');
    }
}
