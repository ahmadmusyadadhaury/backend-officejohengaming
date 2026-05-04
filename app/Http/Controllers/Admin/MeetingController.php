<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with(['requester', 'team', 'teams', 'room'])
            ->latest()->paginate(15);
        return view('admin.meetings.index', compact('meetings'));
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['requester', 'team', 'teams', 'room', 'participants', 'assets']);
        return view('admin.meetings.show', compact('meeting'));
    }

    public function approve(Meeting $meeting)
    {
        $meeting->update(['status' => 'approved', 'approved_by' => auth()->id(), 'approved_at' => now()]);

        // Undang semua anggota dari semua tim yang terlibat
        $members = User::whereIn('team_id', $meeting->allTeamIds())->get();

        foreach ($members as $member) {
            MeetingInvitation::firstOrCreate(
                ['meeting_id' => $meeting->id, 'user_id' => $member->id],
                ['is_read' => false]
            );
        }

        return back()->with('success', 'Meeting disetujui dan undangan dikirim ke semua anggota tim.');
    }

    public function reject(Request $request, Meeting $meeting)
    {
        $request->validate(['reject_reason' => 'required|string']);
        $meeting->update(['status' => 'rejected', 'reject_reason' => $request->reject_reason]);
        return back()->with('success', 'Meeting ditolak.');
    }
}
