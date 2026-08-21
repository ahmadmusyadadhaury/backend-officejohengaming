@php
    $isMeetingActive = request()->routeIs('koordinator.meetings.*', 'koordinator.mom.*', 'koordinator.recordings.*', 'calendar');
    $isOperationalActive = request()->routeIs('koordinator.asset-saya.*', 'koordinator.aset-tim.*', 'koordinator.aset-mes.*');
    $isPaymentActive = request()->routeIs('payment-approval.*');
    $isItActive = request()->routeIs('it-tickets.*');

    $totalTagihan = \App\Services\TagihanService::tagihanCount();
@endphp

<p class="sidebar-section-label">Menu Utama</p>

<a href="{{ route('koordinator.dashboard') }}"
    class="sidebar-item {{ request()->routeIs('koordinator.dashboard') ? 'active' : '' }}">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
    </svg>
    <span class="truncate">Dashboard</span>
</a>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isMeetingActive ? 'true' : 'false' }}">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="truncate">Meeting</span>
        </span>
        <svg class="w-3 h-3 caret {{ $isMeetingActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu {{ $isMeetingActive ? '' : 'hidden' }}">
    <a href="{{ route('koordinator.meetings.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('koordinator.meetings.index') ? 'active' : '' }}">
        <span class="flex-1 truncate">Meeting Saya</span>
        <span class="notif-badge-activity ml-auto" style="display:none;background:#ef4444;color:white;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;"></span>
    </a>
    <a href="{{ route('koordinator.mom.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('koordinator.mom.index') ? 'active' : '' }}"><span class="truncate">Rekap MOM</span></a>
    <a href="{{ route('koordinator.recordings.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('koordinator.recordings.*') ? 'active' : '' }}"><span class="truncate">Rekap Rapat</span></a>
    <a href="{{ route('calendar') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('calendar') ? 'active' : '' }}"><span class="truncate">Jadwal Meeting</span></a>
</div>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isOperationalActive ? 'true' : 'false' }}">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span class="truncate">Operasional</span>
        </span>
        <svg class="w-3 h-3 caret {{ $isOperationalActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu {{ $isOperationalActive ? '' : 'hidden' }}">
    <a href="{{ route('koordinator.asset-saya.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('koordinator.asset-saya.*') ? 'active' : '' }}">
        <span class="truncate">Data Aset Saya</span>
    </a>
    <a href="{{ route('koordinator.aset-tim.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('koordinator.aset-tim.index') ? 'active' : '' }}"><span class="truncate">Aset TIM</span></a>
    <a href="{{ route('koordinator.aset-mes.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('koordinator.aset-mes.index') ? 'active' : '' }}"><span class="truncate">Aset MES</span></a>
</div>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isPaymentActive ? 'true' : 'false' }}">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <span class="truncate">Pembayaran</span>
        </span>
        <svg class="w-3 h-3 caret {{ $isPaymentActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu {{ $isPaymentActive ? '' : 'hidden' }}">
    <a href="{{ route('payment-approval.tagihan') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('payment-approval.tagihan') ? 'active' : '' }}">
        <span class="truncate">Tagihan</span>
        <span class="sidebar-badge tagihan-badge" style="{{ $totalTagihan > 0 ? '' : 'display:none;' }}background:#ef4444;color:#fff;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;line-height:1.4;">{{ $totalTagihan }}</span>
    </a>
    <a href="{{ route('payment-approval.status') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('payment-approval.status') ? 'active' : '' }}"><span class="truncate">Status Pengajuan</span></a>
</div>

<p class="sidebar-section-label">Layanan</p>

<a href="{{ route('it-tickets.index') }}"
    class="sidebar-item {{ $isItActive ? 'active' : '' }}">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
    </svg>
    <span class="truncate">Ticketing IT</span>
</a>

<p class="sidebar-section-label">Akun</p>
<a href="{{ route('profile.edit') }}"
    class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    <span class="truncate">Profile</span>
</a>
