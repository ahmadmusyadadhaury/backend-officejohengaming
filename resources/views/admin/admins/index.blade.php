@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Kelola Akun')
@section('page-title', 'Overview > Kelola Akun')
@section('page-subtitle', 'Kelola akun admin, koordinator, dan karyawan dalam satu halaman.')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="pill-switcher">
        <button type="button" class="pill-btn active" onclick="switchTab('admin')">Kelola Admin</button>
        <button type="button" class="pill-btn" onclick="switchTab('koordinator')">Kelola Koordinator</button>
        <button type="button" class="pill-btn" onclick="switchTab('karyawan')">Kelola Karyawan</button>
    </div>

    <div id="tab-admin">
    {{-- ═══════════════════ TABEL ADMIN ═══════════════════ --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Admin</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Akun dengan akses PENUH ke seluruh menu sistem.</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <div class="flex gap-2">
            <button type="button" onclick="openCreateAdminModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Admin
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
        <form method="GET" action="{{ route('admin.admins.index') }}" id="admin-filter-form">
        <input type="hidden" name="status" id="admin-status-input" value="{{ request('status') }}">
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
                <button type="button" onclick="toggleAdminFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="admin-filter-label">{{ request('status') === 'active' ? 'Aktif' : (request('status') === 'inactive' ? 'Nonaktif' : 'Semua Status') }}</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="admin-filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="" onclick="setAdminFilter('')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="active" onclick="setAdminFilter('active')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="inactive" onclick="setAdminFilter('inactive')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Nonaktif</button>
                </div>
            </div>
        </div>
        </form>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[600px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>NIK</th>
                        <th>Role</th>
                        <th>Status</th>
<th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $admins->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $admin->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $admin->username }}</code></td>
                        <td style="color:var(--text-muted);">{{ $admin->nik ?? '—' }}</td>
                        <td>
                            @php
                                $roleClass = match($admin->role) {
                                    'admin'         => 'badge-primary',
                                    'head_of_store' => 'badge-blue',
                                    'gm'            => 'badge-cyan',
                                    'ceo'           => 'badge-primary',
                                    'hr'            => 'badge-green',
                                    'assistant_manager' => 'badge-purple',
                                    default         => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $roleClass }}">{{ $admin->role_label }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $admin->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $admin->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            @if($admin->id !== auth()->id())
                                <div class="flex items-center gap-1">
                                    <button type="button" onclick="showAdminDetail({{ json_encode(['id'=>$admin->id,'name'=>$admin->name,'username'=>$admin->username,'nik'=>$admin->nik,'role'=>$admin->role,'role_label'=>$admin->role_label,'is_active'=>$admin->is_active]) }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat Detail
                                    </button>
                                    <div class="dropdown-wrap" style="position:relative;">
                                        <button type="button" onclick="toggleDropdown(this, 'admin-{{ $admin->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                        <div id="dropdown-admin-{{ $admin->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                            <button type="button" onclick="showAdminDetail({{ json_encode(['id'=>$admin->id,'name'=>$admin->name,'username'=>$admin->username,'nik'=>$admin->nik,'role'=>$admin->role,'role_label'=>$admin->role_label,'is_active'=>$admin->is_active]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                            @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                            <button type="button" onclick="openEditAdminModal({{ json_encode(['id'=>$admin->id,'name'=>$admin->name,'username'=>$admin->username,'nik'=>$admin->nik,'role'=>$admin->role,'role_label'=>$admin->role_label,'is_active'=>$admin->is_active]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                            <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun admin ini?" style="margin:0;">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="badge badge-gray">Akun kamu</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun admin ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $admins->links() }}</div>
    </div>
    </div>

    {{-- ═══════════════════ TABEL KOORDINATOR ═══════════════════ --}}
    <div id="tab-koordinator" style="display:none;">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Koordinator</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Akun koordinator divisi dengan akses terbatas (menu Meeting saja).</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <div class="flex gap-2">
            <button type="button" onclick="openCreateKoordinatorModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Koordinator
            </button>
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
                    @forelse($koordinators as $koordinator)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $koordinators->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $koordinator->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $koordinator->username }}</code></td>
                        <td style="color:var(--text-muted);">{{ $koordinator->nik ?? '—' }}</td>
                        <td style="color:var(--text-muted);">{{ $koordinator->team?->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $koordinator->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $koordinator->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showKoordinatorDetail({{ json_encode(['id'=>$koordinator->id,'name'=>$koordinator->name,'username'=>$koordinator->username,'nik'=>$koordinator->nik,'team_id'=>$koordinator->team_id,'team'=>$koordinator->team?->name ?? '—','role_label'=>$koordinator->role_label,'is_active'=>$koordinator->is_active]) }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, 'koordinator-{{ $koordinator->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-koordinator-{{ $koordinator->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showKoordinatorDetail({{ json_encode(['id'=>$koordinator->id,'name'=>$koordinator->name,'username'=>$koordinator->username,'nik'=>$koordinator->nik,'team_id'=>$koordinator->team_id,'team'=>$koordinator->team?->name ?? '—','role_label'=>$koordinator->role_label,'is_active'=>$koordinator->is_active]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <button type="button" onclick="openEditKoordinatorModal({{ json_encode(['id'=>$koordinator->id,'name'=>$koordinator->name,'username'=>$koordinator->username,'nik'=>$koordinator->nik,'team_id'=>$koordinator->team_id,'team'=>$koordinator->team?->name ?? '—','role_label'=>$koordinator->role_label,'is_active'=>$koordinator->is_active]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.users.destroy', $koordinator) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun koordinator ini?" style="margin:0;">
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
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun koordinator ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $koordinators->links() }}</div>
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
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showKaryawanDetail({{ json_encode(['id'=>$karyawan->id,'name'=>$karyawan->name,'username'=>$karyawan->username,'nik'=>$karyawan->nik,'team_id'=>$karyawan->team_id,'team'=>$karyawan->team?->name ?? '—','role_label'=>$karyawan->role_label,'is_active'=>$karyawan->is_active]) }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, 'karyawan-{{ $karyawan->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-karyawan-{{ $karyawan->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showKaryawanDetail({{ json_encode(['id'=>$karyawan->id,'name'=>$karyawan->name,'username'=>$karyawan->username,'nik'=>$karyawan->nik,'team_id'=>$karyawan->team_id,'team'=>$karyawan->team?->name ?? '—','role_label'=>$karyawan->role_label,'is_active'=>$karyawan->is_active]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <button type="button" onclick="openEditKaryawanModal({{ json_encode(['id'=>$karyawan->id,'name'=>$karyawan->name,'username'=>$karyawan->username,'nik'=>$karyawan->nik,'team_id'=>$karyawan->team_id,'team'=>$karyawan->team?->name ?? '—','role_label'=>$karyawan->role_label,'is_active'=>$karyawan->is_active]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.admins.karyawan.destroy', $karyawan) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun karyawan ini?" style="margin:0;">
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
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun karyawan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $karyawans->links() }}</div>
    </div>
    </div>
</div>

{{-- ═══════════════════ MODALS ADMIN ═══════════════════ --}}
<div id="edit-admin-modal" class="modal-modern" onclick="if(event.target===this)closeEditAdminModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Akun Admin</h3>
            <button type="button" onclick="closeEditAdminModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-admin-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-admin-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" id="edit-admin-username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">NIK</label>
                    <input type="text" name="nik" id="edit-admin-nik" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Role Admin <span style="color:#f87171;">*</span></label>
                    <select name="role" id="edit-admin-role" required class="gaming-input gaming-select">
                        <option value="admin">Admin Master</option>
                        <option value="head_of_store">Head of Store</option>
                        <option value="gm">General Manager (GM)</option>
                        <option value="ceo">Chief Executive Officer (CEO)</option>
                        <option value="hr">HR (Human Resources)</option>
                        <option value="assistant_manager">Assistant Manager</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-admin-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-admin-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditAdminModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="create-admin-modal" class="modal-modern" onclick="if(event.target===this)closeCreateAdminModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Admin</h3>
            <button type="button" onclick="closeCreateAdminModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-admin-form" method="POST" action="{{ route('admin.admins.store') }}">
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
                    <label class="gaming-label">Role Admin <span style="color:#f87171;">*</span></label>
                    <select name="role" required class="gaming-input gaming-select">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin Master</option>
                        <option value="head_of_store">Head of Store</option>
                        <option value="gm">General Manager (GM)</option>
                        <option value="ceo">Chief Executive Officer (CEO)</option>
                        <option value="hr">HR (Human Resources)</option>
                        <option value="assistant_manager">Assistant Manager</option>
                    </select>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <button type="button" onclick="closeCreateAdminModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ MODALS KOORDINATOR ═══════════════════ --}}
<div id="edit-koordinator-modal" class="modal-modern" onclick="if(event.target===this)closeEditKoordinatorModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Akun Koordinator</h3>
            <button type="button" onclick="closeEditKoordinatorModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-koordinator-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-koordinator-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" id="edit-koordinator-username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">NIK</label>
                    <input type="text" name="nik" id="edit-koordinator-nik" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Tim</label>
                    <select name="team_id" id="edit-koordinator-team-id" class="gaming-input gaming-select">
                        <option value="">— Pilih Tim —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-koordinator-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-koordinator-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditKoordinatorModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="create-koordinator-modal" class="modal-modern" onclick="if(event.target===this)closeCreateKoordinatorModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Koordinator</h3>
            <button type="button" onclick="closeCreateKoordinatorModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-koordinator-form" method="POST" action="{{ route('admin.users.store') }}">
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
                        <option value="">— Pilih Tim —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="role" value="koordinator">
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <button type="button" onclick="closeCreateKoordinatorModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════ MODALS KARYAWAN ═══════════════════ --}}
<div id="edit-karyawan-modal" class="modal-modern" onclick="if(event.target===this)closeEditKaryawanModal()">
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

<div id="create-karyawan-modal" class="modal-modern" onclick="if(event.target===this)closeCreateKaryawanModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Karyawan</h3>
            <button type="button" onclick="closeCreateKaryawanModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-karyawan-form" method="POST" action="{{ route('admin.admins.karyawan.store') }}">
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
<div id="upload-nik-modal" class="modal-modern" onclick="if(event.target===this)closeUploadNikModal()">
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
<div id="import-karyawan-modal" class="modal-modern" onclick="if(event.target===this)closeImportKaryawanModal()">
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

{{-- ═══════════════════ DETAIL MODAL ═══════════════════ --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail Akun</h3>
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
function toggleAdminFilterMenu(e) {
    e.stopPropagation();
    var menu = document.getElementById('admin-filter-menu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function setAdminFilter(value) {
    document.getElementById('admin-status-input').value = value;
    document.getElementById('admin-filter-menu').style.display = 'none';
    document.getElementById('admin-filter-form').submit();
}
document.addEventListener('click', function(e) {
    var menu = document.getElementById('admin-filter-menu');
    if (menu && !e.target.closest('.filter-dropdown-wrap')) {
        menu.style.display = 'none';
    }
});

function openEditAdminModal(data) {
    document.getElementById('edit-admin-form').action = '/admin/admins/' + data.id;
    document.getElementById('edit-admin-name').value = data.name;
    document.getElementById('edit-admin-username').value = data.username;
    document.getElementById('edit-admin-nik').value = data.nik || '';
    document.getElementById('edit-admin-role').value = data.role;
    document.getElementById('edit-admin-is-active').checked = data.is_active == 1;
    openModal('edit-admin-modal');
}
function closeEditAdminModal() { closeModal('edit-admin-modal'); }
function openCreateAdminModal() {
    document.getElementById('create-admin-form').reset();
    openModal('create-admin-modal');
}
function closeCreateAdminModal() { closeModal('create-admin-modal'); }

function openEditKoordinatorModal(data) {
    document.getElementById('edit-koordinator-form').action = '/admin/users/' + data.id;
    document.getElementById('edit-koordinator-name').value = data.name;
    document.getElementById('edit-koordinator-username').value = data.username;
    document.getElementById('edit-koordinator-nik').value = data.nik || '';
    document.getElementById('edit-koordinator-team-id').value = data.team_id || '';
    document.getElementById('edit-koordinator-is-active').checked = data.is_active == 1;
    openModal('edit-koordinator-modal');
}
function closeEditKoordinatorModal() { closeModal('edit-koordinator-modal'); }
function openCreateKoordinatorModal() {
    document.getElementById('create-koordinator-form').reset();
    openModal('create-koordinator-modal');
}
function closeCreateKoordinatorModal() { closeModal('create-koordinator-modal'); }

function showKoordinatorDetail(data) {
    document.getElementById('detail-title').textContent = 'Detail Akun Koordinator';
    renderDetail([
        { label: 'Nama Lengkap', value: data.name },
        { label: 'Username', value: data.username },
        { label: 'NIK', value: data.nik || '—' },
        { label: 'Divisi', value: data.team || '—' },
        { label: 'Status', value: data.is_active, badge: data.is_active == 1 },
    ]);
}

function switchTab(tab) {
    document.getElementById('tab-admin').style.display = tab === 'admin' ? 'block' : 'none';
    document.getElementById('tab-koordinator').style.display = tab === 'koordinator' ? 'block' : 'none';
    document.getElementById('tab-karyawan').style.display = tab === 'karyawan' ? 'block' : 'none';
    document.querySelectorAll('.pill-btn').forEach(function(btn) { btn.classList.remove('active'); });
    var idx = { admin: 0, koordinator: 1, karyawan: 2 }[tab];
    document.querySelectorAll('.pill-btn')[idx].classList.add('active');
}

function openEditKaryawanModal(data) {
    document.getElementById('edit-karyawan-form').action = '/admin/admins/karyawan/' + data.id;
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

function showAdminDetail(data) {
    document.getElementById('detail-title').textContent = 'Detail Akun Admin';
    renderDetail([
        { label: 'Nama Lengkap', value: data.name },
        { label: 'Username', value: data.username },
        { label: 'NIK', value: data.nik || '—' },
        { label: 'Role', value: data.role_label },
        { label: 'Status', value: data.is_active, badge: data.is_active == 1 },
    ]);
}

function showKaryawanDetail(data) {
    document.getElementById('detail-title').textContent = 'Detail Akun Karyawan';
    renderDetail([
        { label: 'Nama Lengkap', value: data.name },
        { label: 'Username', value: data.username },
        { label: 'NIK', value: data.nik || '—' },
        { label: 'Role', value: data.role_label },
        { label: 'Divisi', value: data.team || '—' },
        { label: 'Status', value: data.is_active, badge: data.is_active == 1 },
    ]);
}

function closeDetail() { closeModal('detail-modal'); }
document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditAdminModal(); closeCreateAdminModal();
        closeEditKoordinatorModal(); closeCreateKoordinatorModal();
        closeEditKaryawanModal(); closeCreateKaryawanModal();
        closeUploadNikModal(); closeImportKaryawanModal();
        closeDetail();
    }
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
.pill-btn.active { background:var(--sidebar-active-bg); color:white; box-shadow:0 2px 8px rgba(109,94,249,0.35); }
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection
