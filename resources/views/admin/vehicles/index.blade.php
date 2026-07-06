@extends('layouts.app')
@section('title', 'Data Kendaraan')
@section('page-title', 'Data Aset > Kendaraan')
@section('page-subtitle', 'Seluruh aset kendaraan milik perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Total Kendaraan</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh aset kendaraan</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:#34d399;">{{ $stats['pajak_aktif'] }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Pajak Aktif</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);">Pajak masih berlaku</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:#fbbf24;">{{ $stats['segera_habis'] }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Pajak Segera Habis</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);">Pajak akan habis dalam 30 hari</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;">{{ $stats['pajak_mati'] }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Pajak Mati</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);">Pajak sudah expired</div>
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
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Data Kendaraan</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Seluruh aset kendaraan milik perusahaan.</div>
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kendaraan
            </button>
        </div>
        <div class="px-6 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-vehicle" placeholder="Cari plat nomor atau nama kendaraan" oninput="filterVehicles()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="{{ route('admin.export', ['type' => 'vehicles', 'filter' => 'all']) }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">Download Excel</a>
                <div class="filter-dropdown-wrap" style="position:relative;">
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
        </div>
        <div class="table-responsive">
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
                        <th class="hidden lg:table-cell">Nomor Rangka</th>
                        <th class="hidden lg:table-cell">Nomor Mesin</th>
                        <th class="hidden lg:table-cell">Foto</th>
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
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);font-family:monospace;font-size:12px;">
                            @if($v->nomor_rangka){{ $v->nomor_rangka }}@else<svg class="w-4 h-4 inline-block align-middle" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg><span class="inline-block align-middle text-xs" style="color:#f59e0b;margin-left:4px;font-weight:500;">Data Belum Dilengkapi</span>@endif
                        </td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);font-family:monospace;font-size:12px;">
                            @if($v->nomor_mesin){{ $v->nomor_mesin }}@else<svg class="w-4 h-4 inline-block align-middle" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg><span class="inline-block align-middle text-xs" style="color:#f59e0b;margin-left:4px;font-weight:500;">Data Belum Dilengkapi</span>@endif
                        </td>
                        <td class="hidden lg:table-cell" style="vertical-align:middle;font-size:12px;">
                            @if($v->foto)
                            <a href="{{ url('storage/'.$v->foto) }}" target="_blank" rel="noopener">
                                <img src="{{ url('storage/'.$v->foto) }}" alt="Foto" style="width:60px;height:40px;border-radius:6px;object-fit:cover;border:1px solid var(--border-color);display:block;">
                            </a>
                            @else
                            <svg class="w-4 h-4 inline-block align-middle" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg><span class="inline-block align-middle" style="color:#f59e0b;margin-left:4px;font-weight:500;font-size:12px;font-family:monospace;">Data Belum Dilengkapi</span>
                            @endif
                        </td>
                        <td><span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $v->keperluan }}">{{ $v->keperluan ?? '-' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showPajakRequestModal({{ $v->id }})" class="btn btn-primary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Bayar
                                </button>
                                <button type="button" onclick="showDetail({{ $v->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $v->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $v->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $v->id }})" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal({{ $v->id }})" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.vehicles.destroy', $v) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus kendaraan ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="13" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data kendaraan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Popup Alert Pajak --}}
<div id="alert-overlay" style="display:none;position:fixed;inset:0;z-index:9999;background:var(--bg-overlay);align-items:center;justify-content:center;padding:16px;" onclick="if(event.target===this)closeAlertPopup()">
    <div style="background:var(--bg-surface);border-radius:16px;padding:24px;width:90%;max-width:460px;max-height:65vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <div id="alert-popup-title" style="font-weight:700;font-size:16px;color:var(--text-primary);">Detail Pajak Kendaraan</div>
            <button type="button" onclick="closeAlertPopup()" style="background:none;border:none;color:var(--text-secondary);cursor:pointer;font-size:20px;line-height:1;">&times;</button>
        </div>
        <div id="alert-popup-body"></div>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[520px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail Kendaraan</h3>
            <button type="button" onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>

        {{-- Footer --}}
        <div class="px-6 py-4 flex-shrink-0 flex justify-between items-center" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>

{{-- Status Pengajuan Saya --}}
@if($myPajakRequests->isNotEmpty())
<div class="gaming-card overflow-hidden">
    <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
        <div style="display:flex;align-items:center;gap:8px;">
            <svg class="w-5 h-5" style="color:var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Status Pengajuan Pajak Saya</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;">{{ $myPajakRequests->count() }} pengajuan</div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="gaming-table min-w-[650px]">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Pajak</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($myPajakRequests as $pr)
                <tr>
                    <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                    <td style="color:var(--text-primary);font-weight:500;">{{ $pr->vehicle->nama_kendaraan }}</td>
                    <td style="font-family:monospace;font-weight:600;color:var(--text-muted);">{{ $pr->vehicle->plat_nomor }}</td>
                    <td style="color:var(--text-primary);">{{ $pr->jenis === 'tahunan' ? 'Pajak Tahunan' : 'Pajak 5 Tahunan' }}</td>
                    <td style="color:var(--text-primary);">Rp {{ number_format($pr->nominal, 0, ',', '.') }}</td>
                    <td style="color:var(--text-muted);">{{ $pr->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @php
                            $statusLabel = match($pr->status) {
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                default => $pr->status,
                            };
                            $statusColor = match($pr->status) {
                                'pending' => '#f59e0b',
                                'approved' => '#10b981',
                                'rejected' => '#ef4444',
                                default => '#6b7280',
                            };
                            $statusBg = match($pr->status) {
                                'pending' => 'rgba(245,158,11,0.12)',
                                'approved' => 'rgba(16,185,129,0.12)',
                                'rejected' => 'rgba(239,68,68,0.12)',
                                default => 'rgba(107,114,128,0.12)',
                            };
                        @endphp
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;background:{{ $statusBg }};color:{{ $statusColor }};">{{ $statusLabel }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@push('modals')
{{-- Modal Tambah / Edit Kendaraan --}}
<style>
#vehicle-modal { background: rgba(13,15,26,1); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); }
body.light #vehicle-modal { background: rgba(255,255,255,1); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); }
</style>
<div id="vehicle-modal" style="display:none;position:fixed;top:0;right:0;bottom:0;left:0;z-index:99999;align-items:center;justify-content:center;padding:16px;background:rgba(13,15,26,1);">
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
                                Nomor Rangka
                            </label>
                            <input type="text" name="nomor_rangka" id="f-nomor_rangka" placeholder="Masukan nomor rangka" class="vehicle-input">
                        </div>
                        <div class="vehicle-field">
                            <label class="vehicle-label">
                                Nomor Mesin
                            </label>
                            <input type="text" name="nomor_mesin" id="f-nomor_mesin" placeholder="Masukan nomor mesin" class="vehicle-input">
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
                        <div class="vehicle-field">
                            <label class="vehicle-label">Foto Kendaraan</label>
                            <div style="display:flex;flex-direction:column;gap:8px;">
                                <label for="f-foto" class="vehicle-upload" id="foto-upload-area" style="height:80px;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span id="foto-label" style="font-size:12px;">Klik untuk upload gambar</span>
                                </label>
                                <input type="file" name="foto" id="f-foto" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" style="display:none;">
                                <div id="foto-preview" style="display:none;text-align:center;">
                                    <img id="foto-preview-img" src="" alt="Preview" style="max-width:100%;max-height:100px;border-radius:8px;object-fit:cover;">
                                </div>
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
@endpush

{{-- Pending Approvals Section --}}
@if($isApprover && $pendingPajakRequests->isNotEmpty())
<div class="gaming-card overflow-hidden" id="pending-approvals">
    <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
        <div style="display:flex;align-items:center;gap:8px;">
            <svg class="w-5 h-5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Pengajuan Pembayaran Pajak</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;">{{ $pendingPajakRequests->count() }} pengajuan menunggu persetujuan</div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="gaming-table min-w-[700px]">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>Plat Nomor</th>
                    <th>Jenis Pajak</th>
                    <th>Nominal</th>
                    <th>Pemohon</th>
                    <th>Tanggal</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingPajakRequests as $pr)
                <tr>
                    <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                    <td style="color:var(--text-primary);font-weight:500;">{{ $pr->vehicle->nama_kendaraan }}</td>
                    <td style="font-family:monospace;font-weight:600;color:var(--text-muted);">{{ $pr->vehicle->plat_nomor }}</td>
                    <td style="color:var(--text-primary);">{{ $pr->jenis === 'tahunan' ? 'Pajak Tahunan' : 'Pajak 5 Tahunan' }}</td>
                    <td style="color:var(--text-primary);">Rp {{ number_format($pr->nominal, 0, ',', '.') }}</td>
                    <td style="color:var(--text-muted);">{{ $pr->requester->name }}</td>
                    <td style="color:var(--text-muted);">{{ $pr->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($pr->bukti_bayar)
                        <a href="{{ url('storage/'.$pr->bukti_bayar) }}" target="_blank" rel="noopener" style="color:var(--color-accent);font-size:13px;text-decoration:none;font-weight:500;">Lihat</a>
                        @else
                        <span style="color:var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex gap-1">
                            <button type="button" onclick="approveRequest({{ $pr->id }})" class="btn btn-success btn-sm" style="padding:3px 10px;font-size:11px;">Setuju</button>
                            <button type="button" onclick="showRejectModal({{ $pr->id }})" class="btn btn-danger btn-sm" style="padding:3px 10px;font-size:11px;">Tolak</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Modal Alasan Tolak --}}
<div id="reject-modal" style="display:none;position:fixed;inset:0;z-index:100001;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div style="width:100%;max-width:420px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,0.5);padding:24px;" onclick="event.stopPropagation()">
        <h3 style="font-size:16px;font-weight:700;color:var(--text-primary);margin:0 0 4px;">Tolak Pengajuan</h3>
        <p style="font-size:13px;color:var(--text-muted);margin:0 0 16px;">Masukan alasan penolakan</p>
        <input type="hidden" id="reject-id" value="">
        <textarea id="reject-notes" rows="3" placeholder="Alasan penolakan..." style="width:100%;padding:12px 16px;background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:12px;color:var(--text-primary);font-size:14px;outline:none;resize:vertical;box-sizing:border-box;min-height:80px;"></textarea>
        <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:16px;">
            <button type="button" onclick="closeModal('reject-modal')" style="padding:8px 20px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;background:transparent;border:1px solid var(--border-color);color:var(--text-secondary);" onmouseover="this.style.borderColor='rgba(128,128,128,0.4)';this.style.color='var(--text-primary)'" onmouseout="this.style.borderColor='var(--border-color)';this.style.color='var(--text-secondary)'">Batal</button>
            <button type="button" onclick="rejectRequest()" style="padding:8px 20px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;background:#ef4444;color:#fff;border:none;">Tolak</button>
        </div>
    </div>
</div>

@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
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

@push('scripts')
<script>
console.log('[Vehicles] Script loaded');
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
                '<span onclick="event.stopPropagation()"><button onclick="showPajakRequestModal(' + v.id + ')" style="flex-shrink:0;padding:8px 16px;border-radius:10px;font-size:12px;font-weight:700;border:none;cursor:pointer;transition:all 0.2s;background:' + color + ';color:#fff;box-shadow:0 4px 12px ' + (isDanger ? 'rgba(239,68,68,0.3)' : 'rgba(245,158,11,0.3)') + ';" onmouseover="this.style.opacity=\'0.85\'" onmouseout="this.style.opacity=\'1\'">Ajukan Pembayaran</button></span>' +
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

function showDetail(id) {
    document.querySelectorAll('.dropdown-menu').forEach(function(el) { el.style.display = 'none'; });
    const v = vehiclesData.find(i => i.id === id);
    if (!v) return;
    document.getElementById('detail-title').textContent = v.nama_kendaraan;

    const st = statusMap[v.status_pajak] || statusMap.mati;
    const rp = v.biaya_kendaraan ? 'Rp ' + Number(v.biaya_kendaraan).toLocaleString('id-ID') : '-';

    const fotoHtml = v.foto ? `
        <div style="margin-bottom:20px;text-align:center;background:var(--bg-surface-2);border-radius:16px;padding:16px;">
            <img src="${v.foto}" alt="Foto Kendaraan" style="max-width:100%;max-height:180px;border-radius:12px;object-fit:cover;">
        </div>` : '';

    const rows = [
        { label: 'Plat Nomor', value: `<span style="font-family:monospace;background:var(--bg-surface-2);padding:2px 8px;border-radius:6px;">${v.plat_nomor}</span>` },
        { label: 'Jenis', value: v.jenis_kendaraan },
        { label: 'Merk / Tipe', value: v.merk_tipe || '-' },
        { label: 'Tahun', value: v.tahun },
        { label: 'Warna', value: v.warna || '-' },
        { label: 'Nomor Rangka', value: v.nomor_rangka || '-' },
        { label: 'Nomor Mesin', value: v.nomor_mesin || '-' },
        { label: 'Kepemilikan', value: v.kepemilikan_status },
        { label: 'PIC', value: v.pic },
        { label: 'Jabatan', value: v.jabatan },
        { label: 'Pajak Tahunan', value: v.pajak_tahunan },
        { label: 'Pajak 5 Tahun', value: v.pajak_5_tahunan },
        { label: 'Biaya', value: rp },
        { label: 'Keterangan', value: v.keperluan || '-' },
    ];

    const mid = Math.ceil(rows.length / 2);
    const leftItems = rows.slice(0, mid);
    const rightItems = rows.slice(mid);

    const renderCol = (items) => items.map(r => `
        <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border-color);">
            <span style="font-size:12px;color:var(--text-muted);">${r.label}</span>
            <span style="font-size:13px;font-weight:600;color:var(--text-primary);text-align:right;margin-left:12px;">${r.value}</span>
        </div>
    `).join('');

    const detailBody = document.getElementById('detail-body');
    detailBody.innerHTML = `
        ${fotoHtml}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 24px;">
            <div>${renderCol(leftItems)}</div>
            <div>${renderCol(rightItems)}</div>
        </div>
        <div style="margin-top:16px;padding:12px 16px;border-radius:12px;display:flex;align-items:center;justify-content:space-between;background:${st.bg};border:1px solid ${st.border};">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:13px;font-weight:600;color:${st.text};">${st.label}</span>
            </div>
        </div>
        <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border-color);text-align:center;">
            <span onclick="event.stopPropagation()"><button onclick="showPajakRequestModal(${v.id})" style="padding:10px 20px;border-radius:10px;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:all 0.2s;background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;box-shadow:0 4px 15px rgba(108,92,255,0.3);" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">Ajukan Pembayaran Pajak</button></span>
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

function toggleDropdown(btn, id) {
    const all = document.querySelectorAll('.dropdown-menu');
    all.forEach(el => { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    const menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
    }
});

function openCreateModal() {
    closeDetail();
    closeModal('pajak-request-modal');
    closeModal('reject-modal');
    closeAlertPopup();
    document.querySelectorAll('.dropdown-menu').forEach(function(el) { el.style.display = 'none'; });
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
    document.getElementById('foto-preview').style.display = 'none';
    document.getElementById('foto-preview-img').src = '';
    document.getElementById('foto-label').textContent = 'Klik untuk upload gambar';
    document.getElementById('f-foto').value = '';
    showModal();
}

function openEditModal(id) {
    document.querySelectorAll('.dropdown-menu').forEach(function(el) { el.style.display = 'none'; });
    closeModal('pajak-request-modal');
    closeModal('reject-modal');
    closeAlertPopup();
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
    document.getElementById('f-nomor_rangka').value = v.nomor_rangka || '';
    document.getElementById('f-nomor_mesin').value = v.nomor_mesin || '';
    var fotoPreview = document.getElementById('foto-preview');
    var fotoLabel = document.getElementById('foto-label');
    if (v.foto) {
        fotoPreview.style.display = 'block';
        document.getElementById('foto-preview-img').src = v.foto;
        fotoLabel.textContent = 'Klik untuk ganti gambar';
    } else {
        fotoPreview.style.display = 'none';
        document.getElementById('foto-preview-img').src = '';
        fotoLabel.textContent = 'Klik untuk upload gambar';
    }
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

const urlParams = new URLSearchParams(window.location.search);
const statusParam = urlParams.get('status');
if (statusParam) { currentFilter = statusParam; filterVehicles(); }

document.getElementById('f-foto')?.addEventListener('change', function() {
    var label = document.getElementById('foto-label');
    var preview = document.getElementById('foto-preview');
    var previewImg = document.getElementById('foto-preview-img');
    if (this.files && this.files[0]) {
        label.textContent = this.files[0].name;
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.style.display = 'block';
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    } else {
        label.textContent = 'Klik untuk upload gambar';
        preview.style.display = 'none';
        previewImg.src = '';
    }
});

document.getElementById('reject-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('reject-modal');
});

function approveRequest(id) {
    showConfirmModal('Setujui pengajuan pembayaran pajak ini?', function() {
        fetch('/admin/vehicles/pajak-requests/' + id + '/approve', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
        }).then(function(r) {
            if (!r.ok) return r.json().then(function(e) { throw new Error(e.error); });
            return r.json();
        }).then(function() {
            showSuccessModal('Pengajuan berhasil disetujui. Pajak kendaraan diperpanjang.');
            setTimeout(function() { location.reload(); }, 1500);
        }).catch(function(e) {
            showAlertModal(e.message || 'Gagal menyetujui pengajuan.');
        });
    }, { icon: 'success', buttonText: 'Ya, Setujui', buttonColor: '#10b981', buttonHoverColor: '#059669' });
}

function showRejectModal(id) {
    document.getElementById('reject-id').value = id;
    document.getElementById('reject-notes').value = '';
    openModal('reject-modal');
}

function rejectRequest() {
    var id = document.getElementById('reject-id').value;
    var notes = document.getElementById('reject-notes').value.trim();
    if (!notes) { showAlertModal('Harap masukan alasan penolakan.'); return; }
    fetch('/admin/vehicles/pajak-requests/' + id + '/reject', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ notes: notes }),
    }).then(function(r) {
        if (!r.ok) return r.json().then(function(e) { throw new Error(e.error); });
        return r.json();
    }).then(function() {
        closeModal('reject-modal');
        showSuccessModal('Pengajuan berhasil ditolak.');
        setTimeout(function() { location.reload(); }, 1500);
    }).catch(function(e) {
        showAlertModal(e.message || 'Gagal menolak pengajuan.');
    });
}
</script>
@endpush
@endsection
