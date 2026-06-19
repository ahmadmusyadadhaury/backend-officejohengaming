@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="space-y-6 pt-2 stagger-children">

    {{-- Welcome Banner --}}
    <div class="gaming-card p-6 relative overflow-hidden" style="background:#6C63FF80;border:1px solid rgba(108,99,255,0.3);">
        <div class="absolute inset-0 grid-pattern opacity-20"></div>
        <div class="relative">
            <h2 class="font-gaming font-bold text-2xl text-white tracking-wide mb-1">Selamat Datang Kembali</h2>
            <p class="text-white/80" style="font-size:0.95rem;">Kelola Meeting, Pembayaran, Aset Perusahaan dalam Satu Sistem</p>
        </div>
    </div>

    {{-- Divider --}}
    <div style="border-top:1px solid var(--border-color);"></div>

    {{-- TOTAL ASET, MEETING, PEMBAYARAN, ASET DIGITAL --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Aset --}}
        <div class="gaming-card overflow-hidden" style="border:1px solid rgba(124,58,237,0.2);">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,rgba(124,58,237,0.1),rgba(124,58,237,0.05));border-bottom:1px solid rgba(124,58,237,0.2);">
                <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">TOTAL ASET</h3>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div>
                    <div class="text-3xl font-gaming font-bold" style="color:var(--color-accent);">{{ $stats['total_assets'] }}</div>
                    <p class="text-xs" style="color:var(--text-muted);margin-top:4px;">Jumlah Aset</p>
                </div>
                @if($stats['assets_near_expire'] > 0)
                <div class="pt-3 px-3 py-2 rounded" style="background:rgba(239,68,68,0.1);border-left:3px solid #ef4444;">
                    <p class="text-xs font-medium" style="color:#ef4444;">⚠ {{ $stats['assets_near_expire'] }} akan expire dalam 30 hari</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Meeting --}}
        <div class="gaming-card overflow-hidden" style="border:1px solid rgba(59,130,246,0.2);">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,rgba(59,130,246,0.1),rgba(59,130,246,0.05));border-bottom:1px solid rgba(59,130,246,0.2);">
                <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING</h3>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div>
                    <div class="text-3xl font-gaming font-bold" style="color:#60a5fa;">{{ $stats['total_meetings'] }}</div>
                    <p class="text-xs" style="color:var(--text-muted);margin-top:4px;">Total Meeting</p>
                </div>
                <div class="pt-1">
                </div>
            </div>
        </div>

        {{-- Pembayaran --}}
        <div class="gaming-card overflow-hidden" style="border:1px solid rgba(16,185,129,0.2);">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,rgba(16,185,129,0.1),rgba(16,185,129,0.05));border-bottom:1px solid rgba(16,185,129,0.2);">
                <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">PEMBAYARAN</h3>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div>
                    <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $stats['total_payments'] }}</div>
                    <p class="text-xs" style="color:var(--text-muted);margin-top:4px;">Total Pembayaran</p>
                </div>
                @if($stats['pending_payments'] > 0)
                <div class="pt-1">
                    <p class="text-sm font-medium" style="color:#f59e0b;">{{ $stats['pending_payments'] }} pending pembayaran</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Aset Digital --}}
        <div class="gaming-card overflow-hidden" style="border:1px solid rgba(245,158,11,0.2);">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,rgba(245,158,11,0.1),rgba(245,158,11,0.05));border-bottom:1px solid rgba(245,158,11,0.2);">
                <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">ASET DIGITAL</h3>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div>
                    <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;">{{ $stats['digital_assets'] }}</div>
                    <p class="text-xs" style="color:var(--text-muted);margin-top:4px;">Total Aset Digital</p>
                </div>
                @if($digitalAssetsNeedMaintenance->count() > 0)
                <div class="pt-1">
                    <p class="text-sm font-medium" style="color:#f59e0b;">{{ $digitalAssetsNeedMaintenance->count() }} memerlukan maintenance</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- BREAKDOWN AKUN --}}
    <div>
        <h3 class="text-xs font-gaming font-bold uppercase tracking-widest mb-3" style="color:var(--text-muted);">Breakdown Akun</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
            @php
                $accountBreakdown = [
                    ['label' => 'Chief Executive Officer', 'short' => 'Chief Execu...', 'count' => $stats['total_ceo'], 'icon' => 'M5 16l2-9 5 5 5-5 2 9H5zm2 4h10', 'bg' => 'linear-gradient(135deg,#8b5cf6,#a855f7)', 'accent' => '#a855f7'],

['label' => 'General Manager', 'short' => 'General Ma...', 'count' => $stats['total_gm'], 'icon' => 'M12 3l2 5 5 .5-4 3 1.2 5-4.7-2.6-4.7 2.6 1.2-5-4-3 5-.5 2-5z', 'bg' => 'linear-gradient(135deg,#f59e0b,#fbbf24)', 'accent' => '#fbbf24'],

['label' => 'Head of Store', 'short' => 'Head of Store', 'count' => $stats['total_head_store'], 'icon' => 'M3 9l1-5h16l1 5M5 9v11h14V9M9 20v-6h6v6M8 13h2m4 0h2', 'bg' => 'linear-gradient(135deg,#7c3aed,#a855f7)', 'accent' => '#a855f7'],

['label' => 'Human Resources', 'short' => 'Human Resources', 'count' => $stats['total_hr'], 'icon' => 'M9 11a3 3 0 100-6 3 3 0 000 6zm6 0a3 3 0 100-6 3 3 0 000 6zM4 20v-1a5 5 0 015-5h6a5 5 0 015 5v1M7 15h10', 'bg' => 'linear-gradient(135deg,#ec4899,#f472b6)', 'accent' => '#f472b6'],

['label' => 'Koordinator', 'short' => 'Koordinator', 'count' => $stats['total_koordinator'], 'icon' => 'M12 3a3 3 0 110 6 3 3 0 010-6zm-7 11a3 3 0 110 6 3 3 0 010-6zm14 0a3 3 0 110 6 3 3 0 010-6zM12 9v3M7 15l3-3m7 3l-3-3', 'bg' => 'linear-gradient(135deg,#3b82f6,#60a5fa)', 'accent' => '#60a5fa'],

['label' => 'Karyawan', 'short' => 'Karyawan', 'count' => $stats['total_karyawan'], 'icon' => 'M17 20h5v-2a4 4 0 00-4-4h-1M7 20H2v-2a4 4 0 014-4h1m5-2a4 4 0 100-8 4 4 0 000 8zm0 2c-4 0-7 2-7 5v1h14v-1c0-3-3-5-7-5z', 'bg' => 'linear-gradient(135deg,#1e40af,#3b82f6)', 'accent' => '#60a5fa'],

['label' => 'Total Tim', 'short' => 'Total Tim', 'count' => $stats['total_team'], 'icon' => 'M12 3l1.5 4.5L18 9l-4.5 1.5L12 15l-1.5-4.5L6 9l4.5-1.5L12 3zm-5 11l1 3 4 2 4-2 1-3', 'bg' => 'linear-gradient(135deg,#06b6d4,#22d3ee)', 'accent' => '#22d3ee'],
                ];
            @endphp
            @foreach($accountBreakdown as $item)
            <div class="gaming-card p-4 flex flex-col items-center text-center gap-2" style="border-top:2px solid {{ $item['accent'] }};">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:{{ $item['bg'] }};">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                    </svg>
                </div>
                <div class="text-2xl font-gaming font-bold leading-none" style="color:var(--text-primary);">{{ $item['count'] }}</div>
                <div class="text-xs font-medium leading-tight" style="color:var(--text-muted);">{{ $item['short'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

        {{-- STATISTIK MEETING --}}
    <div>
        <h3 class="text-xs font-gaming font-bold uppercase tracking-widest mb-3" style="color:var(--text-muted);">Statistik Meeting</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Menunggu Approval --}}
            <div class="gaming-card overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(245,158,11,0.1),rgba(245,158,11,0.05));">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#f59e0b,#fbbf24);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-gaming font-bold uppercase tracking-wider" style="color:var(--text-muted);">Menunggu Approval</p>
                            <p class="text-2xl font-gaming font-bold leading-none" style="color:var(--text-primary);">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                    <span class="badge" style="background:rgba(245,158,11,0.2);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);font-size:0.7rem;">PENDING</span>
                </div>
                <div class="divide-y" style="border-color:var(--border-color);max-height:220px;overflow-y:auto;">
                    @forelse($approvalWaitingMeetings as $meeting)
                    <div class="px-5 py-3 flex items-start justify-between gap-3 transition hover:bg-slate-100/5">
                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                            <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $meeting->room->name }} • {{ $meeting->meeting_date->format('d M Y') }}</p>
                        </div>
                        <a href="{{ route('admin.meetings.show', $meeting) }}" class="badge flex-shrink-0" style="background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);font-size:0.7rem;">Review</a>
                    </div>
                    @empty
                    <div class="px-5 py-6 text-center">
                        <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting yang menunggu approval</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Meeting Hari Ini --}}
            <div class="gaming-card overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(59,130,246,0.1),rgba(59,130,246,0.05));">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#3b82f6,#60a5fa);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-gaming font-bold uppercase tracking-wider" style="color:var(--text-muted);">Meeting Hari Ini</p>
                            <p class="text-2xl font-gaming font-bold leading-none" style="color:var(--text-primary);">{{ $stats['today_meetings'] }}</p>
                        </div>
                    </div>
                    <span class="badge" style="background:rgba(59,130,246,0.2);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);font-size:0.7rem;">{{ today()->isoFormat('D MMM') }}</span>
                </div>
                <div class="divide-y" style="border-color:var(--border-color);max-height:220px;overflow-y:auto;">
                    @forelse($todayMeetings as $meeting)
                    <div class="px-5 py-3 flex items-center gap-3 transition hover:bg-slate-100/5">
                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#60a5fa;box-shadow:0 0 6px rgba(96,165,250,0.6);"></span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                            <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }} • {{ $meeting->team->name }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-6 text-center">
                        <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting hari ini</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- Pembayaran Mendatang & Undangan Aktif --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Pembayaran Mendatang --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(168,85,247,0.1),rgba(168,85,247,0.05));">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">PEMBAYARAN MENDATANG</h3>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($upcomingPayments->take(5) as $payment)
                <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $payment->room->name }}</p>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $payment->meeting_date->format('d M Y') }} • {{ substr($payment->start_time,0,5) }}</p>
                    </div>
                    <span class="badge flex-shrink-0 text-xs" style="background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);">
                        PENDING
                    </span>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada pembayaran mendatang</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Undangan Aktif --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(16,185,129,0.1),rgba(16,185,129,0.05));">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">UNDANGAN AKTIF</h3>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($myInvitations->take(5) as $inv)
                <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $inv->meeting->title }}</p>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $inv->meeting->team->name }} • {{ substr($inv->meeting->start_time,0,5) }}</p>
                    </div>
                    <span class="badge flex-shrink-0 text-xs" style="background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.3);">
                        AKTIF
                    </span>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada undangan aktif</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Peringatan Expire --}}
    @if($expiringAssets->count() > 0 || $expiredAssets->count() > 0)
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(239,68,68,0.1),rgba(239,68,68,0.05));">
            <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                <svg class="w-5 h-5 flex-shrink-0" style="color:#ef4444;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                PERINGATAN EXPIRE
            </h3>
            <span class="badge" style="background:rgba(239,68,68,0.2);color:#ef4444;border:1px solid rgba(239,68,68,0.3);">{{ $expiringAssets->count() + $expiredAssets->count() }}</span>
        </div>
        <div class="divide-y" style="border-color:var(--border-color);">
            @forelse($expiredAssets->merge($expiringAssets)->take(8) as $asset)
            @php
                $daysLeft = now()->diffInDays($asset->expire_date);
                $isExpired = $asset->expire_date->isPast();
                $badgeClass = $isExpired 
                    ? 'background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);'
                    : ($daysLeft <= 7 
                        ? 'background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);'
                        : 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);');
            @endphp
            <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                <div class="min-w-0">
                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $asset->asset_name }}</p>
                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">
                        @if($isExpired)
                            <span style="color:#ef4444;">Expired {{ $daysLeft }} hari lalu</span>
                        @else
                            Expire dalam {{ $daysLeft }} hari ({{ $asset->expire_date->format('d M Y') }})
                        @endif
                    </p>
                </div>
                <span class="badge flex-shrink-0 text-xs" style="{{ $badgeClass }}">
                    @if($isExpired)
                        EXPIRED
                    @elseif($daysLeft <= 7)
                        URGENT
                    @else
                        SOON
                    @endif
                </span>
            </div>
            @empty
            <div class="px-5 py-8 text-center">
                <p class="text-sm" style="color:var(--text-muted);">Semua aset dalam kondisi baik</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

</div>

@push('scripts')
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
</script>
@endpush
@endsection
