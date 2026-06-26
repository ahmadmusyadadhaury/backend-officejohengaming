@extends('layouts.app')
@section('title', $jenisLabels[$jenis])
@section('page-title', 'Pembayaran')
@section('page-subtitle', $jenis === 'internet' ? 'Data WiFi prabayar — Indosat billing tgl 5, IndiHome billing tgl 20. Input setelah bayar.' : 'Kelola tagihan '.$jenisLabels[$jenis])
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Stat Cards --}}
    @if($jenis === 'internet')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M3.5 13.58a10.5 10.5 0 0117 0"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Total WiFi</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Seluruh data WiFi</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Sudah Dibayar</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Tagihan lunas</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:0 0 16px rgba(245,158,11,0.2);">
                <svg class="w-6 h-6" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;">{{ $stats['jatuh_tempo'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Dalam masa tenggang</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:0 0 16px rgba(239,68,68,0.2);">
                <svg class="w-6 h-6" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#f87171;">{{ $stats['terlambat'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Terlambat</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Lewat masa tenggang</div>
            </div>
        </div>
    </div>
    @elseif($jenis === 'aset_digital')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Total Aset Digital</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $stats['total'] }} tagihan</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Sudah Dibayar</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Tagihan lunas</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:0 0 16px rgba(245,158,11,0.2);">
                <svg class="w-6 h-6" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;">{{ $stats['jatuh_tempo'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Belum dibayar</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:0 0 16px rgba(239,68,68,0.2);">
                <svg class="w-6 h-6" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:#f87171;">{{ $stats['terlambat'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Terlambat</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Lewat jatuh tempo</div>
            </div>
        </div>
    </div>
    @elseif($jenis !== 'listrik')
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2H9a3 3 0 013-3V7a2 2 0 012 2h-2zm0 8a3 3 0 01-3-3h1a2 2 0 002 2v1zm2-4h4v2h-4v-2zm-8 0H2v2h4v-2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Total Tagihan</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $stats['total'] }} tagihan</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Sudah Dibayar</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Tagihan lunas</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Alert Jatuh Tempo / Masa Tenggang --}}
    @if($jenis !== 'listrik' && $alertItems->isNotEmpty())
        @php
            $today = now()->startOfDay();
            $redItems = collect();
            $yellowItems = collect();
            $dueField = $jenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
            foreach ($alertItems as $a) {
                $dueDate = $a->{$dueField};
                if (!$dueDate) continue;
                $dueStart = $dueDate->copy()->startOfDay();
                if ($dueStart->lte($today)) {
                    $redItems->push($a);
                } elseif ($dueStart->lte($today->copy()->addDays(3))) {
                    $yellowItems->push($a);
                }
            }
        @endphp
        @if($redItems->isNotEmpty() || $yellowItems->isNotEmpty())
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            @if($redItems->isNotEmpty())
            <div style="flex:1;min-width:280px;">
                <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-bold" style="color:#ef4444;">{{ $redItems->count() }} Lewat Jatuh Tempo</div>
                        <div class="text-xs mt-1" style="color:var(--text-secondary);">{{ $redItems->count() }} tagihan lewat jatuh tempo.</div>
                    </div>
                    <button type="button" onclick="showAlertPopup('danger')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.25);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
                </div>
            </div>
            @endif
            @if($yellowItems->isNotEmpty())
            <div style="flex:1;min-width:280px;">
                <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-bold" style="color:#f59e0b;">{{ $yellowItems->count() }} Segera Jatuh Tempo</div>
                        <div class="text-xs mt-1" style="color:var(--text-secondary);">{{ $yellowItems->count() }} tagihan jatuh tempo dalam 3 hari.</div>
                    </div>
                    <button type="button" onclick="showAlertPopup('warning')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.25);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
                </div>
            </div>
            @endif
        </div>
        @endif
    @endif

    {{-- Popup Detail Alert --}}
    <div id="alert-overlay" style="display:none;position:fixed;inset:0;z-index:9999;background:var(--bg-overlay);align-items:flex-start;justify-content:center;padding-top:80px;" onclick="if(event.target===this)closeAlertPopup()">
        <div style="background:var(--bg-surface);border-radius:16px;padding:24px;width:90%;max-width:520px;max-height:80vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <div id="alert-popup-title" style="font-weight:700;font-size:16px;color:var(--text-primary);">Detail Tagihan</div>
                <button type="button" onclick="closeAlertPopup()" style="background:none;border:none;color:var(--text-secondary);cursor:pointer;font-size:20px;line-height:1;">&times;</button>
            </div>
            <div id="alert-popup-body"></div>
        </div>
    </div>

    {{-- Token Listrik Alert --}}
    @if($jenis === 'listrik' && $tokenAlert)
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:{{ $tokenAlert['level'] === 'danger' ? 'rgba(239,68,68,0.1)' : ($tokenAlert['level'] === 'warning' ? 'rgba(245,158,11,0.1)' : 'rgba(59,130,246,0.1)') }};border:1px solid {{ $tokenAlert['level'] === 'danger' ? 'rgba(239,68,68,0.25)' : ($tokenAlert['level'] === 'warning' ? 'rgba(245,158,11,0.25)' : 'rgba(59,130,246,0.25)') }};">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:{{ $tokenAlert['level'] === 'danger' ? '#ef4444' : ($tokenAlert['level'] === 'warning' ? '#f59e0b' : '#3b82f6') }};" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:{{ $tokenAlert['level'] === 'danger' ? '#ef4444' : ($tokenAlert['level'] === 'warning' ? '#f59e0b' : '#3b82f6') }};">Token Listrik</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">{{ $tokenAlert['message'] }}</div>
        </div>
    </div>
    @endif

    {{-- Table --}}
    @if($jenis !== 'listrik')
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pembayaran {{ $jenisLabels[$jenis] }}</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    @if($jenis === 'internet')
                        Data WiFi prabayar — Indosat billing tgl 5, IndiHome billing tgl 20. Input setelah bayar.
                    @else
                        Data tagihan {{ $jenisLabels[$jenis] }}.
                    @endif
                </div>
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Tagihan
            </button>
        </div>
        <div class="px-5 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-payment" placeholder="Cari..." oninput="filterTable()"
                    class="w-full pl-9 pr-3 py-2 rounded-lg text-sm"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="relative" style="position:relative;">
                <button type="button" onclick="toggleExportMenu(event)" class="filter-btn" style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="export-menu" class="export-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:160px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <a href="{{ route('admin.export', ['type' => 'pembayaran', 'jenis' => $jenis, 'filter' => 'all']) }}" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;text-decoration:none;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Download Semua Data</a>
                    <button type="button" onclick="exportFiltered('pembayaran')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Download Hasil Filter</button>
                </div>
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Status</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="lunas" onclick="setFilter('lunas')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lunas</button>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[900px]" id="payment-table">
                <thead>
                    <tr>
                        <th>No</th>
                        @if($jenis === 'internet')
                            <th>Nama Internet</th>
                            <th class="hidden md:table-cell">Provider</th>
                            <th class="hidden md:table-cell">PIC</th>
                            <th class="hidden lg:table-cell">Jabatan</th>
                            <th class="hidden md:table-cell">Masa Tenggang</th>
                            <th class="hidden md:table-cell">Biaya</th>
                        @else
                            <th>{{ $jenis === 'aset_digital' ? 'Nama Aset' : 'Periode' }}</th>
                            <th class="hidden md:table-cell">Tagihan</th>
                            <th>Jatuh Tempo</th>
                            <th>Nominal</th>
                        @endif
                        <th>Status</th>
                            <th class="hidden md:table-cell">Tgl Bayar</th>
                            <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="payment-tbody">
                    @forelse($items as $item)
                    @php
                        $dueDate = $jenis === 'internet' ? $item->masa_tenggang : $item->jatuh_tempo;
                        $today = now()->startOfDay();
                        if ($item->status === 'lunas') {
                            $badgeClass = 'badge-green';
                            $badgeLabel = 'Lunas';
                        } elseif ($dueDate) {
                            $dueStart = $dueDate->copy()->startOfDay();
                            if ($dueStart->lt($today)) {
                                $badgeClass = 'badge-red';
                                $badgeLabel = 'Terlambat';
                            } elseif ($dueStart->lte($today->copy()->addDays(3))) {
                                $sisa = $today->diffInDays($dueStart);
                                $badgeClass = 'badge-yellow';
                                $badgeLabel = $sisa === 0 ? 'Hari Ini' : 'H - ' . $sisa . ' Hari';
                            } else {
                                $badgeClass = 'badge-yellow';
                                $badgeLabel = 'Jatuh Tempo';
                            }
                        } else {
                            $badgeClass = 'badge-yellow';
                            $badgeLabel = 'Jatuh Tempo';
                        }
                        $itemId = $item->id;
                    @endphp
                    <tr data-status="{{ $item->status }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        @if($jenis === 'internet')
                        <td style="color:var(--text-primary);font-weight:500;">{{ $item->nama_internet }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->provider }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->pic }}</td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);">{{ $item->jabatan }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->masa_tenggang?->format('d/m/Y') }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-primary);font-weight:600;">Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                        @else
                        <td style="color:var(--text-primary);font-weight:500;">{{ $item->periode }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->tanggal_tagihan?->format('d/m/Y') }}</td>
                        <td style="color:var(--text-muted);">{{ $item->jatuh_tempo?->format('d/m/Y') }}</td>
                        <td style="color:var(--text-primary);font-weight:600;">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        @endif
                        <td><span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ ($item->tanggal_bayar) ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $itemId }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="relative" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown({{ $itemId }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $itemId }}" class="dropdown-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $itemId }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal({{ $itemId }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.pembayaran.destroy', $itemId) }}" onsubmit="return confirm('Hapus data ini?')" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data {{ $jenisLabels[$jenis] }}.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Riwayat Top Up Token --}}
    @if($jenis === 'listrik')
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Riwayat Top Up Token</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Riwayat pembelian/pengisian token listrik.</div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:8px;padding:2px;background:var(--bg-card);">
                    <button type="button" onclick="setTopupRange('harian')" class="topup-range-btn" data-range="harian" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($topupRange ?? 'bulanan') === 'harian' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($topupRange ?? 'bulanan') === 'harian' ? '#a78bfa' : 'var(--text-muted)' }};">Harian</button>
                    <button type="button" onclick="setTopupRange('mingguan')" class="topup-range-btn" data-range="mingguan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($topupRange ?? 'bulanan') === 'mingguan' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($topupRange ?? 'bulanan') === 'mingguan' ? '#a78bfa' : 'var(--text-muted)' }};">Mingguan</button>
                    <button type="button" onclick="setTopupRange('bulanan')" class="topup-range-btn" data-range="bulanan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($topupRange ?? 'bulanan') === 'bulanan' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($topupRange ?? 'bulanan') === 'bulanan' ? '#a78bfa' : 'var(--text-muted)' }};">Bulanan</button>
                </div>
                <a href="{{ route('admin.export', ['type' => 'token-topups', 'range' => $topupRange ?? 'bulanan']) }}" class="btn btn-secondary btn-sm" title="Download Excel Riwayat Top Up">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Excel
                </a>
                <button type="button" onclick="openTopupModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Top Up Baru
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Bayar</th>
                        <th>Periode</th>
                        <th>Jumlah KWH</th>
                        <th>Oleh</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topupHistory as $i => $t)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="color:var(--text-primary);">{{ $t->payment_date->format('d M Y') }}</td>
                        <td style="color:var(--text-muted);">{{ $t->period }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ number_format($t->amount_kwh, 0) }} KWH</td>
                        <td style="color:var(--text-primary);">{{ $t->creator?->name ?? '-' }}</td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $t->notes ?: 'Tidak ada catatan' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.pembayaran.token-topup.destroy', $t->id) }}" onsubmit="return confirm('Hapus data top up ini?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;font-size:13px;padding:2px 6px;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada riwayat top up token.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($jenis === 'listrik')
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.12);">
                <svg class="w-5 h-5" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Top Up Terakhir</div>
                <div class="text-lg font-gaming font-bold" style="color:var(--text-primary);">{{ $latestPayment ? number_format($latestPayment->amount_kwh, 0) : '7.000' }} KWH</div>
                <div class="text-xs" style="color:var(--text-muted);">{{ $latestPayment ? $latestPayment->payment_date->format('d M Y') : '-' }} · {{ $latestPayment?->creator?->name ?? '-' }}</div>
            </div>
            <button type="button" onclick="openTopupModal()" class="btn btn-primary btn-xs flex-shrink-0" style="font-size:11px;padding:4px 10px;">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Top Up
            </button>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(59,130,246,0.12);">
                <svg class="w-5 h-5" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Terpakai</div>
                <div class="text-lg font-gaming font-bold" style="color:var(--text-primary);">{{ number_format($usedKwh, 1) }} KWH</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $latestReading && $latestReading->remaining_kwh < 500 ? 'rgba(239,68,68,0.12)' : ($latestReading && $latestReading->remaining_kwh < 1000 ? 'rgba(245,158,11,0.12)' : 'rgba(16,185,129,0.12)') }};">
                <svg class="w-5 h-5" style="color:{{ $latestReading && $latestReading->remaining_kwh < 500 ? '#ef4444' : ($latestReading && $latestReading->remaining_kwh < 1000 ? '#f59e0b' : '#34d399') }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Sisa Token</div>
                <div class="text-lg font-gaming font-bold" style="color:{{ $latestReading && $latestReading->remaining_kwh < 500 ? '#ef4444' : ($latestReading && $latestReading->remaining_kwh < 1000 ? '#f59e0b' : 'var(--text-primary)') }};">
                    {{ $latestReading ? number_format($latestReading->remaining_kwh, 1) : number_format($capacityKwh, 0) }} KWH
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Pengecekan Token Listrik --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pengecekan Token Listrik</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    Lakukan pengecekan sisa KWH token setiap minggu. Kapasitas token: {{ number_format($capacityKwh, 0) }} KWH/bulan.
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:8px;padding:2px;background:var(--bg-card);">
                    <button type="button" onclick="setReadingRange('harian')" class="reading-range-btn" data-range="harian" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($readingRange ?? 'bulanan') === 'harian' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($readingRange ?? 'bulanan') === 'harian' ? '#60a5fa' : 'var(--text-muted)' }};">Harian</button>
                    <button type="button" onclick="setReadingRange('mingguan')" class="reading-range-btn" data-range="mingguan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($readingRange ?? 'bulanan') === 'mingguan' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($readingRange ?? 'bulanan') === 'mingguan' ? '#60a5fa' : 'var(--text-muted)' }};">Mingguan</button>
                    <button type="button" onclick="setReadingRange('bulanan')" class="reading-range-btn" data-range="bulanan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($readingRange ?? 'bulanan') === 'bulanan' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($readingRange ?? 'bulanan') === 'bulanan' ? '#60a5fa' : 'var(--text-muted)' }};">Bulanan</button>
                </div>
                <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-2">
                    <input type="hidden" name="jenis" value="listrik">
                    <input type="month" name="token_month" value="{{ $tokenMonth }}" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                </form>
                <a href="{{ route('admin.export', ['type' => 'token-readings', 'range' => $readingRange ?? 'bulanan', 'token_month' => $tokenMonth]) }}" class="btn btn-secondary btn-sm" title="Download Excel Pengecekan Token">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Excel
                </a>
                <button type="button" onclick="openTokenModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Input Pengecekan
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Check</th>
                        <th>Sisa KWH</th>
                        <th>Terpakai</th>
                        <th>Status</th>
                        <th>Pengecek</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tokenReadings as $i => $r)
                    @php
                        $statusMap = ['segera_isi' => ['#ef4444', 'Segera Isi Token'], 'warning' => ['#f97316', 'Warning'], 'perhatian' => ['#3b82f6', 'Perhatian'], 'aman' => ['#10b981', 'Aman']];
                        $statusColor = $statusMap[$r->status][0] ?? '#10b981';
                        $statusLabel = $statusMap[$r->status][1] ?? 'Aman';
                        $usedInReading = $capacityKwh - $r->remaining_kwh;
                    @endphp
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="color:var(--text-primary);">{{ $r->checked_date->format('d M Y') }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ $r->remaining_kwh }} KWH</td>
                        <td style="color:var(--text-muted);">{{ number_format($usedInReading, 0) }} KWH</td>
                        <td><span class="badge text-xs" style="background:{{ $statusColor === '#10b981' ? 'rgba(16,185,129,0.15)' : ($statusColor === '#3b82f6' ? 'rgba(59,130,246,0.15)' : ($statusColor === '#f97316' ? 'rgba(249,115,22,0.15)' : 'rgba(239,68,68,0.15)')) }};color:{{ $statusColor }};border:1px solid {{ $statusColor === '#10b981' ? 'rgba(16,185,129,0.3)' : ($statusColor === '#3b82f6' ? 'rgba(59,130,246,0.3)' : ($statusColor === '#f97316' ? 'rgba(249,115,22,0.3)' : 'rgba(239,68,68,0.3)')) }};">{{ $statusLabel }}</span></td>
                        <td style="color:var(--text-primary);">{{ $r->checker->name }}</td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->notes ?: 'Tidak ada catatan' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <form method="POST" action="{{ route('admin.pembayaran.token-reading.destroy', $r->id) }}" onsubmit="return confirm('Hapus data pengecekan ini?')" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;font-size:13px;padding:2px 6px;">Hapus</button>
                                </form>
                                <a href="{{ route('admin.export', ['type' => 'token-readings']) }}" class="btn btn-secondary btn-sm" style="padding:4px 8px;line-height:1;" title="Download Excel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada pengecekan token listrik.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Token Reading Modal --}}
    <div id="token-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:80px 16px 16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:88vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Input Pengecekan Token</h3>
                <button type="button" onclick="closeTokenModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1">
                <form method="POST" action="{{ route('admin.pembayaran.token-reading.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div class="field-group">
                            <label class="gaming-label">Sisa KWH <span class="field-req">*</span></label>
                            <input type="number" name="remaining_kwh" id="f-remaining_kwh" required step="0.01" min="0" max="9999" placeholder="Contoh: 342.5" class="gaming-input">
                            <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Input sisa KWH yang tertera di meteran.</div>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Tanggal Pengecekan <span class="field-req">*</span></label>
                            <input type="date" name="checked_date" id="f-checked_date" required value="{{ date('Y-m-d') }}" class="gaming-input">
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Pengecek <span class="field-req">*</span></label>
                            <select name="checked_by" id="f-checked_by" required class="gaming-input">
                                <option value="">Pilih pengecek</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ $u->id === auth()->id() ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Catatan</label>
                            <textarea name="notes" id="f-notes" rows="2" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                        <button type="button" onclick="closeTokenModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Top Up Token Modal --}}
    <div id="topup-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:80px 16px 16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:88vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Top Up Token Listrik</h3>
                <button type="button" onclick="closeTopupModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1">
                <form method="POST" action="{{ route('admin.pembayaran.token-topup.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div class="field-group">
                            <label class="gaming-label">Jumlah KWH <span class="field-req">*</span></label>
                            <input type="number" name="amount_kwh" id="f-amount_kwh" required step="0.01" min="1" placeholder="Contoh: 7000" class="gaming-input">
                            <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Masukkan jumlah KWH yang dibeli.</div>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                            <input type="date" name="payment_date" id="f-payment_date" required value="{{ date('Y-m-d') }}" class="gaming-input">
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Catatan</label>
                            <textarea name="notes" id="f-topup-notes" rows="2" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                        <button type="button" onclick="closeTopupModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:60px 16px 16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[520px] rounded-3xl shadow-2xl flex flex-col" style="max-height:80vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail</h3>
            <button type="button" onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex justify-between items-center" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            <div class="flex gap-2">
                <button type="button" id="detail-bayar-btn" onclick="markAsLunas()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="display:none;background:#10b981;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Bayar / Lunaskan</button>
                <button type="button" onclick="editFromDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">Edit</button>
            </div>
        </div>
    </div>
</div>

{{-- Form Modal --}}
<div id="payment-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:80px 16px 16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="max-height:88vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="modal-title">Tambah Tagihan</h3>
            <button type="button" onclick="closeModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form id="payment-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">
                <input type="hidden" name="jenis" id="f-jenis" value="{{ $jenis }}">

                <div class="form-grid-2">
                    @if($jenis === 'internet')
                    <div class="field-group">
                        <label class="gaming-label">Nama Internet <span class="field-req">*</span></label>
                        <input type="text" name="nama_internet" id="f-nama_internet" required placeholder="Contoh: Wifi 1 (Kantor Utama)" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Provider <span class="field-req">*</span></label>
                        <select name="provider" id="f-provider" required class="gaming-input">
                            <option value="">Pilih provider</option>
                            <option value="Indosat">Indosat</option>
                            <option value="IndiHome">IndiHome</option>
                            <option value="First Media">First Media</option>
                            <option value="MyRepublic">MyRepublic</option>
                            <option value="Biznet">Biznet</option>
                            <option value="CBN">CBN</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" id="f-pic" required placeholder="Nama penanggung jawab" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
                        <input type="text" name="jabatan" id="f-jabatan" required placeholder="Jabatan PIC" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Masa Tenggang <span class="field-req">*</span></label>
                        <input type="date" name="masa_tenggang" id="f-masa_tenggang" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Biaya <span class="field-req">*</span></label>
                        <input type="number" name="biaya" id="f-biaya" required placeholder="Contoh: Rp 300.000" class="gaming-input" min="0" step="0.01">
                    </div>
                    @else
                    <div class="field-group">
                        <label class="gaming-label">{{ $jenis === 'aset_digital' ? 'Nama Aset' : 'Periode' }} <span class="field-req">*</span></label>
                        <input type="text" name="periode" id="f-periode" required placeholder="{{ $jenis === 'aset_digital' ? 'Contoh: Adobe Photoshop' : 'Contoh: Januari 2026' }}" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nominal <span class="field-req">*</span></label>
                        <input type="number" name="nominal" id="f-nominal" required placeholder="Contoh: Rp 300.000" class="gaming-input" min="0" step="0.01">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tagihan <span class="field-req">*</span></label>
                        <input type="date" name="tanggal_tagihan" id="f-tanggal_tagihan" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jatuh Tempo <span class="field-req">*</span></label>
                        <input type="date" name="jatuh_tempo" id="f-jatuh_tempo" required class="gaming-input">
                    </div>
                    @endif
                    <div class="field-group">
                        <label class="gaming-label">Status <span class="field-req">*</span></label>
                        <select name="status" id="f-status" required class="gaming-input" onchange="toggleTanggalBayar()">
                            <option value="jatuh_tempo">Jatuh Tempo</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                    <div class="field-group" id="f-tanggal_bayar-group">
                        <label class="gaming-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" id="f-tanggal_bayar" class="gaming-input">
                    </div>
                </div>

                <div class="form-footer">
                    <button type="button" onclick="closeModal()" class="btn-form btn-form-batal">Batal</button>
                    <button type="submit" class="btn-form btn-form-simpan" id="form-submit-btn">Tambah</button>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- Modal Bayar/Lunaskan --}}
<div id="bayar-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:80px 16px 16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:88vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Bayar / Lunaskan</h3>
            <button type="button" onclick="closeBayarModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <div id="bayar-info" style="margin-bottom:16px;padding:12px;border-radius:10px;background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div id="bayar-name" style="font-weight:600;font-size:14px;color:var(--text-primary);"></div>
                <div id="bayar-nominal" style="font-size:13px;color:var(--text-muted);margin-top:4px;"></div>
                <div id="bayar-due" style="font-size:13px;color:var(--text-muted);margin-top:2px;"></div>
            </div>
            <form id="bayar-form" method="POST" action="{{ url('admin/pembayaran') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="jenis" value="{{ $jenis }}">
                <input type="hidden" name="id" id="bayar-id" value="">
                @if($jenis === 'internet')
                <input type="hidden" name="nama_internet" id="bayar-nama_internet">
                <input type="hidden" name="provider" id="bayar-provider">
                <input type="hidden" name="pic" id="bayar-pic">
                <input type="hidden" name="jabatan" id="bayar-jabatan">
                <input type="hidden" name="masa_tenggang" id="bayar-masa_tenggang">
                <input type="hidden" name="biaya" id="bayar-biaya">
                @else
                <input type="hidden" name="periode" id="bayar-periode">
                <input type="hidden" name="tanggal_tagihan" id="bayar-tanggal_tagihan">
                <input type="hidden" name="jatuh_tempo" id="bayar-jatuh_tempo">
                <input type="hidden" name="nominal" id="bayar-nominal_val">
                @endif
                <input type="hidden" name="status" id="bayar-status" value="lunas">
                <div class="space-y-4">
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                        <input type="date" name="tanggal_bayar" id="bayar-tanggal_bayar" required value="{{ date('Y-m-d') }}" class="gaming-input">
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeBayarModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;box-shadow:0 4px 15px rgba(16,185,129,0.3);cursor:pointer;">Lunaskan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px 24px;
    margin-bottom: 16px;
}
@media (max-width: 640px) {
    .form-grid-2 { grid-template-columns: 1fr; }
}
.field-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.field-req { color: #f87171; }
.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 16px;
    margin-top: 8px;
    border-top: 1px solid var(--border-color);
}
.btn-form {
    padding: 8px 22px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}
.btn-form-batal {
    background: transparent;
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.7);
}
.btn-form-batal:hover {
    border-color: rgba(255,255,255,0.3);
    color: #fff;
}
.btn-form-simpan {
    background: linear-gradient(135deg, #6c5cff, #8b7bff);
    color: #fff;
    box-shadow: 0 4px 15px rgba(108,92,255,0.3);
}
.btn-form-simpan:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(108,92,255,0.4);
}
</style>
@endpush

@push('scripts')
<script>
const paymentData = @json($itemsJson);
const currentJenis = '{{ $jenis }}';
const dueField = currentJenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
const jenisLabel = @json($jenisLabels[$jenis] ?? $jenis);
let detailId = null;

function showAlertPopup(type) {
    const overlay = document.getElementById('alert-overlay');
    const title = document.getElementById('alert-popup-title');
    const body = document.getElementById('alert-popup-body');
    const today = new Date(); today.setHours(0,0,0,0);
    const color = type === 'danger' ? '#ef4444' : '#f59e0b';
    const bgColor = type === 'danger' ? 'rgba(239,68,68,0.1)' : 'rgba(245,158,11,0.1)';
    const borderColor = type === 'danger' ? 'rgba(239,68,68,0.25)' : 'rgba(245,158,11,0.25)';
    const label = currentJenis === 'internet' ? 'Masa Tenggang' : 'Jatuh Tempo';

    const items = paymentData.filter(function(item) {
        if (!item[dueField]) return false;
        if (item.status !== 'jatuh_tempo') return false;
        const due = new Date(item[dueField]); due.setHours(0,0,0,0);
        if (type === 'danger') return due <= today;
        const in3 = new Date(today); in3.setDate(in3.getDate() + 3);
        return due > today && due <= in3;
    });

    title.textContent = type === 'danger' ? 'Tagihan Lewat Jatuh Tempo' : 'Tagihan Segera Jatuh Tempo';
    title.style.color = color;
    body.innerHTML = '';

    if (items.length === 0) {
        body.innerHTML = '<div style="text-align:center;padding:20px;color:var(--text-muted);">Tidak ada data.</div>';
    } else {
        items.forEach(function(item) {
            const due = new Date(item[dueField]); due.setHours(0,0,0,0);
            const diffDays = Math.round((today - due) / (1000 * 60 * 60 * 24));
            let badgeText = '';
            if (type === 'danger') {
                badgeText = diffDays === 0 ? 'Hari Ini' : diffDays + ' Hari Lewat';
            } else {
                badgeText = diffDays + ' Hari Lagi';
            }
            const name = currentJenis === 'internet' ? (item.nama_internet + ' (' + item.provider + ')') : item.periode;
            const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.nominal);

            var card = document.createElement('div');
            card.setAttribute('data-id', item.id);
            card.style.cssText = 'padding:12px;margin-bottom:8px;border-radius:10px;background:' + bgColor + ';border:1px solid ' + borderColor + ';cursor:pointer;transition:all 0.15s;';

            card.onmouseover = function() { this.style.transform = 'translateY(-1px)'; this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)'; };
            card.onmouseout = function() { this.style.transform = ''; this.style.boxShadow = ''; };
            card.onclick = function() { goToEdit(item.id); };

            card.innerHTML =
                '<div style="display:flex;justify-content:space-between;align-items:center;">' +
                    '<div>' +
                        '<div style="font-weight:600;font-size:13px;color:var(--text-primary);">' + name + '</div>' +
                        '<div style="font-size:12px;color:var(--text-muted);margin-top:2px;">' + label + ': ' + badgeText + ' &middot; ' + nominal + '</div>' +
                    '</div>' +
                    '<div style="display:flex;align-items:center;gap:6px;">' +
                        '<span style="padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;background:' + bgColor + ';color:' + color + ';border:1px solid ' + borderColor + ';">' + badgeText + '</span>' +
                        '<svg style="width:14px;height:14px;color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>' +
                    '</div>' +
                '</div>';

            body.appendChild(card);
        });
    }
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function goToEdit(id) {
    closeAlertPopup();
    openBayarModal(id);
}

function openBayarModal(id) {
    const i = paymentData.find(function(x) { return x.id === id; });
    if (!i) return;

    document.getElementById('bayar-id').value = i.id;
    document.getElementById('bayar-form').action = '{{ url("admin/pembayaran") }}/' + i.id;

    const name = currentJenis === 'internet' ? (i.nama_internet + ' (' + i.provider + ')') : i.periode;
    const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(i.nominal);
    const dueField = currentJenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
    const dueLabel = currentJenis === 'internet' ? 'Masa Tenggang' : 'Jatuh Tempo';
    const dueDate = i[dueField] ? new Date(i[dueField]).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';

    document.getElementById('bayar-name').textContent = name;
    document.getElementById('bayar-nominal').textContent = 'Nominal: ' + nominal;
    document.getElementById('bayar-due').textContent = dueLabel + ': ' + dueDate;

    if (currentJenis === 'internet') {
        document.getElementById('bayar-nama_internet').value = i.nama_internet;
        document.getElementById('bayar-provider').value = i.provider;
        document.getElementById('bayar-pic').value = i.pic;
        document.getElementById('bayar-jabatan').value = i.jabatan;
        document.getElementById('bayar-masa_tenggang').value = i.masa_tenggang;
        document.getElementById('bayar-biaya').value = i.biaya;
    } else {
        document.getElementById('bayar-periode').value = i.periode;
        document.getElementById('bayar-tanggal_tagihan').value = i.tanggal_tagihan;
        document.getElementById('bayar-jatuh_tempo').value = i.jatuh_tempo;
        document.getElementById('bayar-nominal_val').value = i.nominal;
    }

    document.getElementById('bayar-tanggal_bayar').value = new Date().toISOString().split('T')[0];
    document.getElementById('bayar-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeBayarModal() {
    document.getElementById('bayar-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('bayar-modal')?.addEventListener('click', function(e) { if (e.target === this) closeBayarModal(); });

function closeAlertPopup() {
    document.getElementById('alert-overlay').style.display = 'none';
    document.body.style.overflow = '';
}

function toggleTanggalBayar() {
    const status = document.getElementById('f-status').value;
    const group = document.getElementById('f-tanggal_bayar-group');
    const input = document.getElementById('f-tanggal_bayar');
    if (status === 'lunas') {
        group.style.display = '';
        if (!input.value) {
            input.value = new Date().toISOString().split('T')[0];
        }
    } else {
        group.style.display = 'none';
        input.value = '';
    }
}

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Tagihan';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('payment-form').action = '{{ route('admin.pembayaran.store') }}';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('payment-form').querySelectorAll('input, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') el.value = '';
    });
    document.getElementById('f-status').value = 'jatuh_tempo';
    document.getElementById('f-tanggal_bayar-group').style.display = 'none';
    showModal();
}

function showDetail(id) {
    detailId = id;
    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    @if($jenis === 'internet')
    document.getElementById('detail-title').textContent = i.nama_internet;
    @else
    document.getElementById('detail-title').textContent = i.periode;
    @endif

    const fmtDate = (d) => d ? new Date(d + 'T00:00:00') : null;
    const today = new Date(); today.setHours(0,0,0,0);
    @if($jenis === 'internet')
    const dueDate = fmtDate(i.masa_tenggang);
    @else
    const dueDate = fmtDate(i.jatuh_tempo);
    @endif
    let computedLabel, computedBg, computedText, computedBorder;
    if (i.status === 'lunas') {
        computedLabel = 'Lunas'; computedBg = '#ecfdf5'; computedText = '#059669'; computedBorder = '#a7f3d0';
    } else if (dueDate && dueDate < today) {
        computedLabel = 'Terlambat'; computedBg = '#fef2f2'; computedText = '#dc2626'; computedBorder = '#fecaca';
    } else if (dueDate && dueDate <= new Date(today.getTime() + 3*86400000)) {
        const sisa = Math.round((dueDate - today) / 86400000);
        computedLabel = sisa === 0 ? 'Hari Ini' : 'H - ' + sisa + ' Hari';
        computedBg = '#fff7ed'; computedText = '#c2410c'; computedBorder = '#fed7aa';
    } else {
        computedLabel = 'Jatuh Tempo'; computedBg = '#fff7ed'; computedText = '#c2410c'; computedBorder = '#fed7aa';
    }
    const s = { label: computedLabel, bg: computedBg, text: computedText, border: computedBorder };

    const fmt = (d) => d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';

    @if($jenis === 'internet')
    const rows = [
        { label: 'Nama Internet', value: i.nama_internet },
        { label: 'Provider', value: i.provider },
        { label: 'PIC', value: i.pic },
        { label: 'Jabatan', value: i.jabatan },
        { label: 'Masa Tenggang', value: fmt(i.masa_tenggang) },
        { label: 'Biaya', value: 'Rp ' + Number(i.biaya).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    @else
    const rows = [
        { label: '{{ $jenis === "aset_digital" ? "Nama Aset" : "Periode" }}', value: i.periode },
        { label: 'Tagihan', value: fmt(i.tanggal_tagihan) },
        { label: 'Jatuh Tempo', value: fmt(i.jatuh_tempo) },
        { label: 'Nominal', value: 'Rp ' + Number(i.nominal).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    @endif

    const bayarBtn = document.getElementById('detail-bayar-btn');
    if (i.status === 'jatuh_tempo') {
        bayarBtn.style.display = '';
    } else {
        bayarBtn.style.display = 'none';
    }

    document.getElementById('detail-body').innerHTML = `
        <div class="space-y-1">
            ${rows.map((r, idx) => `
                <div class="flex items-center justify-between py-2.5" ${idx < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
                </div>
            `).join('')}
            <div class="flex items-center justify-between py-2.5">
                <p class="text-sm" style="color:var(--text-muted);">Status</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${s.bg};color:${s.text};border:1px solid ${s.border};">${s.label}</span>
            </div>
        </div>
    `;
    document.getElementById('detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function markAsLunas() {
    const id = detailId;
    if (!id) return;
    if (!confirm('Tandai pembayaran ini sebagai Lunas?')) return;

    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');
    formData.append('jenis', currentJenis);
    formData.append('status', 'lunas');
    formData.append('tanggal_bayar', new Date().toISOString().split('T')[0]);

    @if($jenis === 'internet')
    formData.append('nama_internet', i.nama_internet);
    formData.append('provider', i.provider);
    formData.append('pic', i.pic);
    formData.append('jabatan', i.jabatan);
    formData.append('masa_tenggang', i.masa_tenggang);
    formData.append('biaya', i.biaya);
    @else
    formData.append('periode', i.periode);
    formData.append('tanggal_tagihan', i.tanggal_tagihan);
    formData.append('jatuh_tempo', i.jatuh_tempo);
    formData.append('nominal', i.nominal);
    @endif

    fetch('{{ url('admin/pembayaran') }}/' + id, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData,
    }).then(r => {
        if (r.ok) { location.reload(); }
        else { r.json().then(e => { alert('Gagal: ' + JSON.stringify(e.errors || e)); }); }
    }).catch(() => { location.reload(); });
}

function closeDetail() {
    detailId = null;
    document.getElementById('detail-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function editFromDetail() {
    const id = detailId;
    closeDetail();
    if (id) openEditModal(id);
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function toggleDropdown(id) {
    const all = document.querySelectorAll('.dropdown-menu');
    all.forEach(el => { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    const menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.dropdown-menu, .export-menu').forEach(el => el.style.display = 'none');
    }
});

function openEditModal(id) {
    closeDetail();
    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    document.getElementById('modal-title').textContent = 'Edit Tagihan';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = i.id;
    document.getElementById('payment-form').action = '{{ url('admin/pembayaran') }}/' + i.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    @if($jenis === 'internet')
    document.getElementById('f-nama_internet').value = i.nama_internet;
    document.getElementById('f-provider').value = i.provider;
    document.getElementById('f-pic').value = i.pic;
    document.getElementById('f-jabatan').value = i.jabatan;
    document.getElementById('f-masa_tenggang').value = i.masa_tenggang;
    document.getElementById('f-biaya').value = i.biaya;
    @else
    document.getElementById('f-periode').value = i.periode;
    document.getElementById('f-tanggal_tagihan').value = i.tanggal_tagihan;
    document.getElementById('f-jatuh_tempo').value = i.jatuh_tempo;
    document.getElementById('f-nominal').value = i.nominal;
    @endif

    document.getElementById('f-status').value = i.status;
    if (i.status === 'lunas') {
        document.getElementById('f-tanggal_bayar').value = i.tanggal_bayar || new Date().toISOString().split('T')[0];
        document.getElementById('f-tanggal_bayar-group').style.display = '';
    } else {
        document.getElementById('f-tanggal_bayar').value = '';
        document.getElementById('f-tanggal_bayar-group').style.display = 'none';
    }

    showModal();
}

function showModal() { document.getElementById('payment-modal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closeModal() { document.getElementById('payment-modal').style.display = 'none'; document.body.style.overflow = ''; }

document.getElementById('payment-modal')?.addEventListener('click', function(e) { if (e.target === this) closeModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeDetail(); closeModal(); } });

let currentFilter = 'all';

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

function setFilter(value) {
    currentFilter = value;
    const label = document.querySelector(`.filter-menu button[data-value="${value}"]`).textContent;
    document.getElementById('filter-label').textContent = label;
    document.getElementById('filter-menu').style.display = 'none';
    filterTable();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterTable() {
    const search = (document.getElementById('search-payment')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#payment-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowStatus === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}

function toggleExportMenu(e) {
    e.stopPropagation();
    const all = document.querySelectorAll('.export-menu');
    all.forEach(el => el.style.display = 'none');
    const menu = document.getElementById('export-menu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function exportFiltered(type) {
    const activeFilter = document.querySelector('#filter-menu button.active') || document.querySelector('#filter-menu button[data-value="all"]');
    const filterValue = activeFilter?.getAttribute('data-value') || 'all';
    const search = document.getElementById('search-payment')?.value || '';
    const jenis = '{{ $jenis }}';
    const params = new URLSearchParams({ type, filter: filterValue, search });
    if (jenis) params.set('jenis', jenis);
    window.location.href = '{{ route("admin.export") }}?' + params.toString();
}

function openTokenModal() {
    document.getElementById('token-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-remaining_kwh').focus();
}

function closeTokenModal() {
    document.getElementById('token-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('token-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTokenModal(); });
document.getElementById('topup-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTopupModal(); });

function openTopupModal() {
    document.getElementById('topup-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-amount_kwh').focus();
}

function closeTopupModal() {
    document.getElementById('topup-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function setTopupRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('topup_range', range);
    params.delete('reading_range');
    window.location.search = params.toString();
}

function setReadingRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('reading_range', range);
    params.delete('topup_range');
    window.location.search = params.toString();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTokenModal();
        closeTopupModal();
        closeAlertPopup();
        closeBayarModal();
        document.body.style.overflow = '';
    }
});
</script>
@endpush
