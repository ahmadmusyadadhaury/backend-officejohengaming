@extends('layouts.app')
@section('body-class', 'page-leader page-leader-aset-mes')
@section('title', 'Aset MES Saya')
@section('page-title', 'Operasional > Aset MES')
@section('page-subtitle', 'Daftar aset MES yang menjadi tanggung jawab saya')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Aset MES</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Daftar aset MES yang menjadi tanggung jawab anda.</div>
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset MES
            </button>
        </div>

        <div class="table-responsive">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $a)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $a->nama_aset }}</td>
                        <td style="color:var(--text-muted);">{{ $a->jumlah }}</td>
                        <td style="max-width:150px;color:var(--text-muted);">{{ $a->keterangan ?? '-' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="openDetailModal({{ $a->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $a->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $a->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="openDetailModal({{ $a->id }})" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lihat Detail</button>
                                        <button type="button" onclick="openEditModal({{ $a->id }})" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('koordinator.aset-mes.destroy', $a) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data aset MES.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah / Edit --}}
<div id="aset-modal" class="modal-modern" onclick="if(event.target===this)closeAsetModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="modal-title">Tambah Aset MES</h3>
            <button type="button" onclick="closeAsetModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="aset-form" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <div class="modal-modern-body">
                <div class="form-grid-2">
                    <div class="field-group">
                        <label class="gaming-label">Nama Aset <span class="field-req">*</span></label>
                        <input type="text" name="nama_aset" id="f-nama_aset" required placeholder="Masukan nama aset" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jumlah</label>
                        <input type="number" name="jumlah" id="f-jumlah" placeholder="Jumlah" min="1" class="gaming-input">
                    </div>
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="keterangan" id="f-keterangan" placeholder="Keterangan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="button" onclick="closeAsetModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary" id="form-submit-btn">Tambah</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail --}}
<div id="detailModal" class="modal-modern" onclick="if(event.target===this)closeDetailModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Detail Aset MES</h3>
            <button type="button" onclick="closeDetailModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body">
            <div class="space-y-3">
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Nama Aset</span>
                    <span class="text-xs font-medium" id="detail_nama_aset" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Jumlah</span>
                    <span class="text-xs font-medium" id="detail_jumlah" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Keterangan</span>
                    <span class="text-xs" id="detail_keterangan" style="color:var(--text-primary);text-align:right;max-width:60%;"></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-xs" style="color:var(--text-muted);">Status</span>
                    <span id="detail_status"></span>
                </div>
            </div>
        </div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetailModal()" class="btn btn-secondary btn-sm">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 24px; margin-bottom: 16px; }
@media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }
.field-group { display: flex; flex-direction: column; gap: 6px; }
.field-req { color: #f87171; }
.page-leader.page-leader-aset-mes .btn-primary {
    background: #6d5ef9;
    box-shadow: 0 2px 8px rgba(109,94,249,0.25);
}
.page-leader.page-leader-aset-mes .btn-primary:hover {
    background: #5a4be0;
    box-shadow: 0 4px 14px rgba(109,94,249,0.35);
}
</style>
@endpush

@push('scripts')
<script>
const assets = @json($assetsJson);

function closeAsetModal() { document.getElementById('aset-modal').style.display = 'none'; document.body.style.overflow = ''; }

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Aset MES';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('aset-form').action = '{{ route("koordinator.aset-mes.index") }}';
    document.getElementById('f-nama_aset').value = '';
    document.getElementById('f-jumlah').value = '';
    document.getElementById('f-keterangan').value = '';
    document.getElementById('aset-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openEditModal(id) {
    const a = assets.find(x => x.id === id);
    if (!a) return;
    document.getElementById('modal-title').textContent = 'Edit Aset MES';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-submit-btn').textContent = 'Simpan';
    document.getElementById('aset-form').action = '{{ route("koordinator.aset-mes.update", ["asetMes" => "___ID___"]) }}'.replace('___ID___', id);
    document.getElementById('f-nama_aset').value = a.nama_aset;
    document.getElementById('f-jumlah').value = a.jumlah || '';
    document.getElementById('f-keterangan').value = a.keterangan || '';
    document.getElementById('aset-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openDetailModal(id) {
    const a = assets.find(x => x.id === id);
    if (!a) return;
    document.getElementById('detail_nama_aset').textContent = a.nama_aset;
    document.getElementById('detail_jumlah').textContent = a.jumlah || '-';
    document.getElementById('detail_keterangan').textContent = a.keterangan || '-';
    var statusEl = document.getElementById('detail_status');
    if (a.is_active) {
        statusEl.innerHTML = '<span class="badge badge-green" style="font-size:0.65rem;">Aktif</span>';
    } else {
        statusEl.innerHTML = '<span class="badge badge-red" style="font-size:0.65rem;">Tidak Aktif</span>';
    }
    document.getElementById('detailModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
    document.body.style.overflow = '';
}

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
</script>
@endpush
