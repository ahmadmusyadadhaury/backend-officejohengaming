<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Johen Gaming Meeting Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:   { DEFAULT: '#1e3a5f', light: '#2d5a8e', dark: '#152a45' },
                        secondary: { DEFAULT: '#3b82f6', light: '#60a5fa' },
                        accent:    { DEFAULT: '#7c3aed', light: '#a78bfa' },
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-primary-dark via-primary to-accent flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        {{-- Logo & Title --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur mb-4">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Johen Gaming</h1>
            <p class="text-blue-200 text-sm mt-1">Meeting Room Management System</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-semibold text-primary mb-6">Masuk ke Sistem</h2>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" required autofocus
                        placeholder="Masukkan NIK kamu"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        placeholder="Masukkan password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-accent rounded border-gray-300">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full py-2.5 px-4 bg-gradient-to-r from-primary to-accent text-white font-semibold rounded-lg hover:opacity-90 transition text-sm">
                    Masuk
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-6">
                Belum punya akun? Hubungi Admin HR
            </p>
        </div>

        <p class="text-center text-blue-200/60 text-xs mt-6">
            &copy; {{ date('Y') }} Johen Gaming. All rights reserved.
        </p>
    </div>

</body>
</html>
