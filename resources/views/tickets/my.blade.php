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
        <a href="{{ route('ticket.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Ticket
        </a>
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
                <a href="{{ route('ticket.create') }}" class="btn btn-primary btn-sm">+ Buat Ticket</a>
            </div>
        </div>
        @else
        <table class="tk-table w-full">
            <thead>
                <tr>
                    <th>No. Ticket</th>
                    <th>Judul</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Teknisi</th>
                    <th>SLA</th>
                    <th>Dibuat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr>
                    <td>
                        <span class="tk-slip">
                            <span class="tk-slip-tab" style="background:{{ $ticket->priorityColor() }};"></span>
                            {{ $ticket->ticket_number }}
                        </span>
                    </td>
                    <td>
                        <p class="text-sm font-semibold truncate max-w-[200px]" style="color:var(--tk-text);">{{ $ticket->title }}</p>
                    </td>
                    <td>
                        <span class="tk-chip" style="background:{{ $ticket->priorityColor() }}1a;color:{{ $ticket->priorityColor() }};border-color:{{ $ticket->priorityColor() }}40;">
                            <span class="tk-chip-dot" style="background:{{ $ticket->priorityColor() }};"></span>
                            {{ $ticket->priorityLabel() }}
                        </span>
                    </td>
                    <td>@include('tickets.partials.badges', ['ticket' => $ticket])</td>
                    <td><span class="text-xs" style="color:var(--tk-muted);">{{ $ticket->technician?->name ?? 'Belum ditugaskan' }}</span></td>
                    <td>
                        @if($ticket->isOverSla())
                        <span class="tk-sla tk-sla-over"><span class="tk-sla-dot"></span>Lewat Batas</span>
                        @else
                        <span class="tk-mono text-xs" style="color:var(--tk-muted);">{{ $ticket->slaProgress() }}</span>
                        @endif
                    </td>
                    <td class="tk-mono text-xs whitespace-nowrap" style="color:var(--tk-muted);">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('ticket.show', $ticket) }}" class="btn btn-sm btn-secondary">Detail</a>
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
@endsection
