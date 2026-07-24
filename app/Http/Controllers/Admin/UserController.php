<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Koordinator + admin_ga
        $query = User::with('team')
            ->whereIn('role', ['koordinator', 'admin_ga']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhereHas('team', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        // Karyawan (role user)
        $karyawanQuery = User::with('team')->where('role', 'user');

        if ($search = $request->input('search')) {
            $karyawanQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhereHas('team', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $karyawanQuery->where('is_active', true);
            } elseif ($status === 'inactive') {
                $karyawanQuery->where('is_active', false);
            }
        }

        $karyawans = $karyawanQuery->orderBy('name')->paginate(10, ['*'], 'karyawan_page')->withQueryString();
        $teams = Team::where('is_active', true)->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'karyawans', 'teams'));
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
            'role' => 'required|in:koordinator,user,admin_ga',
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
            'role' => 'required|in:koordinator,user,admin_ga',
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

    public function storeKaryawan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'team_id' => $request->team_id,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun karyawan berhasil dibuat.');
    }

    public function updateKaryawan(Request $request, User $karyawan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,'.$karyawan->id,
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'team_id' => $request->team_id,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $karyawan->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun karyawan berhasil diperbarui.');
    }

    public function destroyKaryawan(User $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun karyawan berhasil dihapus.');
    }
}
