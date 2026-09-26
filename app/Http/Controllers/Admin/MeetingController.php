<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\Notification;
use App\Models\Room;
use App\Models\Team;
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
        $search = trim((string) $request->input('search', ''));
        $status = $request->input('status', '');

        $query = Meeting::with(['requester', 'team', 'teams', 'room', 'assets', 'mom.creator']);

        $startDate = Carbon::parse($meetingMonth.'-01')->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        $query->whereBetween('meeting_date', [$startDate, $endDate]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('requester', function ($qq) use ($search) {
                        $qq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $meetings = $query->orderBy('meeting_date', 'desc')->orderBy('start_time', 'desc')->paginate(10)->withQueryString();

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
            'file_path' => $m->file_path,
            'file_url' => $m->file_path ? route('files.show', $m->file_path) : null,
            'teams' => $m->teams->map(fn ($t) => $t->name),
            'extra_team_ids' => $m->teams->pluck('id'),
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
                'file_path' => $m->mom->file_path,
                'file_url' => $m->mom->file_path ? route('files.show', $m->mom->file_path) : null,
                'file_name' => $m->mom->file_path ? basename($m->mom->file_path) : null,
                'upload_url' => $m->mom->file_path ? route('koordinator.mom.upload-file', $m->mom->id) : null,
            ] : null,
        ]);

        $totalMeeting = Meeting::count();
        $menungguMeeting = Meeting::where('status', 'pending')->count();
        $disetujuiMeeting = Meeting::whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])->count();
        $ditolakMeeting = Meeting::where('status', 'rejected')->count();

        $rooms = Room::orderBy('name')->get();
        $teams = Team::where('is_active', true)->orderBy('name')->get();

        return view('admin.meetings.index', compact('meetings', 'meetingsJson', 'totalMeeting', 'menungguMeeting', 'disetujuiMeeting', 'ditolakMeeting', 'meetingMonth', 'rooms', 'teams', 'search', 'status'));
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
            'main_team_id' => 'required|exists:teams,id',
            'extra_teams' => 'nullable|array',
            'extra_teams.*' => 'exists:teams,id',
        ]);

        $room = Room::find($request->room_id);
        if ($room && $room->is_weekly_only) {
            return back()->withErrors(['room_id' => 'Ruangan ini khusus Weekly Meeting dan tidak bisa dipesan untuk meeting biasa.'])->withInput();
        }

        if ($room && $room->isSmokingArea() && Room::lunchBreakOverlaps($request->start_time, $request->end_time)) {
            return back()->withErrors(['room_id' => 'Smoking Area tidak dapat digunakan pada jam istirahat (12.00 - 13.00 WIB).'])->withInput();
        }

        $extraTeams = collect($request->input('extra_teams', []) ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->reject(fn ($id) => $id === (int) $validated['main_team_id'])
            ->values()
            ->all();

        // Tim tidak berubah? tidak perlu sentuh undangan
        $teamChanged = (int) $meeting->team_id !== (int) $validated['main_team_id']
            || $meeting->teams()->pluck('teams.id')->map(fn ($id) => (int) $id)->sort()->values()->all()
                !== collect($extraTeams)->sort()->values()->all();

        $meeting->update([
            'title' => $validated['title'],
            'meeting_date' => $validated['meeting_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room_id' => $validated['room_id'],
            'team_id' => $validated['main_team_id'],
        ]);

        $meeting->teams()->sync($extraTeams);
        $meeting->load('teams');

        $message = 'Meeting berhasil diperbarui.';

        if ($teamChanged) {
            $message = $this->syncInvitations($meeting);
        }

        return redirect()->route('admin.meetings.index')->with('success', $message);
    }

    /**
     * Samakan undangan peserta dengan tim terbaru.
     * Menghapus undangan ke peserta yang bukan anggota tim baru,
     * lalu mengundang anggota tim baru yang belum punya undangan.
     */
    private function syncInvitations(Meeting $meeting): string
    {
        $memberIds = User::whereIn('team_id', $meeting->allTeamIds())->pluck('id');

        $removedCount = MeetingInvitation::where('meeting_id', $meeting->id)
            ->whereNotIn('user_id', $memberIds)
            ->delete();

        $existingIds = MeetingInvitation::where('meeting_id', $meeting->id)->pluck('user_id');
        $newIds = $memberIds->diff($existingIds)->values();

        foreach ($newIds as $userId) {
            MeetingInvitation::firstOrCreate(
                ['meeting_id' => $meeting->id, 'user_id' => $userId],
                ['is_read' => false]
            );
        }

        $notifyIds = $newIds->reject(fn ($id) => $id === $meeting->requested_by)->all();
        if (! empty($notifyIds)) {
            Notification::sendToMany($notifyIds, 'meeting',
                'Undangan Meeting Baru 📅',
                'Kamu diundang ke meeting: '.$meeting->title.' pada '.$meeting->meeting_date->format('d M Y'),
                route('invitation.index')
            );
        }

        $parts = ['Tim diperbarui.'];
        if ($newIds->isNotEmpty()) {
            $parts[] = $newIds->count().' peserta baru diundang.';
        }
        if ($removedCount > 0) {
            $parts[] = $removedCount.' undangan lama dibatalkan.';
        }

        return implode(' ', $parts);
    }

    public function destroy(Meeting $meeting)
    {
        $title = $meeting->title;
        $roomId = $meeting->room_id;
        $meetingDate = $meeting->meeting_date;

        $meeting->delete();

        $this->compactQueue($roomId, $meetingDate);

        return redirect()->route('admin.meetings.index')
            ->with('success', 'Meeting "'.$title.'" berhasil dihapus beserta data terkaitnya.');
    }

    /**
     * Rapatkan nomor antrian di ruangan + tanggal yang sama setelah ada meeting dihapus.
     * Hanya menomori ulang queue_position, tidak menggeser start_time / end_time.
     */
    private function compactQueue($roomId, $meetingDate): void
    {
        $queue = Meeting::where('room_id', $roomId)
            ->where('meeting_date', $meetingDate)
            ->whereIn('status', ['approved', 'confirmed'])
            ->whereNotNull('queue_position')
            ->orderBy('queue_position')
            ->get();

        $position = 0;
        foreach ($queue as $m) {
            $m->update(['queue_position' => $position]);
            $position++;
        }
    }
}
