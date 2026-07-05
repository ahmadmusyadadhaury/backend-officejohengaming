<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Mom;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MomController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Mom::with(['meeting.room', 'meeting.requester', 'creator'])
            ->where('created_by', $userId)
            ->latest();

        $moms = $query->paginate(20);

        $momsJson = $moms->map(function ($mom) {
            return [
                'id' => $mom->id,
                'judul_meeting' => $mom->meeting->title ?? '—',
                'tanggal_meeting' => $mom->meeting->meeting_date ? $mom->meeting->meeting_date->format('d M Y') : '—',
                'dibuat_oleh' => $mom->creator->name ?? '—',
                'pic' => $mom->pic ?? '—',
                'dikirim' => $mom->sent_at ? $mom->sent_at->format('d M Y H:i') : '—',
                'status' => $mom->meeting->status ?? '—',
                'mom_status' => $mom->status,
                'file_path' => $mom->file_path,
                'file_name' => $mom->file_path ? basename($mom->file_path) : null,
                'file_url' => $mom->file_path ? url('storage/'.$mom->file_path) : null,
                'why' => $mom->meeting->why ?? '',
                'what' => $mom->meeting->what ?? '',
                'how' => $mom->meeting->how_expected ?? '',
                'summary' => $mom->summary ?? '',
                'decisions' => $mom->decisions ?? '',
                'action_plan' => $mom->action_plan ?? '',
            ];
        });

        $momStats = [
            'total_moms' => Mom::where('created_by', $userId)->count(),
            'sent_moms' => Mom::where('created_by', $userId)->where('status', 'sent')->count(),
            'draft_moms' => Mom::where('created_by', $userId)->where('status', 'draft')->count(),
        ];

        return view('leader.mom.index', compact('moms', 'momStats', 'momsJson'));
    }

    public function create(Meeting $meeting)
    {
        return view('leader.mom.create', compact('meeting'));
    }

    public function store(Request $request, Meeting $meeting)
    {
        $request->validate([
            'summary' => 'required|string',
            'decisions' => 'required|string',
            'action_plan' => 'required|string',
            'pic' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'action' => 'nullable|in:draft,send',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('mom-files', 'public');
        }

        $mom = Mom::create([
            'meeting_id' => $meeting->id,
            'created_by' => auth()->id(),
            'summary' => $request->summary,
            'decisions' => $request->decisions,
            'action_plan' => $request->action_plan,
            'pic' => $request->pic,
            'file_path' => $filePath,
            'status' => 'draft',
        ]);

        if ($request->input('action') === 'send') {
            $this->sendMom($mom);
            $message = 'MOM berhasil dibuat dan dikirim.';
        } else {
            $message = 'MOM berhasil disimpan sebagai draft.';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'mom_id' => $mom->id,
            ]);
        }

        return redirect()->route('koordinator.meetings.show', $meeting)->with('success', $message);
    }

    public function show(Mom $mom)
    {
        return view('leader.mom.show', compact('mom'));
    }

    public function edit(Mom $mom)
    {
        if ($mom->status === 'sent') {
            abort(403, 'MOM sudah dikirim, tidak bisa diedit.');
        }

        return view('leader.mom.edit', compact('mom'));
    }

    public function update(Request $request, Mom $mom)
    {
        if ($mom->status === 'sent') {
            abort(403);
        }
        $request->validate([
            'summary' => 'required',
            'decisions' => 'required',
            'action_plan' => 'required',
            'pic' => 'required',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $data = $request->only('summary', 'decisions', 'action_plan', 'pic');

        if ($request->hasFile('file')) {
            if ($mom->file_path) {
                Storage::disk('public')->delete($mom->file_path);
            }
            $data['file_path'] = $request->file('file')->store('mom-files', 'public');
        }

        $mom->update($data);

        return redirect()->route('koordinator.meetings.show', $mom->meeting_id)->with('success', 'MOM diperbarui.');
    }

    public function send(Mom $mom, Request $request)
    {
        if ($mom->status === 'sent') {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'MOM sudah dikirim.'])
                : back()->with('error', 'MOM sudah dikirim.');
        }

        $this->sendMom($mom);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'MOM berhasil dikirim.']);
        }

        return back()->with('success', 'MOM berhasil dikirim.');
    }

    private function sendMom(Mom $mom): void
    {
        $mom->update(['status' => 'sent', 'sent_at' => now()]);

        $meeting = $mom->meeting;
        $url = route('admin.meetings.show', $meeting);

        // 1. Semua anggota tim (tim koordinator + tim tambahan)
        $teamMemberIds = User::whereIn('team_id', $meeting->allTeamIds())
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();

        // 2. Peserta individu (meeting_participants)
        $participantIds = $meeting->participants()->pluck('users.id')->toArray();

        // 3. Semua admin (FULL_ACCESS_ROLES)
        $adminIds = User::whereIn('role', User::FULL_ACCESS_ROLES)
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();

        // Gabung & unique, termasuk pembuat sendiri
        $allIds = array_unique(array_merge(
            $teamMemberIds,
            $participantIds,
            $adminIds,
            [$mom->created_by]
        ));

        Notification::sendToMany($allIds, 'activity',
            'MOM Terkirim 📄',
            'Minutes of Meeting untuk "'.$meeting->title.'" telah dikirim.',
            $url
        );
    }

    public function destroy(Mom $mom)
    {
        return back()->with('error', 'MOM tidak bisa dihapus.');
    }
}
