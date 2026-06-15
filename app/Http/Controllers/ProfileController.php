<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'avatar_cropped' => 'required|string',
        ]);

        // Decode base64 dari hasil crop
        $data = $request->avatar_cropped;
        if (! preg_match('/^data:image\/(\w+);base64,/', $data, $matches)) {
            return back()->withErrors(['avatar' => 'Format gambar tidak valid.']);
        }

        $ext = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        $imgData = substr($data, strpos($data, ',') + 1);
        $imgData = base64_decode($imgData);
        $filename = 'avatars/'.auth()->id().'_'.time().'.'.$ext;

        // Hapus avatar lama
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Storage::disk('public')->put($filename, $imgData);
        $user->update(['avatar' => $filename]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Kata sandi lama wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if (! Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi lama tidak sesuai.'])->withFragment('password-section');
        }

        auth()->user()->update(['password' => $request->password]);

        return back()->with('success', 'Kata sandi berhasil diubah.')->withFragment('password-section');
    }
}
