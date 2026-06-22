<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('team')
            ->whereNotIn('role', ['admin', 'head_of_store', 'gm', 'hr', 'ceo'])
            ->paginate(15);

        $breakdown = [
            'total_ceo'         => User::where('role', 'ceo')->where('is_active', true)->count(),
            'total_gm'          => User::where('role', 'gm')->where('is_active', true)->count(),
            'total_head_store'  => User::where('role', 'head_of_store')->where('is_active', true)->count(),
            'total_hr'          => User::where('role', 'hr')->where('is_active', true)->count(),
            'total_koordinator' => User::where('role', 'koordinator')->where('is_active', true)->count(),
            'total_karyawan'    => User::where('role', 'user')->where('is_active', true)->count(),
            'total_team'        => Team::count(),
        ];

        return view('admin.users.index', compact('users', 'breakdown'));
    }

    public function create()
    {
        $teams = Team::where('is_active', true)->get();

        return view('admin.users.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:koordinator,user',
            'team_id' => 'required_if:role,koordinator,user|nullable|exists:teams,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'team_id' => in_array($request->role, ['koordinator', 'user']) ? $request->team_id : null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $teams = Team::where('is_active', true)->get();

        return view('admin.users.edit', compact('user', 'teams'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'role' => 'required|in:koordinator,user',
            'team_id' => 'required_if:role,koordinator,user|nullable|exists:teams,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'team_id' => in_array($request->role, ['koordinator', 'user']) ? $request->team_id : null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
