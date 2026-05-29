@extends('layouts.app')
@section('title', 'Rekap MOM')
@section('page-title', 'Rekap Minutes of Meeting')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Filter --}}
    <div class="gaming-card p-5">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="gaming-label">Periode</label>
                <select name="period" class="gaming-input" onchange="this.form.submit()">
                    <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Harian</option>
                    <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                    <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                </select>
            </div>
            <div id="filter-date" class="{{ $period === 'daily' ? '' : 'hidden' }}">
                <label class="gaming-label">Tanggal</label>
                <input type="date" name="date" class="gaming-input" value="{{ request('date', today()->format('Y-m-d')) }}" onchange="this.form.submit()">
            </div>
            <div id="filter-week" class="{{ $period === 'weekly' ? '' : 'hidden' }}">
                <label class="gaming-label">Minggu</label>
                <input type="week" name="week" class="gaming-input" value="{{ request('week', now()->format('Y-\WW')) }}" onchange="this.form.submit()">
            </div>
            <div id="filter-month" class="{{ $period === 'monthly' ? '' : 'hidden' }}">
                <label class="gaming-label">Bulan</label>
                <input type="month" name="month" class="gaming-input" value="{{ request('month', now()->format('Y-m')) }}" onchange="this.form.submit()">
            </div>
            <div id="filter-custom" class="{{ !in_array($period, ['daily','weekly','monthly','all']) ? '' : 'hidden' }}">
                <label class="gaming-label">Dari</label>
                <input type="date" name="start_date" class="gaming-input" value="{{ request('start_date') }}">
            </div>
            <div id="filter-custom-end" class="{{ !in_array($period, ['daily','weekly','monthly','all']) ? '' : 'hidden' }}">
                <label class="gaming-label">Sampai</label>
                <input type="date" name="end_date" class="gaming-input" value="{{ request('end_date') }}">
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
            </div>
            <div>
                <button type="button" onclick="window.print()" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak / PDF
                </button>
            </div>
        </form>
    </div>

    {{-- Summary --}}
    <div class="gaming-card p-4 flex items-center justify-between">
        <p class="text-sm" style="color:var(--text-muted);">Total MOM Terkirim: <strong style="color:var(--text-primary);">{{ $moms->total() }}</strong></p>
    </div>

    {{-- Table --}}
    <div class="gaming-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[900px]">
                <thead>
                    <tr>
                        <th>Judul Meeting</th>
                        <th>PIC</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal Meeting</th>
                        <th>Dikirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($moms as $mom)
                    <tr>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $mom->meeting->title ?? '—' }}</td>
                        <td style="color:var(--text-secondary);">{{ $mom->pic }}</td>
                        <td style="color:var(--text-muted);">{{ $mom->creator->name ?? '—' }}</td>
                        <td style="color:var(--text-muted);">{{ $mom->meeting->meeting_date ? $mom->meeting->meeting_date->format('d M Y') : '—' }}</td>
                        <td style="color:var(--text-muted);">{{ $mom->sent_at ? $mom->sent_at->format('d M Y H:i') : '—' }}</td>
                        <td>
                            <a href="{{ route('admin.meetings.show', $mom->meeting_id) }}" class="btn btn-secondary btn-sm">Detail Meeting</a>
                            @if($mom->file_path)
                            <a href="{{ Storage::url($mom->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">Download</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada MOM terkirim.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $moms->links() }}</div>
    </div>

    {{-- Detail cards for print --}}
    <div class="print-only space-y-4">
        @foreach($moms as $mom)
        <div class="gaming-card p-6" style="break-inside:avoid;">
            <h3 class="font-gaming font-bold text-lg" style="color:var(--text-primary);">{{ $mom->meeting->title ?? 'Meeting' }}</h3>
            <p class="text-sm mt-1" style="color:var(--text-muted);">{{ $mom->meeting->meeting_date ? $mom->meeting->meeting_date->format('d M Y') : '' }} · {{ $mom->meeting->room->name ?? '' }}</p>
            <div class="mt-4 space-y-3">
                <div><p class="text-xs font-semibold" style="color:var(--color-accent-light);">RINGKASAN PEMBAHASAN</p><p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $mom->summary }}</p></div>
                <div><p class="text-xs font-semibold" style="color:var(--color-accent-light);">KEPUTUSAN</p><p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $mom->decisions }}</p></div>
                <div><p class="text-xs font-semibold" style="color:var(--color-accent-light);">ACTION PLAN</p><p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $mom->action_plan }}</p></div>
                <div><p class="text-xs font-semibold" style="color:var(--color-accent-light);">PIC</p><p class="text-sm mt-1" style="color:var(--text-primary);font-weight:600;">{{ $mom->pic }}</p></div>
            </div>
            @if($mom->file_path)
            <p class="text-xs mt-3" style="color:var(--text-muted);">Lampiran: {{ basename($mom->file_path) }}</p>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .gaming-sidebar, .gaming-topbar, .btn, form, .pagination, .print-only { display: block !important; }
        .sidebar-item, .sidebar-section-label, [data-dropdown], #push-status, .flash-success, .flash-error { display: none !important; }
        body { background: white !important; color: black !important; }
        .gaming-card { border: 1px solid #ddd !important; box-shadow: none !important; }
        .lg\\:ml-64 { margin-left: 0 !important; }
        .page-content { padding: 0 !important; }
        nav, header, .flex-wrap .btn { display: none !important; }
        .print-only { display: block !important; }
        .gaming-table { display: none !important; }
        .space-y-4 > .gaming-card:first-child { display: none !important; }
        .space-y-4 > .gaming-card:nth-child(2) { display: none !important; }
    }
</style>
@endpush
