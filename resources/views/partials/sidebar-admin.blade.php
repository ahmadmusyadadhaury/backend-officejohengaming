@php
    $dashboardMenu = ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'];
    $meetingMenus = [
        ['route' => 'admin.meetings.index', 'label' => 'Permintaan Meeting', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['route' => 'admin.moms.index',     'label' => 'Rekap MOM',          'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['route' => 'calendar',             'label' => 'Jadwal Meeting',     'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ];
    $assetMenus = [
        ['route' => 'admin.assets.index', 'label' => 'Kelola Aset',      'icon' => 'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18'],
        ['route' => 'admin.rooms.index',  'label' => 'Kelola Ruangan',   'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ['route' => 'admin.teams.index',  'label' => 'Kelola Tim',      'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
    ];
    $paymentMenus = [
        ['route' => 'admin.pembayaran.index', 'label' => 'Listrik',      'params' => ['jenis' => 'listrik']],
        ['route' => 'admin.pembayaran.index', 'label' => 'Internet',     'params' => ['jenis' => 'internet']],
        ['route' => 'admin.pembayaran.index', 'label' => 'Aset Digital', 'params' => ['jenis' => 'aset_digital']],
        ['route' => 'admin.pembayaran.index', 'label' => 'IPL Ruko',     'params' => ['jenis' => 'ipl_ruko']],
    ];
    $accountMenus = [
        ['route' => 'admin.users.index', 'label' => 'Kelola Akun', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
    ];
    $isMeetingSectionActive = request()->routeIs('admin.meetings.*', 'admin.moms.*', 'calendar');
    $isAssetSectionActive = request()->routeIs('admin.assets.*', 'admin.rooms.*', 'admin.teams.*', 'admin.vehicles.*', 'admin.digital-assets.*', 'admin.sim-cards.*', 'admin.peralatan-kantor.*', 'admin.ruko.*');
    $isPaymentSectionActive = request()->routeIs('admin.pembayaran.*');
    $isAccountSectionActive = request()->routeIs('admin.users.*', 'admin.admins.*');
    if (auth()->user()->role === 'admin') {
        $accountMenus[] = ['route' => 'admin.admins.index', 'label' => 'Kelola Admin', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'];
    }

    $isAdminHr = in_array(auth()->user()->role, ['admin', 'hr']);

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

    <a href="{{ route($dashboardMenu['route']) }}"
        class="sidebar-item {{ request()->routeIs($dashboardMenu['route'] . '*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $dashboardMenu['icon'] }}"/>
        </svg>
        {{ $dashboardMenu['label'] }}
    </a>

@if($isAdminHr)
    <div class="sidebar-section">
        <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isMeetingSectionActive ? 'true' : 'false' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Meeting
            </span>
            <svg class="w-3 h-3 caret {{ $isMeetingSectionActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
        </button>
    </div>
    <div class="sidebar-submenu {{ $isMeetingSectionActive ? '' : 'hidden' }}">
        @foreach($meetingMenus as $menu)
            <a href="{{ route($menu['route']) }}"
                class="sidebar-item sidebar-submenu-item {{ request()->routeIs($menu['route'] . '*') ? 'active' : '' }}">
                {{ $menu['label'] }}
            </a>
        @endforeach
    </div>

    <div class="sidebar-section">
        <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isAssetSectionActive ? 'true' : 'false' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zM3 13h18v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                </svg>
                Data Aset
            </span>
            <svg class="w-3 h-3 caret {{ $isAssetSectionActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
        </button>
    </div>
    <div class="sidebar-submenu {{ $isAssetSectionActive ? '' : 'hidden' }}">
        <a href="{{ route('admin.vehicles.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">Kendaraan</a>
        <a href="{{ route('admin.digital-assets.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.digital-assets.*') ? 'active' : '' }}">Digital</a>
        <a href="{{ route('admin.sim-cards.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.sim-cards.*') ? 'active' : '' }}">SIM Card</a>
        <a href="{{ route('admin.peralatan-kantor.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.peralatan-kantor.*') ? 'active' : '' }}">Peralatan Kantor</a>
        <a href="{{ route('admin.ruko.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.ruko.*') ? 'active' : '' }}">Milik Ruko</a>
    </div>

    <div class="sidebar-section">
        <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isPaymentSectionActive ? 'true' : 'false' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2H9a3 3 0 013-3V7a2 2 0 012 2h-2zm0 8a3 3 0 01-3-3h1a2 2 0 002 2v1zm2-4h4v2h-4v-2zm-8 0H2v2h4v-2z"/>
                </svg>
                Pembayaran
            </span>
            <svg class="w-3 h-3 caret {{ $isPaymentSectionActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
        </button>
    </div>
    <div class="sidebar-submenu {{ $isPaymentSectionActive ? '' : 'hidden' }}">
        @foreach($paymentMenus as $menu)
            <a href="{{ route($menu['route'], $menu['params'] ?? []) }}" class="sidebar-item sidebar-submenu-item {{ request('jenis') === ($menu['params']['jenis'] ?? '') ? 'active' : '' }}">{{ $menu['label'] }}</a>
        @endforeach
    </div>

    <div class="sidebar-section">
        <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isAccountSectionActive ? 'true' : 'false' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Kelola Akun
            </span>
            <svg class="w-3 h-3 caret {{ $isAccountSectionActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
        </button>
    </div>
    <div class="sidebar-submenu {{ $isAccountSectionActive ? '' : 'hidden' }}">
        @foreach($accountMenus as $menu)
            <a href="{{ route($menu['route']) }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs($menu['route'] . '*') ? 'active' : '' }}">{{ $menu['label'] }}</a>
        @endforeach
    </div>
@else
    <a href="{{ route('calendar') }}" class="sidebar-item {{ request()->routeIs('calendar') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Jadwal Meeting
    </a>
@endif

@if(in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr', 'ceo']))
    <p class="sidebar-section-label">Meeting</p>
    <a href="{{ route('koordinator.meetings.index') }}"
        class="sidebar-item {{ request()->routeIs('koordinator.meetings.index') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span class="flex-1">Meeting Saya</span>
        <span class="notif-badge-activity" style="display:none;background:#ef4444;color:white;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;"></span>
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
            <span class="flex-1">Undangan</span>
            <span class="notif-badge-meeting" style="display:none;background:#ef4444;color:white;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;"></span>
        </a>
    @endif
@endif

{{-- Admin / HR account links are already rendered above inside Kelola Akun group --}}

<p class="sidebar-section-label">Akun</p>
<a href="{{ route('profile.edit') }}"
    class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    Profil Saya
</a>
