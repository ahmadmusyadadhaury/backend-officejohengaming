<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetDaya;
use App\Models\AsetTim;

class DataSayaController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $asetDaya = AsetDaya::with('penanggungJawab')
            ->where('penanggung_jawab', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $asetTim = AsetTim::with('penanggungJawab')
            ->where('penanggung_jawab', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.data-saya.index', compact('asetDaya', 'asetTim'));
    }
}
