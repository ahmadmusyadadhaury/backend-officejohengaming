@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Kelola Akun Koordinator')
@section('page-title', 'Overview > Kelola Akun Koordinator')
@section('page-subtitle', 'Kelola akun koordinator divisi dengan akses TERBATAS (menu Meeting saja).')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="pill-switcher">
        <button type="button" class="pill-btn active" onclick="switchTab('koordinator')">Kelola Koordinator</button>
        <button type="button" class="pill-btn" onclick="switchTab('karyawan')">Kelola Karyawan</button>
    </div>

    <div id="tab-koordinator">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Akun Koordinator</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Kelola akun koordinator divisi dengan akses TERBATAS (menu Meeting saja).</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <div class="flex gap-2">
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Koordinator
            </button>
            <button type="button" onclick="openUploadNikModal()" class="btn btn-secondary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5 5 5M12 5v12"/>
                </svg>
                Upload NIK
            </button>
            </div>
@endif
        </div>
        <form method="GET" action="{{ route('admin.users.index') }}" id="filter-form">
        <input type="hidden" name="status" id="status-input" value="{{ request('status') }}">
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
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>NIK</th>
                        <th>Role</th>
                        <th>Divisi</th>
                        <th>Status</th>
<th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $users->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $user->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $user->username }}</code></td>
                        <td style="color:var(--text-muted);">{{ $user->nik ?? '—' }}</td>
                        <td>
                            <span class="badge badge-primary">{{ $user->role_label }}</span>
                        </td>
                        <td style="color:var(--text-muted);">{{ $user->team?->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <button type="button" onclick="openDetailModal({{ json_encode(['id'=>$user->id,'name'=>$user->name,'username'=>$user->username,'nik'=>$user->nik,'role'=>$user->role,'role_label'=>$user->role_label,'team_name'=>($user->team?->name ?? '—'),'is_active'=>$user->is_active]) }})" class="btn btn-secondary btn-sm" style="margin-right:4px;display:inline-flex;align-items:center;gap:4px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Detail
                            </button>
                            <div class="dropdown-wrap" style="display:inline-block;position:relative;">
                                <button type="button" onclick="toggleDropdown(event)" class="btn btn-secondary btn-sm" style="padding:6px 10px;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                                </button>
                                <div class="dropdown-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:140px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                    @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                    <button type="button" onclick="openEditModal({{ json_encode(['id'=>$user->id,'name'=>$user->name,'username'=>$user->username,'nik'=>$user->nik,'role'=>$user->role,'team_id'=>$user->team_id,'is_active'=>$user->is_active]) }})" style="display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:8px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun ini?" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button style="display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:8px 12px;border:none;background:none;font-size:13px;color:#f87171;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun koordinator ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $users->links() }}</div>
    </div>
    </div>

    {{-- ═══════════════════ TABEL KARYAWAN ═══════════════════ --}}
    <div id="tab-karyawan" style="display:none;">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Karyawan</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Akun karyawan biasa dengan akses terbatas.</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <div class="flex gap-2 flex-wrap">
            <button type="button" onclick="openCreateKaryawanModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Karyawan
            </button>
            <button type="button" onclick="openImportKaryawanModal()" class="btn btn-secondary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                </svg>
                Import Karyawan
            </button>
            <a href="{{ route('admin.users.karyawan.template') }}" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:6px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                Download Template Excel
            </a>
            </div>
@endif
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>NIK</th>
                        <th>Divisi</th>
                        <th>Status</th>
<th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $karyawan)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $karyawans->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $karyawan->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $karyawan->username }}</code></td>
                        <td style="color:var(--text-muted);">{{ $karyawan->nik ?? '—' }}</td>
                        <td style="color:var(--text-muted);">{{ $karyawan->team?->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $karyawan->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $karyawan->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <button type="button" onclick="openDetailKaryawanModal({{ json_encode(['id'=>$karyawan->id,'name'=>$karyawan->name,'username'=>$karyawan->username,'nik'=>$karyawan->nik,'team_name'=>($karyawan->team?->name ?? '—'),'is_active'=>$karyawan->is_active]) }})" class="btn btn-secondary btn-sm" style="margin-right:4px;display:inline-flex;align-items:center;gap:4px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Detail
                            </button>
                            <div class="dropdown-wrap" style="display:inline-block;position:relative;">
                                <button type="button" onclick="toggleDropdown(event)" class="btn btn-secondary btn-sm" style="padding:6px 10px;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                                </button>
                                <div class="dropdown-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:140px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                    @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                    <button type="button" onclick="openEditKaryawanModal({{ json_encode(['id'=>$karyawan->id,'name'=>$karyawan->name,'username'=>$karyawan->username,'nik'=>$karyawan->nik,'team_id'=>$karyawan->team_id,'is_active'=>$karyawan->is_active]) }})" style="display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:8px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.users.karyawan.destroy', $karyawan) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun karyawan ini?" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button style="display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:8px 12px;border:none;background:none;font-size:13px;color:#f87171;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun karyawan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $karyawans->links() }}</div>
    </div>
    </div>
</div>

{{-- ═══════════════════ DETAIL MODAL ═══════════════════ --}}
<div id="detail-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Detail Akun Koordinator</h3>
            <button type="button" onclick="closeDetailModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body space-y-4">
            <div>
                <label class="gaming-label">Nama Lengkap</label>
                <div id="detail-name" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Username</label>
                <div id="detail-username" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--color-neon-blue);font-family:monospace;">—</div>
            </div>
            <div>
                <label class="gaming-label">NIK</label>
                <div id="detail-nik" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Role</label>
                <div id="detail-role" style="padding:8px 12px;">—</div>
            </div>
            <div>
                <label class="gaming-label">Divisi / Tim</label>
                <div id="detail-team" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Status</label>
                <div id="detail-status" style="padding:8px 12px;">—</div>
            </div>
        </div>
        <div class="modal-modern-footer gap-2">
            <button type="button" id="detail-edit-btn" class="btn btn-primary">Edit</button>
            <button type="button" onclick="closeDetailModal()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>

{{-- ═══════════════════ EDIT MODAL ═══════════════════ --}}
<div id="edit-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Akun Koordinator</h3>
            <button type="button" onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" id="edit-username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">NIK</label>
                    <input type="text" name="nik" id="edit-nik" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Role</label>
                    <select name="role" id="edit-role" onchange="toggleEditTeam(this.value)" class="gaming-input gaming-select">
                        <option value="koordinator">Koordinator</option>
                        <option value="user">Karyawan</option>
                        <option value="admin_ga">Admin General Affairs</option>
                    </select>
                </div>
                <div id="edit-team-field">
                    <label class="gaming-label">Tim</label>
                    <select name="team_id" id="edit-team-id" class="gaming-input gaming-select">
                        <option value="">— Pilih Tim —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ CREATE MODAL ═══════════════════ --}}
<div id="create-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Koordinator</h3>
            <button type="button" onclick="closeCreateModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-form" method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">NIK</label>
                    <input type="text" name="nik" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password <span style="color:#f87171;">*</span></label>
                    <input type="password" name="password" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Role <span style="color:#f87171;">*</span></label>
                    <select name="role" id="create-role" required onchange="toggleCreateTeam(this.value)" class="gaming-input gaming-select">
                        <option value="">Pilih Role</option>
                        <option value="koordinator">Koordinator</option>
                        <option value="user">Karyawan</option>
                        <option value="admin_ga">Admin General Affairs</option>
                    </select>
                </div>
                <div id="create-team-field" style="display:none;">
                    <label class="gaming-label">Tim <span style="color:#f87171;">*</span></label>
                    <select name="team_id" class="gaming-input gaming-select">
                        <option value="">Pilih Tim</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <button type="button" onclick="closeCreateModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ DETAIL KARYAWAN MODAL ═══════════════════ --}}
<div id="detail-karyawan-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Detail Akun Karyawan</h3>
            <button type="button" onclick="closeDetailKaryawanModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body space-y-4">
            <div>
                <label class="gaming-label">Nama Lengkap</label>
                <div id="detail-karyawan-name" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Username</label>
                <div id="detail-karyawan-username" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--color-neon-blue);font-family:monospace;">—</div>
            </div>
            <div>
                <label class="gaming-label">NIK</label>
                <div id="detail-karyawan-nik" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Divisi / Tim</label>
                <div id="detail-karyawan-team" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Status</label>
                <div id="detail-karyawan-status" style="padding:8px 12px;">—</div>
            </div>
        </div>
        <div class="modal-modern-footer gap-2">
            <button type="button" id="detail-karyawan-edit-btn" class="btn btn-primary">Edit</button>
            <button type="button" onclick="closeDetailKaryawanModal()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>

{{-- ═══════════════════ EDIT KARYAWAN MODAL ═══════════════════ --}}
<div id="edit-karyawan-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Akun Karyawan</h3>
            <button type="button" onclick="closeEditKaryawanModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-karyawan-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-karyawan-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" id="edit-karyawan-username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">NIK</label>
                    <input type="text" name="nik" id="edit-karyawan-nik" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Tim</label>
                    <select name="team_id" id="edit-karyawan-team-id" class="gaming-input gaming-select">
                        <option value="">— Tanpa Tim —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-karyawan-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-karyawan-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditKaryawanModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ CREATE KARYAWAN MODAL ═══════════════════ --}}
<div id="create-karyawan-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Karyawan</h3>
            <button type="button" onclick="closeCreateKaryawanModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-karyawan-form" method="POST" action="{{ route('admin.users.karyawan.store') }}">
            @csrf
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">NIK</label>
                    <input type="text" name="nik" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password <span style="color:#f87171;">*</span></label>
                    <input type="password" name="password" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Tim</label>
                    <select name="team_id" class="gaming-input gaming-select">
                        <option value="">— Tanpa Tim —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <button type="button" onclick="closeCreateKaryawanModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ UPLOAD NIK MODAL ═══════════════════ --}}
<div id="upload-nik-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Upload NIK Karyawan</h3>
            <button type="button" onclick="closeUploadNikModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="upload-nik-form" method="POST" action="{{ route('admin.users.nik.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-modern-body space-y-4">
                <p style="font-size:0.8rem;color:var(--text-muted);">
                    Download template, isi kolom NIK untuk setiap karyawan (dicocokkan berdasarkan username), lalu upload kembali.
                </p>
                <a href="{{ route('admin.users.nik.template') }}" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Download Template Excel
                </a>
                <div>
                    <label class="gaming-label">File Excel (xlsx/xls/csv) <span style="color:#f87171;">*</span></label>
                    <input type="file" name="file" required accept=".xlsx,.xls,.csv" class="gaming-input">
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Upload</button>
                <button type="button" onclick="closeUploadNikModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ IMPORT KARYAWAN MODAL ═══════════════════ --}}
<div id="import-karyawan-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Import Karyawan dari Excel</h3>
            <button type="button" onclick="closeImportKaryawanModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="import-karyawan-form" method="POST" action="{{ route('admin.users.karyawan.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-modern-body space-y-4">
                <p style="font-size:0.8rem;color:var(--text-muted);">
                    Download template, isi data karyawan (kolom Tim & Role memakai dropdown pilihan), lalu upload kembali.
                    Role bisa <b>Karyawan</b>, <b>Koordinator</b>, atau <b>Admin</b>. Password dikosongkan berarti memakai default <code>password</code>.
                </p>
                <a href="{{ route('admin.users.karyawan.template') }}" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Download Template Excel
                </a>
                <div>
                    <label class="gaming-label">File Excel (xlsx/xls/csv) <span style="color:#f87171;">*</span></label>
                    <input type="file" name="file" required accept=".xlsx,.xls,.csv" class="gaming-input">
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Import</button>
                <button type="button" onclick="closeImportKaryawanModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function switchTab(tab) {
    document.getElementById('tab-koordinator').style.display = tab === 'koordinator' ? 'block' : 'none';
    document.getElementById('tab-karyawan').style.display = tab === 'karyawan' ? 'block' : 'none';
    document.querySelectorAll('.pill-btn').forEach(function(btn) { btn.classList.remove('active'); });
    if (tab === 'koordinator') {
        document.querySelector('.pill-btn:first-child').classList.add('active');
    } else {
        document.querySelector('.pill-btn:last-child').classList.add('active');
    }
}
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
    document.querySelectorAll('.dropdown-menu').forEach(function(d) {
        if (!e.target.closest('.dropdown-wrap')) d.style.display = 'none';
    });
});

function toggleDropdown(e) {
    e.stopPropagation();
    var parent = e.currentTarget.closest('.dropdown-wrap');
    var menu = parent.querySelector('.dropdown-menu');
    document.querySelectorAll('.dropdown-menu').forEach(function(d) { if (d !== menu) d.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

function openDetailModal(data) {
    document.getElementById('detail-name').textContent = data.name;
    document.getElementById('detail-username').textContent = data.username;
    document.getElementById('detail-nik').textContent = data.nik || '—';
    document.getElementById('detail-role').innerHTML = '<span class="badge badge-primary">' + data.role_label + '</span>';
    document.getElementById('detail-team').textContent = data.team_name;
    document.getElementById('detail-status').innerHTML = data.is_active == 1
        ? '<span class="badge badge-green">Aktif</span>'
        : '<span class="badge badge-red">Nonaktif</span>';
    document.getElementById('detail-edit-btn').onclick = function() {
        closeDetailModal();
        openEditModal(data);
    };
    openModal('detail-modal');
}
function closeDetailModal() { closeModal('detail-modal'); }

function openEditModal(data) {
    document.getElementById('edit-form').action = '/admin/users/' + data.id;
    document.getElementById('edit-name').value = data.name;
    document.getElementById('edit-username').value = data.username;
    document.getElementById('edit-nik').value = data.nik || '';
    document.getElementById('edit-role').value = data.role;
    document.getElementById('edit-team-id').value = data.team_id || '';
    document.getElementById('edit-is-active').checked = data.is_active == 1;
    toggleEditTeam(data.role);
    openModal('edit-modal');
}
function closeEditModal() { closeModal('edit-modal'); }
function toggleEditTeam(role) {
    document.getElementById('edit-team-field').style.display = ['koordinator','user'].includes(role) ? 'block' : 'none';
}

function openCreateModal() {
    document.getElementById('create-form').reset();
    document.getElementById('create-team-field').style.display = 'none';
    openModal('create-modal');
}
function closeCreateModal() { closeModal('create-modal'); }
function toggleCreateTeam(role) {
    document.getElementById('create-team-field').style.display = ['koordinator','user'].includes(role) ? 'block' : 'none';
}

function openDetailKaryawanModal(data) {
    document.getElementById('detail-karyawan-name').textContent = data.name;
    document.getElementById('detail-karyawan-username').textContent = data.username;
    document.getElementById('detail-karyawan-nik').textContent = data.nik || '—';
    document.getElementById('detail-karyawan-team').textContent = data.team_name;
    document.getElementById('detail-karyawan-status').innerHTML = data.is_active == 1
        ? '<span class="badge badge-green">Aktif</span>'
        : '<span class="badge badge-red">Nonaktif</span>';
    document.getElementById('detail-karyawan-edit-btn').onclick = function() {
        closeDetailKaryawanModal();
        openEditKaryawanModal(data);
    };
    openModal('detail-karyawan-modal');
}
function closeDetailKaryawanModal() { closeModal('detail-karyawan-modal'); }

function openEditKaryawanModal(data) {
    document.getElementById('edit-karyawan-form').action = '/admin/users/karyawan/' + data.id;
    document.getElementById('edit-karyawan-name').value = data.name;
    document.getElementById('edit-karyawan-username').value = data.username;
    document.getElementById('edit-karyawan-nik').value = data.nik || '';
    document.getElementById('edit-karyawan-team-id').value = data.team_id || '';
    document.getElementById('edit-karyawan-is-active').checked = data.is_active == 1;
    openModal('edit-karyawan-modal');
}
function closeEditKaryawanModal() { closeModal('edit-karyawan-modal'); }

function openCreateKaryawanModal() {
    document.getElementById('create-karyawan-form').reset();
    openModal('create-karyawan-modal');
}
function closeCreateKaryawanModal() { closeModal('create-karyawan-modal'); }

function openUploadNikModal() {
    document.getElementById('upload-nik-form').reset();
    openModal('upload-nik-modal');
}
function closeUploadNikModal() { closeModal('upload-nik-modal'); }

function openImportKaryawanModal() {
    document.getElementById('import-karyawan-form').reset();
    openModal('import-karyawan-modal');
}
function closeImportKaryawanModal() { closeModal('import-karyawan-modal'); }

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetailModal(); closeEditModal(); closeCreateModal(); closeDetailKaryawanModal(); closeEditKaryawanModal(); closeCreateKaryawanModal(); closeUploadNikModal(); closeImportKaryawanModal(); }
});
</script>

@if(session('import_errors') || session('import_skipped'))
<div class="pt-2">
    <div class="gaming-card p-4" style="border-left:4px solid #f59e0b;">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">
                    Import Selesai:
                    @if(session('import_success_count') !== null) {{ session('import_success_count') }} berhasil, @endif
                    @if(session('import_skipped_count')) {{ session('import_skipped_count') }} duplikat dilewati, @endif
                    @if(session('import_error_count') !== null) {{ session('import_error_count') }} gagal.
                    @endif
                </p>
                @if(session('import_skipped'))
                <div class="mt-2 max-h-[150px] overflow-y-auto" style="scrollbar-width:thin;">
                    <ul style="list-style:none;padding:0;margin:0;">
                        @foreach(session('import_skipped') as $item)
                        <li style="font-size:12px;color:#f59e0b;padding:2px 0;">{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session('import_errors'))
                <div class="mt-2 max-h-[150px] overflow-y-auto" style="scrollbar-width:thin;">
                    <ul style="list-style:none;padding:0;margin:0;">
                        @foreach(session('import_errors') as $error)
                        <li style="font-size:12px;color:#ef4444;padding:2px 0;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <button type="button" onclick="this.closest('.gaming-card').remove()" class="ml-auto p-1" style="background:none;border:none;cursor:pointer;color:var(--text-muted);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif
@push('styles')
<style>
.pill-switcher { display:flex; gap:0.25rem; background:var(--bg-surface-2); border:1px solid var(--border-color); border-radius:0.625rem; padding:0.2rem; width:fit-content; }
.pill-btn { padding:0.4rem 1rem; border-radius:0.4rem; border:none; background:transparent; font-family:'Rajdhani',sans-serif; font-weight:700; font-size:0.75rem; letter-spacing:0.05em; text-transform:uppercase; color:var(--text-muted); cursor:pointer; transition:all 0.18s ease; white-space:nowrap; }
.pill-btn:hover { color:var(--text-primary); }
.pill-btn.active { background:linear-gradient(135deg, var(--color-accent), var(--color-primary-light)); color:white; box-shadow:0 2px 8px rgba(124,58,237,0.35); }
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection
