<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Johen Gaming') — Meeting Room</title>
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
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex">

    {{-- Sidebar --}}
    <aside id="sidebar" class="w-64 min-h-screen bg-primary-dark flex flex-col fixed top-0 left-0 z-30 transition-transform duration-300">
        {{-- Logo --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
            <img src="{{ asset('images/logo/logo_web.png') }}" alt="Johen Gaming" class="w-9 h-9 rounded-xl object-contain flex-shrink-0">
            <div>
                <p class="text-white font-bold text-sm leading-tight">JOHEN GAMING</p>
                <p class="text-blue-300 text-xs">Meeting Room</p>
            </div>
        </div>

        {{-- User Info --}}
        <div class="px-6 py-4 border-b border-white/10">
            <p class="text-white font-medium text-sm truncate">{{ auth()->user()->name }}</p>
            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-medium
                @if(auth()->user()->role === 'admin') bg-accent/30 text-accent-light
                @elseif(auth()->user()->role === 'leader') bg-secondary/30 text-secondary-light
                @else bg-green-500/20 text-green-300 @endif">
                {{ auth()->user()->role_label }}
                @if(auth()->user()->team) — {{ auth()->user()->team->name }} @endif
            </span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            @yield('sidebar-menu')
        </nav>

        {{-- Logout --}}
        <div class="px-4 py-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-red-300 hover:bg-red-500/10 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-20">
            <div>
                <h1 class="text-lg font-semibold text-primary">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-gray-400">@yield('page-subtitle', '')</p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Notifikasi Undangan --}}
                @php
                    $pendingInvitations = \App\Models\MeetingInvitation::where('user_id', auth()->id())
                        ->where('is_read', false)
                        ->whereHas('meeting', fn($q) => $q->whereIn('status', ['approved','confirmed','in_progress']))
                        ->with('meeting')
                        ->get();

                    $activeInvitations = \App\Models\MeetingInvitation::where('user_id', auth()->id())
                        ->whereHas('meeting', fn($q) => $q->whereIn('status', ['approved','confirmed','in_progress']))
                        ->with('meeting')
                        ->get();
                @endphp

                @if($activeInvitations->count() > 0)
                    <div class="relative" onclick="this.querySelector('[data-dropdown]').classList.toggle('hidden')">
                        <button class="relative flex items-center gap-2 px-3 py-1.5 rounded-lg bg-accent/10 hover:bg-accent/20 text-accent text-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Undangan
                            @if($pendingInvitations->count() > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                    {{ $pendingInvitations->count() }}
                                </span>
                            @endif
                        </button>
                        <div data-dropdown class="hidden absolute right-0 top-10 w-72 bg-white rounded-xl shadow-lg border border-gray-100 z-50">
                            <p class="px-4 py-2 text-xs font-semibold text-gray-400 border-b">Undangan Meeting Aktif</p>
                            @foreach($activeInvitations as $inv)
                            <a href="{{ route('invitation.show', $inv) }}"
                                class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 border-b border-gray-50 transition">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 {{ !$inv->is_read ? 'bg-accent' : 'bg-gray-300' }}"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $inv->meeting->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $inv->meeting->meeting_date->format('d M Y') }} · {{ substr($inv->meeting->start_time,0,5) }}</p>
                                    @php
                                        $sc = ['approved'=>'text-blue-600','confirmed'=>'text-indigo-600','in_progress'=>'text-purple-600','cancelled'=>'text-red-500','rejected'=>'text-red-500'];
                                    @endphp
                                    <p class="text-xs {{ $sc[$inv->meeting->status] ?? 'text-gray-400' }}">{{ ucfirst($inv->meeting->status) }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <a href="{{ route('calendar') }}"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-primary/5 hover:bg-primary/10 text-primary text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Kalender
                </a>
                <span class="text-sm text-gray-500">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-4 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 px-6 pb-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
