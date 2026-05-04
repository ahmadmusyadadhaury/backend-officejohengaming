<?php

namespace App\Http\Controllers;

use App\Models\MeetingInvitation;

class InvitationController extends Controller
{
    // List semua undangan user
    public function index()
    {
        $invitations = MeetingInvitation::where('user_id', auth()->id())
            ->whereHas('meeting', fn($q) => $q->whereIn('status', ['approved','confirmed','in_progress']))
            ->with('meeting.room', 'meeting.team')
            ->latest()
            ->get();

        return view('invitations.index', compact('invitations'));
    }

    // Detail undangan — tetap bisa dibuka selama meeting belum completed
    public function show(MeetingInvitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        // Tandai sudah dibaca (hanya sekali, untuk hilangkan badge)
        if (!$invitation->is_read) {
            $invitation->update(['is_read' => true, 'read_at' => now()]);
        }

        $meeting = $invitation->meeting->load(['room', 'team', 'teams', 'requester']);

        return view('invitations.show', compact('invitation', 'meeting'));
    }
}
