<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\Notification;
use App\Models\User;
use App\Services\MeetingQueueService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        // Tandai notif activity sebagai sudah dibaca
        \App\Models\Notification::where('user_id', auth()->id())
            ->where('type', 'activity')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $meetings = Meeting::with(['requester', 'team', 'teams', 'room'])
            ->latest()->paginate(15);
        return view('admin.meetings.index', compact('meetings'));
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['requester', 'team', 'teams', 'room', 'participants', 'assets']);
        return view('admin.meetings.show', compact('meeting'));
    }

    public function approve(Meeting $meeting, MeetingQueueService $queue)
    {
        $meeting->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Tentukan posisi antrian
        $queue->assignQueue($meeting);

        // Undang semua anggota tim
        $members = User::whereIn('team_id', $meeting->allTeamIds())->get();
        foreach ($members as $member) {
            MeetingInvitation::firstOrCreate(
                ['meeting_id' => $meeting->id, 'user_id' => $member->id],
                ['is_read' => false]
            );
        }

        $queueLabel = MeetingQueueService::queueLabel($meeting->fresh()->queue_position);

        // Notif ke pemohon bahwa meeting disetujui
        Notification::send($meeting->requested_by, 'activity',
            'Meeting Disetujui ✅',
            'Meeting "' . $meeting->title . '" telah disetujui. Status: ' . $queueLabel,
            route('koordinator.meetings.show', $meeting)
        );

        // Notif ke semua anggota tim yang diundang
        $memberIds = $members->pluck('id')->reject(fn($id) => $id === $meeting->requested_by)->toArray();
        if (!empty($memberIds)) {
            Notification::sendToMany($memberIds, 'meeting',
                'Undangan Meeting Baru 📅',
                'Kamu diundang ke meeting: ' . $meeting->title . ' pada ' . $meeting->meeting_date->format('d M Y'),
                route('invitation.index')
            );
        }

        return back()->with('success', "Meeting disetujui. Status: {$queueLabel}.");
    }

    public function reject(Request $request, Meeting $meeting)
    {
        $request->validate(['reject_reason' => 'required|string']);
        $meeting->update(['status' => 'rejected', 'reject_reason' => $request->reject_reason]);

        // Notif ke pemohon bahwa meeting ditolak
        Notification::send($meeting->requested_by, 'activity',
            'Meeting Ditolak ❌',
            'Meeting "' . $meeting->title . '" ditolak. Alasan: ' . $request->reject_reason,
            route('koordinator.meetings.show', $meeting)
        );

        return back()->with('success', 'Meeting ditolak.');
    }

    public function destroy(Meeting $meeting)
    {
        abort_if(in_array($meeting->status, ['approved', 'confirmed', 'in_progress']), 403,
            'Tidak bisa menghapus meeting yang sedang aktif.');

        $meeting->delete();

        return redirect()->route('admin.meetings.index')
            ->with('success', 'Meeting berhasil dihapus.');
    }
}
