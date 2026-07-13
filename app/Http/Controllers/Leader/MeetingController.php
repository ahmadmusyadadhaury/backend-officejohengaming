<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Meeting;
use App\Models\MeetingInvitation;
use App\Models\Notification;
use App\Models\Room;
use App\Models\Team;
use App\Models\User;
use App\Services\MeetingQueueService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        Notification::where('user_id', auth()->id())
            ->where('type', 'activity')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $userId = auth()->id();
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        $query = Meeting::with(['room', 'team', 'teams', 'assets', 'mom.creator', 'requester'])
            ->where('requested_by', $userId);

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $meetings = $query->latest()->paginate(15)->withQueryString();

        $meetingsJson = $meetings->map(fn ($m) => [
            'id' => $m->id,
            'title' => $m->title,
            'why' => $m->why,
            'what' => $m->what,
            'how_expected' => $m->how_expected,
            'status' => $m->status,
            'queue_position' => $m->queue_position,
            'room' => $m->room ? ['name' => $m->room->name] : null,
            'team' => $m->team ? ['name' => $m->team->name] : null,
            'requester' => $m->requester ? ['name' => $m->requester->name] : null,
            'meeting_date' => $m->meeting_date?->format('d M Y'),
            'meeting_date_raw' => $m->meeting_date?->format('Y-m-d'),
            'start_time' => $m->start_time,
            'end_time' => $m->end_time,
            'actual_end_time' => $m->actual_end_time,
            'reject_reason' => $m->reject_reason,
            'teams' => $m->teams->map(fn ($t) => $t->name),
            'rt_label' => MeetingQueueService::realtimeStatus($m)['label'] ?? '-',
            'assets' => $m->assets->map(fn ($a) => [
                'name' => $a->name,
                'quantity' => $a->pivot->quantity,
            ]),
            'mom' => $m->mom ? [
                'id' => $m->mom->id,
                'status' => $m->mom->status,
                'summary' => $m->mom->summary,
                'decisions' => $m->mom->decisions,
                'action_plan' => $m->mom->action_plan,
                'pic' => $m->mom->pic,
                'creator_name' => $m->mom->creator->name ?? null,
                'sent_at' => $m->mom->sent_at?->format('d M Y H:i'),
                'file_url' => $m->mom->file_path ? route('files.show', $m->mom->file_path) : null,
            ] : null,
        ]);

        $totalMeeting = Meeting::where('requested_by', $userId)->count();
        $menungguMeeting = Meeting::where('requested_by', $userId)->where('status', 'pending')->count();
        $disetujuiMeeting = Meeting::where('requested_by', $userId)->whereIn('status', ['approved', 'confirmed', 'in_progress', 'completed'])->count();
        $ditolakMeeting = Meeting::where('requested_by', $userId)->where('status', 'rejected')->count();

        $rooms = Room::where('is_active', true)->get();
        $teams = Team::where('is_active', true)->get();
        $assets = Asset::where('is_active', true)->get();
        $users = User::where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('leader.meetings.index', compact(
            'meetings', 'meetingsJson', 'totalMeeting', 'menungguMeeting', 'disetujuiMeeting', 'ditolakMeeting', 'search', 'status',
            'rooms', 'teams', 'assets', 'users'
        ));
    }

    public function create()
    {
        return view('leader.meetings.create', [
            'rooms' => Room::where('is_active', true)->get(),
            'teams' => Team::where('is_active', true)->get(),
            'assets' => Asset::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'meeting_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'why' => 'required|string',
            'what' => 'required|string',
            'how_expected' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'extra_teams' => 'nullable|array',
            'extra_teams.*' => 'exists:teams,id',
            'main_team_id' => 'required_if:team_id,null|nullable|exists:teams,id',
        ]);

        // Tentukan team_id: koordinator pakai team sendiri, head_of_store/gm pilih dari form
        $teamId = auth()->user()->team_id ?? $request->main_team_id;

        $room = Room::findOrFail($request->room_id);

        // Cek konflik waktu milik sendiri di hari yang sama (prioritas utama)
        $ownConflict = Meeting::where('requested_by', auth()->id())
            ->where('meeting_date', $request->meeting_date)
            ->whereIn('status', ['pending', 'approved', 'confirmed', 'in_progress'])
            ->where(function ($q) use ($request) {
                $q->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($ownConflict) {
            return back()->withErrors(['title' => 'Kamu sudah memiliki meeting di waktu yang sama.'])->withInput();
        }

        // Cek apakah ruangan sudah dibooking orang lain di waktu yang sama
        $conflict = Meeting::where('room_id', $request->room_id)
            ->where('meeting_date', $request->meeting_date)
            ->where('requested_by', '!=', auth()->id())
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->where('queue_position', 0)
            ->where(function ($q) use ($request) {
                $q->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->first();

        if ($conflict) {
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('meeting-files', 'public');
            }

            session()->put('override_meeting_data', [
                'title' => $request->title,
                'team_id' => $teamId,
                'why' => $request->why,
                'what' => $request->what,
                'how_expected' => $request->how_expected,
                'meeting_date' => $request->meeting_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'file_path' => $filePath,
                'extra_teams' => $request->extra_teams ?? [],
                'assets' => $request->assets ?? [],
                'conflict_meeting_id' => $conflict->id,
            ]);

            return redirect()->route('override.create');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('meeting-files', 'public');
        }

        $meeting = Meeting::create([
            'title' => $request->title,
            'room_id' => $request->room_id,
            'requested_by' => auth()->id(),
            'team_id' => $teamId,
            'why' => $request->why,
            'what' => $request->what,
            'meeting_date' => $request->meeting_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'how_expected' => $request->how_expected,
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        // Simpan tim tambahan
        if ($request->extra_teams) {
            $meeting->teams()->attach($request->extra_teams);
        }

        // Simpan asset
        if ($request->assets) {
            foreach ($request->assets as $assetId => $qty) {
                if ($qty > 0) {
                    $meeting->assets()->attach($assetId, ['quantity' => $qty]);
                }
            }
        }

        // Auto-approve jika yang request adalah HR
        if (auth()->user()->role === 'hr') {
            $meeting->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            app(MeetingQueueService::class)->assignQueue($meeting);

            $members = User::whereIn('team_id', $meeting->allTeamIds())->get();
            foreach ($members as $member) {
                MeetingInvitation::firstOrCreate(
                    ['meeting_id' => $meeting->id, 'user_id' => $member->id],
                    ['is_read' => false]
                );
            }

            $memberIds = $members->pluck('id')->reject(fn ($id) => $id === auth()->id())->toArray();
            if (! empty($memberIds)) {
                Notification::sendToMany($memberIds, 'meeting',
                    'Undangan Meeting Baru 📅',
                    'Kamu diundang ke meeting: '.$meeting->title.' pada '.$meeting->meeting_date->format('d M Y'),
                    route('invitation.index')
                );
            }

            return redirect()->route('koordinator.meetings.index')->with('success', 'Meeting berhasil dibuat dan langsung disetujui.');
        }

        // Notif ke semua FULL_ACCESS_ROLES bahwa ada request meeting baru
        $approverIds = User::whereIn('role', User::FULL_ACCESS_ROLES)->pluck('id')->toArray();
        Notification::sendToMany($approverIds, 'activity',
            'Request Meeting Baru',
            auth()->user()->name.' mengajukan request meeting: '.$meeting->title,
            route('admin.meetings.show', $meeting)
        );

        return redirect()->route('koordinator.meetings.index')->with('success', 'Request meeting berhasil dikirim ke Admin HR.');
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['room', 'team', 'teams', 'assets', 'mom.creator']);

        return view('leader.meetings.show', compact('meeting'));
    }

    public function confirm(Meeting $meeting)
    {
        if ($meeting->requested_by !== auth()->id()) {
            abort(403);
        }
        $meeting->update(['status' => 'confirmed']);

        // Notif ke semua FULL_ACCESS_ROLES bahwa meeting dikonfirmasi
        $approverIds = User::whereIn('role', User::FULL_ACCESS_ROLES)->pluck('id')->toArray();
        Notification::sendToMany($approverIds, 'activity',
            'Meeting Dikonfirmasi',
            auth()->user()->name.' mengkonfirmasi kehadiran: '.$meeting->title,
            route('admin.meetings.show', $meeting)
        );

        return back()->with('success', 'Kehadiran dikonfirmasi.');
    }

    public function cancel(Meeting $meeting)
    {
        if ($meeting->requested_by !== auth()->id()) {
            abort(403);
        }
        $meeting->update(['status' => 'cancelled']);

        // Notif ke semua FULL_ACCESS_ROLES bahwa meeting dibatalkan
        $approverIds = User::whereIn('role', User::FULL_ACCESS_ROLES)->pluck('id')->toArray();
        Notification::sendToMany($approverIds, 'activity',
            'Meeting Dibatalkan',
            auth()->user()->name.' membatalkan meeting: '.$meeting->title,
            route('admin.meetings.show', $meeting)
        );

        return back()->with('success', 'Meeting dibatalkan.');
    }

    public function finish(Request $request, Meeting $meeting)
    {
        if ($meeting->requested_by !== auth()->id()) {
            abort(403);
        }

        $actualEnd = $request->actual_end_time ?? now()->format('H:i:s');

        $meeting->update([
            'status' => 'completed',
            'actual_end_time' => $actualEnd,
        ]);

        // Geser antrian berikutnya
        app(MeetingQueueService::class)->shiftQueue($meeting);

        // Tandai semua undangan sudah dibaca
        $meeting->invitations()->update(['is_read' => true, 'read_at' => now()]);

        // Notif ke semua FULL_ACCESS_ROLES bahwa meeting selesai
        $approverIds = User::whereIn('role', User::FULL_ACCESS_ROLES)->pluck('id')->toArray();
        Notification::sendToMany($approverIds, 'activity',
            'Meeting Selesai',
            $meeting->title.' telah diselesaikan oleh '.auth()->user()->name,
            route('admin.meetings.show', $meeting)
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Meeting diselesaikan.',
                'show_mom' => true,
                'meeting_id' => $meeting->id,
                'meeting' => [
                    'id' => $meeting->id,
                    'title' => $meeting->title,
                    'meeting_date' => $meeting->meeting_date?->format('d M Y'),
                    'start_time' => $meeting->start_time,
                    'end_time' => $meeting->end_time,
                    'actual_end_time' => $meeting->actual_end_time,
                    'room' => $meeting->room ? $meeting->room->name : null,
                    'status' => $meeting->status,
                ],
            ]);
        }

        return redirect()->route('koordinator.meetings.index')
            ->with('success', 'Meeting diselesaikan. Silakan buat MOM.')
            ->with('mom_meeting_id', $meeting->id);
    }

    public function edit(Meeting $meeting)
    {
        return view('leader.meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        return back()->with('error', 'Fitur edit belum tersedia.');
    }

    public function destroy(Meeting $meeting)
    {
        if ($meeting->requested_by !== auth()->id()) {
            abort(403);
        }

        $title = $meeting->title;
        $meeting->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Meeting berhasil dihapus.',
                'redirect' => route('koordinator.meetings.index'),
            ]);
        }

        return redirect()->route('koordinator.meetings.index')
            ->with('success', 'Meeting "'.$title.'" berhasil dihapus.');
    }
}
