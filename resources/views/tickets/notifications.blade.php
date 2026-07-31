@extends('layouts.app')
@section('title', 'Notifikasi Ticket')
@section('page-title', 'Notifikasi Ticket')
@section('page-subtitle', 'Semua pemberitahuan bantuan IT Anda')
@section('sidebar-menu')
@if(auth()->user()->isTicketTeam())
    @include('partials.sidebar-admin')
@elseif(in_array(auth()->user()->role, ['koordinator', 'head_of_store', 'gm', 'hr', 'ceo']))
    @include('partials.sidebar-leader')
@else
    @include('partials.sidebar-user')
@endif
@endsection

@section('content')
<div class="tk tk-stack">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <p class="tk-eyebrow mb-1">Inbox · Bantuan IT</p>
            <h2 class="text-base font-bold" style="color:var(--tk-text);">Notifikasi</h2>
            <p class="text-xs" style="color:var(--tk-muted);">{{ $notifications->total() }} notifikasi</p>
        </div>
        <div class="flex items-center gap-2">
            <form method="POST" action="{{ route('ticket.notifications.read') }}" onsubmit="confirmSubmit(event, this)" data-confirm="Tandai semua notifikasi sudah dibaca?">
                @csrf
                <button type="submit" class="btn btn-secondary btn-sm">✓ Tandai Dibaca</button>
            </form>
            <form method="POST" action="{{ route('ticket.notifications.destroy') }}" data-confirm="Hapus semua notifikasi?" onsubmit="confirmSubmit(event, this)">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">🗑 Hapus Semua</button>
            </form>
        </div>
    </div>

    <div class="tk-card p-3">
        @if($notifications->isEmpty())
        <div class="tk-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <p>Tidak ada notifikasi.</p>
        </div>
        @else
        <div class="space-y-2">
            @foreach($notifications as $notification)
            <a href="{{ route('ticket.notifications.read', ['url' => $notification->url ?: route('ticket.show', $notification->ticket_id)]) }}"
                class="tk-notif {{ $notification->is_read ? '' : 'unread' }}">
                <span class="tk-slip">
                    <span class="tk-slip-tab" style="background:{{ $notification->is_read ? 'var(--tk-muted)' : 'var(--tk-accent)' }};"></span>
                    {{ $notification->ticket?->ticket_number ?? 'TICKET' }}
                </span>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-sm font-semibold truncate" style="color:{{ $notification->is_read ? 'var(--tk-muted)' : 'var(--tk-text)' }};">{{ $notification->title }}</p>
                        <span class="tk-mono text-[0.6rem] whitespace-nowrap" style="color:var(--tk-muted);">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs mt-0.5" style="color:var(--tk-muted);">{{ $notification->message }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-3">{{ $notifications->links() }}</div>
        @endif
    </div>
</div>
@endsection
