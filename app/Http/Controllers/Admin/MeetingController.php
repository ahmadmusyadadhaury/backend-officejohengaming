<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\Notification;
use App\Models\Room;
use App\Models\User;
use App\Services\MeetingQueueService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        Notification::where('user_id', auth()->id())
            ->where('type', 'activity')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $meetingMonth = $request->get('meeting_month', now()->format('Y-m'));

        $query = Meeting::with(['requester', 'team', 'teams', 'room', 'assets', 'mom.creator']);

        $startDate = Carbon::parse($meetingMonth.'-01')->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        $query->whereBetween('meeting_date', [$startDate, $endDate]);

        $meetings = $query->latest()->paginate(15)->withQueryString();

        $meetingsJson = $meetings->map(fn ($m) => [
            'id' => $m->id,
            'title' => $m->title,
            'description' => $m->description,
            'why' => $m->why,
            'what' => $m->what,
            'how_expected' => $m->how_expected,
            'requester' => $m->requester ? ['name' => $m->requester->name] : null,
            'team' => $m->team ? ['name' => $m->team->name, 'id' => $m->team->id] : null,
            'room' => $m->room ? ['name' => $m->room->name, 'id' => $m->room->id] : null,
            'meeting_date' => $m->meeting_date?->format('d M Y'),
            'meeting_date_raw' => $m->meeting_date?->format('Y-m-d'),
            'start_time' => $m->start_time,
            'end_time' => $m->end_time,
            'status' => $m->status,
            'queue_position' => $m->queue_position,
            'rt_label' => MeetingQueueService::realtimeStatus($m)['label'] ?? '-',
            'reject_reason' => $m->reject_reason,
            'teams' => $m->teams->map(fn ($t) => $t->name),
            'assets' => $m->assets->map(fn ($a) => [
                'name' => $a->name,
                'quantity' => $a->pivot->quantity,
            ]),
            'mom' => $m->mom ? [
                'status' => $m->mom->status,
                'summary' => $m->mom->summary,
                'decisions' => $m->mom->decisions,
                'action_plan' => $m->mom->action_plan,
                'pic' => $m->mom->pic,
                'creator_name' => $m->mom->creator->name ?? null,
                'sent_at' => $m->mom->sent_at?->format('d M Y H:i'),
                'file_url' => $m->mom->file_path ? asset('storage/'.$m->mom->file_path) : null,
            ] : null,
        ]);

        $totalMeeting = Meeting::count();
        $menungguMeeting = Meeting::where('status', 'pending')->count();
        $disetujuiMeeting = Meeting::whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])->count();
        $ditolakMeeting = Meeting::where('status', 'rejected')->count();

        $rooms = Room::orderBy('name')->get();

        return view('admin.meetings.index', compact('meetings', 'meetingsJson', 'totalMeeting', 'menungguMeeting', 'disetujuiMeeting', 'ditolakMeeting', 'meetingMonth', 'rooms'));
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['requester', 'team', 'teams', 'room', 'participants', 'assets', 'mom.creator']);

        return view('admin.meetings.show', compact('meeting'));
    }

    public function approve(Meeting $meeting, MeetingQueueService $queue)
    {
        $meeting->update([
            'status' => 'approved',
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
            'Meeting "'.$meeting->title.'" telah disetujui. Status: '.$queueLabel,
            route('koordinator.meetings.show', $meeting)
        );

        // Notif ke semua anggota tim yang diundang
        $memberIds = $members->pluck('id')->reject(fn ($id) => $id === $meeting->requested_by)->toArray();
        if (! empty($memberIds)) {
            Notification::sendToMany($memberIds, 'meeting',
                'Undangan Meeting Baru 📅',
                'Kamu diundang ke meeting: '.$meeting->title.' pada '.$meeting->meeting_date->format('d M Y'),
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
            'Meeting "'.$meeting->title.'" ditolak. Alasan: '.$request->reject_reason,
            route('koordinator.meetings.show', $meeting)
        );

        return back()->with('success', 'Meeting ditolak.');
    }

    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meeting_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $meeting->update($validated);

        return redirect()->route('admin.meetings.index')
            ->with('success', 'Meeting berhasil diperbarui.');
    }

    public function destroy(Meeting $meeting)
    {
        abort_if(! in_array($meeting->status, ['cancelled', 'rejected']), 403,
            'Hanya meeting dengan status Cancelled atau Rejected yang bisa dihapus.');

        $meeting->delete();

        return redirect()->route('admin.meetings.index')
            ->with('success', 'Meeting berhasil dihapus.');
    }
}
