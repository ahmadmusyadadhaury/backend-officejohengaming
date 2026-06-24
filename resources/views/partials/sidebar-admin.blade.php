@php
    $isMeetingActive = request()->routeIs('admin.meetings.*', 'admin.moms.*', 'calendar');
    $isAssetActive = request()->routeIs('admin.vehicles.*', 'admin.digital-assets.*', 'admin.sim-cards.*', 'admin.peralatan-kantor.*', 'admin.ruko.*');
    $isPaymentActive = request()->routeIs('admin.pembayaran.*');
    $isAdminActive = request()->routeIs('admin.users.*', 'admin.admins.*', 'admin.assets.*', 'admin.teams.*', 'admin.rooms.*');

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

<p class="sidebar-section-label">Overview</p>

<a href="{{ route('admin.dashboard') }}"
    class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
    </svg>
    Dashboard
</a>

@if($isAdminHr)
<p class="sidebar-section-label">Manajemen</p>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isMeetingActive ? 'true' : 'false' }}">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Meeting
        </span>
        <svg class="w-3 h-3 caret {{ $isMeetingActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu {{ $isMeetingActive ? '' : 'hidden' }}">
    <a href="{{ route('admin.meetings.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.meetings.*') ? 'active' : '' }}">Permintaan Meeting</a>
    <a href="{{ route('admin.moms.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.moms.*') ? 'active' : '' }}">Rekap MOM</a>
    <a href="{{ route('calendar') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('calendar') ? 'active' : '' }}">Jadwal Meeting</a>
</div>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isAssetActive ? 'true' : 'false' }}">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Data Aset
        </span>
        <svg class="w-3 h-3 caret {{ $isAssetActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu {{ $isAssetActive ? '' : 'hidden' }}">
    <a href="{{ route('admin.vehicles.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">Kendaraan</a>
    <a href="{{ route('admin.digital-assets.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.digital-assets.*') ? 'active' : '' }}">Digital</a>
    <a href="{{ route('admin.sim-cards.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.sim-cards.*') ? 'active' : '' }}">SIM Card</a>
    <a href="{{ route('admin.peralatan-kantor.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.peralatan-kantor.*') ? 'active' : '' }}">Peralatan Kantor</a>
    <a href="{{ route('admin.ruko.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.ruko.*') ? 'active' : '' }}">Milik Ruko</a>
</div>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isPaymentActive ? 'true' : 'false' }}">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Pembayaran
        </span>
        <svg class="w-3 h-3 caret {{ $isPaymentActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu {{ $isPaymentActive ? '' : 'hidden' }}">
    <a href="{{ route('admin.pembayaran.index', ['jenis' => 'listrik']) }}" class="sidebar-item sidebar-submenu-item {{ request('jenis') === 'listrik' ? 'active' : '' }}">Listrik</a>
    <a href="{{ route('admin.pembayaran.index', ['jenis' => 'internet']) }}" class="sidebar-item sidebar-submenu-item {{ request('jenis') === 'internet' ? 'active' : '' }}">Internet</a>
    <a href="{{ route('admin.pembayaran.index', ['jenis' => 'aset_digital']) }}" class="sidebar-item sidebar-submenu-item {{ request('jenis') === 'aset_digital' ? 'active' : '' }}">Aset Digital</a>
    <a href="{{ route('admin.pembayaran.index', ['jenis' => 'ipl_ruko']) }}" class="sidebar-item sidebar-submenu-item {{ request('jenis') === 'ipl_ruko' ? 'active' : '' }}">IPL Ruko</a>
</div>

<p class="sidebar-section-label">Admin</p>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isAdminActive ? 'true' : 'false' }}">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Kelola
        </span>
        <svg class="w-3 h-3 caret {{ $isAdminActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu {{ $isAdminActive ? '' : 'hidden' }}">
    <a href="{{ route('admin.users.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Kelola Akun</a>
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.admins.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">Kelola Admin</a>
    @endif
    <a href="{{ route('admin.assets.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.assets.*') ? 'active' : '' }}">Kelola Aset Meeting</a>
    <a href="{{ route('admin.teams.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}">Kelola Tim</a>
    <a href="{{ route('admin.rooms.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">Kelola Ruangan</a>
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

<p class="sidebar-section-label">Akun</p>
<a href="{{ route('profile.edit') }}"
    class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    Profile
</a>
