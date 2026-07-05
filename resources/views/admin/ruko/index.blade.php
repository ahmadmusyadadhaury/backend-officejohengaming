@extends('layouts.app')
@section('title', 'Aset Ruko')
@section('page-title', 'Data Aset > Milik Ruko')
@section('page-subtitle', 'Seluruh aset ruko milik perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 3 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div id="stat-total" class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total Aset Ruko</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh aset ruko perusahaan</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:none rgba(16,185,129,0.2);">
                <svg class="w-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div id="stat-baik" class="text-xl font-gaming font-bold" style="color:#34d399;">{{ $stats['kondisi_baik'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Kondisi Baik</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Aset ruko dalam kondisi baik</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div id="stat-perlu" class="text-xl font-gaming font-bold" style="color:#fbbf24;">{{ $stats['perlu_servis'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Perlu Servis</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Aset ruko perlu perbaikan</div>
            </div>
        </div>
    </div>

    {{-- Alert Maintenance --}}
    @php $perluCount = $alertJson->count(); @endphp
    @if($perluCount > 0)
    <div>
        <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-bold" style="color:#f59e0b;">{{ $perluCount }} Aset Ruko Perlu Servis</div>
                <div class="text-xs mt-1" style="color:var(--text-secondary);">{{ $perluCount }} aset ruko perlu perbaikan atau servis.</div>
            </div>
            <button type="button" onclick="showAlertPopup()" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(245,158,11,0.12);color:#f59e0b;border:1px solid rgba(245,158,11,0.2);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
        </div>
    </div>
    @endif

    {{-- Tabel --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Data Aset Ruko</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Seluruh aset ruko milik perusahaan.</div>
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset Ruko
            </button>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-ruko" placeholder="Cari nama aset atau lokasi" oninput="filterRuko()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="{{ route('admin.export', ['type' => 'ruko', 'filter' => 'all']) }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">Download Excel</a>
                <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Kondisi</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Kondisi</button>
                    <button type="button" data-value="baik" onclick="setFilter('baik')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Kondisi Baik</button>
                    <button type="button" data-value="perlu_servis" onclick="setFilter('perlu_servis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Perlu Servis</button>
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[600px]" id="ruko-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th class="hidden md:table-cell">Lokasi</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="ruko-tbody">
                    @forelse($items as $i)
                    @php
                        $kondisiBadge = $i->kondisi === 'baik' ? 'badge-green' : 'badge-yellow';
                        $kondisiLabel = $i->kondisi === 'baik' ? 'Baik' : 'Perlu Servis';
                    @endphp
                    <tr data-id="{{ $i->id }}" data-kondisi="{{ $i->kondisi }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $i->nama_aset }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $i->lokasi }}</td>
                        <td><span class="badge badge-cyan">{{ $i->jumlah }}</span></td>
                        <td><span class="badge {{ $kondisiBadge }}">{{ $kondisiLabel }}</span></td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $i->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $i->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $i->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.ruko.destroy', $i) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset ruko ini?" style="margin:0;">
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
                        <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data aset ruko.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Popup Alert Maintenance --}}
<div id="alert-overlay" style="display:none;position:fixed;inset:0;z-index:9999;background:var(--bg-overlay);align-items:center;justify-content:center;padding:16px;" onclick="if(event.target===this)closeAlertPopup()">
    <div style="background:var(--bg-surface);border-radius:16px;padding:24px;width:90%;max-width:520px;max-height:65vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <div id="alert-popup-title" style="font-weight:700;font-size:16px;color:var(--text-primary);">Aset Ruko Perlu Servis</div>
            <button type="button" onclick="closeAlertPopup()" style="background:none;border:none;color:var(--text-secondary);cursor:pointer;font-size:20px;line-height:1;">&times;</button>
        </div>
        <div id="alert-popup-body"></div>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail Aset Ruko</h3>
            <button type="button" onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex justify-between items-center" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal Tambah / Edit Aset Ruko --}}
<div id="ruko-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[440px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="modal-title">Tambah Aset Ruko</h3>
            <button type="button" onclick="closeModal('ruko-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form id="ruko-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">

                <div class="form-grid-2">
                    <div class="field-group">
                        <label class="gaming-label">Nama Aset <span class="field-req">*</span></label>
                        <input type="text" name="nama_aset" id="f-nama_aset" required placeholder="Masukan nama aset" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Lokasi <span class="field-req">*</span></label>
                        <input type="text" name="lokasi" id="f-lokasi" required placeholder="Masukan lokasi" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jumlah <span class="field-req">*</span></label>
                        <input type="number" name="jumlah" id="f-jumlah" required placeholder="Masukan jumlah unit" class="gaming-input" min="1">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Kondisi <span class="field-req">*</span></label>
                        <select name="kondisi" id="f-kondisi" required class="gaming-input">
                            <option value="baik">Baik</option>
                            <option value="perlu_servis">Perlu Servis</option>
                        </select>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="button" onclick="closeModal('ruko-modal')" class="btn-form btn-form-batal">Batal</button>
                    <button type="submit" class="btn-form btn-form-simpan" id="form-submit-btn">Tambah</button>
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
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush

@push('scripts')
<script>
const rukoData = @json($itemsJson);
const alertData = @json($alertJson);

function showAlertPopup() {
    const overlay = document.getElementById('alert-overlay');
    const body = document.getElementById('alert-popup-body');
    const color = '#f59e0b';

    if (alertData.length === 0) {
        body.innerHTML = '<p style="text-align:center;padding:20px;color:var(--text-muted);">Tidak ada aset ruko perlu servis.</p>';
    } else {
        body.innerHTML = alertData.map(function(i) {
            return '<div class="flex items-center gap-3 px-4 py-3.5 rounded-xl" style="border:1px solid var(--border-color);margin-bottom:8px;cursor:pointer;transition:all 0.15s;background:var(--bg-surface-2);" onclick="openEditModal(' + i.id + ')" onmouseover="this.style.borderColor=\'' + color + '\'" onmouseout="this.style.borderColor=\'var(--border-color)\'">' +
                '<div class="flex-1 min-w-0">' +
                    '<p style="font-weight:600;font-size:14px;color:var(--text-primary);margin:0;">' + i.nama_aset + '</p>' +
                    '<p style="font-size:12px;color:var(--text-muted);margin:2px 0 0;">' + i.lokasi + ' — ' + i.jumlah + ' unit</p>' +
                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold" style="margin-top:4px;background:rgba(245,158,11,0.12);color:#c2410c;border:1px solid rgba(245,158,11,0.25);">Perlu Servis</span>' +
                '</div>' +
                '<button onclick="event.stopPropagation(); openEditModal(' + i.id + ')" style="flex-shrink:0;padding:8px 16px;border-radius:10px;font-size:12px;font-weight:700;border:none;cursor:pointer;transition:all 0.2s;background:' + color + ';color:#fff;box-shadow:0 4px 12px rgba(245,158,11,0.3);" onmouseover="this.style.opacity=\'0.85\'" onmouseout="this.style.opacity=\'1\'">Perbaiki</button>' +
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

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Aset Ruko';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('ruko-form').action = '{{ route('admin.ruko.store') }}';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('ruko-form').querySelectorAll('input, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') el.value = '';
    });
    document.getElementById('f-kondisi').value = 'baik';
    showModal();
}

function showDetail(id) {
    const i = rukoData.find(x => x.id === id);
    if (!i) return;
    document.getElementById('detail-title').textContent = i.nama_aset;

    const kondisiMap = {
        baik: { label: 'Baik', bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
        perlu_servis: { label: 'Perlu Servis', bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
    };
    const k = kondisiMap[i.kondisi] || kondisiMap.baik;

    const rows = [
        { label: 'Nama Aset', value: i.nama_aset },
        { label: 'Lokasi', value: i.lokasi },
        { label: 'Jumlah', value: i.jumlah },
    ];

    const detailBody = document.getElementById('detail-body');
    detailBody.innerHTML = `
        <div class="space-y-1">
            ${rows.map((r, i) => `
                <div class="flex items-center justify-between py-2.5" ${i < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
                </div>
            `).join('')}
            <div class="flex items-center justify-between py-2.5">
                <p class="text-sm" style="color:var(--text-muted);">Kondisi</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${k.bg};color:${k.text};border:1px solid ${k.border};">${k.label}</span>
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

function openEditModal(id) {
    closeDetail();
    const i = rukoData.find(x => x.id === id);
    if (!i) return;

    document.getElementById('modal-title').textContent = 'Edit Aset Ruko';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = i.id;
    document.getElementById('ruko-form').action = '{{ url('admin/ruko') }}/' + i.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    document.getElementById('f-nama_aset').value = i.nama_aset;
    document.getElementById('f-lokasi').value = i.lokasi;
    document.getElementById('f-jumlah').value = i.jumlah;
    document.getElementById('f-kondisi').value = i.kondisi;

    showModal();
}

function showModal() { openModal('ruko-modal'); }

document.getElementById('ruko-modal')?.addEventListener('click', function(e) { if (e.target === this) closeModal('ruko-modal'); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeDetail(); closeModal('ruko-modal'); } });

function updateRukoStats() {
    const total = rukoData.length;
    const baik = rukoData.filter(x => x.kondisi === 'baik').length;
    const perlu = total - baik;
    const statTotal = document.getElementById('stat-total');
    const statBaik = document.getElementById('stat-baik');
    const statPerlu = document.getElementById('stat-perlu');
    if (statTotal) statTotal.textContent = total;
    if (statBaik) statBaik.textContent = baik;
    if (statPerlu) statPerlu.textContent = perlu;
}

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
    filterRuko();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterRuko() {
    const search = (document.getElementById('search-ruko')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#ruko-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowKondisi = row.dataset.kondisi;
        const text = row.textContent.toLowerCase();
        const matchKondisi = currentFilter === 'all' || rowKondisi === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchKondisi && matchSearch ? '' : 'none';
    });
}
</script>
@endpush
