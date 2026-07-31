@extends('layouts.app')
@section('title', 'Laporan Ticket')
@section('page-title', 'Laporan Ticket')
@section('page-subtitle', 'Rekap, analisis, dan ekspor data ticket')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="tk tk-stack">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <p class="tk-eyebrow mb-1">Help Desk · Analisis</p>
            <h2 class="text-base font-bold" style="color:var(--tk-text);">Laporan & Statistik</h2>
            <p class="text-xs" style="color:var(--tk-muted);">Analisis performa layanan IT helpdesk</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('ticket.reports.print', request()->query()) }}" target="_blank" class="btn btn-secondary btn-sm">🖨 Cetak</a>
            <a href="{{ route('ticket.reports.export', request()->query()) }}" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export Excel
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('ticket.reports') }}" class="tk-card p-4">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2.5">
            <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="gaming-input">
            <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="gaming-input">
            <select name="category_id" class="gaming-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="priority" class="gaming-select">
                <option value="">Semua Prioritas</option>
                @foreach(\App\Support\Ticket::priorities() as $pr)
                <option value="{{ $pr }}" {{ ($filters['priority'] ?? '') === $pr ? 'selected' : '' }}>{{ $pr }}</option>
                @endforeach
            </select>
            <select name="status" class="gaming-select">
                <option value="">Semua Status</option>
                @foreach(\App\Support\Ticket::statuses() as $st)
                <option value="{{ $st }}" {{ ($filters['status'] ?? '') === $st ? 'selected' : '' }}>{{ \App\Support\Ticket::statusLabel($st) }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-2 mt-3">
            <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
            <a href="{{ route('ticket.reports') }}" class="btn btn-secondary btn-sm">Reset</a>
        </div>
    </form>

    {{-- Summary --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 md:gap-3">
        @php
            $summaryCards = [
                ['label' => 'Total Ticket', 'count' => $summary['total'], 'color' => '#6366f1'],
                ['label' => 'Selesai / Ditutup', 'count' => $summary['closed'], 'color' => '#10b981'],
                ['label' => 'Sedang Diproses', 'count' => $summary['processing'] + $summary['open'], 'color' => '#f59e0b'],
                ['label' => 'Over SLA', 'count' => $summary['over_sla'], 'color' => '#ef4444'],
            ];
        @endphp
        @foreach($summaryCards as $card)
        <div class="tk-stat" style="--tk-stat-accent:{{ $card['color'] }};">
            <div class="tk-stat-num" style="color:{{ $card['color'] }};">{{ $card['count'] }}</div>
            <div class="tk-stat-label">{{ $card['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Grafik per kategori --}}
    @if($byCategory->isNotEmpty())
    <div class="tk-card p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="tk-eyebrow mb-0.5">Distribusi</p>
                <h3 class="tk-h">Ticket per Kategori</h3>
            </div>
            <span class="tk-mono text-xs" style="color:#f59e0b;">★ {{ $avgRating }} rata-rata</span>
        </div>
        <div class="space-y-3">
            @php $maxCat = max(1, $byCategory->max()); @endphp
            @foreach($byCategory as $name => $count)
            <div>
                <div class="flex items-center justify-between text-xs mb-1">
                    <span style="color:var(--tk-text);">{{ $name }}</span>
                    <span class="tk-mono font-semibold" style="color:var(--tk-text);">{{ $count }}</span>
                </div>
                <div class="tk-rail">
                    <i style="width:{{ round($count / $maxCat * 100) }}%;background:var(--tk-accent);"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Tabel detail --}}
    <div class="tk-card p-3 overflow-x-auto">
        <div class="flex items-center justify-between px-1 pt-2 pb-3">
            <div>
                <p class="tk-eyebrow mb-0.5">Detail</p>
                <h3 class="tk-h">Detail Ticket ({{ $tickets->count() }})</h3>
            </div>
        </div>
        @if($tickets->isEmpty())
        <div class="tk-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p>Tidak ada data untuk filter ini.</p>
        </div>
        @else
        <table class="tk-table w-full">
            <thead>
                <tr>
                    <th>No. Ticket</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Pengaju</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Rating</th>
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
                    <td class="text-sm max-w-[200px] truncate" style="color:var(--tk-text);">{{ $ticket->title }}</td>
                    <td class="text-xs" style="color:var(--tk-muted);">{{ $ticket->category?->name ?? '-' }}</td>
                    <td class="text-xs" style="color:var(--tk-text);">{{ $ticket->requester?->name }}</td>
                    <td>
                        <span class="tk-chip" style="background:{{ $ticket->priorityColor() }}1a;color:{{ $ticket->priorityColor() }};border-color:{{ $ticket->priorityColor() }}40;">
                            <span class="tk-chip-dot" style="background:{{ $ticket->priorityColor() }};"></span>
                            {{ $ticket->priorityLabel() }}
                        </span>
                    </td>
                    <td>@include('tickets.partials.badges', ['ticket' => $ticket])</td>
                    <td class="tk-mono text-xs whitespace-nowrap" style="color:var(--tk-muted);">{{ $ticket->created_at->format('d/m/Y') }}</td>
                    <td class="tk-mono text-xs" style="color:#f59e0b;">{{ $ticket->rating ? str_repeat('★', $ticket->rating->rating) : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
