<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetDaya;

class AsetDayaController extends Controller
{
    public function index()
    {
        $assets = AsetDaya::with('penanggungJawab')
            ->where('penanggung_jawab', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.aset-daya.index', compact('assets'));
    }
}
