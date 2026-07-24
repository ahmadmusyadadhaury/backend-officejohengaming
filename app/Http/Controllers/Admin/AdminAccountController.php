<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function index(Request $request)
    {
        // Fetch admin accounts (admin, head_of_store, gm, hr, ceo, admin_ga)
        $adminQuery = User::whereIn('role', ['admin', 'head_of_store', 'gm', 'hr', 'ceo', 'admin_ga']);

        if ($search = $request->input('search')) {
            $adminQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $adminQuery->where('is_active', true);
            } elseif ($status === 'inactive') {
                $adminQuery->where('is_active', false);
            }
        }

        $admins = $adminQuery->orderBy('name')->paginate(15)->withQueryString();

        // Fetch karyawan accounts (user role) with team
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

        $karyawans = $karyawanQuery->orderBy('name')->paginate(15, ['*'], 'karyawan_page')->withQueryString();
        $teams = Team::where('is_active', true)->orderBy('name')->get();

        return view('admin.admins.index', compact('admins', 'karyawans', 'teams'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,head_of_store,gm,hr,ceo,admin_ga',
        ]);

        if ($request->role === 'ceo' && User::where('role', 'ceo')->exists()) {
            return back()->withInput()->with('error', 'Akun CEO sudah ada. Hanya 1 CEO yang diperbolehkan.');
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Akun admin berhasil dibuat.');
    }

    public function edit(User $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,'.$admin->id,
            'role' => 'required|in:admin,head_of_store,gm,hr,ceo,admin_ga',
        ]);

        if ($request->role === 'ceo' && $admin->role !== 'ceo' && User::where('role', 'ceo')->exists()) {
            return back()->withInput()->with('error', 'Akun CEO sudah ada. Hanya 1 CEO yang diperbolehkan.');
        }

        $data = $request->only('name', 'username', 'role', 'is_active');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Akun admin berhasil dihapus.');
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

        return redirect()->route('admin.admins.index')->with('success', 'Akun karyawan berhasil dibuat.');
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

        return redirect()->route('admin.admins.index')->with('success', 'Akun karyawan berhasil diperbarui.');
    }

    public function destroyKaryawan(User $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Akun karyawan berhasil dihapus.');
    }
}
