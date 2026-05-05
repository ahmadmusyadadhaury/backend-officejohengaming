<?php

namespace App\Http\Controllers;

use App\Models\WeeklyMeetingContribution;
use App\Models\WeeklyMeetingInvitation;
use App\Models\WeeklyMeetingSession;
use App\Services\WeeklyMeetingService;
use Illuminate\Http\Request;

class WeeklySessionController extends Controller
{
    // Fallback: generate sesi hari ini saat user buka halaman
    public function index(WeeklyMeetingService $service)
    {
        $service->generateTodaySessions();
        $service->completeExpiredSessions();

        $invitations = WeeklyMeetingInvitation::where('user_id', auth()->id())
            ->whereHas('session', fn($q) => $q->whereIn('status', ['active', 'extended']))
            ->with('session.weeklyMeeting.room')
            ->latest()
            ->get();

        return view('weekly.index', compact('invitations'));
    }

    // Detail undangan weekly
    public function show(WeeklyMeetingInvitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) abort(403);

        if (!$invitation->is_read) {
            $invitation->update(['is_read' => true, 'read_at' => now()]);
        }

        $session = $invitation->session->load([
            'weeklyMeeting.room',
            'contributions.user.team',
        ]);

        return view('weekly.show', compact('invitation', 'session'));
    }

    // Simpan kontribusi
    public function contribute(Request $request, WeeklyMeetingSession $session)
    {
        // Cek akses
        if (!in_array(auth()->user()->role, ['koordinator', 'head_of_store', 'gm', 'admin', 'hr'])) {
            abort(403);
        }

        $request->validate([
            'what_to_discuss' => 'required|string',
            'file'            => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('weekly-files', 'public');
        }

        WeeklyMeetingContribution::create([
            'session_id'      => $session->id,
            'user_id'         => auth()->id(),
            'what_to_discuss' => $request->what_to_discuss,
            'file_path'       => $filePath,
        ]);

        return back()->with('success', 'Kontribusi berhasil ditambahkan.');
    }

    // Perpanjang waktu meeting
    public function extend(Request $request, WeeklyMeetingSession $session)
    {
        if (!in_array(auth()->user()->role, ['koordinator', 'head_of_store', 'gm', 'admin', 'hr'])) {
            abort(403);
        }

        $request->validate([
            'extend_minutes' => 'required|integer|min:1|max:240',
        ]);

        $newEndTime = \Carbon\Carbon::parse($session->end_time)
            ->addMinutes($request->extend_minutes)
            ->format('H:i:s');

        $session->update(['end_time' => $newEndTime, 'status' => 'extended']);

        return back()->with('success', 'Meeting diperpanjang ' . $request->extend_minutes . ' menit.');
    }

    // Selesaikan manual
    public function complete(WeeklyMeetingSession $session)
    {
        if (!in_array(auth()->user()->role, ['koordinator', 'head_of_store', 'gm', 'admin', 'hr'])) {
            abort(403);
        }

        $session->update([
            'status'          => 'completed',
            'actual_end_time' => now()->format('H:i:s'),
        ]);

        // Tandai semua undangan sudah dibaca agar hilang dari navbar
        $session->invitations()->update(['is_read' => true, 'read_at' => now()]);

        return back()->with('success', 'Meeting mingguan diselesaikan.');
    }
}
