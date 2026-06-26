@extends('layouts.app')
@section('title', 'Data Kendaraan')
@section('page-title', 'Data Aset > Kendaraan')
@section('page-subtitle', 'Seluruh aset kendaraan milik perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Kendaraan</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh aset kendaraan</div>
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
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $stats['pajak_aktif'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Pajak Aktif</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Pajak masih berlaku</div>
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
                <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;">{{ $stats['segera_habis'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Pajak Segera Habis</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Pajak akan habis dalam 30 hari</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:0 0 16px rgba(239,68,68,0.2);">
                <svg class="w-6 h-6" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:#ef4444;">{{ $stats['pajak_mati'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Pajak Mati</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Pajak sudah expired</div>
            </div>
        </div>
    </div>

    {{-- Alert Pajak Mendekati --}}
    @php
        $matiCount = $alertVehicles->where('status_pajak', 'mati')->count();
        $segeraCount = $alertVehicles->where('status_pajak', 'segera_habis')->count();
    @endphp
    @if($alertVehicles->isNotEmpty())
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        @if($matiCount > 0)
        <div style="flex:1;min-width:260px;">
            <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold" style="color:#ef4444;">{{ $matiCount }} Pajak Mati</div>
                    <div class="text-xs mt-1" style="color:var(--text-secondary);">{{ $matiCount }} kendaraan dengan pajak sudah expired.</div>
                </div>
                <button type="button" onclick="showAlertPopup('danger')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(239,68,68,0.12);color:#ef4444;border:1px solid rgba(239,68,68,0.2);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
            </div>
        </div>
        @endif
        @if($segeraCount > 0)
        <div style="flex:1;min-width:260px;">
            <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold" style="color:#f59e0b;">{{ $segeraCount }} Segera Habis</div>
                    <div class="text-xs mt-1" style="color:var(--text-secondary);">{{ $segeraCount }} kendaraan dengan pajak akan segera habis.</div>
                </div>
                <button type="button" onclick="showAlertPopup('warning')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(245,158,11,0.12);color:#f59e0b;border:1px solid rgba(245,158,11,0.2);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Tabel --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Data Kendaraan</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Seluruh aset kendaraan milik perusahaan.</div>
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kendaraan
            </button>
        </div>
        <div class="px-5 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-vehicle" placeholder="Cari plat nomor atau nama kendaraan" oninput="filterVehicles()"
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
                    <a href="{{ route('admin.export', ['type' => 'vehicles', 'filter' => 'all']) }}" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;text-decoration:none;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Download Semua Data</a>
                    <button type="button" onclick="exportFiltered('vehicles')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Download Hasil Filter</button>
                </div>
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">{{ $statusFilter === 'all' ? 'Semua Status' : ($statusFilter === 'aktif' ? 'Pajak Aktif' : ($statusFilter === 'segera_habis' ? 'Segera Habis' : 'Pajak Mati')) }}</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="aktif" onclick="setFilter('aktif')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Pajak Aktif</button>
                    <button type="button" data-value="segera_habis" onclick="setFilter('segera_habis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Segera Habis</button>
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Pajak Mati</button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]" id="vehicles-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kendaraan</th>
                        <th>Nomor Polisi</th>
                        <th class="hidden md:table-cell">Jenis</th>
                        <th class="hidden lg:table-cell">Merk/Tipe</th>
                        <th class="hidden md:table-cell">Tahun</th>
                        <th class="hidden lg:table-cell">Warna</th>
                        <th>Status</th>
                        <th class="hidden md:table-cell">Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="vehicles-tbody">
                    @forelse($vehicles as $v)
                    @php
                        $statusBadge = match($v->status_pajak) {
                            'aktif'        => 'badge-green',
                            'segera_habis' => 'badge-yellow',
                            'mati'         => 'badge-red',
                            default        => 'badge-gray',
                        };
                        $statusLabel = match($v->status_pajak) {
                            'aktif'        => 'Pajak Aktif',
                            'segera_habis' => 'Segera Habis',
                            'mati'         => 'Pajak Mati',
                            default        => '-',
                        };
                    @endphp
                    <tr data-status="{{ $v->status_pajak }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $v->nama_kendaraan }}</td>
                        <td style="color:var(--text-muted);font-family:monospace;font-weight:600;">{{ $v->plat_nomor }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-primary);">{{ $v->jenis_kendaraan }}</td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);">{{ $v->merk_tipe ?? '-' }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $v->tahun }}</td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);">{{ $v->warna ?? '-' }}</td>
                        <td><span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $v->keperluan }}">{{ $v->keperluan ?? '-' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $v->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="relative" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown({{ $v->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $v->id }}" class="dropdown-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $v->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal({{ $v->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.vehicles.destroy', $v) }}" onsubmit="return confirm('Hapus kendaraan ini?')" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="10" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data kendaraan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Popup Alert Pajak --}}
<div id="alert-overlay" style="display:none;position:fixed;inset:0;z-index:9999;background:var(--bg-overlay);align-items:flex-start;justify-content:center;padding-top:80px;" onclick="if(event.target===this)closeAlertPopup()">
    <div style="background:var(--bg-surface);border-radius:16px;padding:24px;width:90%;max-width:520px;max-height:80vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <div id="alert-popup-title" style="font-weight:700;font-size:16px;color:var(--text-primary);">Detail Pajak Kendaraan</div>
            <button type="button" onclick="closeAlertPopup()" style="background:none;border:none;color:var(--text-secondary);cursor:pointer;font-size:20px;line-height:1;">&times;</button>
        </div>
        <div id="alert-popup-body"></div>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:60px 16px 16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[600px] rounded-3xl shadow-2xl flex flex-col" style="max-height:75vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div id="detail-header" style="padding:0;flex-shrink:0;border-bottom:none;border-radius:20px 20px 0 0;overflow:hidden;">
            <div style="background:linear-gradient(135deg,rgba(109,94,249,0.12),rgba(109,94,249,0.04));padding:24px 24px 20px;position:relative;">
                <button type="button" onclick="closeDetail()" style="position:absolute;top:16px;right:16px;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.08);border:none;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.15)'" onmouseout="this.style.background='rgba(0,0,0,0.08)'">
                    <svg class="w-4 h-4" style="color:var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div id="detail-header-icon" style="width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;background:rgba(109,94,249,0.15);margin-bottom:12px;">
                    <svg class="w-6 h-6" style="color:#6D5ef9;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                </div>
                <h3 id="detail-title" style="font-size:20px;font-weight:700;color:var(--text-primary);margin:0;line-height:1.3;">Detail Kendaraan</h3>
                <p id="detail-subtitle" style="font-size:13px;color:var(--text-muted);margin:4px 0 0;"></p>
                <div id="detail-badge" style="margin-top:10px;"></div>
            </div>
        </div>

        {{-- Body --}}
        <div class="px-5 py-4 overflow-y-auto flex-1" id="detail-body"></div>

        {{-- Footer --}}
        <div class="px-5 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeDetail()" style="width:100%;padding:10px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;transition:all 0.2s;background:var(--bg-surface-2);border:1px solid var(--border-color);color:var(--text-primary);" onmouseover="this.style.background='var(--bg-surface)'" onmouseout="this.style.background='var(--bg-surface-2)'">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal Tambah / Edit Kendaraan --}}
<div id="vehicle-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:50px 16px 16px;background:var(--bg-overlay);">
    <div class="vehicle-modal-card" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="vehicle-modal-header">
            <div>
                <h3 class="vehicle-modal-title" id="modal-title">Tambah Aset Kendaraan</h3>
                <p class="vehicle-modal-subtitle">Lengkapi informasi kendaraan dengan benar</p>
            </div>
            <button type="button" onclick="closeModal('vehicle-modal')" class="vehicle-close-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="vehicle-modal-body">
            <form id="vehicle-form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">

                <div class="vehicle-form-grid">
                    {{-- Left Column --}}
                    <div class="vehicle-form-col">
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Nama Kendaraan <span class="vehicle-required">*</span>
                            </label>
                            <input type="text" name="nama_kendaraan" id="f-nama_kendaraan" required placeholder="Masukan nama kendaraan" class="vehicle-input">
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Nomor Polisi <span class="vehicle-required">*</span>
                            </label>
                            <input type="text" name="plat_nomor" id="f-plat_nomor" required placeholder="Masukan plat nomor" class="vehicle-input" style="text-transform:uppercase;">
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Jenis Kendaraan <span class="vehicle-required">*</span>
                            </label>
                            <input type="text" name="jenis_kendaraan" id="f-jenis_kendaraan" required placeholder="Contoh: Motor, Mobil" class="vehicle-input">
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Merk / Tipe
                            </label>
                            <input type="text" name="merk_tipe" id="f-merk_tipe" placeholder="Contoh: Toyota Avanza" class="vehicle-input">
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Keterangan <span class="vehicle-required">*</span>
                            </label>
                            <textarea name="keperluan" id="f-keperluan" required placeholder="Masukan keterangan" rows="2" class="vehicle-input vehicle-textarea"></textarea>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="vehicle-form-col">
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Tahun Kendaraan <span class="vehicle-required">*</span>
                            </label>
                            <input type="number" name="tahun" id="f-tahun" required placeholder="Masukan tahun" class="vehicle-input" min="1900" max="{{ now()->year + 1 }}">
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Warna
                            </label>
                            <input type="text" name="warna" id="f-warna" placeholder="Masukan warna kendaraan" class="vehicle-input">
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Status Kepemilikan <span class="vehicle-required">*</span>
                            </label>
                            <select name="kepemilikan_status" id="f-kepemilikan_status" required class="vehicle-input">
                                <option value="">Pilih status</option>
                                <option value="Milik Perusahaan">Milik Perusahaan</option>
                                <option value="Sewa">Sewa</option>
                                <option value="Pribadi">Pribadi</option>
                            </select>
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Pajak Tahunan <span class="vehicle-required">*</span>
                            </label>
                            <input type="date" name="pajak_tahunan" id="f-pajak_tahunan" required class="vehicle-input">
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Pajak 5 Tahunan <span class="vehicle-required">*</span>
                            </label>
                            <input type="date" name="pajak_5_tahun" id="f-pajak_5_tahun" required class="vehicle-input">
                        </div>
                    </div>
                </div>

                {{-- Hidden fields --}}
                <input type="hidden" name="biaya_kendaraan" id="f-biaya_kendaraan" value="0">
                <input type="hidden" name="pic" id="f-pic" value="{{ auth()->user()->name }}">
                <input type="hidden" name="jabatan" id="f-jabatan" value="{{ auth()->user()->jabatan ?? auth()->user()->role }}">

                {{-- Footer --}}
                <div class="vehicle-modal-footer">
                    <button type="button" onclick="closeModal('vehicle-modal')" class="vehicle-btn vehicle-btn-batal">Batal</button>
                    <button type="submit" class="vehicle-btn vehicle-btn-simpan" id="form-submit-btn">Simpan</button>
                </div>
            </form>
        </div>

    </div>
</div>

@push('styles')
<style>
.vehicle-modal-card {
    width: 100%;
    max-width: 700px;
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.5);
    display: flex;
    flex-direction: column;
    max-height: 80vh;
    animation: vehicleFadeIn 0.3s ease;
}
@keyframes vehicleFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.vehicle-modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 24px 28px 20px;
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
}
.vehicle-modal-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}
.vehicle-modal-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin: 4px 0 0;
    font-weight: 400;
}
.vehicle-close-btn {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}
.vehicle-close-btn:hover { background: rgba(128,128,128,0.2); color: var(--text-primary); }
.vehicle-modal-body {
    padding: 20px 24px 16px;
    overflow-y: auto;
    flex: 1;
}
.vehicle-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px 24px;
}
@media (max-width: 768px) {
    .vehicle-form-grid { grid-template-columns: 1fr; }
    .vehicle-modal-card { max-width: 95vw; }
    .vehicle-modal-header { padding: 20px 20px 16px; }
    .vehicle-modal-body { padding: 20px; }
}
.vehicle-form-col {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.vehicle-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.vehicle-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 6px;
}
.vehicle-required { color: #f87171; }
.vehicle-input {
    width: 100%;
    height: 48px;
    padding: 0 16px;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    color: var(--text-primary);
    font-size: 14px;
    outline: none;
    transition: all 0.25s ease;
    box-sizing: border-box;
}
.vehicle-input:focus {
    border-color: #6c5cff;
    box-shadow: 0 0 0 3px rgba(108,92,255,0.15);
}
.vehicle-input::placeholder { color: var(--text-muted); }
.vehicle-input option { background: var(--bg-surface); color: var(--text-primary); }
.vehicle-textarea {
    height: auto;
    padding: 12px 16px;
    resize: vertical;
    min-height: 80px;
}
.vehicle-upload {
    width: 100%;
    height: 100px;
    background: var(--bg-surface-2);
    border: 1px dashed var(--border-color);
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.25s ease;
}
.vehicle-upload:hover {
    border-color: rgba(108,92,255,0.4);
    background: var(--bg-surface-2);
}
.vehicle-upload svg { color: var(--text-muted) !important; }
.vehicle-upload span { color: var(--text-muted) !important; }
.vehicle-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 20px;
    margin-top: 20px;
    border-top: 1px solid var(--border-color);
}
.vehicle-btn {
    padding: 10px 28px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    border: none;
}
.vehicle-btn-batal {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
}
.vehicle-btn-batal:hover {
    border-color: rgba(128,128,128,0.4);
    color: var(--text-primary);
}
.vehicle-btn-simpan {
    background: linear-gradient(135deg, #6c5cff, #8b7bff);
    color: #fff;
    box-shadow: 0 4px 15px rgba(108,92,255,0.3);
}
.vehicle-btn-simpan:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(108,92,255,0.4);
}
</style>
@endpush
@endsection

@push('scripts')
<script>
const vehiclesData = @json($vehiclesJson);
const csrfToken = '{{ csrf_token() }}';

const statusMap = {
    aktif:        { label: 'Pajak Aktif',      bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
    segera_habis: { label: 'Segera Habis',     bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
    mati:         { label: 'Pajak Mati',       bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
};

const alertData = @json($alertJson);

function showAlertPopup(type) {
    const overlay = document.getElementById('alert-overlay');
    const title = document.getElementById('alert-popup-title');
    const body = document.getElementById('alert-popup-body');
    const isDanger = type === 'danger';
    const color = isDanger ? '#ef4444' : '#f59e0b';
    const bgColor = isDanger ? 'rgba(239,68,68,0.08)' : 'rgba(245,158,11,0.08)';
    const borderColor = isDanger ? 'rgba(239,68,68,0.2)' : 'rgba(245,158,11,0.2)';

    const items = alertData.filter(function(v) {
        if (isDanger) return v.status_pajak === 'mati';
        return v.status_pajak === 'segera_habis';
    });

    title.textContent = isDanger ? 'Kendaraan dengan Pajak Mati' : 'Kendaraan dengan Pajak Segera Habis';

    if (items.length === 0) {
        body.innerHTML = '<p style="text-align:center;padding:20px;color:var(--text-muted);">Tidak ada kendaraan.</p>';
    } else {
        body.innerHTML = items.map(function(v) {
            var daysLabel = '';
            var dateStr = v.pajak_tahunan;
            if (dateStr) {
                var parts = dateStr.split('/');
                var d = new Date(parts[2], parts[1] - 1, parts[0]);
                var today = new Date(); today.setHours(0,0,0,0);
                var diff = Math.ceil((d - today) / (1000 * 60 * 60 * 24));
                if (isDanger) {
                    daysLabel = '<span style="color:#ef4444;font-weight:600;">Pajak sudah mati</span>';
                } else {
                    daysLabel = 'Berakhir <span style="color:#f59e0b;font-weight:600;">' + dateStr + '</span> (' + diff + ' hari lagi)';
                }
            }
            return '<div class="flex items-center gap-3 px-4 py-3.5 rounded-xl" style="border:1px solid var(--border-color);margin-bottom:8px;cursor:pointer;transition:all 0.15s;background:var(--bg-surface-2);" onclick="openEditModal(' + v.id + ')" onmouseover="this.style.borderColor=\'' + color + '\'" onmouseout="this.style.borderColor=\'var(--border-color)\'">' +
                '<div class="flex-1 min-w-0">' +
                    '<p style="font-weight:600;font-size:14px;color:var(--text-primary);margin:0;">' + v.nama_kendaraan + '</p>' +
                    '<p style="font-size:12px;color:var(--text-muted);margin:2px 0 0;">' + v.plat_nomor + ' — ' + v.jenis_kendaraan + '</p>' +
                    '<p style="font-size:11px;color:var(--text-secondary);margin:4px 0 0;">' + daysLabel + '</p>' +
                '</div>' +
                '<button onclick="event.stopPropagation(); bayarPajak(' + v.id + ')" style="flex-shrink:0;padding:8px 16px;border-radius:10px;font-size:12px;font-weight:700;border:none;cursor:pointer;transition:all 0.2s;background:' + color + ';color:#fff;box-shadow:0 4px 12px ' + (isDanger ? 'rgba(239,68,68,0.3)' : 'rgba(245,158,11,0.3)') + ';" onmouseover="this.style.opacity=\'0.85\'" onmouseout="this.style.opacity=\'1\'">Bayar</button>' +
            '</div>';
        }).join('');
    }

    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeAlertPopup() {
    document.getElementById('alert-overlay').style.display = 'none';
    document.body.style.overflow = '';
}

function bayarPajak(id) {
    closeAlertPopup();
    if (confirm('Bayar/mperbarui pajak kendaraan ini?')) {
        updatePajakStatus(id, 'aktif');
    }
}

function showDetail(id) {
    const v = vehiclesData.find(i => i.id === id);
    if (!v) return;
    document.getElementById('detail-title').textContent = v.nama_kendaraan;

    const st = statusMap[v.status_pajak] || statusMap.mati;
    const rp = v.biaya_kendaraan ? 'Rp ' + Number(v.biaya_kendaraan).toLocaleString('id-ID') : '-';

    const fotoHtml = v.foto ? `
        <div style="margin-bottom:20px;text-align:center;background:var(--bg-surface-2);border-radius:16px;padding:16px;">
            <img src="${v.foto}" alt="Foto Kendaraan" style="max-width:100%;max-height:180px;border-radius:12px;object-fit:cover;">
        </div>` : '';

    const renderField = (icon, label, value) => `
        <div style="display:flex;align-items:flex-start;gap:10px;padding:10px 0;border-bottom:1px solid var(--border-color);">
            <div style="width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:var(--bg-surface-2);">
                <svg class="w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icon}</svg>
            </div>
            <div style="flex:1;min-width:0;">
                <p style="font-size:11px;color:var(--text-muted);font-weight:500;text-transform:uppercase;letter-spacing:0.05em;margin:0;">${label}</p>
                <p style="font-size:14px;color:var(--text-primary);font-weight:600;margin:2px 0 0;word-break:break-word;">${value}</p>
            </div>
        </div>`;

    const icons = {
        plat: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
        jenis: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>',
        merk: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
        tahun: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        warna: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>',
        status: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        pic: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
        jabatan: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
        pajak: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
        biaya: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        keterangan: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
    };

    const leftContent = [
        renderField(icons.plat, 'Plat Nomor', `<span style="font-family:monospace;background:var(--bg-surface-2);padding:2px 8px;border-radius:6px;">${v.plat_nomor}</span>`),
        renderField(icons.jenis, 'Jenis', v.jenis_kendaraan),
        renderField(icons.merk, 'Merk / Tipe', v.merk_tipe || '-'),
        renderField(icons.tahun, 'Tahun', v.tahun),
        renderField(icons.warna, 'Warna', v.warna || '-'),
        renderField(icons.status, 'Kepemilikan', v.kepemilikan_status),
    ].join('');

    const rightContent = [
        renderField(icons.pic, 'PIC', v.pic),
        renderField(icons.jabatan, 'Jabatan', v.jabatan),
        renderField(icons.pajak, 'Pajak Tahunan', v.pajak_tahunan),
        renderField(icons.pajak, 'Pajak 5 Tahun', v.pajak_5_tahun),
        renderField(icons.biaya, 'Biaya', rp),
        renderField(icons.keterangan, 'Keterangan', v.keperluan || '-'),
    ].join('');

    const detailBody = document.getElementById('detail-body');
    detailBody.innerHTML = `
        ${fotoHtml}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 20px;">
            <div>${leftContent}</div>
            <div>${rightContent}</div>
        </div>
        <div style="margin-top:16px;padding:12px 16px;border-radius:12px;display:flex;align-items:center;justify-content:space-between;background:${st.bg};border:1px solid ${st.border};">
            <div style="display:flex;align-items:center;gap:8px;">
                <svg class="w-4 h-4" style="color:${st.text};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span style="font-size:13px;font-weight:600;color:${st.text};">${st.label}</span>
            </div>
            <span style="font-size:11px;color:${st.text};opacity:0.7;">Status saat ini</span>
        </div>
        <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border-color);">
            <p style="font-size:11px;font-weight:700;color:var(--text-muted);letter-spacing:0.05em;margin-bottom:10px;">UPDATE STATUS PAJAK</p>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;">
                <button onclick="updatePajakStatus(${v.id}, 'aktif')" style="padding:10px;border-radius:10px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all 0.2s;background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;" onmouseover="this.style.background='#d1fae5'" onmouseout="this.style.background='#ecfdf5'">
                    <div style="font-size:16px;">✓</div>
                    <div style="margin-top:2px;">Hidup</div>
                </button>
                <button onclick="updatePajakStatus(${v.id}, 'segera_habis')" style="padding:10px;border-radius:10px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all 0.2s;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;" onmouseover="this.style.background='#ffedd5'" onmouseout="this.style.background='#fff7ed'">
                    <div style="font-size:16px;">⚠</div>
                    <div style="margin-top:2px;">Mau Habis</div>
                </button>
                <button onclick="updatePajakStatus(${v.id}, 'mati')" style="padding:10px;border-radius:10px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all 0.2s;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'">
                    <div style="font-size:16px;">✕</div>
                    <div style="margin-top:2px;">Mati</div>
                </button>
            </div>
        </div>
    `;
    openModal('detail-modal');
}

function closeDetail() {
    closeModal('detail-modal');
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function updatePajakStatus(id, status) {
    fetch('/admin/vehicles/' + id + '/status', {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ status })
    }).then(r => r.json()).then(() => { location.reload(); }).catch(() => { location.reload(); });
}

function toggleDropdown(id) {
    const all = document.querySelectorAll('.dropdown-menu');
    all.forEach(el => { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    const menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.export-menu').forEach(el => el.style.display = 'none');
    }
});

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Aset Kendaraan';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('vehicle-form').action = '{{ route('admin.vehicles.store') }}';
    document.getElementById('form-submit-btn').textContent = 'Simpan';
    document.getElementById('vehicle-form').querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') el.value = '';
    });
    document.getElementById('f-kepemilikan_status').value = 'Milik Perusahaan';
    document.getElementById('f-pajak_tahunan').value = '';
    document.getElementById('f-pajak_5_tahun').value = '';
    document.getElementById('f-biaya_kendaraan').value = '0';
    showModal();
}

function openEditModal(id) {
    const v = vehiclesData.find(i => i.id === id);
    if (!v) return;
    closeDetail();
    document.getElementById('modal-title').textContent = 'Edit Aset Kendaraan';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = v.id;
    document.getElementById('vehicle-form').action = '{{ url('admin/vehicles') }}/' + v.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';
    document.getElementById('f-nama_kendaraan').value = v.nama_kendaraan;
    document.getElementById('f-jenis_kendaraan').value = v.jenis_kendaraan;
    document.getElementById('f-plat_nomor').value = v.plat_nomor;
    document.getElementById('f-tahun').value = v.tahun;
    document.getElementById('f-pajak_tahunan').value = v.pajak_tahunan ? v.pajak_tahunan.split('/').reverse().join('-') : '';
    document.getElementById('f-pajak_5_tahun').value = v.pajak_5_tahun ? v.pajak_5_tahun.split('/').reverse().join('-') : '';
    document.getElementById('f-kepemilikan_status').value = v.kepemilikan_status;
    document.getElementById('f-biaya_kendaraan').value = v.biaya_kendaraan;
    document.getElementById('f-pic').value = v.pic;
    document.getElementById('f-jabatan').value = v.jabatan;
    document.getElementById('f-keperluan').value = v.keperluan;
    document.getElementById('f-merk_tipe').value = v.merk_tipe || '';
    document.getElementById('f-warna').value = v.warna || '';
    showModal();
}

function showModal() { openModal('vehicle-modal'); }
document.getElementById('vehicle-modal')?.addEventListener('click', function(e) { if (e.target === this) closeModal('vehicle-modal'); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeDetail(); closeModal('vehicle-modal'); } });

let currentFilter = '{{ $statusFilter }}';

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
    filterVehicles();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterVehicles() {
    const search = (document.getElementById('search-vehicle')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#vehicles-tbody tr:not(#empty-row)');
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
    const filterValue = document.querySelector('#filter-menu button.active, .filter-btn [data-value].active')?.getAttribute('data-value') || document.querySelector('#filter-menu button[data-value="all"]')?.getAttribute('data-value') || 'all';
    const search = document.getElementById('search-vehicle')?.value || '';
    const params = new URLSearchParams({ type, filter: filterValue, search });
    window.location.href = '{{ route("admin.export") }}?' + params.toString();
}

const urlParams = new URLSearchParams(window.location.search);
const statusParam = urlParams.get('status');
if (statusParam) { currentFilter = statusParam; filterVehicles(); }

document.getElementById('f-foto')?.addEventListener('change', function() {
    var label = document.getElementById('foto-label');
    if (this.files && this.files[0]) {
        label.textContent = this.files[0].name;
    } else {
        label.textContent = 'Klik untuk upload gambar';
    }
});
</script>
@endpush
