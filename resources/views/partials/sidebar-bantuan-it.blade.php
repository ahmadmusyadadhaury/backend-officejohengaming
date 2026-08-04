@php
    $ticketUnread = auth()->user()->ticketNotifications()->where('is_read', false)->count();
@endphp
<a href="{{ route('ticket.dashboard') }}"
    class="sidebar-item {{ request()->routeIs('ticket.*') ? 'active' : '' }}">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="truncate">Bantuan IT</span>
    @if($ticketUnread > 0)
    <span class="sidebar-badge" style="background:#ef4444;color:#fff;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;line-height:1.4;">{{ $ticketUnread }}</span>
    @endif
</a>
