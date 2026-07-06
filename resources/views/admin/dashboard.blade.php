@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
@php
    $totalTagihanDonut = array_sum($chartTagihan ?? []);
    $totalBayarDonut = array_sum($chartBayar ?? []);
    $sisaDonut = $totalTagihanDonut - $totalBayarDonut;
@endphp
<div class="dashboard-section stagger-children">

    {{-- Komposisi Tim (GM & CEO only) --}}
    @if(in_array(auth()->user()->role, ['gm', 'ceo']))
    <div class="dashboard-section">
        <div class="section-label">Komposisi Tim</div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-2.5 md:gap-3">
            @php
                $teamRoles = [
                    ['label' => 'CEO', 'count' => $stats['total_ceo'], 'color' => '#fbbf24', 'bg' => 'rgba(251,191,36,0.12)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'General Manager', 'count' => $stats['total_gm'], 'color' => '#a78bfa', 'bg' => 'rgba(167,139,250,0.12)', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['label' => 'Head of Store', 'count' => $stats['total_head_store'], 'color' => '#34d399', 'bg' => 'rgba(52,211,153,0.12)', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'HR', 'count' => $stats['total_hr'], 'color' => '#fb923c', 'bg' => 'rgba(251,146,60,0.12)', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['label' => 'Koordinator', 'count' => $stats['total_koordinator'], 'color' => '#38bdf8', 'bg' => 'rgba(56,189,248,0.12)', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                    ['label' => 'Total Tim', 'count' => $stats['total_team'], 'color' => '#c084fc', 'bg' => 'rgba(192,132,252,0.12)', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['label' => 'Karyawan', 'count' => $stats['total_karyawan'], 'color' => '#f87171', 'bg' => 'rgba(248,113,113,0.12)', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
                ];
            @endphp
            @foreach($teamRoles as $role)
            <div class="stat-card-compact flex-col items-center text-center py-3" style="border-color:{{ $role['color'] }}20;">
                <div class="stat-icon-box mb-1.5" style="background:{{ $role['bg'] }};box-shadow:0 0 12px {{ $role['color'] }}20;">
                    <svg class="w-4 h-4" style="color:{{ $role['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $role['icon'] }}"/>
                    </svg>
                </div>
                <div class="stat-num" style="color:{{ $role['color'] }};">{{ $role['count'] }}</div>
                <div class="stat-label-text">{{ $role['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="dashboard-section">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 md:gap-3">
            @php
                $statCards = [
                    ['label' => 'Total Meeting', 'count' => $stats['total_meetings'], 'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.12)', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['label' => 'Total Asset', 'count' => $stats['total_assets'], 'color' => '#a78bfa', 'bg' => 'rgba(124,58,237,0.12)', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['label' => 'Total Tagihan', 'count' => $stats['total_payments'], 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.12)', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                ];
            @endphp
            @foreach($statCards as $card)
            <div class="stat-card-compact">
                <div class="stat-icon-box" style="background:{{ $card['bg'] }};box-shadow:0 0 14px {{ $card['color'] }}20;">
                    <svg style="color:{{ $card['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-num">{{ $card['count'] }}</div>
                    <div class="stat-label-text" style="font-size:0.7rem;">{{ $card['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Meeting Hari Ini + Pembayaran Mendatang --}}
    <div class="dashboard-section">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2.5 md:gap-3">
            {{-- Meeting Hari Ini --}}
            <div class="gaming-card overflow-hidden">
                <div class="card-header">
                    <span class="card-header-title">
                        <svg style="color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Meeting Hari Ini
                    </span>
                    <span class="badge badge-blue text-[0.6rem]">{{ today()->isoFormat('D MMM') }}</span>
                </div>
                <div>
                    @forelse($todayMeetings as $meeting)
                    <div class="card-list-item">
                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#60a5fa;box-shadow:0 0 6px rgba(96,165,250,0.6);"></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                            <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }} · {{ $meeting->team->name }} · {{ $meeting->room->name }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p>Tidak ada meeting hari ini</p>
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
                <div class="card-header flex-shrink-0">
                    <span class="card-header-title">
                        <svg style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Pembayaran Mendatang
                    </span>
                    <button type="button" onclick="openModal('semua-pembayaran-modal')" class="text-[0.65rem] font-medium cursor-pointer" style="color:var(--color-accent);">Lihat Semua &rarr;</button>
                </div>
                @if($tokenAlertDashboard)
                <a href="{{ route('admin.pembayaran.index', ['jenis' => 'listrik']) }}" class="block mx-3 my-2.5 rounded-xl overflow-hidden transition" style="text-decoration:none;background:{{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.04)' : ($tokenAlertDashboard['level'] === 'warning' ? 'rgba(245,158,11,0.04)' : 'rgba(59,130,246,0.04)') }};border:1px solid {{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.15)' : ($tokenAlertDashboard['level'] === 'warning' ? 'rgba(245,158,11,0.15)' : 'rgba(59,130,246,0.15)') }};" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <div class="px-3 py-1.5 flex items-center justify-between" style="border-bottom:1px solid {{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.08)' : ($tokenAlertDashboard['level'] === 'warning' ? 'rgba(245,158,11,0.08)' : 'rgba(59,130,246,0.08)') }};">
                        <span class="text-[0.6rem] font-bold uppercase tracking-wider" style="color:{{ $tokenAlertDashboard['level'] === 'danger' ? '#ef4444' : ($tokenAlertDashboard['level'] === 'warning' ? '#f59e0b' : '#3b82f6') }};">
                            Token Listrik
                            @if($tokenAlertDashboard['level'] === 'danger') — Segera Isi
                            @elseif($tokenAlertDashboard['level'] === 'warning') — Warning
                            @else — Perhatian
                            @endif
                        </span>
                        <span class="px-1.5 py-0.5 rounded-full text-[9px] font-bold" style="background:{{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.15)' : ($tokenAlertDashboard['level'] === 'warning' ? 'rgba(245,158,11,0.15)' : 'rgba(59,130,246,0.15)') }};color:{{ $tokenAlertDashboard['level'] === 'danger' ? '#ef4444' : ($tokenAlertDashboard['level'] === 'warning' ? '#f59e0b' : '#3b82f6') }};">{{ number_format($tokenAlertDashboard['kwh'], 0) }} KWH</span>
                    </div>
                    <div class="px-3 py-1.5 flex items-center justify-between">
                        <span class="text-[0.65rem]" style="color:var(--text-muted);">{{ $tokenAlertDashboard['message'] }}</span>
                        <svg class="w-3 h-3 flex-shrink-0" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                @endif
                <div class="overflow-y-auto" style="max-height:340px;">
                    <div class="p-2 space-y-1.5">
                        @if($hasOverdue)
                        <div class="rounded-lg overflow-hidden" style="background:rgba(239,68,68,0.03);border:1px solid rgba(239,68,68,0.08);">
                            <div class="px-3 py-1.5 flex items-center justify-between" style="border-bottom:1px solid rgba(239,68,68,0.06);">
                                <span class="text-[0.6rem] font-bold uppercase tracking-wider" style="color:#ef4444;">Terlewat</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[9px] font-bold" style="background:rgba(239,68,68,0.15);color:#ef4444;">{{ $overduePayments->count() }}</span>
                            </div>
                            @foreach($overduePayments as $p)
                            <div class="px-3 py-1.5 flex items-center justify-between gap-2 pembayaran-item" style="cursor:pointer;" onclick="openDashboardBayar({{ $p['id'] }}, '{{ $p['type'] }}')">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                                    <p class="text-[0.6rem]" style="color:#ef4444;">Lewat {{ \Carbon\Carbon::parse($p['due_date'])->diffInDays() }} hari · {{ $p['jenis'] }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                                    <span class="badge text-[9px]" style="background:rgba(239,68,68,0.12);color:#ef4444;border:1px solid rgba(239,68,68,0.2);">{{ ucfirst($p['status']) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        @if($hasToday)
                        <div class="rounded-lg overflow-hidden" style="background:rgba(245,158,11,0.03);border:1px solid rgba(245,158,11,0.08);">
                            <div class="px-3 py-1.5 flex items-center justify-between" style="border-bottom:1px solid rgba(245,158,11,0.06);">
                                <span class="text-[0.6rem] font-bold uppercase tracking-wider" style="color:#f59e0b;">Hari Ini</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[9px] font-bold" style="background:rgba(245,158,11,0.15);color:#f59e0b;">{{ $todayPayments->count() }}</span>
                            </div>
                            @foreach($todayPayments as $p)
                            <div class="px-3 py-1.5 flex items-center justify-between gap-2 pembayaran-item" style="cursor:pointer;" onclick="openDashboardBayar({{ $p['id'] }}, '{{ $p['type'] }}')">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                                    <p class="text-[0.6rem]" style="color:#f59e0b;">Jatuh tempo hari ini · {{ $p['jenis'] }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                                    <span class="badge text-[9px]" style="background:rgba(245,158,11,0.12);color:#fbbf24;border:1px solid rgba(245,158,11,0.2);">{{ ucfirst($p['status']) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        @if($hasWarning)
                        <div class="rounded-lg overflow-hidden" style="background:rgba(59,130,246,0.03);border:1px solid rgba(59,130,246,0.08);">
                            <div class="px-3 py-1.5 flex items-center justify-between" style="border-bottom:1px solid rgba(59,130,246,0.06);">
                                <span class="text-[0.6rem] font-bold uppercase tracking-wider" style="color:#3b82f6;">Mendatang</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[9px] font-bold" style="background:rgba(59,130,246,0.15);color:#60a5fa;">{{ $warningPayments->count() }}</span>
                            </div>
                            @foreach($warningPayments as $p)
                            <div class="px-3 py-1.5 flex items-center justify-between gap-2 pembayaran-item" style="cursor:pointer;" onclick="openDashboardBayar({{ $p['id'] }}, '{{ $p['type'] }}')">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                                    <p class="text-[0.6rem]" style="color:var(--text-muted);">Jatuh tempo {{ \Carbon\Carbon::parse($p['due_date'])->format('d M Y') }} · {{ $p['jenis'] }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                                    <span class="badge text-[9px]" style="background:rgba(59,130,246,0.12);color:#60a5fa;border:1px solid rgba(59,130,246,0.2);">{{ ucfirst($p['status']) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="gaming-card overflow-hidden">
                <div class="empty-state" style="min-height:6rem;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <p>Tidak ada pembayaran mendatang</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Pajak Approval Alert --}}
    @php
        $isApprover = in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr', 'admin']);
    @endphp
    @if($isApprover && ($pendingPajakApprovalsCount ?? 0) > 0)
    <div class="dashboard-section">
        <a href="{{ route('admin.vehicles.index') }}#pending-approvals" style="text-decoration:none;display:block;">
            <div class="stat-card-compact gap-3" style="border-color:rgba(245,158,11,0.2);background:rgba(245,158,11,0.03);">
                <div class="stat-icon-box" style="background:rgba(245,158,11,0.12);width:2.5rem;height:2.5rem;">
                    <svg class="w-4 h-4" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold" style="color:#f59e0b;">{{ $pendingPajakApprovalsCount }} Pengajuan Pajak Menunggu</p>
                    <p class="text-xs" style="color:var(--text-muted);">Pengajuan pembayaran pajak kendaraan perlu persetujuan</p>
                </div>
                <svg class="w-4 h-4 flex-shrink-0" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>
    </div>
    @endif

    {{-- Grafik Pengeluaran & Tagihan + Ringkasan Donut --}}
    <div class="dashboard-section">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-2.5 md:gap-3">
            {{-- Bar Chart --}}
            <div class="gaming-card lg:col-span-3 overflow-hidden">
                <div class="card-header">
                    <span class="card-header-title">
                        <svg style="color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Pengeluaran & Tagihan
                    </span>
                    <span class="text-[0.65rem]" style="color:var(--text-muted);">6 bulan terakhir</span>
                </div>
                <div class="card-body">
                    <div style="position:relative;height:240px;"><canvas id="monthlyChart"></canvas></div>
                </div>
            </div>

            {{-- Donut Chart --}}
            <div class="gaming-card lg:col-span-2 flex flex-col overflow-hidden">
                <div class="card-header flex-shrink-0">
                    <span class="card-header-title">
                        <svg style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Ringkasan
                    </span>
                </div>
                <div class="flex-1 flex items-center justify-center p-4">
                    <div style="position:relative;height:140px;width:140px;max-width:100%;"><canvas id="ringkasanChart"></canvas></div>
                </div>
                <div class="grid grid-cols-3 gap-1.5 px-4 pb-4 flex-shrink-0">
                    <div class="flex flex-col items-center gap-0.5 py-1.5 rounded-lg" style="background:rgba(59,130,246,0.06);">
                        <span class="text-[0.55rem] font-medium" style="color:var(--text-muted);">Tagihan</span>
                        <span class="text-xs font-semibold" style="color:var(--text-primary);">Rp {{ number_format($totalTagihanDonut, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex flex-col items-center gap-0.5 py-1.5 rounded-lg" style="background:rgba(16,185,129,0.06);">
                        <span class="text-[0.55rem] font-medium" style="color:var(--text-muted);">Dibayar</span>
                        <span class="text-xs font-semibold" style="color:var(--text-primary);">Rp {{ number_format($totalBayarDonut, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex flex-col items-center gap-0.5 py-1.5 rounded-lg" style="background:rgba(245,158,11,0.06);">
                        <span class="text-[0.55rem] font-medium" style="color:var(--text-muted);">Sisa</span>
                        <span class="text-xs font-semibold" style="color:var(--text-primary);">Rp {{ number_format($sisaDonut, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- Notifikasi Popup Container --}}
<div id="notification-stack" class="toast-stack"></div>

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
    $approverRoles = ['admin', 'head_of_store', 'hr', 'gm', 'ceo'];
    if (in_array(auth()->user()->role, $approverRoles) && ($stats['approval_pending_payments'] ?? 0) > 0) {
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
            setTimeout(function() {
                el.style.opacity = '0';
                el.style.transform = 'translateX(40px)';
                setTimeout(function() { if (el.parentElement) el.remove(); }, 400);
            }, 4000);
        }, alert.delay + (index * 200));
    }

    document.addEventListener('DOMContentLoaded', function() {
        dismissibleAlerts.forEach(function(alert, i) {
            showDismissibleAlert(alert, i);
        });
    });
</script>

{{-- Modal Semua Pembayaran --}}
<div id="semua-pembayaran-modal" class="modal-modern" onclick="if(event.target===this)closeModal('semua-pembayaran-modal')">
    <div class="modal-modern-panel lg" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Semua Pembayaran Mendatang</h3>
            <button type="button" onclick="closeModal('semua-pembayaran-modal')" class="modal-modern-close">&times;</button>
        </div>
        <div class="overflow-y-auto" style="max-height:65vh;">
            <table class="gaming-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Label</th>
                        <th>Jenis</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allMerged->sortBy('due_date') as $p)
                    <tr style="cursor:pointer;" onclick="openDashboardBayar({{ $p['id'] }}, '{{ $p['type'] }}')">
                        <td>
                            @php
                                $isOverdue = \Carbon\Carbon::parse($p['due_date'])->lt(today());
                                $isToday = \Carbon\Carbon::parse($p['due_date'])->isToday();
                            @endphp
                            @if($isOverdue)
                                <span class="badge badge-red" style="font-size:0.6rem;">Terlewat</span>
                            @elseif($isToday)
                                <span class="badge badge-yellow" style="font-size:0.6rem;">Hari Ini</span>
                            @else
                                <span class="badge badge-blue" style="font-size:0.6rem;">Mendatang</span>
                            @endif
                        </td>
                        <td><span style="font-weight:500;color:var(--text-primary);">{{ $p['label'] }}</span></td>
                        <td><span style="color:var(--text-muted);">{{ $p['jenis'] }}</span></td>
                        <td><span style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($p['due_date'])->format('d M Y') }}</span></td>
                        <td class="text-right"><span style="font-weight:600;color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada data pembayaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="modal-modern-footer">
            <span class="text-[0.65rem]" style="color:var(--text-muted);">Total: {{ $allMerged->count() }} item · Klik baris untuk bayar</span>
            <a href="{{ route('admin.pembayaran.index', ['jenis' => 'listrik']) }}" class="text-[0.65rem] font-medium" style="color:var(--color-accent);">Buka Halaman Pembayaran &rarr;</a>
        </div>
    </div>
</div>

{{-- Modal Bayar dari Dashboard --}}
<div id="dashboard-bayar-modal" class="modal-modern" style="z-index:60;" onclick="if(event.target===this)closeDashboardBayar()">
    <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Bayar / Lunaskan</h3>
            <button type="button" onclick="closeDashboardBayar()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body">
            <div class="p-3 rounded-xl mb-4" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div id="dbayar-name" style="font-weight:600;font-size:0.85rem;color:var(--text-primary);"></div>
                <div id="dbayar-nominal" style="font-size:0.75rem;color:var(--text-muted);margin-top:4px;"></div>
                <div id="dbayar-due" style="font-size:0.75rem;color:var(--text-muted);margin-top:2px;"></div>
            </div>
            <form id="dashboard-bayar-form" method="POST" action="{{ url('admin/pembayaran') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="jenis" id="dbayar-jenis" value="">
                <input type="hidden" name="id" id="dbayar-id" value="">
                <input type="hidden" name="status" value="lunas">
                <input type="hidden" name="nama_internet" id="dbayar-nama_internet">
                <input type="hidden" name="provider" id="dbayar-provider">
                <input type="hidden" name="pic" id="dbayar-pic">
                <input type="hidden" name="jabatan" id="dbayar-jabatan">
                <input type="hidden" name="masa_tenggang" id="dbayar-masa_tenggang">
                <input type="hidden" name="biaya" id="dbayar-biaya">
                <input type="hidden" name="periode" id="dbayar-periode">
                <input type="hidden" name="tanggal_tagihan" id="dbayar-tanggal_tagihan">
                <input type="hidden" name="jatuh_tempo" id="dbayar-jatuh_tempo_val">
                <input type="hidden" name="nominal" id="dbayar-nominal_val">
                <div>
                    <label class="gaming-label">Tanggal Bayar <span style="color:#f87171;">*</span></label>
                    <input type="date" name="tanggal_bayar" id="dbayar-tanggal_bayar" required value="{{ date('Y-m-d') }}" class="gaming-input">
                </div>
            </form>
        </div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDashboardBayar()" class="btn btn-secondary btn-sm">Batal</button>
            <button type="submit" form="dashboard-bayar-form" class="btn btn-success btn-sm" style="background:linear-gradient(135deg,#10b981,#059669);">Lunaskan</button>
        </div>
    </div>
</div>

@php
    $paymentDataJson = $allMerged->sortBy('due_date')->values()->toJson();
@endphp

@push('styles')
<style>
.pembayaran-item {
    transition: background 0.15s ease;
}
.pembayaran-item:hover {
    background: rgba(124,58,237,0.03);
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
        openModal('dashboard-bayar-modal');
    }

    function closeDashboardBayar() {
        closeModal('dashboard-bayar-modal');
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
    var labels = @json($chartLabels);
    var tagihan = @json($chartTagihan);
    var bayar = @json($chartBayar);

    function formatChartCurrency(v) {
        return 'Rp ' + v.toLocaleString('id-ID');
    }

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
                maintainAspectRatio: false,
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

    // Ringkasan Donut Chart
    var rc = document.getElementById('ringkasanChart');
    if (rc) {
        var totalTagihan = tagihan.reduce(function(a, b) { return a + b; }, 0);
        var totalBayar = bayar.reduce(function(a, b) { return a + b; }, 0);
        var sisa = totalTagihan - totalBayar;
        var pctBayar = totalTagihan > 0 ? (totalBayar / totalTagihan * 100) : 0;
        var pctSisa = totalTagihan > 0 ? (sisa / totalTagihan * 100) : 0;

        new Chart(rc.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Dibayar', 'Sisa'],
                datasets: [{
                    data: [totalBayar, sisa],
                    backgroundColor: ['rgba(16,185,129,0.85)', 'rgba(245,158,11,0.85)'],
                    borderColor: ['#10b981', '#f59e0b'],
                    borderWidth: 2,
                    hoverOffset: 8,
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
                                var total = totalTagihan;
                                var pct = c.raw / total * 100;
                                return c.label + ': ' + formatChartCurrency(c.raw) + ' (' + pct.toFixed(1) + '%)';
                            },
                        },
                    },
                },
            },
            plugins: [{
                afterDraw: function(chart) {
                    var ctx = chart.ctx;
                    var w = chart.width;
                    var h = chart.height;
                    var cx = chart.chartArea.left + (chart.chartArea.right - chart.chartArea.left) / 2;
                    var cy = chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.font = 'bold 18px Poppins, sans-serif';
                    ctx.fillStyle = getComputedStyle(document.body).getPropertyValue('--text-primary').trim() || '#e2e8f0';
                    ctx.fillText(formatChartCurrency(totalTagihan), cx, cy - 8);
                    ctx.font = '11px Poppins, sans-serif';
                    ctx.fillStyle = getComputedStyle(document.body).getPropertyValue('--text-muted').trim() || '#94a3b8';
                    ctx.fillText('Total Tagihan', cx, cy + 16);
                },
            }],
        });
    }
    });
</script>
@endpush
@endsection
