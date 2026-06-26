<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'JOHEN OFFICE Management System')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v={{ filemtime(public_path('favicon-32x32.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v={{ filemtime(public_path('favicon-16x16.png')) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v={{ filemtime(public_path('apple-touch-icon.png')) }}">
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
    <aside id="sidebar" class="gaming-sidebar w-72 flex flex-col fixed top-0 left-0 z-30 transition-transform duration-300 -translate-x-full lg:translate-x-0" style="height:100dvh;">

        {{-- Logo --}}
        <div class="flex-shrink-0 flex items-center gap-2 px-4 py-4" style="border-bottom:1px solid var(--sidebar-border);">
            <div class="relative flex-shrink-0">
                <img src="{{ asset('images/logo/logo_web.png') }}" alt="JOHEN OFFICE" loading="lazy"
                    class="w-9 h-9 rounded-lg object-contain">

            </div>
            <div class="min-w-0 flex-1">
                <p class="font-gaming font-bold leading-none truncate" style="font-size:0.85rem;color:var(--sidebar-brand);letter-spacing:0.05em;">JOHEN OFFICE</p>
                <p class="truncate" style="font-size:0.6rem;color:#9398b8;letter-spacing:0.1em;margin-top:2px;">MANAGEMENT SYSTEM</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden flex-shrink-0" style="color:var(--sidebar-text);background:none;border:none;cursor:pointer;padding:4px;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
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
    <div class="lg:ml-72 flex flex-col min-h-screen-safe">

        {{-- Topbar --}}
        <header class="gaming-topbar px-4 lg:px-8 py-4 flex items-center justify-between topbar-safe">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg transition"
                    style="color:var(--text-secondary);background:none;border:none;cursor:pointer;"
                    onmouseover="this.style.background='var(--bg-surface-2)'"
                    onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="min-w-0">
                    <h1 class="font-gaming font-semibold leading-tight truncate" style="font-size:1.1rem;color:var(--text-primary);">
                        @yield('page-title', 'Dashboard')
                    </h1>
                    <p class="hidden sm:block truncate" style="font-size:0.8rem;color:var(--text-muted);">@yield('page-subtitle', '')</p>
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
                        });
                    $activeInvitations = $activeInvitations->with('meeting')->get();
                    $pendingInvitations = $activeInvitations->where('is_read', false);
                    $activeWeeklyInvitations = \App\Models\WeeklyMeetingInvitation::where('user_id', auth()->id())
                        ->whereHas('session', fn($q) => $q->whereIn('status', ['active','extended']))
                        ->with('session.weeklyMeeting')->get();
                    $pendingWeeklyInvitations = $activeWeeklyInvitations->where('is_read', false);
                    $totalPending = $pendingInvitations->count() + $pendingWeeklyInvitations->count();
                @endphp
                <span id="notif-total-pending" data-count="{{ $totalPending }}" class="hidden"></span>

                <div class="flex items-center gap-2">
                    <div class="relative">
                        <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')" class="topbar-btn" aria-label="Notifikasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span data-notif-badge class="topbar-badge {{ $totalPending > 0 ? '' : 'hidden' }}">{{ $totalPending }}</span>
                        </button>
                        <div class="hidden absolute right-0 top-12 w-64 rounded-xl z-50 max-h-80 overflow-y-auto topbar-dropdown"
                            style="background:var(--bg-surface);border:1px solid var(--border-color);box-shadow:var(--shadow-lg);">
                            {{-- Undangan Aktif --}}
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-bottom:1px solid var(--border-color);">
                                UNDANGAN AKTIF
                            </p>
                            @if($activeInvitations->count() === 0 && $activeWeeklyInvitations->count() === 0)
                                <div class="px-4 py-3 text-center text-xs" style="color:var(--text-muted);">
                                    Belum ada undangan aktif
                                </div>
                            @endif
                            @foreach($activeInvitations as $inv)
                            <button type="button" onclick="showInvitationModal({{ $inv->id }}, {{ $inv->meeting_id }})" class="flex items-start gap-3 px-4 py-3 transition text-left w-full" style="border-bottom:1px solid var(--border-color);background:none;border-left:none;border-right:none;border-top:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:{{ !$inv->is_read ? 'var(--color-accent)' : 'var(--text-muted)' }};"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $inv->meeting->title }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $inv->meeting->meeting_date->format('d M Y') }} · {{ substr($inv->meeting->start_time,0,5) }}</p>
                                </div>
                            </button>
                            @endforeach
                            @foreach($activeWeeklyInvitations as $inv)
                            <a href="{{ route('weekly.show', $inv) }}" class="flex items-start gap-3 px-4 py-3 transition" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:{{ !$inv->is_read ? '#00d4ff' : 'var(--text-muted)' }};"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">🔁 {{ $inv->session->weeklyMeeting->title }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $inv->session->session_date->format('d M Y') }} · {{ substr($inv->session->start_time,0,5) }}</p>
                                </div>
                            </a>
                            @endforeach

                            {{-- Jadwal Meeting Terdekat --}}
                            @if($upcomingMeetings->count() > 0)
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);margin-top:4px;">
                                📅 JADWAL MEETING TERDEKAT
                            </p>
                            @foreach($upcomingMeetings as $meeting)
                            <div class="flex items-start gap-3 px-4 py-3" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:var(--color-secondary);"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $meeting->meeting_date->format('d M Y') }} · {{ substr($meeting->start_time,0,5) }}</p>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            {{-- Pembayaran Mendatang --}}
                            @if($upcomingPayments->count() > 0)
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);margin-top:4px;">
                                💳 PEMBAYARAN MENDATANG
                            </p>
                            @foreach($upcomingPayments as $payment)
                            <div class="flex items-start gap-3 px-4 py-3" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:#fbbf24;"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $payment->requester->name }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $payment->meeting_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            {{-- Peringatan Kadaluarsa --}}
                            @if($upcomingAlerts->count() > 0)
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);margin-top:4px;">
                                ⚠️  PERINGATAN KADALUARSA
                            </p>
                            @foreach($upcomingAlerts as $alert)
                            <div class="flex items-start gap-3 px-4 py-3" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:#f87171;"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $alert->name }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">Stock: {{ $alert->quantity }} unit</p>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <button type="button" class="topbar-btn" onclick="window.location.href='{{ route('calendar') }}'" aria-label="Kalender">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </button>

                    <button id="theme-toggle" type="button" onclick="toggleTheme()" class="topbar-btn" aria-label="Toggle theme">
                        <svg id="theme-toggle-icon" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3.75a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V4.5A.75.75 0 0112 3.75zm0 14.25a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5a.75.75 0 01.75-.75zm8.25-6.75a.75.75 0 01.75.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75.75.75 0 01.75-.75zM4.5 12a.75.75 0 01.75.75H3.75a.75.75 0 010-1.5h1.5A.75.75 0 014.5 12zm12.03-5.72a.75.75 0 011.06 0l1.06 1.06a.75.75 0 01-1.06 1.06l-1.06-1.06a.75.75 0 010-1.06zM6.36 17.64a.75.75 0 011.06 0l1.06 1.06a.75.75 0 01-1.06 1.06L6.36 18.7a.75.75 0 010-1.06zm12.03 0a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zM7.42 6.34a.75.75 0 010 1.06L6.36 8.46a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zM12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
                        </svg>
                    </button>

                    <div class="relative">
                        <button type="button" class="topbar-profile-btn" onclick="this.parentElement.querySelector('[data-profile-dropdown]').classList.toggle('hidden')">
                            <span class="topbar-profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                            <span class="hidden sm:inline font-semibold" style="font-size:0.75rem;color:var(--text-primary);">{{ auth()->user()->role_label }}</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div data-profile-dropdown class="hidden absolute right-0 top-12 w-48 rounded-xl z-50 topbar-dropdown"
                            style="background:var(--bg-surface);border:1px solid var(--border-color);box-shadow:var(--shadow-lg);overflow:hidden;">
                            <div class="px-4 py-3 border-b" style="border-color:var(--border-color);">
                                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ auth()->user()->name }}</p>
                                <p class="text-xs" style="color:var(--text-muted);">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 transition"
                                style="color:var(--text-primary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium">Profile Saya</span>
                            </a>
                            <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 transition"
                                style="color:var(--text-primary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-sm font-medium">Pengaturan</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t" style="border-color:var(--border-color);">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 transition"
                                    style="color:#f87171;background:none;border:none;cursor:pointer;text-align:left;"
                                    onmouseover="this.style.background='rgba(248, 113, 113, 0.1)'" onmouseout="this.style.background='none'">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="text-sm font-medium">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-4 lg:px-6 pt-4">
            @if(session('success'))
                <span id="success-flash-data" style="display:none;">{{ session('success') }}</span>
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
        <main class="flex-1 px-4 lg:px-8 pt-4 pb-8 page-content">
            @yield('content')
        </main>
    </div>

    {{-- Invitation Modal --}}
    <div id="invitation-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Undangan Meeting</h3>
                <button type="button" onclick="closeInvitationModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1" id="invitation-modal-body">
                <div class="text-center py-8" style="color:var(--text-muted);">Memuat data...</div>
            </div>
            <div class="px-6 py-4 flex-shrink-0 flex justify-end" style="border-top:1px solid var(--border-color);">
                <button type="button" onclick="closeInvitationModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Success Modal --}}
    <div id="success-modal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;background:var(--bg-overlay);" onclick="if(event.target===this)closeSuccessModal()">
        <div class="w-full max-w-[400px] rounded-3xl shadow-2xl overflow-hidden animate-fade-in" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 flex-shrink-0" fill="#10b981" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-base font-bold" style="color:var(--text-primary);" id="success-modal-header">Berhasil</h3>
                </div>
                <button type="button" onclick="closeSuccessModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-10 flex flex-col items-center text-center space-y-4">
                <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background:rgba(16,185,129,0.15);">
                    <svg class="w-8 h-8" fill="#10b981" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="space-y-1.5">
                    <h2 class="text-lg font-bold" style="color:var(--text-primary);" id="success-modal-title">Berhasil!</h2>
                    <p class="text-sm" style="color:var(--text-tertiary);" id="success-modal-sub">Data telah diproses.</p>
                </div>
            </div>
            <div class="px-6 py-4 flex justify-center" style="border-top:1px solid var(--border-color);">
                <button type="button" onclick="closeSuccessModal()" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition hover:opacity-90 active:scale-95" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);box-shadow:0 4px 15px rgba(99,102,241,0.3);">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Confirm Modal --}}
    <div id="confirm-modal" style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[380px] rounded-2xl shadow-2xl flex flex-col p-6" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex flex-col items-center text-center mb-5">
                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3" style="background:rgba(239,68,68,0.15);">
                    <svg class="w-6 h-6" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-base font-semibold" style="color:var(--text-primary);" id="confirm-title">Konfirmasi</p>
                <p class="text-sm mt-1" style="color:var(--text-muted);" id="confirm-message">Yakin ingin melanjutkan?</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeConfirmModal()" class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold transition" style="background:var(--bg-surface-2);color:var(--text-primary);border:none;cursor:pointer;" onmouseover="this.style.background='var(--border-color)'" onmouseout="this.style.background='var(--bg-surface-2)'">Batal</button>
                <button type="button" id="confirm-yes-btn" class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold transition" style="background:#ef4444;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) { const el = document.getElementById(id); if (el) { el.style.display = 'flex'; document.body.style.overflow = 'hidden'; } }
        function closeModal(id) { const el = document.getElementById(id); if (el) { el.style.display = 'none'; document.body.style.overflow = ''; } }

        // Success Modal
        function closeSuccessModal() {
            const el = document.getElementById('success-modal');
            if (el) {
                el.style.display = 'none';
                el.style.visibility = 'hidden';
                el.style.opacity = '0';
                el.style.pointerEvents = 'none';
            }
            document.body.style.overflow = '';
        }

        function parseSuccessMessage(msg) {
            const clean = msg.replace(/\.\s*$/, '').trim();
            const parts = clean.split(' berhasil ');
            let entity = parts[0] || clean;
            let action = parts[1] || '';

            const capitalize = (s) => s.charAt(0).toUpperCase() + s.slice(1);

            let header = entity + ' Berhasil';
            if (action) header += ' ' + capitalize(action);

            let title = entity + ' berhasil';
            if (action) title += ' ' + action;
            if (!title.endsWith('!')) title += '!';

            let sub = entity;
            if (action.includes('ditambah') || action.includes('dibuat') || action.includes('dikirim')) {
                sub += ' telah ditambahkan';
            } else if (action.includes('diperbarui')) {
                sub += ' telah diperbarui';
            } else if (action.includes('dihapus') || action.includes('dibatalkan')) {
                sub += ' telah dihapus';
            } else if (action.includes('disetujui')) {
                sub += ' telah disetujui';
            } else if (action.includes('ditolak')) {
                sub += ' telah ditolak';
            } else if (action.includes('dikonfirmasi')) {
                sub += ' telah dikonfirmasi';
            } else if (action.includes('diselesaikan')) {
                sub += ' telah diselesaikan';
            } else if (action) {
                sub += ' telah ' + action;
            } else {
                sub = clean;
            }

            return { header, title, sub };
        }

        function showSuccessModal(msg) {
            const { header, title, sub } = parseSuccessMessage(msg);
            document.getElementById('success-modal-header').textContent = header;
            document.getElementById('success-modal-title').textContent = title;
            document.getElementById('success-modal-sub').textContent = sub;
            openModal('success-modal');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('success-flash-data');
            if (el) showSuccessModal(el.textContent);

            const sm = document.getElementById('success-modal');
            if (sm) {
                sm.addEventListener('click', function(e) {
                    if (e.target === this) closeSuccessModal();
                });
            }
        });

        let confirmCallback = null;
        function showConfirmModal(message, onConfirm) {
            document.getElementById('confirm-message').textContent = message;
            confirmCallback = onConfirm;
            openModal('confirm-modal');
        }
        function closeConfirmModal() {
            confirmCallback = null;
            closeModal('confirm-modal');
        }
        document.getElementById('confirm-yes-btn')?.addEventListener('click', function() {
            if (typeof confirmCallback === 'function') confirmCallback();
            closeConfirmModal();
        });
        document.getElementById('confirm-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeConfirmModal();
        });

        function confirmSubmit(event, form) {
            event.preventDefault();
            const msg = form.getAttribute('data-confirm') || 'Yakin ingin melanjutkan?';
            showConfirmModal(msg, function() { form.submit(); });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isOpen  = !sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', isOpen);
            overlay.classList.toggle('hidden', isOpen);
        }

        function toggleSidebarSection(button) {
            const section = button.closest('.sidebar-section');
            const submenu = section ? section.nextElementSibling : null;
            const caret   = button.querySelector('.caret');
            if (!submenu || !caret) return;
            submenu.classList.toggle('hidden');
            caret.classList.toggle('rotated');
            button.setAttribute('aria-expanded', submenu.classList.contains('hidden') ? 'false' : 'true');
        }

        function getStoredTheme() {
            try { return localStorage.getItem('johenTheme'); } catch (e) { return null; }
        }

        function updateThemeButton(theme) {
    const icon = document.getElementById('theme-toggle-icon');
    const button = document.getElementById('theme-toggle');

    if (!icon || !button) return;

    icon.setAttribute('viewBox', '0 0 24 24');
    icon.innerHTML = '';

    // Reset
    icon.removeAttribute('stroke');
    icon.removeAttribute('stroke-width');
    icon.removeAttribute('stroke-linecap');
    icon.removeAttribute('stroke-linejoin');
    icon.setAttribute('fill', 'currentColor');

    button.classList.remove('light', 'dark');

    if (theme === 'dark') {

        button.classList.add('dark');

        // Bulan tebal
        icon.innerHTML = `
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M9.598 2.75a.75.75 0 01.785.977
                8.25 8.25 0 0010.89 10.89
                .75.75 0 01.977.785
                10.25 10.25 0 11-12.652-12.652z"
            />
        `;

        button.setAttribute(
            'aria-label',
            'Mode Gelap aktif, klik untuk terang'
        );

    } else {

        button.classList.add('light');

        // Matahari
        icon.innerHTML = `
            <path d="M12 18a6 6 0 100-12 6 6 0 000 12z"/>
            <path d="M12 2.25a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75z"/>
            <path d="M12 19.5a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-.75a.75.75 0 01.75-.75z"/>
            <path d="M21 11.25a.75.75 0 010 1.5h-1.5a.75.75 0 010-1.5H21z"/>
            <path d="M4.5 11.25a.75.75 0 010 1.5H3a.75.75 0 010-1.5h1.5z"/>
            <path d="M18.36 5.64a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 11-1.06-1.06l1.06-1.06a.75.75 0 011.06 0z"/>
            <path d="M7.76 16.24a.75.75 0 010 1.06L6.7 18.36a.75.75 0 11-1.06-1.06l1.06-1.06a.75.75 0 011.06 0z"/>
            <path d="M18.36 18.36a.75.75 0 01-1.06 0l-1.06-1.06a.75.75 0 111.06-1.06l1.06 1.06a.75.75 0 010 1.06z"/>
            <path d="M7.76 7.76a.75.75 0 01-1.06 0L5.64 6.7A.75.75 0 116.7 5.64L7.76 6.7a.75.75 0 010 1.06z"/>
        `;

        button.setAttribute(
            'aria-label',
            'Mode Terang aktif, klik untuk gelap'
        );
    }
}

        function applyTheme(theme) {
            const body = document.body;
            body.classList.toggle('dark', theme === 'dark');
            body.classList.toggle('light', theme === 'light');
            updateThemeButton(theme);
            try { localStorage.setItem('johenTheme', theme); } catch (e) {}
        }

        function resolvePreferredTheme() {
            const stored = getStoredTheme();
            if (stored === 'dark' || stored === 'light') return stored;
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        function toggleTheme() {
            const newTheme = document.body.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(newTheme);
        }

        function initTheme() {
            applyTheme(resolvePreferredTheme());
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
                    if (!getStoredTheme()) {
                        applyTheme(event.matches ? 'dark' : 'light');
                    }
                });
            }
        }

        initTheme();

        // ── Notifikasi Realtime (AudioContext — lebih keras, work di background) ──
        let audioCtx       = null;
        let actBuffer      = null;
        let meetBuffer     = null;
        let soundUnlocked  = false;

        // Unlock AudioContext setelah interaksi user pertama (browser policy)
        document.addEventListener('click', function unlockAudio() {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();

            // Preload & decode kedua sound file
            Promise.all([
                fetch('{{ asset("sounds/notif-activity.mp3") }}').then(r => r.arrayBuffer()).then(buf => audioCtx.decodeAudioData(buf)),
                fetch('{{ asset("sounds/notif-meeting.mp3") }}').then(r => r.arrayBuffer()).then(buf => audioCtx.decodeAudioData(buf)),
            ]).then(([act, meet]) => {
                actBuffer  = act;
                meetBuffer = meet;
            }).catch(() => {});

            soundUnlocked = true;
            document.removeEventListener('click', unlockAudio);
        }, { once: true });

        function playSound(audio) {
            // Fallback ke Audio element jika AudioContext belum siap
            if (typeof audio === 'object' && audio instanceof Audio) {
                audio.currentTime = 0;
                audio.play().catch(() => {});
                return;
            }
        }

        function playBuffer(buffer) {
            if (!soundUnlocked || !audioCtx || !buffer) return;
            const source  = audioCtx.createBufferSource();
            const gain    = audioCtx.createGain();
            gain.gain.value = 2.0; // 2x lebih keras
            source.buffer = buffer;
            source.connect(gain);
            gain.connect(audioCtx.destination);
            source.start(0);
        }

        let pageBaseTitle = document.title;

        function updateNotifBadges(activityCount, meetingCount) {
            document.querySelectorAll('.notif-badge-activity').forEach(el => {
                el.textContent    = activityCount;
                el.style.display  = activityCount > 0 ? 'inline-block' : 'none';
            });
            document.querySelectorAll('.notif-badge-meeting').forEach(el => {
                el.textContent    = meetingCount;
                el.style.display  = meetingCount > 0 ? 'inline-block' : 'none';
            });

            // Update judul tab seperti WhatsApp "(1) New message"
            const totalBadge = activityCount + meetingCount;
            if (!pageBaseTitle) pageBaseTitle = document.title.replace(/^\(\d+\)\s*/, '');
            document.title = totalBadge > 0 ? '(' + totalBadge + ') ' + pageBaseTitle : pageBaseTitle;

            // Badge API untuk icon tab (Chrome/Edge)
            if (navigator.setAppBadge) {
                navigator.setAppBadge(totalBadge).catch(() => {});
            } else if (navigator.clearAppBadge) {
                navigator.clearAppBadge().catch(() => {});
            }
        }

        // Fetch notif dari server, update badge, bunyikan suara jika ada baru
        function pollNotifications() {
            fetch('{{ route("realtime.notifications") }}')
                .then(r => r.json())
                .then(data => {
                    const activityCount = data.items.filter(n => n.type === 'activity').length;
                    const meetingCount  = data.items.filter(n => n.type === 'meeting').length;

                    // Pertama kali load — set baseline tanpa bunyi
                    if (lastActivityCount === null) {
                        lastActivityCount = activityCount;
                        lastMeetingCount  = meetingCount;
                        updateNotifBadges(activityCount, meetingCount);
                        return;
                    }

                    // Ada notif baru — bunyikan suara
                    if (activityCount > lastActivityCount) playBuffer(actBuffer);
                    if (meetingCount  > lastMeetingCount)  playBuffer(meetBuffer);

                    lastActivityCount = activityCount;
                    lastMeetingCount  = meetingCount;
                    updateNotifBadges(activityCount, meetingCount);
                }).catch(() => {});
        }

        // Tandai notif sudah dibaca — update DB dulu, baru update UI
        function markNotifRead(type, event) {
            if (event) event.preventDefault(); // cegah navigasi dulu
            const href = event ? event.currentTarget.href : null;

            fetch('{{ route("realtime.notifications.read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ type })
            }).then(() => {
                const newActivity = type === 'activity' ? 0 : lastActivityCount;
                const newMeeting  = type === 'meeting'  ? 0 : lastMeetingCount;
                lastActivityCount = newActivity;
                lastMeetingCount  = newMeeting;
                updateNotifBadges(newActivity, newMeeting);
                if (href) window.location.href = href;
            }).catch(() => {
                if (href) window.location.href = href;
            });
        }

        // Topbar undangan badge
        function refreshTopbarNotif() {
            fetch('{{ route("realtime.notif") }}')
                .then(r => r.json())
                .then(data => {
                    const badgeEl = document.querySelector('[data-notif-badge]');
                    if (!badgeEl) return;
                    if (data.total_pending > 0) {
                        badgeEl.textContent = data.total_pending;
                        badgeEl.classList.remove('hidden');
                    } else {
                        badgeEl.classList.add('hidden');
                    }
                }).catch(() => {});
        }

        // Jalankan polling segera saat halaman load
        pollNotifications();
        setInterval(pollNotifications, 10000);  // setiap 10 detik
        setInterval(refreshTopbarNotif, 30000); // topbar setiap 30 detik

        // ── Indikator Push Status ──
        const pushDot    = document.getElementById('push-dot');
        const pushLabel  = document.getElementById('push-label');
        const pushStatus = document.getElementById('push-status');

        function updatePushStatus(active, msg) {
            pushDot.style.background   = active ? '#22c55e' : '#ef4444';
            pushStatus.title           = msg;
            if (pushLabel) pushLabel.textContent = active ? 'PUSH ON' : 'PUSH OFF';
        }

        // ── Web Push Notification ──
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            navigator.serviceWorker.register('/sw.js').then(function(reg) {
                // Listen message dari Service Worker → trigger sound instan
                navigator.serviceWorker.addEventListener('message', function(event) {
                    if (event.data && event.data.type === 'push_notification') {
                        playBuffer(event.data.notifType === 'meeting' ? meetBuffer : actBuffer);
                        pollNotifications();
                    }
                });

                // Cek subscription yang sudah ada
                reg.pushManager.getSubscription().then(function(existing) {
                    if (existing) {
                        sendSubscriptionToServer(existing);
                        updatePushStatus(true, 'Push notification aktif');
                    } else {
                        updatePushStatus(false, 'Belum subscribe — izinkan notifikasi');
                    }
                });

                // Minta izin notifikasi
                Notification.requestPermission().then(function(permission) {
                    if (permission !== 'granted') {
                        updatePushStatus(false, 'Izin notifikasi ditolak — ubah di pengaturan browser');
                        return;
                    }

                    // Ambil VAPID public key
                    fetch('{{ route("push.vapid") }}')
                        .then(r => r.json())
                        .then(data => {
                            const vapidKey = urlBase64ToUint8Array(data.key);

                            reg.pushManager.getSubscription().then(function(existing) {
                                if (existing) {
                                    sendSubscriptionToServer(existing);
                                    updatePushStatus(true, 'Push notification aktif');
                                    return;
                                }

                                // Subscribe baru
                                reg.pushManager.subscribe({
                                    userVisibleOnly: true,
                                    applicationServerKey: vapidKey
                                }).then(function(sub) {
                                    sendSubscriptionToServer(sub);
                                    updatePushStatus(true, 'Push notification aktif');
                                }).catch(function(err) {
                                    updatePushStatus(false, 'Gagal subscribe: ' + err.message);
                                });
                            });
                        }).catch(function(err) {
                            updatePushStatus(false, 'Gagal ambil VAPID key');
                        });
                });
            }).catch(function(err) {
                updatePushStatus(false, 'Service Worker gagal daftar');
            });
        } else {
            updatePushStatus(false, 'Browser tidak mendukung push notification');
        }

        function sendSubscriptionToServer(subscription) {
            const key  = subscription.getKey('p256dh');
            const auth = subscription.getKey('auth');

            fetch('{{ route("push.subscribe") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    endpoint: subscription.endpoint,
                    p256dh:   key  ? btoa(String.fromCharCode(...new Uint8Array(key)))  : null,
                    auth:     auth ? btoa(String.fromCharCode(...new Uint8Array(auth))) : null,
                })
            }).catch(() => {});
        }

        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64  = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
            const raw     = window.atob(base64);
            return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
        }

        // Tutup dropdown profile saat klik di luar
        document.addEventListener('click', function(event) {
            const profileDropdown = document.querySelector('[data-profile-dropdown]');
            const profileButton = event.target.closest('.topbar-profile-btn');
            
            if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
                if (!profileButton && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            }
        });

        // Invitation Modal
        function showInvitationModal(invitationId, meetingId) {
            const body = document.getElementById('invitation-modal-body');
            body.innerHTML = '<div class="text-center py-8" style="color:var(--text-muted);">Memuat data...</div>';
            openModal('invitation-modal');

            fetch('/undangan/' + invitationId, { headers: { 'Accept': 'text/html' } })
                .then(r => r.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const content = doc.querySelector('#content');
                    if (content) {
                        body.innerHTML = content.innerHTML;
                    } else {
                        body.innerHTML = '<div class="text-center py-8" style="color:var(--text-muted);">Gagal memuat data.</div>';
                    }
                })
                .catch(() => {
                    body.innerHTML = '<div class="text-center py-8" style="color:var(--text-muted);">Gagal memuat data.</div>';
                });
        }

        function closeInvitationModal() {
            closeModal('invitation-modal');
        }

        document.getElementById('invitation-modal').addEventListener('click', function(e) {
            if (e.target === this) closeInvitationModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sm = document.getElementById('success-modal');
                if (sm && sm.style.display === 'flex') { closeSuccessModal(); return; }
                const cm = document.getElementById('confirm-modal');
                if (cm && cm.style.display === 'flex') { closeConfirmModal(); return; }
                closeInvitationModal();
            }
        });
    </script>
    @stack('modals')
    @stack('scripts')
</body>
</html>
