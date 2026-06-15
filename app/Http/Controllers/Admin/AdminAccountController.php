<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'head_of_store', 'gm', 'hr', 'ceo'])
            ->paginate(15);

        return view('admin.admins.index', compact('admins'));
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
            'role' => 'required|in:admin,head_of_store,gm,hr,ceo',
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
            'role' => 'required|in:admin,head_of_store,gm,hr,ceo',
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
}
