<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Payment;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\WifiPayment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalMeeting = Meeting::where('requested_by', $user->id)->count();
        $disetujui = Meeting::where('requested_by', $user->id)->whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])->count();
        $menunggu = Meeting::where('requested_by', $user->id)->where('status', 'pending')->count();
        $ditolak = Meeting::where('requested_by', $user->id)->where('status', 'rejected')->count();

        return view('leader.dashboard', compact('totalMeeting', 'disetujui', 'menunggu', 'ditolak'));
    }
}
