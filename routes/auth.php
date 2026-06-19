<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', fn () => view('auth.login'))->name('login');

    Route::post('login', function (Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (auth()->attempt(['username' => $request->username, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $role = auth()->user()->role;

            // Semua role full access masuk ke admin dashboard
            if (in_array($role, User::FULL_ACCESS_ROLES)) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route($role.'.dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])->withInput();
    });
});

Route::middleware('auth')->group(function () {
    Route::post('logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});
