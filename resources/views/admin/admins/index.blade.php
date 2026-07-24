@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Kelola Akun')
@section('page-title', 'Overview > Kelola Akun')
@section('page-subtitle', 'Kelola akun admin, koordinator, dan karyawan.')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- ═══════════════════ TABEL ADMIN ═══════════════════ --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Admin</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Akun dengan akses PENUH ke seluruh menu sistem.</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openCreateAdminModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Admin
            </button>
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
                        <th>Role</th>
                        <th>Status</th>
@if(auth()->user()->role !== 'gm')<th>Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $admins->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $admin->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $admin->username }}</code></td>
                        <td>
                            @php
                                $roleClass = match($admin->role) {
                                    'admin'         => 'badge-primary',
                                    'head_of_store' => 'badge-blue',
                                    'gm'            => 'badge-cyan',
                                    'ceo'           => 'badge-primary',
                                    'hr'            => 'badge-green',
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
@if(auth()->user()->role !== 'gm')
                        <td>
                            @if($admin->id !== auth()->id())
                                <div class="flex gap-2">
                                    <button type="button" onclick="openEditAdminModal({{ json_encode(['id'=>$admin->id,'name'=>$admin->name,'username'=>$admin->username,'role'=>$admin->role,'is_active'=>$admin->is_active]) }})" class="btn btn-secondary btn-sm">Edit</button>
                                    <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun admin ini?">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            @else
                                <span class="badge badge-gray">Akun kamu</span>
                            @endif
                        </td>
@endif
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun admin ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $admins->links() }}</div>
    </div>

    {{-- ═══════════════════ TABEL KARYAWAN ═══════════════════ --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Karyawan</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Akun karyawan biasa dengan akses terbatas.</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openCreateKaryawanModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Karyawan
            </button>
@endif
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Divisi</th>
                        <th>Status</th>
@if(auth()->user()->role !== 'gm')<th>Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $karyawan)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $karyawans->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $karyawan->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $karyawan->username }}</code></td>
                        <td style="color:var(--text-muted);">{{ $karyawan->team?->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $karyawan->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $karyawan->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
@if(auth()->user()->role !== 'gm')
                        <td>
                            <div class="flex gap-2">
                                <button type="button" onclick="openEditKaryawanModal({{ json_encode(['id'=>$karyawan->id,'name'=>$karyawan->name,'username'=>$karyawan->username,'team_id'=>$karyawan->team_id,'is_active'=>$karyawan->is_active]) }})" class="btn btn-secondary btn-sm">Edit</button>
                                <form method="POST" action="{{ route('admin.admins.karyawan.destroy', $karyawan) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun karyawan ini?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
@endif
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun karyawan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $karyawans->links() }}</div>
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

function openEditKaryawanModal(data) {
    document.getElementById('edit-karyawan-form').action = '/admin/admins/karyawan/' + data.id;
    document.getElementById('edit-karyawan-name').value = data.name;
    document.getElementById('edit-karyawan-username').value = data.username;
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

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditAdminModal(); closeCreateAdminModal();
        closeEditKaryawanModal(); closeCreateKaryawanModal();
    }
});
</script>
@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection
