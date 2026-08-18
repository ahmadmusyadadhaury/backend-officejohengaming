<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KaryawanImportTemplateExport;
use App\Exports\UsersNikTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\KaryawanImport;
use App\Imports\UsersNikImport;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('admin.admins.index');
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
            'nik' => 'nullable|string|max:50|unique:users,nik',
            'password' => 'required|string|min:6',
            'role' => 'required|in:koordinator,user,admin_ga',
            'team_id' => 'required_if:role,koordinator,user|nullable|exists:teams,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nik' => $request->nik,
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
            'nik' => 'nullable|string|max:50|unique:users,nik,'.$user->id,
            'role' => 'required|in:koordinator,user,admin_ga',
            'team_id' => 'required_if:role,koordinator,user|nullable|exists:teams,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'nik' => $request->nik,
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
            'nik' => 'nullable|string|max:50|unique:users,nik',
            'password' => 'required|string|min:6',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'nik' => $request->nik,
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
            'nik' => 'nullable|string|max:50|unique:users,nik,'.$karyawan->id,
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'nik' => $request->nik,
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

    public function downloadKaryawanTemplate()
    {
        return Excel::download(
            new KaryawanImportTemplateExport,
            'Template_Import_Karyawan.xlsx'
        );
    }

    public function importKaryawan(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new KaryawanImport(auth()->user()->role === 'admin');
        Excel::import($import, $request->file('file'));

        $successCount = $import->getSuccessCount();
        $skipped = $import->getSkipped();
        $skippedCount = $import->getSkippedCount();
        $errors = $import->getErrors();
        $totalErrors = count($errors);

        $redirect = redirect()->route('admin.users.index');

        $details = [];
        if ($skippedCount > 0) {
            $details[] = "{$skippedCount} baris duplikat dilewati";
        }
        if ($totalErrors > 0) {
            $details[] = "{$totalErrors} baris gagal";
        }

        if ($details) {
            session()->flash('import_errors', $errors);
            session()->flash('import_skipped', $skipped);
            session()->flash('import_success_count', $successCount);
            session()->flash('import_skipped_count', $skippedCount);
            session()->flash('import_error_count', $totalErrors);

            return $redirect->with('warning', 'Berhasil tambah '.$successCount.' karyawan. '.implode(', ', $details).'.');
        }

        return $redirect->with('success', "Berhasil tambah {$successCount} karyawan.");
    }

    public function downloadNikTemplate()
    {
        return Excel::download(
            new UsersNikTemplateExport,
            'Template_Import_NIK_Karyawan.xlsx'
        );
    }

    public function importNik(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new UsersNikImport;
        Excel::import($import, $request->file('file'));

        $successCount = $import->getSuccessCount();
        $errors = $import->getErrors();
        $totalErrors = count($errors);

        $redirect = redirect()->route('admin.users.index');

        if ($totalErrors > 0) {
            session()->flash('import_errors', $errors);
            session()->flash('import_success_count', $successCount);
            session()->flash('import_error_count', $totalErrors);

            return $redirect->with('warning', "Berhasil update NIK {$successCount} akun. {$totalErrors} baris gagal.");
        }

        return $redirect->with('success', "Berhasil update NIK {$successCount} akun.");
    }
}
