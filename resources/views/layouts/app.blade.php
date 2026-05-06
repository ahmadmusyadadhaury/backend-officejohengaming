<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Johen Gaming') — Meeting Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/gaming.css') }}?v={{ filemtime(public_path('css/gaming.css')) }}">
    <style>
        .sidebar-safe  { padding-bottom: env(safe-area-inset-bottom, 16px); }
        .topbar-safe   { padding-top: env(safe-area-inset-top, 0px); }
        .min-h-screen-safe { min-height: 100vh; min-height: -webkit-fill-available; }
        body { -webkit-overflow-scrolling: touch; }

        /* Topbar dark mode */
        @media (prefers-color-scheme: dark) {
            .topbar-dropdown {
                background: var(--bg-surface-2) !important;
                border-color: var(--border-color) !important;
            }
            .topbar-dropdown a:hover { background: rgba(255,255,255,0.05) !important; }
            .topbar-dropdown p { color: var(--text-primary) !important; }
            .topbar-dropdown .text-xs { color: var(--text-muted) !important; }
        }

        /* Flash message dark mode */
        @media (prefers-color-scheme: dark) {
            .flash-success { background: rgba(16,185,129,0.1) !important; border-color: rgba(16,185,129,0.3) !important; color: #34d399 !important; }
            .flash-error   { background: rgba(239,68,68,0.1) !important; border-color: rgba(239,68,68,0.3) !important; color: #f87171 !important; }
        }
    </style>
    @stack('styles')
</head>
<body style="background:var(--bg-base);color:var(--text-primary);" class="min-h-screen-safe">

    {{-- Overlay mobile --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden lg:hidden"
        style="background:rgba(0,0,0,0.7);backdrop-filter:blur(4px);"
        onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="gaming-sidebar w-64 flex flex-col fixed top-0 left-0 z-30 transition-transform duration-300 -translate-x-full lg:translate-x-0" style="height:100dvh;">

        {{-- Logo --}}
        <div class="flex-shrink-0 flex items-center gap-3 px-5 py-5" style="border-bottom:1px solid var(--sidebar-border);">
            <div class="relative flex-shrink-0">
                <img src="{{ asset('images/logo/logo_web.png') }}" alt="Johen Gaming"
                    class="w-9 h-9 rounded-xl object-contain">
                <div class="absolute inset-0 rounded-xl" style="box-shadow:0 0 12px rgba(124,58,237,0.4);"></div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-gaming font-bold text-sm tracking-wider" style="color:white;">JOHEN GAMING</p>
                <p class="text-xs" style="color:var(--color-neon-blue);opacity:0.8;letter-spacing:0.08em;">MEETING ROOM</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden" style="color:rgba(255,255,255,0.4);background:none;border:none;cursor:pointer;padding:4px;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- User Info --}}
        <div class="flex-shrink-0 px-5 py-4" style="border-bottom:1px solid var(--sidebar-border);">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 font-gaming font-bold text-sm"
                    style="background:linear-gradient(135deg,var(--color-accent),var(--color-primary-light));color:white;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium truncate" style="color:white;">{{ auth()->user()->name }}</p>
                    <span class="badge badge-primary" style="font-size:0.6rem;margin-top:2px;display:inline-flex;">
                        {{ auth()->user()->role_label }}
                    </span>
                </div>
            </div>
            @if(auth()->user()->team)
            <div class="mt-2 flex items-center gap-1.5" style="color:var(--text-muted);font-size:0.7rem;">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ auth()->user()->team->name }}
            </div>
            @endif
        </div>

        {{-- Navigation — scrollable --}}
        <nav class="flex-1 min-h-0 overflow-y-auto px-3 py-4 space-y-0.5">
            @yield('sidebar-menu')
        </nav>

        {{-- Logout — selalu terlihat di bawah, mobile & desktop --}}
        <div class="flex-shrink-0 px-3 py-3" style="border-top:1px solid var(--sidebar-border);padding-bottom:max(12px, env(safe-area-inset-bottom));">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-item w-full" style="color:#f87171;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="lg:ml-64 flex flex-col min-h-screen-safe">

        {{-- Topbar --}}
        <header class="gaming-topbar px-4 lg:px-6 py-3 flex items-center justify-between topbar-safe">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg transition"
                    style="color:var(--text-secondary);background:none;border:none;cursor:pointer;"
                    onmouseover="this.style.background='var(--bg-surface-2)'"
                    onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div>
                    <h1 class="font-gaming font-semibold text-base lg:text-lg leading-tight" style="color:var(--text-primary);">
                        @yield('page-title', 'Dashboard')
                    </h1>
                    <p class="text-xs hidden sm:block" style="color:var(--text-muted);">@yield('page-subtitle', '')</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                {{-- Notifikasi Undangan --}}
                @php
                    $activeInvitations = \App\Models\MeetingInvitation::where('user_id', auth()->id())
                        ->whereHas('meeting', function($q) {
                            $q->whereIn('status', ['approved','confirmed','in_progress'])
                              ->where(function($q2) {
                                  $q2->where('meeting_date', '>', today())
                                     ->orWhere(function($q3) {
                                         $q3->where('meeting_date', today())
                                            ->where('end_time', '>', \Carbon\Carbon::now()->format('H:i:s'));
                                     });
                              });
                        })
                        ->with('meeting')->get();
                    $pendingInvitations = $activeInvitations->where('is_read', false);
                    $activeWeeklyInvitations = \App\Models\WeeklyMeetingInvitation::where('user_id', auth()->id())
                        ->whereHas('session', fn($q) => $q->whereIn('status', ['active','extended']))
                        ->with('session.weeklyMeeting')->get();
                    $pendingWeeklyInvitations = $activeWeeklyInvitations->where('is_read', false);
                    $totalPending = $pendingInvitations->count() + $pendingWeeklyInvitations->count();
                @endphp
                <span id="notif-total-pending" data-count="{{ $totalPending }}" class="hidden"></span>

                @if($activeInvitations->count() > 0 || $activeWeeklyInvitations->count() > 0)
                    <div class="relative" onclick="this.querySelector('[data-dropdown]').classList.toggle('hidden')">
                        <button class="relative flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition text-sm"
                            style="background:rgba(124,58,237,0.1);color:var(--color-accent-light);border:1px solid rgba(124,58,237,0.2);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="hidden sm:inline font-gaming font-semibold" style="letter-spacing:0.05em;">UNDANGAN</span>
                            @if($totalPending > 0)
                                <span data-notif-badge class="absolute -top-1 -right-1 w-4 h-4 text-white text-xs rounded-full flex items-center justify-center animate-glow-pulse"
                                    style="background:#ef4444;font-size:0.6rem;">{{ $totalPending }}</span>
                            @else
                                <span data-notif-badge class="hidden absolute -top-1 -right-1 w-4 h-4 text-white text-xs rounded-full flex items-center justify-center animate-glow-pulse"
                                    style="background:#ef4444;font-size:0.6rem;"></span>
                            @endif
                        </button>
                        <div data-dropdown class="hidden absolute right-0 top-11 w-72 rounded-xl z-50 max-h-80 overflow-y-auto topbar-dropdown"
                            style="background:var(--bg-surface);border:1px solid var(--border-color);box-shadow:var(--shadow-lg);">
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-bottom:1px solid var(--border-color);">
                                UNDANGAN AKTIF
                            </p>
                            @foreach($activeInvitations as $inv)
                            <a href="{{ route('invitation.show', $inv) }}" class="flex items-start gap-3 px-4 py-3 transition" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:{{ !$inv->is_read ? 'var(--color-accent)' : 'var(--text-muted)' }};"></div>
                                <div>
                                    <p class="text-sm font-medium" style="color:var(--text-primary);">{{ $inv->meeting->title }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $inv->meeting->meeting_date->format('d M Y') }} · {{ substr($inv->meeting->start_time,0,5) }}</p>
                                </div>
                            </a>
                            @endforeach
                            @foreach($activeWeeklyInvitations as $inv)
                            <a href="{{ route('weekly.show', $inv) }}" class="flex items-start gap-3 px-4 py-3 transition" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:{{ !$inv->is_read ? '#00d4ff' : 'var(--text-muted)' }};"></div>
                                <div>
                                    <p class="text-sm font-medium" style="color:var(--text-primary);">🔁 {{ $inv->session->weeklyMeeting->title }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $inv->session->session_date->format('d M Y') }} · {{ substr($inv->session->start_time,0,5) }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <a href="{{ route('calendar') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition text-sm"
                    style="background:rgba(30,58,95,0.1);color:var(--color-secondary);border:1px solid rgba(59,130,246,0.2);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="hidden sm:inline font-gaming font-semibold" style="letter-spacing:0.05em;">KALENDER</span>
                </a>

                <span class="text-xs hidden md:block" style="color:var(--text-muted);">{{ now()->isoFormat('D MMM Y') }}</span>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-4 lg:px-6 pt-4">
            @if(session('success'))
                <div class="flash-success rounded-lg px-4 py-3 mb-4 text-sm flex items-center gap-2 animate-fade-in"
                    style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#10b981;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash-error rounded-lg px-4 py-3 mb-4 text-sm flex items-center gap-2 animate-fade-in"
                    style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="flash-error rounded-lg px-4 py-3 mb-4 text-sm animate-fade-in"
                    style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 px-4 lg:px-6 pb-8 page-content">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isOpen  = !sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', isOpen);
            overlay.classList.toggle('hidden', isOpen);
        }

        // Auto-refresh badge notifikasi topbar setiap 60 detik
        (function() {
            const badgeEl = document.querySelector('[data-notif-badge]');
            if (!badgeEl) return;

            function refreshNotif() {
                fetch('{{ route("realtime.notif") }}')
                    .then(r => r.json())
                    .then(data => {
                        if (data.total_pending > 0) {
                            badgeEl.textContent = data.total_pending;
                            badgeEl.classList.remove('hidden');
                        } else {
                            badgeEl.classList.add('hidden');
                        }
                    }).catch(() => {});
            }

            setInterval(refreshNotif, 60000);
        })();
    </script>
    @stack('scripts')
</body>
</html>
