<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingApiController extends Controller
{
    /**
     * Display a listing of meetings.
     */
    public function index(Request $request)
    {
        $query = Meeting::with([
            'requester:id,name,username',
            'team:id,name',
            'teams:id,name',
            'room:id,name,location,capacity',
            'assets:id,name',
            'mom.creator:id,name',
            'participants:id,name,username',
        ]);

        if ($request->filled('date_from')) {
            $query->whereDate('meeting_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('meeting_date', '<=', $request->date_to);
        }

        if ($request->filled('month')) {
            $query->whereMonth('meeting_date', substr($request->month, 5, 2))
                ->whereYear('meeting_date', substr($request->month, 0, 4));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $query->orderBy('meeting_date')->orderBy('start_time');

        $perPage = $request->filled('per_page') ? (int) $request->per_page : null;
        $meetings = $perPage ? $query->paginate($perPage) : $query->get();

        $data = $meetings->map(fn ($m) => $this->format($m));

        return response()->json($perPage ? [
            'data' => $data,
            'pagination' => [
                'current_page' => $meetings->currentPage(),
                'last_page' => $meetings->lastPage(),
                'per_page' => $meetings->perPage(),
                'total' => $meetings->total(),
            ],
        ] : $data);
    }

    /**
     * Display the specified meeting.
     */
    public function show(Meeting $meeting)
    {
        $meeting->load([
            'requester:id,name,username',
            'team:id,name',
            'teams:id,name',
            'room:id,name,location,capacity',
            'assets:id,name',
            'mom.creator:id,name',
            'participants:id,name,username',
        ]);

        return response()->json($this->format($meeting));
    }

    private function format(Meeting $m): array
    {
        return [
            'id' => $m->id,
            'title' => $m->title,
            'why' => $m->why,
            'what' => $m->what,
            'how_expected' => $m->how_expected,
            'where_detail' => $m->where_detail,
            'who_summary' => $m->who_summary,
            'requester' => $m->requester ? [
                'id' => $m->requester->id,
                'name' => $m->requester->name,
            ] : null,
            'team' => $m->team ? [
                'id' => $m->team->id,
                'name' => $m->team->name,
            ] : null,
            'teams' => $m->teams->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
            ]),
            'room' => $m->room ? [
                'id' => $m->room->id,
                'name' => $m->room->name,
                'location' => $m->room->location,
            ] : null,
            'meeting_date' => $m->meeting_date?->format('Y-m-d'),
            'start_time' => $m->start_time,
            'end_time' => $m->end_time,
            'actual_end_time' => $m->actual_end_time,
            'status' => $m->status,
            'queue_position' => $m->queue_position,
            'reject_reason' => $m->reject_reason,
            'is_weekly' => (bool) $m->is_weekly,
            'weekly_day' => $m->weekly_day,
            'weekly_time' => $m->weekly_time,
            'approved_by' => $m->approved_by,
            'approved_at' => $m->approved_at?->toDateTimeString(),
            'assets' => $m->assets->map(fn ($a) => [
                'id' => $a->id,
                'name' => $a->name,
                'quantity' => $a->pivot->quantity,
            ]),
            'participants' => $m->participants->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'status' => $p->pivot->status,
            ]),
            'mom' => $m->mom ? [
                'status' => $m->mom->status,
                'summary' => $m->mom->summary,
                'decisions' => $m->mom->decisions,
                'action_plan' => $m->mom->action_plan,
                'pic' => $m->mom->pic,
                'creator_name' => $m->mom->creator->name ?? null,
                'sent_at' => $m->mom->sent_at?->format('Y-m-d H:i:s'),
                'file_url' => $m->mom->file_path ? route('files.show', $m->mom->file_path) : null,
            ] : null,
            'created_at' => $m->created_at?->toDateTimeString(),
            'updated_at' => $m->updated_at?->toDateTimeString(),
        ];
    }
}
