<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Meeting;
use App\Models\Room;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index() {
        $meetings = Meeting::with(['room', 'team'])
            ->where('requested_by', auth()->id())
            ->latest()->paginate(10);
        return view('leader.meetings.index', compact('meetings'));
    }

    public function create() {
        return view('leader.meetings.create', [
            'rooms'  => Room::where('is_active', true)->get(),
            'teams'  => Team::where('is_active', true)->get(),
            'assets' => Asset::where('is_active', true)->get(),
            'users'  => User::where('team_id', auth()->user()->team_id)->where('id', '!=', auth()->id())->get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title'        => 'required|string|max:255',
            'room_id'      => 'required|exists:rooms,id',
            'meeting_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required',
            'end_time'     => 'required|after:start_time',
            'why'          => 'required|string',
            'what'         => 'required|string',
            'how_expected' => 'required|string',
        ]);

        // Cek konflik ruangan
        $room = Room::findOrFail($request->room_id);
        if (!$room->isAvailable($request->meeting_date, $request->start_time, $request->end_time)) {
            return back()->withErrors(['room_id' => 'Ruangan tidak tersedia pada waktu tersebut.'])->withInput();
        }

        // Cek leader tidak punya meeting aktif
        $activeMeeting = Meeting::where('requested_by', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'confirmed', 'in_progress'])
            ->exists();
        if ($activeMeeting) {
            return back()->withErrors(['title' => 'Kamu masih memiliki meeting aktif. Selesaikan atau batalkan terlebih dahulu.'])->withInput();
        }

        $meeting = Meeting::create([
            'title'          => $request->title,
            'room_id'        => $request->room_id,
            'requested_by'   => auth()->id(),
            'team_id'        => auth()->user()->team_id,
            'second_team_id' => $request->second_team_id,
            'why'            => $request->why,
            'what'           => $request->what,
            'meeting_date'   => $request->meeting_date,
            'start_time'     => $request->start_time,
            'end_time'       => $request->end_time,
            'where_detail'   => $request->where_detail,
            'who_summary'    => $request->who_summary,
            'how_expected'   => $request->how_expected,
            'status'         => 'pending',
        ]);

        // Tambah peserta
        if ($request->participants) {
            $meeting->participants()->attach($request->participants, ['status' => 'invited']);
        }

        // Tambah asset
        if ($request->assets) {
            foreach ($request->assets as $assetId => $qty) {
                if ($qty > 0) {
                    $meeting->assets()->attach($assetId, ['quantity' => $qty]);
                }
            }
        }

        return redirect()->route('leader.meetings.index')->with('success', 'Request meeting berhasil dikirim ke Admin HR.');
    }

    public function show(Meeting $meeting) {
        $meeting->load(['room', 'team', 'secondTeam', 'participants', 'assets', 'mom']);
        return view('leader.meetings.show', compact('meeting'));
    }

    public function confirm(Meeting $meeting) {
        if ($meeting->requested_by !== auth()->id()) abort(403);
        $meeting->update(['status' => 'confirmed']);
        return back()->with('success', 'Kehadiran dikonfirmasi. Meeting akan berlangsung.');
    }

    public function cancel(Meeting $meeting) {
        if ($meeting->requested_by !== auth()->id()) abort(403);
        $meeting->update(['status' => 'cancelled']);
        return back()->with('success', 'Meeting dibatalkan.');
    }

    public function finish(Request $request, Meeting $meeting) {
        if ($meeting->requested_by !== auth()->id()) abort(403);
        $meeting->update(['status' => 'completed', 'actual_end_time' => $request->actual_end_time ?? now()->format('H:i:s')]);
        return back()->with('success', 'Meeting diselesaikan.');
    }

    public function edit(Meeting $meeting) {
        return view('leader.meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting) {
        return back()->with('error', 'Fitur edit belum tersedia.');
    }

    public function destroy(Meeting $meeting) {
        return back()->with('error', 'Gunakan fitur batalkan meeting.');
    }
}
