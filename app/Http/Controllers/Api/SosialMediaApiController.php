<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SosialMedia;

class SosialMediaApiController extends Controller
{
    public function index()
    {
        $items = SosialMedia::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $items->map(fn ($i) => [
                'id' => $i->id,
                'username' => $i->username,
                'nama' => $i->nama,
                'followers' => $i->followers,
                'platform' => $i->platform,
                'divisi' => $i->divisi,
                'pic' => $i->pic,
                'ket' => $i->ket,
                'status' => $i->status,
            ]),
        ]);
    }
}
