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
<div class="space-y-6 pt-2 stagger-children dashboard-wrapper">

    {{-- TOTAL ASET, MEETING, PEMBAYARAN, ASET DIGITAL --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 md:gap-4">

        {{-- Total Aset --}}
        <div class="gaming-card p-4 md:p-5 flex items-center gap-3 md:gap-4 relative card-hover-info" style="border:1px solid rgba(124,58,237,0.15);">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.12);box-shadow:0 0 16px rgba(124,58,237,0.2);">
                <svg class="w-5 h-5 md:w-6 md:h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-2xl md:text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total_assets'] }}</div>
                <div class="text-xs md:text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Aset</div>
                @if($stats['assets_near_expire'] > 0)
                <div class="text-xs font-medium mt-1 hover-info" style="color:#ef4444;">⚠ {{ $stats['assets_near_expire'] }} akan expire</div>
                @endif
            </div>
            @if($stats['assets_near_expire'] > 0)
            <div class="absolute top-2 right-2 w-2 h-2 rounded-full" style="background:#ef4444;box-shadow:0 0 6px #ef4444;"></div>
            @endif
        </div>

        {{-- Meeting --}}
        <div class="gaming-card p-4 md:p-5 flex items-center gap-3 md:gap-4 relative" style="border:1px solid rgba(59,130,246,0.15);">
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

        {{-- Pembayaran --}}
        <div class="gaming-card p-4 md:p-5 flex items-center gap-3 md:gap-4 relative card-hover-info" style="border:1px solid rgba(16,185,129,0.15);">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.12);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-5 h-5 md:w-6 md:h-6" style="color:#6ee7b7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-2xl md:text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total_payments'] }}</div>
                <div class="text-xs md:text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Pembayaran</div>
                @if($stats['pending_payments'] > 0)
                <div class="text-xs font-medium mt-1 hover-info" style="color:#f59e0b;">{{ $stats['pending_payments'] }} pending</div>
                @endif
            </div>
            @if($stats['pending_payments'] > 0)
            <div class="absolute top-2 right-2 w-2 h-2 rounded-full" style="background:#f59e0b;box-shadow:0 0 6px #f59e0b;"></div>
            @endif
        </div>

        {{-- Aset Digital --}}
        <div class="gaming-card p-4 md:p-5 flex items-center gap-3 md:gap-4 relative card-hover-info" style="border:1px solid rgba(245,158,11,0.15);">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.12);box-shadow:0 0 16px rgba(245,158,11,0.2);">
                <svg class="w-5 h-5 md:w-6 md:h-6" style="color:#fcd34d;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-2xl md:text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['digital_assets'] }}</div>
                <div class="text-xs md:text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Aset Digital</div>
                @if($digitalAssetsNeedMaintenance->count() > 0)
                <div class="text-xs font-medium mt-1 hover-info" style="color:#f59e0b;">{{ $digitalAssetsNeedMaintenance->count() }} perlu maintenance</div>
                @endif
            </div>
            @if($digitalAssetsNeedMaintenance->count() > 0)
            <div class="absolute top-2 right-2 w-2 h-2 rounded-full" style="background:#f59e0b;box-shadow:0 0 6px #f59e0b;"></div>
            @endif
        </div>

    </div>

    {{-- STATISTIK MEETING --}}
    <div>
        <h3 class="text-xs font-gaming font-bold uppercase tracking-widest mb-3" style="color:var(--text-muted);">Statistik Meeting</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Menunggu Approval --}}
            <div class="gaming-card overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
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
                        <a href="{{ route('admin.meetings.index') }}?review={{ $meeting->id }}" class="badge flex-shrink-0" style="background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);font-size:0.7rem;">Review</a>
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
                <div class="flex items-center justify-between px-5 py-3" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
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

    {{-- Pembayaran Mendatang --}}
    @php
        $hasOverdue = $overduePayments->isNotEmpty();
        $hasToday   = $todayPayments->isNotEmpty();
        $hasWarning = $warningPayments->isNotEmpty();
    @endphp
    @if($hasOverdue || $hasToday || $hasWarning)
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">PEMBAYARAN MENDATANG</h3>
            <a href="{{ route('admin.pembayaran.index', ['jenis' => 'listrik']) }}" class="text-xs font-medium" style="color:var(--color-accent);">Lihat Semua &rarr;</a>
        </div>
        <div class="divide-y" style="border-color:var(--border-color);">

            {{-- TERLEWAT --}}
            @if($hasOverdue)
            <div class="px-4 py-2 text-xs font-gaming font-bold uppercase tracking-wider" style="color:#ef4444;background:var(--bg-surface);">Terlewat</div>
            @foreach($overduePayments as $p)
            <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                    <p class="text-xs mt-0.5" style="color:#ef4444;">
                        @if($p['type'] === 'payment')
                            Sudah lewat {{ \Carbon\Carbon::parse($p['due_date'])->diffInDays() }} hari &middot; {{ $p['jenis'] }}
                        @else
                            Sudah lewat {{ \Carbon\Carbon::parse($p['due_date'])->diffInDays() }} hari &middot; {{ $p['jenis'] }}
                        @endif
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                    <span class="badge text-xs mt-0.5" style="background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);">
                        {{ ucfirst($p['status']) }}
                    </span>
                </div>
            </div>
            @endforeach
            @endif

            {{-- HARI INI --}}
            @if($hasToday)
            <div class="px-4 py-2 text-xs font-gaming font-bold uppercase tracking-wider" style="color:#f59e0b;background:var(--bg-surface);">Hari Ini</div>
            @foreach($todayPayments as $p)
            <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                    <p class="text-xs mt-0.5" style="color:#f59e0b;">
                        @if($p['type'] === 'payment')
                            Jatuh tempo hari ini &middot; {{ $p['jenis'] }}
                        @else
                            Masa tenggang hari ini &middot; {{ $p['jenis'] }}
                        @endif
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                    <span class="badge text-xs mt-0.5" style="background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);">
                        {{ ucfirst($p['status']) }}
                    </span>
                </div>
            </div>
            @endforeach
            @endif

            {{-- WARNING --}}
            @if($hasWarning)
            <div class="px-4 py-2 text-xs font-gaming font-bold uppercase tracking-wider" style="color:#3b82f6;background:var(--bg-surface);">Mendatang</div>
            @foreach($warningPayments as $p)
            <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $p['label'] }}</p>
                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">
                        @if($p['type'] === 'payment')
                            Jatuh tempo {{ \Carbon\Carbon::parse($p['due_date'])->format('d M Y') }} &middot; {{ $p['jenis'] }}
                        @else
                            Masa tenggang {{ \Carbon\Carbon::parse($p['due_date'])->format('d M Y') }} &middot; {{ $p['jenis'] }}
                        @endif
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">Rp {{ number_format($p['amount'], 0, ',', '.') }}</p>
                    <span class="badge text-xs mt-0.5" style="background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);">
                        {{ ucfirst($p['status']) }}
                    </span>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
    @endif

    {{-- Token Listrik Alert --}}
    @if($tokenAlertDashboard)
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
            <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                <svg class="w-5 h-5 flex-shrink-0" style="color:{{ $tokenAlertDashboard['level'] === 'danger' ? '#ef4444' : '#f59e0b' }};" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                TOKEN LISTRIK
            </h3>
            <span class="badge" style="background:{{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.2)' : 'rgba(245,158,11,0.2)' }};color:{{ $tokenAlertDashboard['level'] === 'danger' ? '#ef4444' : '#fbbf24' }};border:1px solid {{ $tokenAlertDashboard['level'] === 'danger' ? 'rgba(239,68,68,0.3)' : 'rgba(245,158,11,0.3)' }};">
                {{ $tokenAlertDashboard['level'] === 'danger' ? 'KRITIS' : 'WARNING' }}
            </span>
        </div>
        <div class="px-5 py-4">
            <p class="text-sm" style="color:var(--text-primary);">{{ $tokenAlertDashboard['message'] }}</p>
            <a href="{{ route('admin.pembayaran.index', ['jenis' => 'listrik']) }}" class="text-xs font-medium mt-2 inline-block" style="color:var(--color-accent);">Kelola Token &rarr;</a>
        </div>
    </div>
    @endif

    {{-- Peringatan Expire --}}
    @if($expiringAssets->count() > 0 || $expiredAssets->count() > 0)
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
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

{{-- Welcome Popup --}}
<div id="welcome-popup" style="display:none;position:fixed;top:16px;right:24px;z-index:9999;max-width:360px;background:rgba(16,185,129,0.05);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border:1px solid rgba(16,185,129,0.2);border-radius:16px;padding:20px 24px;box-shadow:0 12px 40px rgba(0,0,0,0.3);">
    <button type="button" onclick="document.getElementById('welcome-popup').style.display='none'" style="position:absolute;top:8px;right:10px;background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:20px;line-height:1;padding:4px;">&times;</button>
    <div style="display:flex;align-items:center;gap:12px;">
        <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:rgba(16,185,129,0.15);">
            <svg class="w-5 h-5" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div style="font-weight:700;font-size:15px;color:var(--text-primary);">Selamat datang!</div>
            <div style="font-size:13px;color:var(--text-secondary);margin-top:3px;">Anda berhasil masuk ke Johen Office Management System</div>
        </div>
    </div>
</div>
<script>
setTimeout(function(){var p=document.getElementById('welcome-popup');if(p){p.style.display='block';p.style.opacity='0';p.style.transition='opacity 0.5s';setTimeout(function(){p.style.opacity='1';},50);setTimeout(function(){p.style.transition='opacity 0.3s';p.style.opacity='0';setTimeout(function(){p.style.display='none';},300);},6000);}},1200);
</script>

@push('styles')
<style>
.card-hover-info .hover-info {
    opacity: 0;
    transition: opacity 0.2s;
}
.card-hover-info:hover .hover-info {
    opacity: 1;
}
</style>
@endpush

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
</script>
@endpush
@endsection
