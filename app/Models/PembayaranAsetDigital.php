<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranAsetDigital extends Model
{
    protected $table = 'pembayaran_aset_digital';

    protected $fillable = [
        'digital_asset_id',
        'periode',
        'tanggal_tagihan',
        'jatuh_tempo',
        'nominal',
        'pic',
        'jabatan',
        'status',
        'tanggal_bayar',
        'requested_by',
        'approved_by',
        'approved_at',
        'bukti_bayar',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_tagihan' => 'date:d/m/Y',
            'jatuh_tempo' => 'date:d/m/Y',
            'tanggal_bayar' => 'date:d/m/Y',
            'approved_at' => 'datetime',
            'nominal' => 'decimal:2',
        ];
    }

    public function digitalAsset()
    {
        return $this->belongsTo(DigitalAsset::class, 'digital_asset_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
