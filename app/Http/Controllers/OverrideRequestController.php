<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingOverrideRequest;
use App\Models\Notification;
use App\Models\User;
use App\Services\MeetingQueueService;
use Illuminate\Http\Request;

class OverrideRequestController extends Controller
{
    public function create()
    {
        if (!session()->has('override_meeting_data')) {
            return redirect()->route('koordinator.meetings.create')
                ->with('error', 'Sesi telah berakhir. Silakan isi form kembali.');
        }

        $data = session('override_meeting_data');
        $conflict = Meeting::with(['room', 'requester', 'team'])
            ->findOrFail($data['conflict_meeting_id']);

        return view('override.create', compact('data', 'conflict'));
    }

    public function store(Request $request, MeetingQueueService $queue)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        if (!session()->has('override_meeting_data')) {
            return redirect()->route('koordinator.meetings.create')
                ->with('error', 'Sesi telah berakhir. Silakan isi form kembali.');
        }

        $data = session('override_meeting_data');
        $conflict = Meeting::findOrFail($data['conflict_meeting_id']);

        $stillConflicts = Meeting::where('room_id', $conflict->room_id)
            ->where('meeting_date', $conflict->meeting_date)
            ->where('id', $conflict->id)
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->where(function ($q) use ($data) {
                $q->where('start_time', '<', $data['end_time'])
                  ->where('end_time', '>', $data['start_time']);
            })
            ->exists();

        if (!$stillConflicts) {
            session()->forget('override_meeting_data');
            return redirect()->route('koordinator.meetings.create')
                ->with('success', 'Ruangan sudah tersedia. Silakan submit ulang.');
        }

        $meeting = Meeting::create([
            'title'        => $data['title'],
            'room_id'      => $conflict->room_id,
            'requested_by' => auth()->id(),
            'team_id'      => $data['team_id'],
            'why'          => $data['why'],
            'what'         => $data['what'],
            'meeting_date' => $data['meeting_date'],
            'start_time'   => $data['start_time'],
            'end_time'     => $data['end_time'],
            'how_expected' => $data['how_expected'],
            'file_path'    => $data['file_path'] ?? null,
            'status'       => 'pending',
        ]);

        if (!empty($data['extra_teams'])) {
            $meeting->teams()->attach($data['extra_teams']);
        }

        if (!empty($data['assets'])) {
            foreach ($data['assets'] as $assetId => $qty) {
                if ($qty > 0) {
                    $meeting->assets()->attach($assetId, ['quantity' => $qty]);
                }
            }
        }

        $override = MeetingOverrideRequest::create([
            'requester_meeting_id' => $meeting->id,
            'target_meeting_id'    => $conflict->id,
            'reason'               => $request->reason,
            'status'               => 'pending',
        ]);

        Notification::send($conflict->requested_by, 'activity',
            'Permintaan Override Booking ⚠️',
            auth()->user()->name . ' (Tim ' . $meeting->team->name . ') ingin memindahkan booking meeting "' . $conflict->title . '". Alasan: ' . $request->reason,
            route('override.show', $override)
        );

        $adminHrIds = User::whereIn('role', ['admin', 'hr'])->pluck('id')->toArray();
        Notification::sendToMany($adminHrIds, 'activity',
            'Request Meeting + Override',
            auth()->user()->name . ' (Tim ' . $meeting->team->name . ') mengajukan override untuk "' . $conflict->title . '". Meeting: ' . $meeting->title,
            route('admin.meetings.show', $meeting)
        );

        session()->forget('override_meeting_data');

        return redirect()->route('koordinator.meetings.index')
            ->with('success', 'Permintaan override telah dikirim ke pemilik booking. Menunggu persetujuan.');
    }

    public function show(MeetingOverrideRequest $override)
    {
        $override->load([
            'requesterMeeting.requester', 'requesterMeeting.room', 'requesterMeeting.team',
            'targetMeeting.requester', 'targetMeeting.room', 'targetMeeting.team',
        ]);

        $canRespond = $override->status === 'pending'
            && auth()->id() === $override->targetMeeting->requested_by;

        return view('override.show', compact('override', 'canRespond'));
    }

    public function accept(MeetingOverrideRequest $override, MeetingQueueService $queue)
    {
        abort_if($override->status !== 'pending', 404);
        abort_if(auth()->id() !== $override->targetMeeting->requested_by, 403);

        $override->targetMeeting->update([
            'status'        => 'cancelled',
            'reject_reason' => 'Dibatalkan karena override: ' . $override->reason,
        ]);

        $override->requesterMeeting->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $queue->assignQueue($override->requesterMeeting);
        $override->update(['status' => 'accepted']);

        Notification::send($override->requesterMeeting->requested_by, 'activity',
            'Override Disetujui ✅',
            'Booking "' . $override->requesterMeeting->title . '" telah disetujui dan menggantikan booking sebelumnya.',
            route('koordinator.meetings.show', $override->requesterMeeting)
        );

        $adminHrIds = User::whereIn('role', ['admin', 'hr'])->pluck('id')->toArray();
        Notification::sendToMany($adminHrIds, 'activity',
            'Override Disetujui',
            auth()->user()->name . ' menyetujui override untuk meeting: ' . $override->requesterMeeting->title,
            route('admin.meetings.show', $override->requesterMeeting)
        );

        return redirect()->route('override.show', $override)
            ->with('success', 'Override diterima. Booking kamu dibatalkan.');
    }

    public function reject(MeetingOverrideRequest $override)
    {
        abort_if($override->status !== 'pending', 404);
        abort_if(auth()->id() !== $override->targetMeeting->requested_by, 403);

        $override->requesterMeeting->update([
            'status'        => 'rejected',
            'reject_reason' => 'Permintaan override ditolak oleh pemilik booking.',
        ]);

        $override->update(['status' => 'rejected']);

        Notification::send($override->requesterMeeting->requested_by, 'activity',
            'Override Ditolak ❌',
            'Permintaan override untuk "' . $override->requesterMeeting->title . '" ditolak oleh pemilik booking.',
            route('koordinator.meetings.show', $override->requesterMeeting)
        );

        return redirect()->route('override.show', $override)
            ->with('success', 'Override ditolak.');
    }
}
