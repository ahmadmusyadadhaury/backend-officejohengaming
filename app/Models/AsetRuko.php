<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetRuko extends Model
{
    protected $table = 'aset_ruko';

    protected $fillable = [
        'nama_aset',
        'lokasi',
        'jumlah',
        'kondisi',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
        ];
    }
}
