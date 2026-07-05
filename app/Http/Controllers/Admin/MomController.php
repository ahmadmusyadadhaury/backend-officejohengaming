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
            ->latest();

        $period = $request->input('period', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($period === 'daily' && $request->input('date')) {
            $query->whereDate('created_at', $request->input('date'));
        } elseif ($period === 'weekly' && $request->input('week')) {
            $week = Carbon::parse($request->input('week'));
            $query->whereBetween('created_at', [$week->startOfWeek()->startOfDay(), $week->copy()->endOfWeek()->endOfDay()]);
        } elseif ($period === 'monthly' && $request->input('month')) {
            $month = Carbon::parse($request->input('month').'-01');
            $query->whereBetween('created_at', [$month->startOfMonth()->startOfDay(), $month->copy()->endOfMonth()->endOfDay()]);
        } elseif ($startDate && $endDate) {
            $query->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }

        $moms = $query->paginate(20);

        $momsJson = $moms->map(function ($mom) {
            return [
                'id' => $mom->id,
                'judul_meeting' => $mom->meeting->title ?? '—',
                'tanggal_meeting' => $mom->meeting->meeting_date ? $mom->meeting->meeting_date->format('d M Y') : '—',
                'dibuat_oleh' => $mom->creator->name ?? '—',
                'pic' => $mom->pic ?? '—',
                'dikirim' => $mom->sent_at ? $mom->sent_at->format('d M Y H:i') : '—',
                'status' => $mom->meeting->status ?? '—',
                'mom_status' => $mom->status,
                'file_path' => $mom->file_path,
                'file_name' => $mom->file_path ? basename($mom->file_path) : null,
                'file_url' => $mom->file_path ? url('storage/'.$mom->file_path) : null,
                'why' => $mom->meeting->why ?? '',
                'what' => $mom->meeting->what ?? '',
                'how' => $mom->meeting->how_expected ?? '',
                'summary' => $mom->summary ?? '',
                'decisions' => $mom->decisions ?? '',
                'action_plan' => $mom->action_plan ?? '',
            ];
        });

        $momStats = [
            'total_moms' => Mom::count(),
            'month_moms' => Mom::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'reviewed_moms' => Mom::where('status', 'sent')->count(),
            'unreviewed_moms' => Mom::where('status', 'draft')->count(),
        ];

        return view('admin.moms.index', compact('moms', 'period', 'momStats', 'momsJson'));
    }
}
