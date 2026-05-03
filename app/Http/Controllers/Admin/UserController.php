<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return view('admin.users.index', ['users' => User::with('team')->where('role', '!=', 'admin')->paginate(15)]);
    }

    public function create() {
        return view('admin.users.create', ['teams' => Team::where('is_active', true)->get()]);
    }

    public function store(Request $request) {
        $request->validate([
            'nik'      => 'required|string|unique:users,nik',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:leader,user',
            'team_id'  => 'required|exists:teams,id',
        ]);

        $isLeader = $request->role === 'leader' && $request->boolean('is_leader');

        // Jika is_leader, pastikan tim belum punya leader
        if ($isLeader) {
            $existing = User::where('team_id', $request->team_id)->where('is_leader', true)->exists();
            if ($existing) {
                return back()->withErrors(['is_leader' => 'Tim ini sudah memiliki kepala tim.'])->withInput();
            }
        }

        User::create([
            'nik'       => $request->nik,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'team_id'   => $request->team_id,
            'is_leader' => $isLeader,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user) {
        return view('admin.users.edit', ['user' => $user, 'teams' => Team::where('is_active', true)->get()]);
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role'    => 'required|in:leader,user',
            'team_id' => 'required|exists:teams,id',
        ]);

        $isLeader = $request->role === 'leader' && $request->boolean('is_leader');

        if ($isLeader && !$user->is_leader) {
            $existing = User::where('team_id', $request->team_id)->where('is_leader', true)->where('id', '!=', $user->id)->exists();
            if ($existing) {
                return back()->withErrors(['is_leader' => 'Tim ini sudah memiliki kepala tim.'])->withInput();
            }
        }

        $data = $request->only('name', 'email', 'role', 'team_id', 'is_active') + ['is_leader' => $isLeader];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
