@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Sosial Media')
@section('page-title', 'Data Aset > Sosial Media')
@section('page-subtitle', 'Seluruh akun sosial media operasional perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@php
$platformBrand = [
    'Instagram' => ['text' => '#e4405f', 'bg' => 'rgba(228,64,95,0.12)'],
    'TikTok'    => ['text' => '#161622', 'bg' => 'rgba(22,22,34,0.10)'],
    'YouTube'   => ['text' => '#ff0000', 'bg' => 'rgba(255,0,0,0.12)'],
    'Facebook'  => ['text' => '#1877f2', 'bg' => 'rgba(24,119,242,0.12)'],
    'LinkedIn'  => ['text' => '#0a66c2', 'bg' => 'rgba(10,102,194,0.12)'],
    'Twitter'   => ['text' => '#1da1f2', 'bg' => 'rgba(29,161,242,0.12)'],
    'X'         => ['text' => '#161622', 'bg' => 'rgba(22,22,34,0.10)'],
    'WhatsApp'  => ['text' => '#25d366', 'bg' => 'rgba(37,211,102,0.12)'],
    'Telegram'  => ['text' => '#0088cc', 'bg' => 'rgba(0,136,204,0.12)'],
];
$fallbackColors = ['#a78bfa', '#60a5fa', '#34d399', '#fbbf24', '#f87171', '#fb923c'];
$fallbackBgs = [
    'rgba(124,58,237,0.12)', 'rgba(59,130,246,0.12)', 'rgba(16,185,129,0.12)',
    'rgba(245,158,11,0.12)', 'rgba(239,68,68,0.12)', 'rgba(249,115,22,0.12)',
];
$badgeVariants = ['badge-primary', 'badge-blue', 'badge-green', 'badge-yellow', 'badge-cyan', 'badge-orange'];

function platformColors($platform, $brands, $fColors, $fBgs) {
    if (isset($brands[$platform])) return $brands[$platform];
    $hash = abs(crc32($platform));
    $idx = $hash % count($fColors);
    return ['text' => $fColors[$idx], 'bg' => $fBgs[$idx]];
}
@endphp

@section('content')
<div class="pt-2 space-y-5 animate-fade-in">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:rgba(124,58,237,0.12);">
                <svg style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="stat-num">{{ $stats['total'] }}</div>
                <div class="stat-label-text">Total Akun</div>
                <div class="text-[10px] leading-tight mt-0.5" style="color:var(--text-muted);">Seluruh sosial media</div>
            </div>
        </div>
        @php $idx = 0; @endphp
        @foreach($stats['platforms'] as $platform => $count)
            @php
                $colors = platformColors($platform, $platformBrand, $fallbackColors, $fallbackBgs);
                $idx++;
            @endphp
            <div class="stat-card-compact">
                <div class="stat-icon-box" style="background:{{ $colors['bg'] }};">
                    <svg style="color:{{ $colors['text'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="stat-num" style="color:{{ $colors['text'] }};">{{ $count }}</div>
                    <div class="stat-label-text">{{ $platform }}</div>
                    <div class="text-[10px] leading-tight mt-0.5" style="color:var(--text-muted);">Jumlah akun</div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Table Card --}}
    <div class="gaming-card" style="overflow:hidden;">
        <div class="card-header">
            <div class="card-header-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Data Sosial Media
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Sosial Media
            </button>
        </div>

        {{-- Filter Bar --}}
        <div class="filter-bar">
            <div class="search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-sosmed" placeholder="Cari username, nama, atau platform" oninput="filterSosmed()"
                    class="gaming-input" style="padding-left:2rem;">
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card, var(--bg-surface));color:var(--text-primary);outline:none;white-space:nowrap;">
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

        {{-- Table --}}
        <div class="table-responsive">
            <table class="gaming-table min-w-[900px]" id="sosmed-table">
                <thead>
                    <tr>
                        <th style="width:48px;">No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th style="width:100px;">Followers</th>
                        <th style="width:120px;">Platform</th>
                        <th class="hidden md:table-cell">Divisi</th>
                        <th class="hidden lg:table-cell">PIC</th>
                        <th style="width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="sosmed-tbody">
                    @forelse($items as $i)
                    @php $bClass = $badgeVariants[$loop->index % count($badgeVariants)]; @endphp
                    <tr data-platform="{{ $i->platform }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td><span style="color:var(--text-primary);font-weight:600;">{{ $i->username }}</span></td>
                        <td style="color:var(--text-muted);">{{ $i->nama }}</td>
                        <td style="color:var(--text-muted);">{{ $i->followers ?? '—' }}</td>
                        <td><span class="badge {{ $bClass }}">{{ $i->platform }}</span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $i->divisi }}</td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);">{{ $i->pic }}</td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <button type="button" onclick="showDetail({{ $i->id }})" class="btn btn-secondary btn-sm" title="Lihat Detail" style="padding:4px 8px;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span class="hidden sm:inline">Detail</span>
                                </button>
                                <button type="button" onclick="openEditModal({{ $i->id }})" class="btn btn-secondary btn-sm" title="Edit" style="padding:4px 8px;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span class="hidden sm:inline">Edit</span>
                                </button>
                                <form method="POST" action="{{ route('admin.sosial-media.destroy', $i) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun {{ $i->username }}?" style="margin:0;display:inline-flex;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus" style="padding:4px 8px;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="8" style="text-align:center;padding:2.5rem 1rem;color:var(--text-muted);">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-8 h-8" style="opacity:0.35;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                                <span>Belum ada data Sosial Media.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Detail Modal --}}
<div id="detail-modal" class="modal-modern">
    <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="detail-title">Detail Sosial Media</h3>
            <button type="button" onclick="closeDetail()" class="modal-modern-close">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-modern-body" id="detail-body"></div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetail()" class="btn btn-secondary btn-sm">Tutup</button>
        </div>
    </div>
</div>

{{-- Create / Edit Modal --}}
<div id="sosmed-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="modal-title">Tambah Sosial Media</h3>
            <button type="button" onclick="closeModal('sosmed-modal')" class="modal-modern-close">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-modern-body">
            <form id="sosmed-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Username <span class="field-req">*</span></label>
                        <input type="text" name="username" id="f-username" required placeholder="Masukan username" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Nama <span class="field-req">*</span></label>
                        <input type="text" name="nama" id="f-nama" required placeholder="Masukan nama akun" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Followers</label>
                        <input type="text" name="followers" id="f-followers" placeholder="Masukan jumlah followers" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Platform <span class="field-req">*</span></label>
                        <input type="text" name="platform" id="f-platform" required placeholder="Contoh: Instagram, TikTok" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Divisi <span class="field-req">*</span></label>
                        <input type="text" name="divisi" id="f-divisi" required placeholder="Masukan divisi" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" id="f-pic" required placeholder="Masukan nama PIC" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5 sm:col-span-2">
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="ket" id="f-ket" placeholder="Masukan keterangan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeModal('sosmed-modal')" class="btn btn-secondary">Batal</button>
            <button type="submit" class="btn btn-primary" id="form-submit-btn" form="sosmed-form">Simpan</button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.field-req { color: #f87171; }

.modal-modern-body .gaming-input {
    padding: 0.55rem 0.75rem;
    font-size: 0.8rem;
}
.modal-modern-body .gaming-label {
    margin-bottom: 0;
    font-size: 0.65rem;
}

.stat-card-compact .stat-label-text {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--text-secondary);
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
    openModal('sosmed-modal');
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

    document.getElementById('detail-body').innerHTML = `
        <div class="space-y-0">
            ${rows.map((r, idx) => `
                <div class="flex items-center justify-between py-2.5 ${idx < rows.length - 1 ? 'border-b' : ''}" style="${idx < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : ''}">
                    <span class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">${r.label}</span>
                    <span class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</span>
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

    openModal('sosmed-modal');
}

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
    const btn = e.currentTarget;
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    if (menu.style.display === 'none' || !menu.style.display) {
        const rect = btn.getBoundingClientRect();
        menu.style.position = 'fixed';
        menu.style.top = (rect.bottom + 4) + 'px';
        menu.style.right = (window.innerWidth - rect.right) + 'px';
        menu.style.left = 'auto';
        menu.style.bottom = 'auto';
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
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
