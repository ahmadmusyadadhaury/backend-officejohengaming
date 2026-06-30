@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<style>
    .dashboard-wrapper .gaming-card {
        background: var(--bg-surface) !important;
    }
</style>

<div>
<div class="space-y-6 pt-2 stagger-children dashboard-wrapper">



    {{-- Komposisi Tim (GM & CEO) --}}
    @if(in_array(auth()->user()->role, ['gm', 'ceo']))
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-3 md:gap-4">

        {{-- CEO --}}
        <div class="gaming-card p-3 md:p-4 flex flex-col items-center gap-2 text-center" style="border:1px solid rgba(250,204,21,0.2);background:linear-gradient(135deg,rgba(250,204,21,0.03),rgba(250,204,21,0.08));">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#fbbf24,#f59e0b);box-shadow:0 4px 12px rgba(245,158,11,0.35);">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl md:text-2xl font-gaming font-bold" style="color:#fbbf24;">{{ $stats['total_ceo'] }}</div>
                <div class="text-[10px] md:text-xs font-semibold mt-0.5 leading-tight" style="color:var(--text-secondary);">Chief Executive Officer</div>
            </div>
        </div>

        {{-- GM --}}
        <div class="gaming-card p-3 md:p-4 flex flex-col items-center gap-2 text-center" style="border:1px solid rgba(139,92,246,0.2);background:linear-gradient(135deg,rgba(139,92,246,0.03),rgba(139,92,246,0.08));">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#a78bfa,#7c3aed);box-shadow:0 4px 12px rgba(124,58,237,0.35);">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl md:text-2xl font-gaming font-bold" style="color:#a78bfa;">{{ $stats['total_gm'] }}</div>
                <div class="text-[10px] md:text-xs font-semibold mt-0.5 leading-tight" style="color:var(--text-secondary);">General Manager</div>
            </div>
        </div>

        {{-- Head of Store --}}
        <div class="gaming-card p-3 md:p-4 flex flex-col items-center gap-2 text-center" style="border:1px solid rgba(52,211,153,0.2);background:linear-gradient(135deg,rgba(52,211,153,0.03),rgba(52,211,153,0.08));">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#34d399,#10b981);box-shadow:0 4px 12px rgba(16,185,129,0.35);">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl md:text-2xl font-gaming font-bold" style="color:#34d399;">{{ $stats['total_head_store'] }}</div>
                <div class="text-[10px] md:text-xs font-semibold mt-0.5 leading-tight" style="color:var(--text-secondary);">Head of Store</div>
            </div>
        </div>

        {{-- HR --}}
        <div class="gaming-card p-3 md:p-4 flex flex-col items-center gap-2 text-center" style="border:1px solid rgba(251,146,60,0.2);background:linear-gradient(135deg,rgba(251,146,60,0.03),rgba(251,146,60,0.08));">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#fb923c,#f97316);box-shadow:0 4px 12px rgba(249,115,22,0.35);">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl md:text-2xl font-gaming font-bold" style="color:#fb923c;">{{ $stats['total_hr'] }}</div>
                <div class="text-[10px] md:text-xs font-semibold mt-0.5 leading-tight" style="color:var(--text-secondary);">Human Resources</div>
            </div>
        </div>

        {{-- Koordinator --}}
        <div class="gaming-card p-3 md:p-4 flex flex-col items-center gap-2 text-center" style="border:1px solid rgba(56,189,248,0.2);background:linear-gradient(135deg,rgba(56,189,248,0.03),rgba(56,189,248,0.08));">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#38bdf8,#0ea5e9);box-shadow:0 4px 12px rgba(14,165,233,0.35);">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <div class="text-xl md:text-2xl font-gaming font-bold" style="color:#38bdf8;">{{ $stats['total_koordinator'] }}</div>
                <div class="text-[10px] md:text-xs font-semibold mt-0.5 leading-tight" style="color:var(--text-secondary);">Koordinator</div>
            </div>
        </div>

        {{-- Total Tim --}}
        <div class="gaming-card p-3 md:p-4 flex flex-col items-center gap-2 text-center" style="border:1px solid rgba(192,132,252,0.2);background:linear-gradient(135deg,rgba(192,132,252,0.03),rgba(192,132,252,0.08));">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#c084fc,#a855f7);box-shadow:0 4px 12px rgba(168,85,247,0.35);">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl md:text-2xl font-gaming font-bold" style="color:#c084fc;">{{ $stats['total_team'] }}</div>
                <div class="text-[10px] md:text-xs font-semibold mt-0.5 leading-tight" style="color:var(--text-secondary);">Total Tim</div>
            </div>
        </div>

        {{-- Karyawan --}}
        <div class="gaming-card p-3 md:p-4 flex flex-col items-center gap-2 text-center" style="border:1px solid rgba(248,113,113,0.2);background:linear-gradient(135deg,rgba(248,113,113,0.03),rgba(248,113,113,0.08));">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#f87171,#ef4444);box-shadow:0 4px 12px rgba(239,68,68,0.35);">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl md:text-2xl font-gaming font-bold" style="color:#f87171;">{{ $stats['total_karyawan'] }}</div>
                <div class="text-[10px] md:text-xs font-semibold mt-0.5 leading-tight" style="color:var(--text-secondary);">Karyawan</div>
            </div>
        </div>

    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">

        {{-- Total Meeting --}}
        <div class="gaming-card p-4 md:p-5 flex items-center gap-3 md:gap-4" style="border:1px solid rgba(59,130,246,0.15);">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(59,130,246,0.12);box-shadow:0 0 16px rgba(59,130,246,0.2);">
                <svg class="w-5 h-5 md:w-6 md:h-6" style="color:#93c5fd;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-2xl md:text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total_meetings'] }}</div>
                <div class="text-xs md:text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Meeting</div>
            </div>
        </div>

        {{-- Total Asset --}}
        <div class="gaming-card p-4 md:p-5 flex items-center gap-3 md:gap-4" style="border:1px solid rgba(124,58,237,0.15);">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.12);box-shadow:0 0 16px rgba(124,58,237,0.2);">
                <svg class="w-5 h-5 md:w-6 md:h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-2xl md:text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total_assets'] }}</div>
                <div class="text-xs md:text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Asset</div>
            </div>
        </div>

        {{-- Total Tagihan --}}
        <div class="gaming-card p-4 md:p-5 flex items-center gap-3 md:gap-4" style="border:1px solid rgba(16,185,129,0.15);">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.12);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-5 h-5 md:w-6 md:h-6" style="color:#6ee7b7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-2xl md:text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total_payments'] }}</div>
                <div class="text-xs md:text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Tagihan</div>
            </div>
        </div>

    </div>

    {{-- Meeting Hari Ini + Pembayaran Mendatang --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 md:gap-4">
        {{-- Meeting Hari Ini --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
                <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                    <svg class="w-5 h-5" style="color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    MEETING HARI INI
                </h3>
                <span class="badge" style="background:rgba(59,130,246,0.2);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);font-size:0.7rem;">{{ today()->isoFormat('D MMM') }}</span>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($todayMeetings as $meeting)
                <div class="px-5 py-3 flex items-center gap-3 transition hover:bg-slate-100/5">
                    <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#60a5fa;box-shadow:0 0 6px rgba(96,165,250,0.6);"></span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }} · {{ $meeting->team->name }} · {{ $meeting->room->name }}</p>
                    </div>
                </div>
                @empty
                <div class="px-5 py-6 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting hari ini</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Pembayaran Mendatang --}}
        @php
            $hasOverdue = $overduePayments->isNotEmpty();
            $hasToday   = $todayPayments->isNotEmpty();
            $hasWarning = $warningPayments->isNotEmpty();
        @endphp
        @if($hasOverdue || $hasToday || $hasWarning)
        <div class="gaming-card overflow-hidden flex flex-col">
            <div class="flex items-center justify-between px-5 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
                <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                    <svg class="w-5 h-5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    PEMBAYARAN MENDATANG
                </h3>
                <button type="button" onclick="openModal('semua-pembayaran-modal')" class="text-xs font-medium cursor-pointer" style="color:var(--color-accent);">Lihat Semua &rarr;</button>
            </div>
                @if($tokenAlertDashboard)
                <a href="{{ route('admin.pembayaran.index', ['jenis' => 'listrik']) }}" class="block rounded-xl overflow-hidden transition" style="text-decoration:none;margin-bottom:8px;background:{{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.04)' : ($tokenAlertDashboard['level'] === 'warning' ? 'rgba(245,158,11,0.04)' : 'rgba(59,130,246,0.04)') }};border:1px solid {{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.15)' : ($tokenAlertDashboard['level'] === 'warning' ? 'rgba(245,158,11,0.15)' : 'rgba(59,130,246,0.15)') }};" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <div class="px-4 py-2.5 flex items-center justify-between" style="border-bottom:1px solid {{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.08)' : ($tokenAlertDashboard['level'] === 'warning' ? 'rgba(245,158,11,0.08)' : 'rgba(59,130,246,0.08)') }};">
                        <span class="text-xs font-gaming font-bold uppercase tracking-wider" style="color:{{ $tokenAlertDashboard['level'] === 'danger' ? '#ef4444' : ($tokenAlertDashboard['level'] === 'warning' ? '#f59e0b' : '#3b82f6') }};">
                            Token Listrik
                            @if($tokenAlertDashboard['level'] === 'danger')
                                — Segera Isi
                            @elseif($tokenAlertDashboard['level'] === 'warning')
                                — Warning
                            @else
                                — Perhatian
                            @endif
                        </span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold" style="background:{{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.15)' : ($tokenAlertDashboard['level'] === 'warning' ? 'rgba(245,158,11,0.15)' : 'rgba(59,130,246,0.15)') }};color:{{ $tokenAlertDashboard['level'] === 'danger' ? '#ef4444' : ($tokenAlertDashboard['level'] === 'warning' ? '#f59e0b' : '#3b82f6') }};">{{ number_format($tokenAlertDashboard['kwh'], 0) }} KWH</span>
                    </div>
                    <div class="px-4 py-2.5 flex items-center justify-between">
                        <span class="text-xs" style="color:var(--text-muted);">{{ $tokenAlertDashboard['message'] }}</span>
                        <svg class="w-4 h-4 flex-shrink-0" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                @endif
            <div class="overflow-y-auto p-2.5 space-y-2.5" style="max-height:340px;">
                @if($hasOverdue)
                <div class="rounded-xl overflow-hidden" style="background:rgba(239,68,68,0.04);border:1px solid rgba(239,68,68,0.1);">
                    <div class="px-4 py-2.5 flex items-center justify-between" style="border-bottom:1px solid rgba(239,68,68,0.08);">
                        <span class="text-xs font-gaming font-bold uppercase tracking-wider" style="color:#ef4444;">Terlewat</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold" style="background:rgba(239,68,68,0.15);color:#ef4444;">{{ $overduePayments->count() }}</span>
                    </div>
                    @foreach($overduePayments as $p)
                    <div class="px-4 py-2.5 flex items-center justify-between gap-3 pembayaran-item" style="cursor:pointer;{{ !$loop->last ? 'border-bottom:1px solid rgba(239,68,68,0.06);' : '' }}" onclick="openDashboardBayar({{ $p['id'] }}, '{{ $p['type'] }}')">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                            <p class="text-xs mt-0.5" style="color:#ef4444;">Lewat {{ \Carbon\Carbon::parse($p['due_date'])->diffInDays() }} hari &middot; {{ $p['jenis'] }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                            <span class="badge text-[10px] mt-0.5" style="background:rgba(239,68,68,0.12);color:#ef4444;border:1px solid rgba(239,68,68,0.2);">{{ ucfirst($p['status']) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($hasToday)
                <div class="rounded-xl overflow-hidden" style="background:rgba(245,158,11,0.04);border:1px solid rgba(245,158,11,0.1);">
                    <div class="px-4 py-2.5 flex items-center justify-between" style="border-bottom:1px solid rgba(245,158,11,0.08);">
                        <span class="text-xs font-gaming font-bold uppercase tracking-wider" style="color:#f59e0b;">Hari Ini</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold" style="background:rgba(245,158,11,0.15);color:#f59e0b;">{{ $todayPayments->count() }}</span>
                    </div>
                    @foreach($todayPayments as $p)
                    <div class="px-4 py-2.5 flex items-center justify-between gap-3 pembayaran-item" style="cursor:pointer;{{ !$loop->last ? 'border-bottom:1px solid rgba(245,158,11,0.06);' : '' }}" onclick="openDashboardBayar({{ $p['id'] }}, '{{ $p['type'] }}')">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                            <p class="text-xs mt-0.5" style="color:#f59e0b;">Jatuh tempo hari ini &middot; {{ $p['jenis'] }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                            <span class="badge text-[10px] mt-0.5" style="background:rgba(245,158,11,0.12);color:#fbbf24;border:1px solid rgba(245,158,11,0.2);">{{ ucfirst($p['status']) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($hasWarning)
                <div class="rounded-xl overflow-hidden" style="background:rgba(245,158,11,0.04);border:1px solid rgba(245,158,11,0.1);">
                    <div class="px-4 py-2.5 flex items-center justify-between" style="border-bottom:1px solid rgba(245,158,11,0.08);">
                        <span class="text-xs font-gaming font-bold uppercase tracking-wider" style="color:#f59e0b;">Mendatang</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold" style="background:rgba(245,158,11,0.15);color:#fbbf24;">{{ $warningPayments->count() }}</span>
                    </div>
                    @foreach($warningPayments as $p)
                    <div class="px-4 py-2.5 flex items-center justify-between gap-3 pembayaran-item" style="cursor:pointer;{{ !$loop->last ? 'border-bottom:1px solid rgba(245,158,11,0.06);' : '' }}" onclick="openDashboardBayar({{ $p['id'] }}, '{{ $p['type'] }}')">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                            <p class="text-xs mt-0.5" style="color:var(--text-muted);">Jatuh tempo {{ \Carbon\Carbon::parse($p['due_date'])->format('d M Y') }} &middot; {{ $p['jenis'] }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                            <span class="badge text-[10px] mt-0.5" style="background:rgba(245,158,11,0.12);color:#fbbf24;border:1px solid rgba(245,158,11,0.2);">{{ ucfirst($p['status']) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="gaming-card overflow-hidden flex items-center justify-center" style="min-height:120px;">
            <p class="text-sm" style="color:var(--text-muted);">Tidak ada pembayaran mendatang</p>
        </div>
        @endif
    </div>

    @php
        $isApprover = in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr', 'admin']);
    @endphp
    @if($isApprover && ($pendingPajakApprovalsCount ?? 0) > 0)
    <a href="{{ route('admin.vehicles.index') }}#pending-approvals" style="text-decoration:none;display:block;">
        <div class="gaming-card px-5 py-4 flex items-center gap-3" style="background:rgba(245,158,11,0.04);border:1px solid rgba(245,158,11,0.15);transition:all 0.2s;" onmouseover="this.style.borderColor='rgba(245,158,11,0.4)'" onmouseout="this.style.borderColor='rgba(245,158,11,0.15)'">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(245,158,11,0.12);">
                <svg class="w-5 h-5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div style="font-weight:600;font-size:15px;color:#f59e0b;">{{ $pendingPajakApprovalsCount }} Pengajuan Pajak Menunggu</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Pengajuan pembayaran pajak kendaraan perlu persetujuan</div>
            </div>
            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </a>
    @endif

    {{-- Grafik Pengeluaran & Tagihan + Ringkasan --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 md:gap-4">
        <div class="gaming-card p-4 md:p-5 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                    <svg class="w-5 h-5" style="color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    PENGELUARAN & TAGIHAN
                </h3>
                <span class="text-xs" style="color:var(--text-muted);">6 bulan terakhir</span>
            </div>
            <div style="position:relative;height:260px;"><canvas id="monthlyChart"></canvas></div>
        </div>
        @php
            $sumTagihan = array_sum($chartTagihan);
            $sumBayar = array_sum($chartBayar);
            $sisa = $sumTagihan - $sumBayar;
            $pctBayar = $sumTagihan > 0 ? round($sumBayar / $sumTagihan * 100) : 0;
        @endphp
        <div class="gaming-card p-4 md:p-5 flex flex-col">
            <h3 class="font-gaming font-semibold flex items-center gap-2 mb-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                <svg class="w-4 h-4" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                RINGKASAN
            </h3>
            <div class="flex-1 flex flex-col items-center justify-center">
                <div style="position:relative;width:150px;height:150px;">
                    <canvas id="summaryDonut"></canvas>
                </div>
                <div class="mt-2 text-center">
                    <span class="text-2xl font-gaming font-bold" style="color:var(--text-primary);">Rp {{ number_format($sumTagihan, 0, ',', '.') }}</span>
                    <div class="text-xs font-semibold mt-0.5" style="color:var(--text-muted);">Total Tagihan 6 Bulan</div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-3">
                <div class="text-center px-2 py-2 rounded-xl" style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.12);">
                    <div class="text-xs font-semibold" style="color:#6ee7b7;">Dibayar</div>
                    <div class="text-sm font-bold" style="color:#34d399;">Rp {{ number_format($sumBayar, 0, ',', '.') }}</div>
                    <div class="text-[10px] font-semibold mt-0.5" style="color:var(--text-muted);">{{ $pctBayar }}%</div>
                </div>
                <div class="text-center px-2 py-2 rounded-xl" style="background:rgba(251,146,60,0.08);border:1px solid rgba(251,146,60,0.12);">
                    <div class="text-xs font-semibold" style="color:#fdba74;">Sisa</div>
                    <div class="text-sm font-bold" style="color:#fb923c;">Rp {{ number_format($sisa, 0, ',', '.') }}</div>
                    <div class="text-[10px] font-semibold mt-0.5" style="color:var(--text-muted);">{{ 100 - $pctBayar }}%</div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

{{-- Notifikasi Popup Container --}}
<div id="notification-stack" style="position:fixed;top:16px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;max-width:380px;width:calc(100% - 48px);pointer-events:none;"></div>

@php
    $dismissibleAlerts = [];
    $dismissibleAlerts[] = [
        'id' => 'welcome',
        'title' => 'Selamat datang!',
        'message' => 'Anda berhasil masuk ke Johen Office Management System',
        'color' => '#10b981',
        'bg' => 'rgba(16,185,129,0.08)',
        'border' => 'rgba(16,185,129,0.2)',
        'icon' => '<svg class="w-5 h-5" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'delay' => 500,
    ];
    if ($tokenAlertDashboard && $tokenAlertDashboard['level'] !== 'info') {
        $levelColor = $tokenAlertDashboard['level'] === 'danger' ? '#ef4444' : '#f59e0b';
        $levelBg = $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.08)' : 'rgba(245,158,11,0.08)';
        $levelBorder = $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.2)' : 'rgba(245,158,11,0.2)';
        $label = $tokenAlertDashboard['level'] === 'danger' ? '— Segera Isi' : '— Warning';
        $dismissibleAlerts[] = [
            'id' => 'token',
            'title' => 'Token Listrik ' . $label,
            'message' => $tokenAlertDashboard['message'],
            'color' => $levelColor,
            'bg' => $levelBg,
            'border' => $levelBorder,
            'icon' => '<svg class="w-5 h-5" style="color:'.$levelColor.';" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
            'delay' => 1500,
        ];
    }
    if ($overduePayments->isNotEmpty()) {
        $dismissibleAlerts[] = [
            'id' => 'overdue',
            'title' => $overduePayments->count() . ' Pembayaran Terlewat',
            'message' => 'Segera lunasi pembayaran yang sudah melewati jatuh tempo.',
            'color' => '#ef4444',
            'bg' => 'rgba(239,68,68,0.08)',
            'border' => 'rgba(239,68,68,0.2)',
            'icon' => '<svg class="w-5 h-5" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
            'delay' => 2500,
        ];
    }
    if ($todayPayments->isNotEmpty()) {
        $dismissibleAlerts[] = [
            'id' => 'today',
            'title' => $todayPayments->count() . ' Pembayaran Jatuh Tempo Hari Ini',
            'message' => 'Jangan lupa lunasi pembayaran sebelum jatuh tempo.',
            'color' => '#f59e0b',
            'bg' => 'rgba(245,158,11,0.08)',
            'border' => 'rgba(245,158,11,0.2)',
            'icon' => '<svg class="w-5 h-5" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'delay' => 3500,
        ];
    }
    $isApprover = in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr', 'admin']);
    if ($isApprover && ($pendingPajakApprovalsCount ?? 0) > 0) {
        $dismissibleAlerts[] = [
            'id' => 'pajak',
            'title' => $pendingPajakApprovalsCount . ' Pengajuan Pajak Menunggu',
            'message' => 'Pengajuan pembayaran pajak kendaraan perlu persetujuan.',
            'color' => '#f59e0b',
            'bg' => 'rgba(245,158,11,0.08)',
            'border' => 'rgba(245,158,11,0.2)',
            'icon' => '<svg class="w-5 h-5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'delay' => 4500,
        ];
    }
    $isGmCeo = in_array(auth()->user()->role, ['gm', 'ceo']);
    if ($isGmCeo && ($stats['approval_pending_payments'] ?? 0) > 0) {
        $dismissibleAlerts[] = [
            'id' => 'payment-approval',
            'title' => $stats['approval_pending_payments'] . ' Pembayaran Perlu Disetujui',
            'message' => 'Pengajuan pembayaran baru menunggu persetujuan Anda.',
            'color' => '#ef4444',
            'bg' => 'rgba(239,68,68,0.08)',
            'border' => 'rgba(239,68,68,0.2)',
            'icon' => '<svg class="w-5 h-5" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'delay' => 5000,
            'url' => route('admin.payment-approvals.index'),
        ];
    }
@endphp

<script>
    var dismissibleAlerts = @json($dismissibleAlerts);
    var notificationStack = document.getElementById('notification-stack');

    function showDismissibleAlert(alert, index) {
        setTimeout(function() {
            var el = document.createElement('div');
            el.id = 'alert-' + alert.id;
            el.style.cssText = 'pointer-events:auto;display:flex;align-items:flex-start;gap:12px;padding:16px 20px;border-radius:14px;background:' + alert.bg + ';border:1px solid ' + alert.border + ';backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);box-shadow:0 8px 32px rgba(0,0,0,0.25);opacity:0;transform:translateX(40px);transition:all 0.4s cubic-bezier(0.22,1,0.36,1);position:relative;cursor:' + (alert.url ? 'pointer' : 'default') + ';';
            if (alert.url) {
                el.addEventListener('click', function() { window.location.href = alert.url; });
            }
            el.innerHTML = '<button type="button" onclick="event.stopPropagation();this.parentElement.remove()" style="position:absolute;top:6px;right:8px;background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:18px;line-height:1;padding:2px 4px;opacity:0.6;">&times;</button><div style="width:36px;height:36px;min-width:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:' + alert.bg.replace('0.08', '0.15') + ';">' + alert.icon + '</div><div style="flex:1;min-width:0;"><div style="font-weight:700;font-size:14px;color:' + alert.color + ';margin-bottom:2px;">' + alert.title + '</div><div style="font-size:12px;color:var(--text-secondary);line-height:1.4;">' + alert.message + '</div></div>';
            notificationStack.appendChild(el);
            requestAnimationFrame(function() {
                el.style.opacity = '1';
                el.style.transform = 'translateX(0)';
            });
        }, alert.delay + (index * 200));
    }

    document.addEventListener('DOMContentLoaded', function() {
        dismissibleAlerts.forEach(function(alert, i) {
            showDismissibleAlert(alert, i);
        });
    });
</script>

{{-- Modal Semua Pembayaran --}}
<div id="semua-pembayaran-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);" onclick="if(event.target===this)closeModal('semua-pembayaran-modal')">
    <div class="w-full" style="max-width:800px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:16px;overflow:hidden;box-shadow:0 25px 60px rgba(0,0,0,0.4);">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
            <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                <svg class="w-5 h-5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                SEMUA PEMBAYARAN MENDATANG
            </h3>
            <button type="button" onclick="closeModal('semua-pembayaran-modal')" style="background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:20px;line-height:1;padding:4px;">&times;</button>
        </div>
        <div class="overflow-y-auto" style="max-height:65vh;">
            <table class="w-full text-left" style="border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--bg-surface);position:sticky;top:0;z-index:1;">
                        <th class="px-5 py-3 text-xs font-gaming font-bold uppercase tracking-wider" style="color:var(--text-muted);border-bottom:1px solid var(--border-color);">Status</th>
                        <th class="px-5 py-3 text-xs font-gaming font-bold uppercase tracking-wider" style="color:var(--text-muted);border-bottom:1px solid var(--border-color);">Label</th>
                        <th class="px-5 py-3 text-xs font-gaming font-bold uppercase tracking-wider" style="color:var(--text-muted);border-bottom:1px solid var(--border-color);">Jenis</th>
                        <th class="px-5 py-3 text-xs font-gaming font-bold uppercase tracking-wider" style="color:var(--text-muted);border-bottom:1px solid var(--border-color);">Jatuh Tempo</th>
                        <th class="px-5 py-3 text-xs font-gaming font-bold uppercase tracking-wider text-right" style="color:var(--text-muted);border-bottom:1px solid var(--border-color);">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allMerged->sortBy('due_date') as $p)
                    <tr class="transition modal-row" style="border-bottom:1px solid var(--border-color);cursor:pointer;" onclick="openDashboardBayar({{ $p['id'] }}, '{{ $p['type'] }}')">
                        <td class="px-5 py-3">
                            @php
                                $isOverdue = \Carbon\Carbon::parse($p['due_date'])->lt(today());
                                $isToday = \Carbon\Carbon::parse($p['due_date'])->isToday();
                            @endphp
                            @if($isOverdue)
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold" style="background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.25);">Terlewat</span>
                            @elseif($isToday)
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold" style="background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.25);">Hari Ini</span>
                            @else
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold" style="background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.25);">Mendatang</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);max-width:240px;">{{ $p['label'] }}</p>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs" style="color:var(--text-muted);">{{ $p['jenis'] }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs" style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($p['due_date'])->format('d M Y') }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <span class="text-sm font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center">
                            <p class="text-sm" style="color:var(--text-muted);">Tidak ada data pembayaran</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 flex items-center justify-between" style="border-top:1px solid var(--border-color);background:var(--bg-surface);">
            <span class="text-xs" style="color:var(--text-muted);">Total: {{ $allMerged->count() }} item &middot; Klik baris untuk bayar</span>
            <a href="{{ route('admin.pembayaran.index', ['jenis' => 'listrik']) }}" class="text-xs font-medium" style="color:var(--color-accent);">Buka Halaman Pembayaran &rarr;</a>
        </div>
    </div>
</div>

{{-- Modal Bayar dari Dashboard --}}
<div id="dashboard-bayar-modal" style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);" onclick="if(event.target===this)closeDashboardBayar()">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Bayar / Lunaskan</h3>
            <button type="button" onclick="closeDashboardBayar()" style="background:none;border:none;color:var(--text-muted);cursor:pointer;padding:4px;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <div style="margin-bottom:16px;padding:12px;border-radius:10px;background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div id="dbayar-name" style="font-weight:600;font-size:14px;color:var(--text-primary);"></div>
                <div id="dbayar-nominal" style="font-size:13px;color:var(--text-muted);margin-top:4px;"></div>
                <div id="dbayar-due" style="font-size:13px;color:var(--text-muted);margin-top:2px;"></div>
            </div>
            <form id="dashboard-bayar-form" method="POST" action="{{ url('admin/pembayaran') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="jenis" id="dbayar-jenis" value="">
                <input type="hidden" name="id" id="dbayar-id" value="">
                <input type="hidden" name="status" value="lunas">
                {{-- internet fields --}}
                <input type="hidden" name="nama_internet" id="dbayar-nama_internet">
                <input type="hidden" name="provider" id="dbayar-provider">
                <input type="hidden" name="pic" id="dbayar-pic">
                <input type="hidden" name="jabatan" id="dbayar-jabatan">
                <input type="hidden" name="masa_tenggang" id="dbayar-masa_tenggang">
                <input type="hidden" name="biaya" id="dbayar-biaya">
                {{-- listrik fields --}}
                <input type="hidden" name="periode" id="dbayar-periode">
                <input type="hidden" name="tanggal_tagihan" id="dbayar-tanggal_tagihan">
                <input type="hidden" name="jatuh_tempo" id="dbayar-jatuh_tempo_val">
                <input type="hidden" name="nominal" id="dbayar-nominal_val">
                <div class="space-y-4">
                    <div>
                        <label class="gaming-label">Tanggal Bayar <span style="color:#f87171;">*</span></label>
                        <input type="date" name="tanggal_bayar" id="dbayar-tanggal_bayar" required value="{{ date('Y-m-d') }}" class="gaming-input">
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeDashboardBayar()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;box-shadow:0 4px 15px rgba(16,185,129,0.3);cursor:pointer;">Lunaskan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@php
    $paymentDataJson = $allMerged->sortBy('due_date')->values()->toJson();
@endphp

@push('styles')
<style>
.card-hover-info .hover-info {
    opacity: 0;
    transition: opacity 0.2s;
}
.card-hover-info:hover .hover-info {
    opacity: 1;
}
.pembayaran-item {
    transition: background 0.15s ease;
}
.pembayaran-item:hover {
    background: rgba(255,255,255,0.03);
}
.modal-row {
    transition: background 0.15s ease;
}
.modal-row:hover {
    background: rgba(255,255,255,0.02);
}
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}
.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent;
}
.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.1);
    border-radius: 4px;
}
.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.2);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    function refreshDashboardStats() {
        fetch('{{ route("realtime.dashboard") }}')
            .then(r => r.json())
            .then(data => {
                if (data.pending !== undefined) {
                    const pendingEl = document.getElementById('stat-pending');
                    if (pendingEl) pendingEl.textContent = data.pending;
                }
                if (data.today_meetings !== undefined) {
                    const todayEl = document.getElementById('stat-today');
                    if (todayEl) todayEl.textContent = data.today_meetings;
                }
            }).catch(() => {});
    }
    setInterval(refreshDashboardStats, 60000);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            var bm = document.getElementById('dashboard-bayar-modal');
            var pm = document.getElementById('semua-pembayaran-modal');
            if (bm && bm.style.display !== 'none') { closeDashboardBayar(); }
            else if (pm && pm.style.display !== 'none') { closeModal('semua-pembayaran-modal'); }
        }
    });

    var dashboardPaymentData = {!! $paymentDataJson !!};

    function openDashboardBayar(id, type) {
        var item = dashboardPaymentData.find(function(x) { return x.id === id && x.type === type; });
        if (!item) return;

        document.getElementById('dbayar-id').value = item.id;
        document.getElementById('dbayar-jenis').value = type === 'wifi' ? 'internet' : 'listrik';
        document.getElementById('dashboard-bayar-form').action = '{{ url("admin/pembayaran") }}/' + item.id;

        var name = item.label;
        var nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.amount);
        var dueDate = item.due_date ? new Date(item.due_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';

        document.getElementById('dbayar-name').textContent = name;
        document.getElementById('dbayar-nominal').textContent = 'Nominal: ' + nominal;
        document.getElementById('dbayar-due').textContent = 'Jatuh Tempo: ' + dueDate;

        if (type === 'wifi') {
            document.getElementById('dbayar-nama_internet').value = item.nama_internet || '';
            document.getElementById('dbayar-provider').value = item.provider || '';
            document.getElementById('dbayar-pic').value = item.pic || '';
            document.getElementById('dbayar-jabatan').value = item.jabatan || '';
            document.getElementById('dbayar-masa_tenggang').value = item.masa_tenggang || '';
            document.getElementById('dbayar-biaya').value = item.biaya || '';
        } else {
            document.getElementById('dbayar-periode').value = item.periode || '';
            document.getElementById('dbayar-tanggal_tagihan').value = item.tanggal_tagihan || '';
            document.getElementById('dbayar-jatuh_tempo_val').value = item.jatuh_tempo || '';
            document.getElementById('dbayar-nominal_val').value = item.nominal || '';
        }

        document.getElementById('dbayar-tanggal_bayar').value = new Date().toISOString().split('T')[0];
        document.getElementById('dashboard-bayar-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeDashboardBayar() {
        document.getElementById('dashboard-bayar-modal').style.display = 'none';
        if (!document.getElementById('semua-pembayaran-modal') || document.getElementById('semua-pembayaran-modal').style.display === 'none') {
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.gaming-card').forEach(function(el) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(el);
            });
        } else {
            document.querySelectorAll('.gaming-card').forEach(function(el) {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            });
        }
    });

    // Chart
    document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('monthlyChart');
    if (ctx) {
        var labels = @json($chartLabels);
        var tagihan = @json($chartTagihan);
        var bayar = @json($chartBayar);

        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Tagihan Masuk',
                        data: tagihan,
                        backgroundColor: 'rgba(59,130,246,0.7)',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        borderRadius: 4,
                    },
                    {
                        label: 'Sudah Dibayar',
                        data: bayar,
                        backgroundColor: 'rgba(16,185,129,0.7)',
                        borderColor: '#10b981',
                        borderWidth: 1,
                        borderRadius: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { color: '#94a3b8', font: { size: 11 }, boxWidth: 12, padding: 12 },
                    },
                    tooltip: {
                        callbacks: {
                            label: function(c) { return c.dataset.label + ': ' + formatChartCurrency(c.raw); },
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: { color: '#64748b', font: { size: 10 } },
                        grid: { display: false },
                    },
                    y: {
                        ticks: {
                            color: '#64748b',
                            font: { size: 10 },
                            callback: function(v) { return 'Rp ' + (v / 1000).toFixed(0) + 'k'; },
                        },
                        grid: { color: 'rgba(255,255,255,0.04)' },
                    },
                },
            },
        });
    }

    function formatChartCurrency(v) {
        return 'Rp ' + v.toLocaleString('id-ID');
    }

    // Summary Donut
    var donutCtx = document.getElementById('summaryDonut');
    if (donutCtx) {
        new Chart(donutCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Sudah Dibayar', 'Sisa'],
                datasets: [{
                    data: [{{ $sumBayar }}, {{ $sisa }}],
                    backgroundColor: ['#10b981', '#fb923c'],
                    borderColor: ['#059669', '#f97316'],
                    borderWidth: 2,
                    hoverOffset: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(c) {
                                var total = c.dataset.data.reduce(function(a, b) { return a + b; }, 0);
                                var pct = total > 0 ? ((c.raw / total) * 100).toFixed(1) : 0;
                                return c.label + ': ' + formatChartCurrency(c.raw) + ' (' + pct + '%)';
                            },
                        },
                    },
                },
            },
        });
    }
});

</script>
@endpush
@endsection
