@php
    $isTicketActive = request()->routeIs('ticket.*');
    $ticketUnread = auth()->user()->ticketNotifications()->where('is_read', false)->count();
@endphp

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="{{ $isTicketActive ? 'true' : 'false' }}">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="truncate">IT Ticketing</span>
        </span>
        <svg class="w-3 h-3 caret {{ $isTicketActive ? 'rotated' : '' }}" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu {{ $isTicketActive ? '' : 'hidden' }}">
    <a href="{{ route('ticket.dashboard') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.dashboard') ? 'active' : '' }}">
        <span class="truncate">Dashboard Ticket</span>
    </a>
    <a href="{{ route('ticket.create') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.create') ? 'active' : '' }}">
        <span class="truncate">Buat Ticket</span>
    </a>
    <a href="{{ route('ticket.my') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.my') ? 'active' : '' }}">
        <span class="truncate">Ticket Saya</span>
    </a>
    @if(auth()->user()->isTicketTeam())
    <a href="{{ route('ticket.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.index') ? 'active' : '' }}">
        <span class="truncate">Semua Ticket</span>
    </a>
    <a href="{{ route('ticket.reports') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.reports*') ? 'active' : '' }}">
        <span class="truncate">Laporan</span>
    </a>
    @endif
    @if(auth()->user()->isTicketLeader())
    <a href="{{ route('ticket.categories.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.categories.*') ? 'active' : '' }}">
        <span class="truncate">Kategori</span>
    </a>
    <a href="{{ route('ticket.sla.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.sla.*') ? 'active' : '' }}">
        <span class="truncate">SLA</span>
    </a>
    <a href="{{ route('ticket.team.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.team.*') ? 'active' : '' }}">
        <span class="truncate">Tim IT</span>
    </a>
    @endif
    <a href="{{ route('ticket.notifications.index') }}" class="sidebar-item sidebar-submenu-item {{ request()->routeIs('ticket.notifications.*') ? 'active' : '' }}">
        <span class="truncate">Notifikasi</span>
        @if($ticketUnread > 0)
        <span class="sidebar-badge" style="background:#ef4444;color:#fff;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;line-height:1.4;">{{ $ticketUnread }}</span>
        @endif
    </a>
</div>
