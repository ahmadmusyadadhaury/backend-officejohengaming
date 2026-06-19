<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mom;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MomController extends Controller
{
    public function index(Request $request)
    {
        $query = Mom::with(['meeting.room', 'meeting.requester', 'creator'])
            ->where('status', 'sent')
            ->latest('sent_at');

        $period = $request->input('period', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($period === 'daily' && $request->input('date')) {
            $query->whereDate('sent_at', $request->input('date'));
        } elseif ($period === 'weekly' && $request->input('week')) {
            $week = Carbon::parse($request->input('week'));
            $query->whereBetween('sent_at', [$week->startOfWeek()->startOfDay(), $week->copy()->endOfWeek()->endOfDay()]);
        } elseif ($period === 'monthly' && $request->input('month')) {
            $month = Carbon::parse($request->input('month').'-01');
            $query->whereBetween('sent_at', [$month->startOfMonth()->startOfDay(), $month->copy()->endOfMonth()->endOfDay()]);
        } elseif ($startDate && $endDate) {
            $query->whereBetween('sent_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }

        $moms = $query->paginate(20);

        return view('admin.moms.index', compact('moms', 'period'));
    }
}
