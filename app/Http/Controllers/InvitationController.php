<?php

namespace App\Http\Controllers;

use App\Models\MeetingInvitation;
use Carbon\Carbon;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = MeetingInvitation::where('user_id', auth()->id())
            ->whereHas('meeting', fn($q) => $q->whereIn('status', ['approved', 'confirmed', 'in_progress']))
            ->with('meeting.room', 'meeting.team')
            ->latest()
            ->get();

        if ($invitations->isEmpty()) {
            abort(404, 'Tidak ada undangan aktif.');
        }

        return view('invitations.index', compact('invitations'));
    }

    public function show(MeetingInvitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $meeting = $invitation->meeting;

        // Cek apakah meeting sudah selesai, dibatalkan, atau ditolak
        if (in_array($meeting->status, ['completed', 'cancelled', 'rejected'])) {
            // Tandai sudah dibaca agar hilang dari navbar
            $invitation->update(['is_read' => true, 'read_at' => now()]);
            abort(404, 'Undangan ini sudah tidak tersedia.');
        }

        // Cek apakah jam meeting sudah lewat
        $endDt = Carbon::parse($meeting->meeting_date->format('Y-m-d') . ' ' . ($meeting->actual_end_time ?? $meeting->end_time));
        if (Carbon::now()->gt($endDt)) {
            $invitation->update(['is_read' => true, 'read_at' => now()]);
            abort(404, 'Undangan ini sudah tidak tersedia.');
        }

        // Tandai sudah dibaca
        if (!$invitation->is_read) {
            $invitation->update(['is_read' => true, 'read_at' => now()]);
        }

        $meeting->load(['room', 'team', 'teams', 'requester']);

        return view('invitations.show', compact('invitation', 'meeting'));
    }
}
