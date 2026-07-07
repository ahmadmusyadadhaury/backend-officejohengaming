<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetTim;

class AsetTimController extends Controller
{
    public function index()
    {
        $assets = AsetTim::with('penanggungJawab')
            ->where('penanggung_jawab', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.aset-tim.index', compact('assets'));
    }
}
