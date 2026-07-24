<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::withCount('members');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $teams = $query->orderBy('name')->paginate(15)->withQueryString();

        $allTeams = Team::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        $availableUsers = User::whereNull('team_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $availableUsersJson = $availableUsers->map(fn($u) => [
            'id' => $u->id,
            'name' => $u->name,
            'username' => $u->username,
            'role' => $u->role_label,
            'initial' => strtoupper(substr($u->name, 0, 1)),
        ])->values();

        return view('admin.teams.index', compact('teams', 'allTeams', 'availableUsers', 'availableUsersJson'));
    }

    public function show(Team $team)
    {
        $team->load(['members', 'leader']);
        $memberIds = $team->members->pluck('id')->toArray();

        $availableUsers = User::whereNull('team_id')
            ->where('is_active', true)
            ->whereNotIn('id', $memberIds)
            ->orderBy('name')
            ->get();

        if (request()->expectsJson()) {
            return response()->json([
                'team' => [
                    'id' => $team->id,
                    'name' => $team->name,
                    'description' => $team->description,
                    'is_active' => $team->is_active,
                    'leader' => $team->leader ? ['id' => $team->leader->id, 'name' => $team->leader->name] : null,
                ],
                'members' => $team->members->map(fn($m) => [
                    'id' => $m->id,
                    'name' => $m->name,
                    'username' => $m->username,
                    'role' => $m->role_label,
                    'role_key' => $m->role,
                    'initial' => strtoupper(substr($m->name, 0, 1)),
                    'avatar_url' => $m->avatar_url,
                ]),
                'available_users' => $availableUsers->map(fn($u) => [
                    'id' => $u->id,
                    'name' => $u->name,
                    'username' => $u->username,
                    'role' => $u->role_label,
                    'initial' => strtoupper(substr($u->name, 0, 1)),
                ])->values(),
                'routes' => [
                    'add_member' => route('admin.teams.members.store', $team),
                    'remove_member_base' => route('admin.teams.members.destroy', [$team, '_USER_']),
                ],
            ]);
        }

        return view('admin.teams.show', compact('team', 'availableUsers'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Team::create(
            $request->only('name', 'description') + ['is_active' => $request->boolean('is_active')]
        );

        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil ditambahkan.');
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->update($request->only('name', 'description', 'is_active'));

        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil diperbarui.');
    }

    public function destroy(Team $team)
    {
        User::where('team_id', $team->id)->update(['team_id' => null]);
        $team->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil dihapus.');
    }

    public function addMember(Request $request, Team $team)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->team_id && $user->team_id !== $team->id) {
            return back()->withErrors(['user_id' => 'User ini sudah tergabung di tim lain.']);
        }

        $user->update(['team_id' => $team->id]);

        return back()->with('success', "Berhasil menambahkan {$user->name} ke tim {$team->name}.");
    }

    public function removeMember(Team $team, User $user)
    {
        if ($user->team_id !== $team->id) {
            return back()->withErrors(['error' => 'User ini bukan anggota tim ini.']);
        }

        $user->update(['team_id' => null]);

        return back()->with('success', "Berhasil menghapus {$user->name} dari tim {$team->name}.");
    }
}
