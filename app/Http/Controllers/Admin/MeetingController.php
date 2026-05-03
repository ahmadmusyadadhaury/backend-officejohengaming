<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index() {
        $meetings = Meeting::with(['requester', 'team', 'room'])
            ->latest()->paginate(15);
        return view('admin.meetings.index', compact('meetings'));
    }

    public function show(Meeting $meeting) {
        $meeting->load(['requester', 'team', 'secondTeam', 'room', 'participants', 'assets']);
        return view('admin.meetings.show', compact('meeting'));
    }

    public function approve(Meeting $meeting) {
        $meeting->update(['status' => 'approved', 'approved_by' => auth()->id(), 'approved_at' => now()]);
        return back()->with('success', 'Meeting disetujui.');
    }

    public function reject(Request $request, Meeting $meeting) {
        $request->validate(['reject_reason' => 'required|string']);
        $meeting->update(['status' => 'rejected', 'reject_reason' => $request->reject_reason]);
        return back()->with('success', 'Meeting ditolak.');
    }
}
