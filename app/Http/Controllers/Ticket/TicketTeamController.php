<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\TicketTeamMember;
use App\Models\User;
use Illuminate\Http\Request;

class TicketTeamController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $members = TicketTeamMember::with('user')->latest()->get();
        $memberIds = $members->pluck('user_id');
        $candidates = User::query()
            ->where('is_active', true)
            ->whereNotIn('id', $memberIds)
            ->orderBy('name')
            ->get();

        return view('tickets.team', compact('members', 'candidates'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'is_leader' => 'nullable|boolean',
        ]);

        $exists = TicketTeamMember::where('user_id', $data['user_id'])->exists();

        if ($exists) {
            return back()->with('error', 'User tersebut sudah menjadi anggota tim IT.');
        }

        TicketTeamMember::create([
            'user_id' => $data['user_id'],
            'is_leader' => ! empty($data['is_leader']),
        ]);

        return back()->with('success', 'Anggota tim IT berhasil ditambahkan.');
    }

    public function update(Request $request, TicketTeamMember $member)
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $data = $request->validate([
            'is_leader' => 'nullable|boolean',
        ]);

        $member->update(['is_leader' => ! empty($data['is_leader'])]);

        return back()->with('success', 'Role anggota diperbarui.');
    }

    public function destroy(TicketTeamMember $member)
    {
        abort_unless(auth()->user()->isTicketLeader(), 403);

        $member->delete();

        return back()->with('success', 'Anggota tim IT dihapus.');
    }
}
