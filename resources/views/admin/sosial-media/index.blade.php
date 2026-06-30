@extends('layouts.app')
@section('title', 'Sosial Media')
@section('page-title', 'Data Aset > Sosial Media')
@section('page-subtitle', 'Seluruh akun sosial media operasional perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Akun</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh akun sosial media</div>
            </div>
        </div>
        @foreach($stats['platforms'] as $platform => $count)
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $count }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">{{ $platform }}</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Jumlah akun</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Data Sosial Media</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Seluruh akun sosial media operasional perusahaan.</div>
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Sosial Media
            </button>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-sosmed" placeholder="Cari username, nama, atau platform" oninput="filterSosmed()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Platform</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Platform</button>
                    @php
                        $uniquePlatforms = $items->pluck('platform')->unique()->sort();
                    @endphp
                    @foreach($uniquePlatforms as $platform)
                    <button type="button" data-value="{{ $platform }}" onclick="setFilter('{{ $platform }}')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">{{ $platform }}</button>
                    @endforeach
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[900px]" id="sosmed-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Followers</th>
                        <th>Platform</th>
                        <th class="hidden md:table-cell">Divisi</th>
                        <th class="hidden lg:table-cell">PIC</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="sosmed-tbody">
                    @forelse($items as $i)
                    <tr data-platform="{{ $i->platform }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:600;">{{ $i->username }}</td>
                        <td style="color:var(--text-muted);">{{ $i->nama }}</td>
                        <td style="color:var(--text-muted);">{{ $i->followers ?? '—' }}</td>
                        <td><span class="badge badge-primary">{{ $i->platform }}</span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $i->divisi }}</td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);">{{ $i->pic }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $i->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $i->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $i->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.sosial-media.destroy', $i) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus Sosial Media ini?" style="margin:0;">
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
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data Sosial Media.</td>
                    </tr>
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
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail Sosial Media</h3>
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

{{-- Modal Tambah / Edit Sosial Media --}}
<div id="sosmed-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="modal-title">Tambah Sosial Media</h3>
            <button type="button" onclick="closeModal('sosmed-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form id="sosmed-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">

                <div class="form-grid-2">
                    <div class="field-group">
                        <label class="gaming-label">Username <span class="field-req">*</span></label>
                        <input type="text" name="username" id="f-username" required placeholder="Masukan username" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nama <span class="field-req">*</span></label>
                        <input type="text" name="nama" id="f-nama" required placeholder="Masukan nama akun" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Followers</label>
                        <input type="text" name="followers" id="f-followers" placeholder="Masukan jumlah followers" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Platform <span class="field-req">*</span></label>
                        <input type="text" name="platform" id="f-platform" required placeholder="Contoh: Instagram, TikTok" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Divisi <span class="field-req">*</span></label>
                        <input type="text" name="divisi" id="f-divisi" required placeholder="Masukan divisi" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" id="f-pic" required placeholder="Masukan nama PIC" class="gaming-input">
                    </div>
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="ket" id="f-ket" placeholder="Masukan keterangan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="button" onclick="closeModal('sosmed-modal')" class="btn-form btn-form-batal">Batal</button>
                    <button type="submit" class="btn-form btn-form-simpan" id="form-submit-btn">Simpan</button>
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
const sosmedData = @json($itemsJson);

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Sosial Media';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('sosmed-form').action = '{{ route('admin.sosial-media.store') }}';
    document.getElementById('form-submit-btn').textContent = 'Simpan';
    document.getElementById('sosmed-form').querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') {
            el.value = '';
        }
    });
    showModal();
}

function showDetail(id) {
    const i = sosmedData.find(item => item.id === id);
    if (!i) return;
    document.getElementById('detail-title').textContent = i.username;

    const rows = [
        { label: 'Username', value: i.username },
        { label: 'Nama', value: i.nama },
        { label: 'Followers', value: i.followers || '-' },
        { label: 'Platform', value: i.platform },
        { label: 'Divisi', value: i.divisi },
        { label: 'PIC', value: i.pic },
        { label: 'Keterangan', value: i.ket || '-' },
    ];

    const detailBody = document.getElementById('detail-body');
    detailBody.innerHTML = `
        <div class="space-y-1">
            ${rows.map((r, idx) => `
                <div class="flex items-center justify-between py-2.5" ${idx < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
                </div>
            `).join('')}
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
    const i = sosmedData.find(item => item.id === id);
    if (!i) return;

    document.getElementById('modal-title').textContent = 'Edit Sosial Media';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = i.id;
    document.getElementById('sosmed-form').action = '{{ url('admin/sosial-media') }}/' + i.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    document.getElementById('f-username').value = i.username;
    document.getElementById('f-nama').value = i.nama;
    document.getElementById('f-followers').value = i.followers || '';
    document.getElementById('f-platform').value = i.platform;
    document.getElementById('f-divisi').value = i.divisi;
    document.getElementById('f-pic').value = i.pic;
    document.getElementById('f-ket').value = i.ket || '';

    showModal();
}

function showModal() { openModal('sosmed-modal'); }

document.getElementById('sosmed-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('sosmed-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetail(); closeModal('sosmed-modal'); }
});

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
    filterSosmed();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterSosmed() {
    const search = (document.getElementById('search-sosmed')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#sosmed-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowPlatform = row.dataset.platform;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowPlatform === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}
</script>
@endpush
