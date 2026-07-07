@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection

@section('content')
<div class="dashboard-section stagger-children">

    {{-- 4 Stat Cards --}}
    <div class="dashboard-section">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 md:gap-3">
            @php
                $statCards = [
                    ['label' => 'Total Meeting Saya', 'count' => $totalMeeting, 'color' => '#a78bfa', 'bg' => 'rgba(124,58,237,0.12)', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['label' => 'Disetujui', 'count' => $disetujui, 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.12)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'Menunggu', 'count' => $menunggu, 'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.12)', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'Ditolak', 'count' => $ditolak, 'color' => '#f87171', 'bg' => 'rgba(239,68,68,0.12)', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
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
                    <div class="stat-num" style="color:{{ $card['color'] }};">{{ $card['count'] }}</div>
                    <div class="stat-label-text" style="font-size:0.7rem;">{{ $card['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Ajukan Meeting Baru --}}
    <div class="dashboard-section">
        <div class="gaming-card">
            <div class="card-body">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-gaming font-bold" style="font-size:0.95rem;color:var(--text-primary);">Ajukan Meeting Baru</h3>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">Butuh meeting? Ajukan permintaan meeting sekarang juga.</p>
                        <p class="text-[0.65rem] mt-1" style="color:var(--text-muted);">Ajukan jadwal meeting dengan mengisi detail pertemuan. Sertakan alasan, pembahasan, dan hasil yang diharapkan.</p>
                    </div>
                    <a href="{{ route('koordinator.meetings.index') }}?open_request=1" class="btn btn-primary btn-sm flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Request Meeting
                    </a>
                </div>
            </div>
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

                        @unless($hasOverdue || $hasToday || $hasWarning)
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <p>Tidak ada tagihan</p>
                        </div>
                        @endunless
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
    if ($overduePayments->isNotEmpty()) {
        $dismissibleAlerts[] = [
            'id' => 'overdue',
            'title' => $overduePayments->count() . ' Pembayaran Terlewat',
            'message' => 'Segera lunasi pembayaran yang sudah melewati jatuh tempo.',
            'color' => '#ef4444',
            'bg' => 'rgba(239,68,68,0.08)',
            'border' => 'rgba(239,68,68,0.2)',
            'icon' => '<svg class="w-5 h-5" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
            'delay' => 1500,
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
            'delay' => 2500,
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
            el.style.cssText = 'pointer-events:auto;display:flex;align-items:flex-start;gap:12px;padding:16px 20px;border-radius:14px;background:' + alert.bg + ';border:1px solid ' + alert.border + ';backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);box-shadow:0 8px 32px rgba(0,0,0,0.25);opacity:0;transform:translateX(40px);transition:all 0.4s cubic-bezier(0.22,1,0.36,1);position:relative;';
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
        </div>
    </div>
</div>

{{-- Modal Bayar dari Dashboard --}}
<div id="dashboard-bayar-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);" onclick="if(event.target===this)closeDashboardBayar()">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Bayar Tagihan</h3>
            <button type="button" onclick="closeDashboardBayar()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5">
            <div style="margin-bottom:16px;padding:12px;border-radius:10px;background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div id="dbayar-name" style="font-weight:600;font-size:14px;color:var(--text-primary);"></div>
                <div id="dbayar-nominal" style="font-size:13px;color:var(--text-muted);margin-top:4px;"></div>
            </div>
            <div class="field-group mb-4">
                <label class="gaming-label">Periode Pembayaran <span class="field-req">*</span></label>
                <div style="display:flex;gap:12px;margin-top:4px;">
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;padding:8px 14px;border-radius:8px;border:2px solid var(--border-color);background:var(--bg-surface-2);transition:all 0.2s;" data-period="bulanan" onclick="selectPeriod(this)">
                        <input type="radio" name="period" value="bulanan" checked style="accent-color:#6c5cff;">
                        <span style="font-weight:500;color:var(--text-primary);font-size:13px;">Bulanan (1 bulan)</span>
                    </label>
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;padding:8px 14px;border-radius:8px;border:2px solid var(--border-color);background:var(--bg-surface-2);transition:all 0.2s;" data-period="tahunan" onclick="selectPeriod(this)">
                        <input type="radio" name="period" value="tahunan" style="accent-color:#6c5cff;">
                        <span style="font-weight:500;color:var(--text-primary);font-size:13px;">Tahunan (12 bulan)</span>
                    </label>
                </div>
                <div id="period-info" style="font-size:12px;color:var(--text-muted);margin-top:4px;"></div>
            </div>
            <form id="dashboard-bayar-form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis" id="dbayar-jenis">
                <div class="field-group mb-4">
                    <label class="gaming-label">PIC <span class="field-req">*</span></label>
                    <input type="text" name="pic" required class="gaming-input" value="{{ auth()->user()->name }}" placeholder="Nama PIC">
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
                    <select name="jabatan" required class="gaming-input">
                        <option value="">— Pilih Jabatan —</option>
                        @foreach($jabatanList as $j)
                        <option value="{{ $j }}">{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                    <input type="date" name="tanggal_bayar" required class="gaming-input" value="{{ date('Y-m-d') }}">
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Upload Bukti Bayar <span class="field-req">*</span></label>
                    <input type="file" name="bukti_bayar" accept="image/jpeg,image/png" required class="gaming-input" style="padding:8px;">
                    <p class="text-xs mt-1" style="color:var(--text-muted);">Format: JPEG/PNG, maks 2MB</p>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;">
                    <button type="button" onclick="closeDashboardBayar()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;box-shadow:0 4px 15px rgba(16,185,129,0.3);cursor:pointer;">Kirim</button>
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
.pembayaran-item {
    transition: background 0.15s ease;
}
.pembayaran-item:hover {
    background: rgba(124,58,237,0.03);
}
.field-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.field-req { color: #f87171; }
.gaming-input { width: 100%; }
</style>
@endpush

@push('scripts')
<script>
    var dashboardPaymentData = {!! $paymentDataJson !!};
    var bayarNominal = 0;

    function openDashboardBayar(id, type) {
        var item = dashboardPaymentData.find(function(x) { return x.id === id && x.type === type; });
        if (!item) return;

        bayarNominal = item.amount;
        document.getElementById('dbayar-name').textContent = item.label;
        document.getElementById('dbayar-nominal').textContent = 'Rp ' + Number(item.amount).toLocaleString('id-ID');
        document.getElementById('dbayar-jenis').value = type === 'wifi' ? 'internet' : type;
        document.getElementById('dashboard-bayar-form').action = '{{ url('payment-approval/tagihan') }}/' + id + '/bayar';

        document.querySelectorAll('[data-period]').forEach(function(el) {
            el.style.borderColor = 'var(--border-color)';
        });
        document.querySelector('[data-period="bulanan"]').style.borderColor = '#6c5cff';
        document.querySelector('input[name="period"][value="bulanan"]').checked = true;
        document.getElementById('period-info').textContent = '';

        document.getElementById('dashboard-bayar-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function selectPeriod(el) {
        var isTahunan = el.dataset.period === 'tahunan';
        document.querySelectorAll('[data-period]').forEach(function(e) {
            e.style.borderColor = 'var(--border-color)';
        });
        el.style.borderColor = '#6c5cff';
        el.querySelector('input[type="radio"]').checked = true;
        var info = document.getElementById('period-info');
        if (isTahunan) {
            info.textContent = 'Total dibayar: Rp ' + (bayarNominal * 12).toLocaleString('id-ID') + ' (' + bayarNominal.toLocaleString('id-ID') + ' \u00d7 12)';
        } else {
            info.textContent = '';
        }
    }

    function closeDashboardBayar() {
        document.getElementById('dashboard-bayar-modal').style.display = 'none';
        document.body.style.overflow = '';
    }

    document.getElementById('dashboard-bayar-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDashboardBayar();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            var bm = document.getElementById('dashboard-bayar-modal');
            var pm = document.getElementById('semua-pembayaran-modal');
            if (bm && bm.style.display !== 'none') { closeDashboardBayar(); }
            else if (pm && pm.style.display !== 'none') { closeModal('semua-pembayaran-modal'); }
        }
    });

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