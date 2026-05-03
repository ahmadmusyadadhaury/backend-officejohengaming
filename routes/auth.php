<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function () {
    Route::get('login', fn() => view('auth.login'))->name('login');

    Route::post('login', function (Request $request) {
        $request->validate([
            'nik'      => 'required|string',
            'password' => 'required',
        ]);

        $credentials = [
            'nik'      => $request->nik,
            'password' => $request->password,
        ];

        if (auth()->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $role = auth()->user()->role;
            return redirect()->route($role . '.dashboard');
        }

        return back()->withErrors(['nik' => 'NIK atau password salah.'])->withInput();
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
