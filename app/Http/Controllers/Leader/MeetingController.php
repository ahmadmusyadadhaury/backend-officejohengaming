<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Meeting;
use App\Models\Room;
use App\Models\Team;
use App\Services\MeetingQueueService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with(['room', 'team', 'teams'])
            ->where('requested_by', auth()->id())
            ->latest()->paginate(10);
        return view('leader.meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('leader.meetings.create', [
            'rooms'  => Room::where('is_active', true)->get(),
            'teams'  => Team::where('is_active', true)->get(),
            'assets' => Asset::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'room_id'      => 'required|exists:rooms,id',
            'meeting_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required',
            'end_time'     => 'required|after:start_time',
            'why'          => 'required|string',
            'what'         => 'required|string',
            'how_expected' => 'required|string',
            'file'         => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'extra_teams'  => 'nullable|array',
            'extra_teams.*'=> 'exists:teams,id',
            'main_team_id' => 'required_if:team_id,null|nullable|exists:teams,id',
        ]);

        // Tentukan team_id: koordinator pakai team sendiri, head_of_store/gm pilih dari form
        $teamId = auth()->user()->team_id ?? $request->main_team_id;

        $room = Room::findOrFail($request->room_id);

        // Tidak ada validasi konflik — sistem antrian yang mengatur
        $activeMeeting = Meeting::where('requested_by', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'confirmed', 'in_progress'])
            ->exists();
        if ($activeMeeting) {
            return back()->withErrors(['title' => 'Kamu masih memiliki meeting aktif.'])->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('meeting-files', 'public');
        }

        $meeting = Meeting::create([
            'title'        => $request->title,
            'room_id'      => $request->room_id,
            'requested_by' => auth()->id(),
            'team_id'      => $teamId,
            'why'          => $request->why,
            'what'         => $request->what,
            'meeting_date' => $request->meeting_date,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'how_expected' => $request->how_expected,
            'file_path'    => $filePath,
            'status'       => 'pending',
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

        return redirect()->route('koordinator.meetings.index')->with('success', 'Request meeting berhasil dikirim ke Admin HR.');
    }

    public function show(Meeting $meeting)
    {
        $meeting->load(['room', 'team', 'teams', 'assets', 'mom']);
        return view('leader.meetings.show', compact('meeting'));
    }

    public function confirm(Meeting $meeting)
    {
        if ($meeting->requested_by !== auth()->id()) abort(403);
        $meeting->update(['status' => 'confirmed']);
        return back()->with('success', 'Kehadiran dikonfirmasi.');
    }

    public function cancel(Meeting $meeting)
    {
        if ($meeting->requested_by !== auth()->id()) abort(403);
        $meeting->update(['status' => 'cancelled']);
        return back()->with('success', 'Meeting dibatalkan.');
    }

    public function finish(Request $request, Meeting $meeting)
    {
        if ($meeting->requested_by !== auth()->id()) abort(403);

        $actualEnd = $request->actual_end_time ?? now()->format('H:i:s');

        $meeting->update([
            'status'          => 'completed',
            'actual_end_time' => $actualEnd,
        ]);

        // Geser antrian berikutnya
        app(MeetingQueueService::class)->shiftQueue($meeting);

        // Tandai semua undangan sudah dibaca
        $meeting->invitations()->update(['is_read' => true, 'read_at' => now()]);

        return back()->with('success', 'Meeting diselesaikan. Antrian berikutnya otomatis dimulai.');
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
        return back()->with('error', 'Gunakan fitur batalkan meeting.');
    }
}
