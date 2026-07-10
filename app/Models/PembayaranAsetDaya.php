<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranAsetDaya extends Model
{
    protected $table = 'pembayaran_aset_daya';

    protected $fillable = [
        'aset_daya_id',
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
        'period',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_tagihan' => 'date:d/m/Y',
            'jatuh_tempo' => 'date:d/m/Y',
            'tanggal_bayar' => 'date:d/m/Y',
            'approved_at' => 'datetime',
            'nominal' => 'decimal:2',
            'period' => 'string',
        ];
    }

    public function asetDaya()
    {
        return $this->belongsTo(AsetDaya::class, 'aset_daya_id');
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
