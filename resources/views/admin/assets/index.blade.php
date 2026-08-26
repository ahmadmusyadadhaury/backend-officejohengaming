@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Kelola Aset Meeting')
@section('page-title', 'Overview > Kelola Aset Meeting')
@section('page-subtitle', 'Inventaris perlengkapan pendukung meeting.')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <form method="GET" action="{{ route('admin.assets.index') }}" id="filter-form">
        <input type="hidden" name="status" id="status-input" value="{{ request('status') }}">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Aset Meeting</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Inventaris perlengkapan pendukung meeting.</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset
            </button>
@endif
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..."
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">{{ request('status') === 'active' ? 'Aktif' : (request('status') === 'inactive' ? 'Nonaktif' : 'Semua Status') }}</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="" onclick="setFilter('')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="active" onclick="setFilter('active')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="inactive" onclick="setFilter('inactive')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Nonaktif</button>
                </div>
            </div>
        </div>
        </form>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[600px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th>Status</th>
<th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $assets->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $asset->name }}</td>
                        <td style="color:var(--text-muted);">{{ $asset->description ?? '—' }}</td>
                        <td>
                            <span class="badge badge-cyan">{{ $asset->quantity }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $asset->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $asset->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ json_encode(['id'=>$asset->id,'name'=>$asset->name,'description'=>$asset->description ?? '','quantity'=>$asset->quantity,'is_active'=>$asset->is_active]) }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $asset->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $asset->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ json_encode(['id'=>$asset->id,'name'=>$asset->name,'description'=>$asset->description ?? '','quantity'=>$asset->quantity,'is_active'=>$asset->is_active]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <button type="button" onclick="openEditModal({{ json_encode(['id'=>$asset->id,'name'=>$asset->name,'description'=>$asset->description ?? '','quantity'=>$asset->quantity,'is_active'=>$asset->is_active]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada aset ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $assets->links() }}</div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="modal-modern" onclick="if(event.target===this)closeEditModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Aset</h3>
            <button type="button" onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Aset <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Deskripsi</label>
                    <textarea name="description" id="edit-description" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Jumlah <span style="color:#f87171;">*</span></label>
                    <input type="number" name="quantity" id="edit-quantity" required min="1" class="gaming-input">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Aset Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Create Modal --}}
<div id="create-modal" class="modal-modern" onclick="if(event.target===this)closeCreateModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Aset</h3>
            <button type="button" onclick="closeCreateModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-form" method="POST" action="{{ route('admin.assets.store') }}">
            @csrf
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Aset <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Deskripsi</label>
                    <textarea name="description" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Jumlah <span style="color:#f87171;">*</span></label>
                    <input type="number" name="quantity" required min="1" class="gaming-input">
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Aset</button>
                <button type="button" onclick="closeCreateModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail Aset Meeting</h3>
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

<script>
function toggleFilterMenu(e) {
    e.stopPropagation();
    var menu = document.getElementById('filter-menu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function setFilter(value) {
    document.getElementById('status-input').value = value;
    document.getElementById('filter-menu').style.display = 'none';
    document.getElementById('filter-form').submit();
}
document.addEventListener('click', function(e) {
    var menu = document.getElementById('filter-menu');
    if (menu && !e.target.closest('.filter-dropdown-wrap')) {
        menu.style.display = 'none';
    }
});

function openEditModal(data) {
    document.getElementById('edit-form').action = '/admin/assets/' + data.id;
    document.getElementById('edit-name').value = data.name;
    document.getElementById('edit-description').value = data.description;
    document.getElementById('edit-quantity').value = data.quantity;
    document.getElementById('edit-is-active').checked = data.is_active == 1;
    openModal('edit-modal');
}
function closeEditModal() {
    closeModal('edit-modal');
}
document.getElementById('edit-modal').addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });

function openCreateModal() {
    document.getElementById('create-form').reset();
    openModal('create-modal');
}
function closeCreateModal() {
    closeModal('create-modal');
}
document.getElementById('create-modal').addEventListener('click', function(e) { if (e.target === this) closeCreateModal(); });

function toggleDropdown(btn, id) {
    document.querySelectorAll('.dropdown-menu').forEach(function(el) {
        if (el.id !== 'dropdown-' + id) el.style.display = 'none';
    });
    const menu = document.getElementById('dropdown-' + id);
    if (menu) menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(function(el) { el.style.display = 'none'; });
    }
});

function renderDetail(rows) {
    const html = rows.map(function(r, i) {
        const border = i < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : '';
        if (r.badge !== undefined) {
            const active = r.badge;
            return `<div class="flex items-center justify-between py-2.5" ${border}>
                <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${active ? '#ecfdf5' : '#fef2f2'};color:${active ? '#059669' : '#dc2626'};border:1px solid ${active ? '#a7f3d0' : '#fecaca'};">${active ? 'Aktif' : 'Nonaktif'}</span>
            </div>`;
        }
        return `<div class="flex items-center justify-between py-2.5" ${border}>
            <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
            <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
        </div>`;
    }).join('');
    document.getElementById('detail-body').innerHTML = '<div class="space-y-1">' + html + '</div>';
    openModal('detail-modal');
}

function showDetail(data) {
    document.getElementById('detail-title').textContent = 'Detail Aset Meeting';
    renderDetail([
        { label: 'Nama Aset', value: data.name },
        { label: 'Deskripsi', value: data.description || '—' },
        { label: 'Jumlah', value: data.quantity },
        { label: 'Status', value: data.is_active, badge: data.is_active == 1 },
    ]);
}

function closeDetail() { closeModal('detail-modal'); }
document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeEditModal(); closeCreateModal(); closeDetail(); } });
</script>
@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection