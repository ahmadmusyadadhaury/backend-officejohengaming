@extends('layouts.app')
@section('title', 'Semua Ticket')
@section('page-title', 'Semua Ticket')
@section('page-subtitle', 'Kelola seluruh ticket bantuan IT')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="tk tk-stack">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <p class="tk-eyebrow mb-1">Help Desk · Semua Antrian</p>
            <h2 class="text-base font-bold" style="color:var(--tk-text);">Semua Ticket</h2>
            <p class="text-xs" style="color:var(--tk-muted);">{{ $tickets->total() }} ticket ditemukan</p>
        </div>
        <button type="button" onclick="openModal('create-ticket-modal')" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Ticket
        </button>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('ticket.index') }}" class="tk-card p-4">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2.5">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nomor/judul..." class="gaming-input">
            <select name="status" class="gaming-select">
                <option value="">Semua Status</option>
                @foreach(\App\Support\Ticket::statuses() as $st)
                <option value="{{ $st }}" {{ ($filters['status'] ?? '') === $st ? 'selected' : '' }}>{{ \App\Support\Ticket::statusLabel($st) }}</option>
                @endforeach
            </select>
            <select name="priority" class="gaming-select">
                <option value="">Semua Prioritas</option>
                @foreach(\App\Support\Ticket::priorities() as $pr)
                <option value="{{ $pr }}" {{ ($filters['priority'] ?? '') === $pr ? 'selected' : '' }}>{{ $pr }}</option>
                @endforeach
            </select>
            <select name="category_id" class="gaming-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="technician" class="gaming-select">
                <option value="">Semua Teknisi</option>
                @foreach($technicians as $tech)
                <option value="{{ $tech->id }}" {{ ($filters['technician'] ?? '') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-3">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            <a href="{{ route('ticket.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            <a href="{{ route('ticket.index', ['filter' => 'over_sla']) }}" class="btn btn-sm {{ ($filters['filter'] ?? '') === 'over_sla' ? 'btn-danger' : 'btn-secondary' }}">Over SLA</a>
            <a href="{{ route('ticket.index', ['filter' => 'waiting']) }}" class="btn btn-sm {{ ($filters['filter'] ?? '') === 'waiting' ? 'btn-warning' : 'btn-secondary' }}">Menunggu User</a>
        </div>
    </form>

    {{-- Table --}}
    <div class="tk-card p-3 overflow-x-auto">
        @if($tickets->isEmpty())
        <div class="tk-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p>Tidak ada ticket yang cocok dengan filter.</p>
        </div>
        @else
        <table class="tk-table w-full">
            <thead>
                <tr>
                    <th>No. Ticket</th>
                    <th>Judul</th>
                    <th>Pengaju</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Teknisi</th>
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
                        <p class="text-sm font-semibold truncate max-w-[180px]" style="color:var(--tk-text);">{{ $ticket->title }}</p>
                        @if($ticket->isOverSla())
                        <span class="tk-sla tk-sla-over"><span class="tk-sla-dot"></span>Over SLA</span>
                        @endif
                    </td>
                    <td>
                        <p class="text-sm" style="color:var(--tk-text);">{{ $ticket->requester?->name }}</p>
                        <p class="text-[0.65rem]" style="color:var(--tk-muted);">{{ $ticket->department }}</p>
                    </td>
                    <td>
                        <span class="tk-chip" style="background:{{ $ticket->priorityColor() }}1a;color:{{ $ticket->priorityColor() }};border-color:{{ $ticket->priorityColor() }}40;">
                            <span class="tk-chip-dot" style="background:{{ $ticket->priorityColor() }};"></span>
                            {{ $ticket->priorityLabel() }}
                        </span>
                    </td>
                    <td>@include('tickets.partials.badges', ['ticket' => $ticket])</td>
                    <td><span class="text-xs" style="color:var(--tk-muted);">{{ $ticket->technician?->name ?? '-' }}</span></td>
                    <td class="tk-mono text-xs whitespace-nowrap" style="color:var(--tk-muted);">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
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
