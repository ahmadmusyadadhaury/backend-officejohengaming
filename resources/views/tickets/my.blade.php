@extends('layouts.app')
@section('title', 'Ticket Saya')
@section('page-title', 'Ticket Saya')
@section('page-subtitle', 'Riwayat ticket yang Anda buat')
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
            <p class="tk-eyebrow mb-1">Laporan Saya · Riwayat</p>
            <h2 class="text-base font-bold" style="color:var(--tk-text);">Ticket Saya</h2>
            <p class="text-xs" style="color:var(--tk-muted);">{{ $tickets->total() }} ticket dibuat oleh Anda</p>
        </div>
        <button type="button" onclick="openModal('create-ticket-modal')" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Ticket
        </button>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('ticket.my') }}" class="tk-card p-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5">
            <select name="status" class="gaming-select">
                <option value="">Semua Status</option>
                @foreach(\App\Support\Ticket::statuses() as $st)
                <option value="{{ $st }}" {{ ($filters['status'] ?? '') === $st ? 'selected' : '' }}>{{ \App\Support\Ticket::statusLabel($st) }}</option>
                @endforeach
            </select>
            <select name="filter" class="gaming-select">
                <option value="">Semua</option>
                <option value="active" {{ ($filters['filter'] ?? '') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="closed" {{ ($filters['filter'] ?? '') === 'closed' ? 'selected' : '' }}>Selesai</option>
                <option value="over_sla" {{ ($filters['filter'] ?? '') === 'over_sla' ? 'selected' : '' }}>Over SLA</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            <a href="{{ route('ticket.my') }}" class="btn btn-secondary btn-sm">Reset</a>
        </div>
    </form>

    <div class="tk-card p-3 overflow-x-auto">
        @if($tickets->isEmpty())
        <div class="tk-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p>Belum ada ticket. Klik "Buat Ticket" untuk melapor masalah.</p>
            <div class="tk-empty-action">
                <button type="button" onclick="openModal('create-ticket-modal')" class="btn btn-primary btn-sm">+ Buat Ticket</button>
            </div>
        </div>
        @else
        <table class="tk-table w-full">
            @php
                $statusMap = [
                    'open' => ['Menunggu', '#94a3b8'],
                    'waiting_user' => ['Menunggu', '#94a3b8'],
                    'assigned' => ['Diproses', '#f59e0b'],
                    'in_progress' => ['Diproses', '#f59e0b'],
                    'reopened' => ['Diproses', '#f59e0b'],
                    'resolved' => ['Selesai', '#22c55e'],
                    'closed' => ['Selesai', '#22c55e'],
                    'cancelled' => ['Dibatalkan', '#111827'],
                    'rejected' => ['Ditolak', '#ef4444'],
                ];
            @endphp
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Diajukan</th>
                    <th>Status</th>
                    <th>PIC</th>
                    <th>Catatan TIM IT</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                @php
                    [$statusLabel, $statusColor] = $statusMap[$ticket->status] ?? [$ticket->statusLabel(), $ticket->statusColor()];
                    $resolveHistory = $ticket->histories->first(fn ($h) => $h->action === 'resolved');
                    $resolveNote = $resolveHistory ? Str::after($resolveHistory->description, ' — ') : null;
                @endphp
                <tr>
                    <td>
                        <a href="javascript:void(0)" onclick="openTicketDetail({{ $ticket->id }}, '{{ addslashes($ticket->ticket_number) }}')">
                            <span class="tk-slip">
                                <span class="tk-slip-tab" style="background:{{ $ticket->priorityColor() }};"></span>
                                {{ $ticket->ticket_number }}
                            </span>
                        </a>
                        <p class="text-sm font-semibold truncate max-w-[200px]" style="color:var(--tk-text);">{{ $ticket->title }}</p>
                    </td>
                    <td class="tk-mono text-xs whitespace-nowrap" style="color:var(--tk-muted);">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="tk-chip" style="background:{{ $statusColor }}1a;color:{{ $statusColor }};border-color:{{ $statusColor }}40;">
                            <span class="tk-chip-dot" style="background:{{ $statusColor }};"></span>
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td><span class="text-xs" style="color:var(--tk-muted);">{{ $ticket->technician?->name ?? '—' }}</span></td>
                    <td>
                        @if($resolveNote)
                        <span class="text-xs" style="color:var(--tk-muted);" title="{{ $resolveNote }}">{{ Str::limit($resolveNote, 40) }}</span>
                        @else
                        <span class="text-xs" style="color:var(--tk-muted);">—</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" onclick="openTicketDetail({{ $ticket->id }}, '{{ addslashes($ticket->ticket_number) }}')" class="btn btn-sm btn-secondary">Detail</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $tickets->links() }}
        </div>
        @endif
    </div>
</div>

@include('tickets.partials.create-modal')
@include('tickets.partials.detail-modal')
@endsection
