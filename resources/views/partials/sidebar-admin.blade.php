@php
    $adminMenus = [
        ['route' => 'admin.dashboard',             'label' => 'Dashboard',          'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'admin.teams.index',           'label' => 'Kelola Tim',         'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['route' => 'admin.rooms.index',           'label' => 'Kelola Ruangan',     'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ['route' => 'admin.assets.index',          'label' => 'Kelola Aset',        'icon' => 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18'],
        ['route' => 'admin.meetings.index',        'label' => 'Permintaan Meeting', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['route' => 'admin.weekly-meetings.index', 'label' => 'Meeting Mingguan',   'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
        ['route' => 'calendar',                    'label' => 'Kalender',           'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ];

    $hasInvitations = \App\Models\MeetingInvitation::where('user_id', auth()->id())
        ->whereHas('meeting', function($q) {
            $q->whereIn('status', ['approved','confirmed','in_progress'])
              ->where(function($q2) {
                  $q2->where('meeting_date', '>', today())
                     ->orWhere(function($q3) {
                         $q3->where('meeting_date', today())
                            ->where('end_time', '>', \Carbon\Carbon::now()->format('H:i:s'));
                     });
              });
        })->exists();
@endphp

<p class="sidebar-section-label">Menu Utama</p>

@foreach($adminMenus as $menu)
    <a href="{{ route($menu['route']) }}"
        class="sidebar-item {{ request()->routeIs($menu['route'] . '*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"/>
        </svg>
        {{ $menu['label'] }}
    </a>
@endforeach

{{-- Request Meeting: untuk head_of_store, gm, dan hr --}}
@if(in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr']))
    <p class="sidebar-section-label">Meeting</p>
    <a href="{{ route('koordinator.meetings.index') }}"
        class="sidebar-item {{ request()->routeIs('koordinator.meetings.index') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Meeting Saya
    </a>
    <a href="{{ route('koordinator.meetings.create') }}"
        class="sidebar-item {{ request()->routeIs('koordinator.meetings.create') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Request Meeting
    </a>
    @if($hasInvitations)
        <a href="{{ route('invitation.index') }}"
            class="sidebar-item {{ request()->routeIs('invitation.*') ? 'active' : '' }}">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Undangan
        </a>
    @endif
@endif

{{-- Kelola Akun & Admin --}}
@if(in_array(auth()->user()->role, ['admin', 'hr']))
    <p class="sidebar-section-label">Manajemen</p>
    <a href="{{ route('admin.users.index') }}"
        class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        Kelola Akun
    </a>
@endif

@if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.admins.index') }}"
        class="sidebar-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        Kelola Admin
    </a>
@endif
