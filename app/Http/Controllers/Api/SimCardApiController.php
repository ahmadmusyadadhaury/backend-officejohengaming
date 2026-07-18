<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SimCard;

class SimCardApiController extends Controller
{
    public function index()
    {
        $cards = SimCard::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $cards->map(fn ($c) => [
                'id' => $c->id,
                'nomor_sim_card' => $c->nomor_sim_card,
                'pic' => $c->pic,
                'atasan' => $c->atasan,
                'jabatan' => $c->jabatan,
                'masa_aktif' => $c->masa_aktif?->format('Y-m-d'),
                'status_kartu' => $c->status_kartu,
                'keperluan' => $c->keperluan,
            ]),
        ]);
    }
}
