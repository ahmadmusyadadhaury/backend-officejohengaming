@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Sosial Media')
@section('page-title', 'Data Aset > Sosial Media')
@section('page-subtitle', 'Seluruh akun sosial media operasional perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@php
$badgeVariants = ['badge-primary', 'badge-blue', 'badge-green', 'badge-yellow', 'badge-cyan', 'badge-orange'];
@endphp

@section('content')
<div class="pt-2 space-y-5 animate-fade-in">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 md:gap-3">
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:rgba(124,58,237,0.12);box-shadow:0 0 14px rgba(124,58,237,0.20);">
                <svg style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:#a78bfa;">{{ $stats['total'] }}</div>
                <div class="stat-label-text" style="font-size:0.7rem;">Total Akun</div>
            </div>
        </div>
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:rgba(16,185,129,0.12);box-shadow:0 0 14px rgba(16,185,129,0.20);">
                <svg style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="stat-label-text" style="font-size:0.7rem;">Akun Aktif</div>
            </div>
        </div>
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:rgba(239,68,68,0.12);box-shadow:0 0 14px rgba(239,68,68,0.20);">
                <svg style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:#ef4444;">{{ $stats['nonaktif'] }}</div>
                <div class="stat-label-text" style="font-size:0.7rem;">Akun Tidak Aktif</div>
            </div>
        </div>
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
            @if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Sosial Media
            </button>
            @endif
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
                        <th style="width:90px;">Status</th>
                        <th class="hidden md:table-cell">Divisi</th>
                        <th class="hidden lg:table-cell">PIC</th>
                        @if(auth()->user()->role !== 'gm')
                        <th style="width:130px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="sosmed-tbody">
                    @forelse($items as $i)
                    @php $bClass = $badgeVariants[$loop->index % count($badgeVariants)]; @endphp
                    <tr data-platform="{{ $i->platform }}">
                        <td style="color:var(--text-muted);">{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
                        <td><span style="color:var(--text-primary);font-weight:600;">{{ $i->username }}</span></td>
                        <td style="color:var(--text-muted);">{{ $i->nama }}</td>
                        <td style="color:var(--text-muted);">{{ $i->followers ?? '—' }}</td>
                        <td><span class="badge {{ $bClass }}">{{ $i->platform }}</span></td>
                        <td><span class="badge {{ $i->status === 'aktif' ? 'badge-green' : 'badge-red' }}">{{ $i->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $i->divisi }}</td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);">{{ $i->pic }}</td>
                        @if(auth()->user()->role !== 'gm')
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $i->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $i->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $i->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lihat Detail</button>
                                        <button type="button" onclick="openEditModal({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.sosial-media.destroy', $i) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun {{ $i->username }}?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endif
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
            <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-top:1px solid var(--border-color);">
                <span style="font-size:0.75rem;color:var(--text-muted);white-space:nowrap;">
                    @if($items->firstItem())
                        @if(!$showAll)
                            Menampilkan {{ $items->firstItem() }}-{{ $items->lastItem() }} dari {{ $items->total() }} item
                        @else
                            Menampilkan semua {{ $items->total() }} item
                        @endif
                    @else
                        Menampilkan 0 dari {{ $items->total() }} item
                    @endif
                </span>
                @if($items->total() > 0)
                    @if(!$showAll)
                        <a href="{{ route('admin.sosial-media.index') }}?show_all=1" style="font-size:0.75rem;color:var(--color-accent);font-weight:500;text-decoration:none;white-space:nowrap;">Selengkapnya &rarr;</a>
                    @else
                        <a href="{{ route('admin.sosial-media.index') }}" style="font-size:0.75rem;color:var(--color-accent);font-weight:500;text-decoration:none;white-space:nowrap;">&larr; Kembali ke Ringkasan</a>
                    @endif
                @endif
                <div style="margin-left:auto;">
                    @if(method_exists($items, 'links') && $items->hasPages())
                        {{ $items->links() }}
                    @endif
                </div>
            </div>
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
<div id="sosmed-modal" style="display:none;position:fixed;inset:0;z-index:100000;align-items:center;justify-content:center;padding:20px;background:var(--bg-overlay);overflow-y:auto;" onclick="if(event.target===this)closeModal('sosmed-modal')">
    <div class="sosmed-modal-card" onclick="event.stopPropagation()">
        <div class="sosmed-modal-header">
            <div>
                <h3 class="sosmed-modal-title" id="modal-title">Tambah Sosial Media</h3>
                <p class="sosmed-modal-subtitle">Kelola akun sosial media operasional</p>
            </div>
            <button type="button" onclick="closeModal('sosmed-modal')" class="sosmed-close-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="sosmed-modal-body">
            <form id="sosmed-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">
                <div class="sosmed-form-grid">
                    <div class="sosmed-form-col">
                        <div class="sosmed-field">
                            <label class="sosmed-label">Username <span class="sosmed-required">*</span></label>
                            <input type="text" name="username" id="f-username" required placeholder="Masukan username" class="sosmed-input">
                        </div>
                        <div class="sosmed-field">
                            <label class="sosmed-label">Nama <span class="sosmed-required">*</span></label>
                            <input type="text" name="nama" id="f-nama" required placeholder="Masukan nama akun" class="sosmed-input">
                        </div>
                        <div class="sosmed-field">
                            <label class="sosmed-label">Followers</label>
                            <input type="text" name="followers" id="f-followers" placeholder="Masukan jumlah followers" class="sosmed-input">
                        </div>
                        <div class="sosmed-field">
                            <label class="sosmed-label">Divisi <span class="sosmed-required">*</span></label>
                            <input type="text" name="divisi" id="f-divisi" required placeholder="Masukan divisi" class="sosmed-input">
                        </div>
                    </div>
                    <div class="sosmed-form-col">
                        <div class="sosmed-field">
                            <label class="sosmed-label">Platform <span class="sosmed-required">*</span></label>
                            <input type="text" name="platform" id="f-platform" required placeholder="Contoh: Instagram, TikTok" class="sosmed-input">
                        </div>
                        <div class="sosmed-field">
                            <label class="sosmed-label">PIC <span class="sosmed-required">*</span></label>
                            <select name="pic" id="f-pic" required class="sosmed-input">
                                <option value="">— Pilih PIC —</option>
                                @foreach(\App\Models\User::where('is_active', true)->orderBy('name')->get() as $u)
                                <option value="{{ $u->name }}">{{ $u->name }} ({{ $u->username }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sosmed-field">
                            <label class="sosmed-label">Status</label>
                            <select name="status" id="f-status" class="sosmed-input">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="sosmed-field">
                            <label class="sosmed-label">Keterangan</label>
                            <textarea name="ket" id="f-ket" placeholder="Masukan keterangan" rows="2" class="sosmed-input sosmed-textarea"></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="sosmed-modal-footer">
            <button type="button" onclick="closeModal('sosmed-modal')" class="sosmed-btn sosmed-btn-batal">Batal</button>
            <button type="submit" class="sosmed-btn sosmed-btn-simpan" id="form-submit-btn" form="sosmed-form">Simpan</button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
@keyframes sosmedFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.sosmed-modal-card {
    width: 100%;
    max-width: 700px;
    background: var(--bg-surface);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.5);
    display: flex;
    flex-direction: column;
    max-height: 95vh;
    animation: sosmedFadeIn 0.3s ease;
}
.sosmed-modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 16px 24px 12px;
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
}
.sosmed-modal-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}
.sosmed-modal-subtitle {
    font-size: 12px;
    color: var(--text-muted);
    margin: 2px 0 0;
    font-weight: 400;
}
.sosmed-close-btn {
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-muted);
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}
.sosmed-close-btn:hover { background: rgba(128,128,128,0.2); color: var(--text-primary); }
.sosmed-modal-body {
    padding: 12px 20px 12px;
    overflow-y: auto;
    flex: 1;
}
.sosmed-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 20px;
}
@media (max-width: 768px) {
    .sosmed-form-grid { grid-template-columns: 1fr; }
    .sosmed-modal-card { max-width: 95vw; }
    .sosmed-modal-header { padding: 12px 20px 10px; }
    .sosmed-modal-body { padding: 10px 16px 10px; }
}
.sosmed-form-col {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.sosmed-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.sosmed-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 6px;
}
.sosmed-required { color: #f87171; }
.sosmed-input {
    width: 100%;
    height: 40px;
    padding: 0 14px;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    color: var(--text-primary);
    font-size: 13px;
    outline: none;
    transition: all 0.25s ease;
    box-sizing: border-box;
}
.sosmed-input:focus {
    border-color: #6c5cff;
    box-shadow: 0 0 0 3px rgba(108,92,255,0.15);
}
.sosmed-input::placeholder { color: var(--text-muted); }
.sosmed-input option { background: var(--bg-surface); color: var(--text-primary); }
.sosmed-textarea {
    height: auto;
    padding: 10px 14px;
    resize: vertical;
    min-height: 64px;
}
.sosmed-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 14px 24px 20px;
    flex-shrink: 0;
    border-top: 1px solid var(--border-color);
}
.sosmed-btn {
    padding: 8px 24px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    border: none;
}
.sosmed-btn-batal {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
}
.sosmed-btn-batal:hover {
    border-color: rgba(128,128,128,0.4);
    color: var(--text-primary);
}
.sosmed-btn-simpan {
    background: linear-gradient(135deg, #6c5cff, #8b7bff);
    color: #fff;
    box-shadow: 0 4px 15px rgba(108,92,255,0.3);
}
.sosmed-btn-simpan:hover {
    transform: translateY(-2px);
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
        { label: 'Status', value: i.status === 'aktif' ? 'Aktif' : 'Tidak Aktif' },
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
    document.getElementById('f-status').value = i.status;
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
