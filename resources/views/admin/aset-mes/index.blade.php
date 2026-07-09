@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Aset MES')
@section('page-title', 'Data Aset > Aset MES')
@section('page-subtitle', 'Daftar aset MES dan perlengkapan perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zM3 13h18v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Total Aset MES</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(16,185,129,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Aset Aktif</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(239,68,68,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;">{{ $stats['nonaktif'] }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Aset Tidak Aktif</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
    </div>

    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Data Aset MES</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Aset MES dan perlengkapan perusahaan.</div>
            </div>
            @if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset MES
            </button>
            @endif
        </div>
        <div class="px-6 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-aset" placeholder="Cari..." oninput="filterTable()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[700px]" id="aset-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Jumlah</th>
                        <th>Penanggung Jawab</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        @if(auth()->user()->role !== 'gm')<th>Aksi</th>@endif
                    </tr>
                </thead>
                <tbody id="aset-tbody">
                    @forelse($assets as $a)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $a->nama_aset }}</td>
                        <td style="color:var(--text-muted);">{{ $a->jumlah }}</td>
                        <td style="color:var(--text-muted);">{{ $a->penanggungJawab?->name ?? '-' }}</td>
                        <td><span class="badge {{ $a->is_active ? 'badge-green' : 'badge-red' }}">{{ $a->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                        <td style="max-width:150px;color:var(--text-muted);">{{ $a->keterangan ?? '-' }}</td>
                        @if(auth()->user()->role !== 'gm')<td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $a->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $a->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $a->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $a->id }})" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal({{ $a->id }})" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.aset-mes.destroy', $a) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset MES ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>@endif
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data aset MES.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail Aset MES</h3>
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

{{-- Modal Tambah / Edit --}}
<div id="aset-modal" class="modal-modern" onclick="if(event.target===this)closeModal('aset-modal')">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="modal-title">Tambah Aset MES</h3>
            <button type="button" onclick="closeModal('aset-modal')" class="modal-modern-close">&times;</button>
        </div>
        <form id="aset-form" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="id" id="form-id" value="">
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
                    <div class="field-group">
                        <label class="gaming-label">Penanggung Jawab</label>
                        <select name="penanggung_jawab" id="f-penanggung_jawab" class="gaming-input gaming-select">
                            <option value="">— Pilih Koordinator —</option>
                            @foreach(\App\Models\User::where('role', 'koordinator')->orWhere('role', 'admin_ga')->orderBy('name')->get() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->username }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC</label>
                        <input type="text" name="pic" id="f-pic" placeholder="Nama PIC" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jabatan</label>
                        <input type="text" name="jabatan" id="f-jabatan" placeholder="Jabatan PIC" class="gaming-input">
                    </div>
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="keterangan" id="f-keterangan" placeholder="Keterangan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="button" onclick="closeModal('aset-modal')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary" id="form-submit-btn">Tambah</button>
            </div>
        </form>
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
.form-footer { display: flex; justify-content: flex-end; gap: 10px; padding-top: 16px; margin-top: 8px; border-top: 1px solid var(--border-color); }
.btn-form { padding: 8px 22px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-form-batal { color: var(--text-primary); border: 1px solid var(--border-color); background: var(--bg-surface); }
.btn-form-simpan { background: linear-gradient(135deg,#6c5cff,#8b7bff); color: #fff; border: none; box-shadow: 0 4px 15px rgba(108,92,255,0.3); }
.btn-form-simpan:hover { transform: translateY(-1px); }

</style>
@endpush

@push('scripts')
<script>
const assets = @json($assetsJson);

function filterTable() {
    const q = (document.getElementById('search-aset')?.value || '').toLowerCase();
    document.querySelectorAll('#aset-tbody tr').forEach(row => {
        row.style.display = !q || row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

function toggleDropdown(btn, id) {
    const menu = document.getElementById('dropdown-' + id);
    document.querySelectorAll('.dropdown-menu').forEach(m => { if (m.id !== 'dropdown-' + id) m.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
    }
});

function closeModal(id) { document.getElementById(id).style.display = 'none'; document.body.style.overflow = ''; }
document.querySelectorAll('[id$="-modal"]').forEach(m => {
    m.addEventListener('click', function(e) { if (e.target === this) { this.style.display = 'none'; document.body.style.overflow = ''; } });
});

function showDetail(id) {
    const a = assets.find(x => x.id === id);
    if (!a) return;
    document.getElementById('detail-title').textContent = a.nama_aset;

    const rows = [
        { label: 'Nama Aset', value: a.nama_aset },
        { label: 'Jumlah', value: a.jumlah },
        { label: 'Penanggung Jawab', value: a.penanggung_jawab_nama },
        { label: 'PIC', value: a.pic || '-' },
        { label: 'Jabatan', value: a.jabatan || '-' },
    ];

    document.getElementById('detail-body').innerHTML = `
        <div class="space-y-1">
            ${rows.map((r, i) => `
                <div class="flex items-center justify-between py-2.5" ${i < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
                </div>
            `).join('')}
            <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--border-color);">
                <p class="text-sm" style="color:var(--text-muted);">Status</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${a.is_active ? '#ecfdf5' : '#fef2f2'};color:${a.is_active ? '#059669' : '#dc2626'};border:1px solid ${a.is_active ? '#a7f3d0' : '#fecaca'};">${a.is_active ? 'Aktif' : 'Tidak Aktif'}</span>
            </div>
            <div class="flex items-center justify-between py-2.5">
                <p class="text-sm" style="color:var(--text-muted);">Keterangan</p>
                <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${a.keterangan || '-'}</p>
            </div>
        </div>
    `;
    openModal('detail-modal');
}
function closeDetail() { closeModal('detail-modal'); }
document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Aset MES';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('aset-form').action = '{{ route("admin.aset-mes.index") }}';
    document.getElementById('f-nama_aset').value = '';
    document.getElementById('f-jumlah').value = '';
    document.getElementById('f-penanggung_jawab').value = '';
    document.getElementById('f-pic').value = '';
    document.getElementById('f-jabatan').value = '';
    document.getElementById('f-keterangan').value = '';
    document.getElementById('aset-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openEditModal(id) {
    const a = assets.find(x => x.id === id);
    if (!a) return;
    document.getElementById('modal-title').textContent = 'Edit Aset MES';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = a.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan';
    document.getElementById('aset-form').action = '{{ url("admin/aset-mes") }}/' + a.id;
    document.getElementById('f-nama_aset').value = a.nama_aset;
    document.getElementById('f-jumlah').value = a.jumlah || '';
    document.getElementById('f-penanggung_jawab').value = a.penanggung_jawab || '';
    document.getElementById('f-pic').value = a.pic || '';
    document.getElementById('f-jabatan').value = a.jabatan || '';
    document.getElementById('f-keterangan').value = a.keterangan || '';
    document.getElementById('aset-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
</script>
@endpush
