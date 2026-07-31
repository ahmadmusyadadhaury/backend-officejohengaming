@extends('layouts.app')
@section('title', 'Dashboard Ticket')
@section('page-title', 'Dashboard Ticket')
@section('page-subtitle', 'Pantau ticket bantuan IT Anda')
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
            <p class="tk-eyebrow mb-1">IT Helpdesk · Operations Console</p>
            <h2 class="text-base font-bold" style="color:var(--tk-text);">Bantuan IT, terpantau hingga tuntas</h2>
            <p class="text-xs" style="color:var(--tk-muted);">Lapor masalah IT dan pantau progresnya dalam satu tempat.</p>
        </div>
        <a href="{{ route('ticket.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Ticket
        </a>
    </div>

    {{-- Stat tiles --}}
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-2.5 md:gap-3">
        @php
            $cards = [
                ['label' => 'Total Ticket', 'count' => $stats['total'], 'color' => '#6366f1', 'url' => route('ticket.index')],
                ['label' => 'Open', 'count' => $stats['open'], 'color' => '#94a3b8', 'url' => route('ticket.index', ['status' => 'open'])],
                ['label' => 'Sedang Diproses', 'count' => $stats['processing'], 'color' => '#f59e0b', 'url' => route('ticket.index', ['status' => 'in_progress'])],
                ['label' => 'Menunggu Anda', 'count' => $stats['waiting_user'], 'color' => '#8b5cf6', 'url' => route('ticket.index', ['status' => 'waiting_user'])],
                ['label' => 'Over SLA', 'count' => $stats['over_sla'], 'color' => '#ef4444', 'url' => route('ticket.index', ['filter' => 'over_sla'])],
                ['label' => 'Selesai', 'count' => $stats['closed'], 'color' => '#10b981', 'url' => route('ticket.index', ['status' => 'closed'])],
            ];
        @endphp
        @foreach($cards as $card)
        <a href="{{ $card['url'] }}" class="tk-stat" style="--tk-stat-accent:{{ $card['color'] }};">
            <div class="tk-stat-num" style="color:{{ $card['color'] }};">{{ $card['count'] }}</div>
            <div class="tk-stat-label">{{ $card['label'] }}</div>
        </a>
        @endforeach
    </div>

    {{-- Queue rail --}}
    <div class="tk-queue">
        @php
            $queue = [
                ['label' => 'Open', 'count' => $stats['open'], 'color' => '#94a3b8', 'url' => route('ticket.index', ['status' => 'open'])],
                ['label' => 'Diproses', 'count' => $stats['processing'], 'color' => '#f59e0b', 'url' => route('ticket.index', ['status' => 'in_progress'])],
                ['label' => 'Menunggu User', 'count' => $stats['waiting_user'], 'color' => '#8b5cf6', 'url' => route('ticket.index', ['status' => 'waiting_user'])],
                ['label' => 'Selesai', 'count' => $stats['closed'], 'color' => '#10b981', 'url' => route('ticket.index', ['status' => 'closed'])],
            ];
        @endphp
        @foreach($queue as $col)
        <a href="{{ $col['url'] }}" class="tk-queue-col tk-card-hover" style="text-decoration:none;--tk-queue-accent:{{ $col['color'] }};">
            <div class="tk-queue-num" style="color:{{ $col['color'] }};">{{ $col['count'] }}</div>
            <div class="tk-queue-label">{{ $col['label'] }}</div>
        </a>
        @endforeach
    </div>

    {{-- Filter tabs --}}
    <div class="tk-tabs">
        @php
            $tabs = [
                ['key' => 'active', 'label' => 'Aktif'],
                ['key' => 'closed', 'label' => 'Selesai'],
                ['key' => 'all', 'label' => 'Semua'],
                ['key' => 'open', 'label' => 'Open'],
                ['key' => 'in_progress', 'label' => 'Diproses'],
                ['key' => 'waiting_user', 'label' => 'Menunggu'],
                ['key' => 'resolved', 'label' => 'Resolved'],
            ];
        @endphp
        @foreach($tabs as $tab)
        <a href="{{ route('ticket.dashboard', ['status' => $tab['key']]) }}"
            class="tk-tab {{ $statusFilter === $tab['key'] ? 'is-active' : '' }}">{{ $tab['label'] }}</a>
        @endforeach
    </div>

    {{-- Recent tickets --}}
    <div class="tk-card p-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <p class="tk-eyebrow mb-0.5">Antrian Terbaru</p>
                <h3 class="tk-h">Ticket Terbaru</h3>
            </div>
            @if(auth()->user()->isTicketTeam())
            <a href="{{ route('ticket.index') }}" class="tk-link">Lihat Semua →</a>
            @else
            <a href="{{ route('ticket.my') }}" class="tk-link">Lihat Semua →</a>
            @endif
        </div>

        @if($recent->isEmpty())
        <div class="tk-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p>Belum ada ticket. Buat ticket pertama Anda!</p>
            <div class="tk-empty-action">
                <a href="{{ route('ticket.create') }}" class="btn btn-primary btn-sm">+ Buat Ticket</a>
            </div>
        </div>
        @else
        <div class="space-y-2">
            @foreach($recent as $ticket)
            <a href="{{ route('ticket.show', $ticket) }}" class="flex flex-wrap items-center gap-3 p-3 rounded-xl tk-card-hover" style="border:1px solid var(--tk-border);text-decoration:none;">
                <span class="tk-slip">
                    <span class="tk-slip-tab" style="background:{{ $ticket->priorityColor() }};"></span>
                    {{ $ticket->ticket_number }}
                </span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold truncate" style="color:var(--tk-text);">{{ $ticket->title }}</p>
                    <p class="text-xs truncate" style="color:var(--tk-muted);">{{ $ticket->created_at->diffForHumans() }} · {{ $ticket->location }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    @if($ticket->isOverSla())
                    <span class="tk-sla tk-sla-over"><span class="tk-sla-dot"></span>Over SLA</span>
                    @endif
                    <span class="tk-chip" style="background:{{ $ticket->priorityColor() }}1a;color:{{ $ticket->priorityColor() }};border-color:{{ $ticket->priorityColor() }}40;">
                        <span class="tk-chip-dot" style="background:{{ $ticket->priorityColor() }};"></span>
                        {{ $ticket->priorityLabel() }}
                    </span>
                    @include('tickets.partials.badges', ['ticket' => $ticket])
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
