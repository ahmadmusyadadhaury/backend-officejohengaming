<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingRecording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecordingController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $isFullAccess = in_array(auth()->user()->role, \App\Models\User::FULL_ACCESS_ROLES);

        $query = MeetingRecording::with(['meeting.room', 'meeting.requester', 'creator'])
            ->latest();

        if (!$isFullAccess) {
            $query->where('created_by', $userId);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('meeting', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $recordings = $query->paginate(20);

        $recordingsJson = $recordings->map(function ($rec) {
            return [
                'id' => $rec->id,
                'judul_meeting' => $rec->meeting->title ?? '—',
                'tanggal_meeting' => $rec->meeting->meeting_date ? $rec->meeting->meeting_date->format('d M Y') : '—',
                'dibuat_oleh' => $rec->creator->name ?? '—',
                'ruangan' => $rec->meeting->room->name ?? '—',
                'durasi' => $rec->duration_formatted,
                'durasi_detik' => $rec->duration,
                'status' => $rec->status,
                'finalized_at' => $rec->finalized_at ? $rec->finalized_at->format('d M Y H:i') : '—',
                'transcript' => $rec->transcript ?? '',
                'summary' => $rec->summary ?? '',
                'audio_url' => $rec->audio_path ? Storage::disk('public')->url($rec->audio_path) : null,
            ];
        });

        $stats = [
            'total' => $isFullAccess
                ? MeetingRecording::count()
                : MeetingRecording::where('created_by', $userId)->count(),
            'this_month' => $isFullAccess
                ? MeetingRecording::whereMonth('created_at', now()->month)->count()
                : MeetingRecording::where('created_by', $userId)->whereMonth('created_at', now()->month)->count(),
            'draft' => $isFullAccess
                ? MeetingRecording::where('status', 'draft')->count()
                : MeetingRecording::where('created_by', $userId)->where('status', 'draft')->count(),
            'finalized' => $isFullAccess
                ? MeetingRecording::where('status', 'finalized')->count()
                : MeetingRecording::where('created_by', $userId)->where('status', 'finalized')->count(),
        ];

        return view('admin.recordings.index', compact('recordings', 'recordingsJson', 'stats'));
    }

    public function create(Request $request)
    {
        $meetingId = $request->query('meeting');
        $meeting = null;

        if ($meetingId) {
            $meeting = Meeting::findOrFail($meetingId);
        }

        $meetings = Meeting::whereIn('status', ['completed', 'in_progress', 'confirmed'])
            ->with('room')
            ->orderBy('meeting_date', 'desc')
            ->get();

        return view('admin.recordings.create', compact('meetings', 'meeting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'meeting_id' => 'required|exists:meetings,id',
            'audio' => 'nullable|file|mimes:webm,mp3,mp4,ogg,wav|max:51200',
            'transcript' => 'nullable|string',
            'summary' => 'nullable|string',
            'duration' => 'nullable|integer|min:0',
        ]);

        $audioPath = null;
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('recording-files', 'public');
        }

        $recording = MeetingRecording::create([
            'meeting_id' => $request->meeting_id,
            'created_by' => auth()->id(),
            'audio_path' => $audioPath,
            'transcript' => $request->transcript,
            'summary' => $request->summary,
            'duration' => $request->duration ?? 0,
            'status' => 'draft',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rekap rapat berhasil disimpan.',
                'recording_id' => $recording->id,
            ]);
        }

        return redirect()->route('admin.recordings.show', $recording)
            ->with('success', 'Rekap rapat berhasil disimpan.');
    }

    public function show(MeetingRecording $recording)
    {
        $recording->load(['meeting.room', 'meeting.requester', 'creator', 'meeting.teams']);

        return view('admin.recordings.show', compact('recording'));
    }

    public function edit(MeetingRecording $recording)
    {
        $recording->load(['meeting.room', 'meeting.requester', 'creator']);

        return view('admin.recordings.edit', compact('recording'));
    }

    public function update(Request $request, MeetingRecording $recording)
    {
        $request->validate([
            'summary' => 'required|string',
            'transcript' => 'nullable|string',
        ]);

        $data = $request->only('summary', 'transcript');

        if ($request->input('action') === 'finalize') {
            $data['status'] = 'finalized';
            $data['finalized_at'] = now();
        } elseif ($request->input('action') === 'unfinalize') {
            $data['status'] = 'draft';
            $data['finalized_at'] = null;
        }

        $recording->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rekap rapat berhasil diperbarui.',
            ]);
        }

        return redirect()->route('admin.recordings.show', $recording)
            ->with('success', 'Rekap rapat berhasil diperbarui.');
    }

    public function destroy(MeetingRecording $recording)
    {
        if ($recording->audio_path && Storage::disk('public')->exists($recording->audio_path)) {
            Storage::disk('public')->delete($recording->audio_path);
        }

        $recording->delete();

        return back()->with('success', 'Rekap rapat berhasil dihapus.');
    }
}
