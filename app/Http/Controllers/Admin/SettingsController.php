<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'nullable|in:light,dark',
            'email_notifications' => 'boolean',
            'app_notifications' => 'boolean',
        ]);

        $user = auth()->user();
        $user->theme = $validated['theme'] ?? $user->theme;
        $user->email_notifications = $request->boolean('email_notifications');
        $user->app_notifications = $request->boolean('app_notifications');
        $user->save();

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
