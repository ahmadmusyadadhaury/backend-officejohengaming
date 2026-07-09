@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Kelola Akun Koordinator')
@section('page-title', 'Overview > Kelola Akun Koordinator')
@section('page-subtitle', 'Kelola akun koordinator divisi dengan akses TERBATAS (menu Meeting saja).')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <form method="GET" action="{{ route('admin.users.index') }}" id="filter-form">
        <input type="hidden" name="status" id="status-input" value="{{ request('status') }}">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Akun Koordinator</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Kelola akun koordinator divisi dengan akses TERBATAS (menu Meeting saja).</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Koordinator
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
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Divisi</th>
                        <th>Status</th>
@if(auth()->user()->role !== 'gm')<th>Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $users->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $user->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $user->username }}</code></td>
                        <td>
                            <span class="badge badge-primary">{{ $user->role_label }}</span>
                        </td>
                        <td style="color:var(--text-muted);">{{ $user->team?->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
@if(auth()->user()->role !== 'gm')
                        <td>
                            <div class="flex gap-2">
                                <button type="button" onclick="openEditModal({{ json_encode(['id'=>$user->id,'name'=>$user->name,'username'=>$user->username,'role'=>$user->role,'team_id'=>$user->team_id,'is_active'=>$user->is_active]) }})" class="btn btn-secondary btn-sm">Edit</button>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun ini?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
@endif
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun koordinator ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $users->links() }}</div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="modal-modern" onclick="if(event.target===this)closeEditModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Akun Koordinator</h3>
            <button type="button" onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-name" required class="gaming-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" id="edit-username" required class="gaming-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="gaming-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Role</label>
                    <select name="role" id="edit-role" onchange="toggleEditTeam(this.value)" class="gaming-input gaming-select">
                        <option value="koordinator">Koordinator</option>
                        <option value="user">Karyawan</option>
                        <option value="admin_ga">Admin General Affairs</option>
                    </select>
                </div>
                <div id="edit-team-field">
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Tim</label>
                    <select name="team_id" id="edit-team-id" class="gaming-input gaming-select">
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-is-active" style="font-size:0.85rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Create Modal --}}
<div id="create-modal" class="modal-modern" onclick="if(event.target===this)closeCreateModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Koordinator</h3>
            <button type="button" onclick="closeCreateModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-form" method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" required class="gaming-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Password <span style="color:#f87171;">*</span></label>
                    <input type="password" name="password" required class="gaming-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Role <span style="color:#f87171;">*</span></label>
                    <select name="role" id="create-role" required onchange="toggleCreateTeam(this.value)" class="gaming-input gaming-select">
                        <option value="">Pilih Role</option>
                        <option value="koordinator">Koordinator</option>
                        <option value="user">Karyawan</option>
                        <option value="admin_ga">Admin General Affairs</option>
                    </select>
                </div>
                <div id="create-team-field" style="display:none;">
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Tim <span style="color:#f87171;">*</span></label>
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

<script>
var teams = @json($teams->pluck('id', 'name'));

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
    document.getElementById('edit-form').action = '/admin/users/' + data.id;
    document.getElementById('edit-name').value = data.name;
    document.getElementById('edit-username').value = data.username;
    document.getElementById('edit-role').value = data.role;
    document.getElementById('edit-team-id').value = data.team_id || '';
    document.getElementById('edit-is-active').checked = data.is_active == 1;
    toggleEditTeam(data.role);
    openModal('edit-modal');
}
function closeEditModal() {
    closeModal('edit-modal');
}
function toggleEditTeam(role) {
    document.getElementById('edit-team-field').style.display = ['koordinator','user'].includes(role) ? 'block' : 'none';
}
document.getElementById('edit-modal').addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeEditModal(); closeCreateModal(); } });

function openCreateModal() {
    document.getElementById('create-form').reset();
    document.getElementById('create-team-field').style.display = 'none';
    openModal('create-modal');
}
function closeCreateModal() {
    closeModal('create-modal');
}
function toggleCreateTeam(role) {
    document.getElementById('create-team-field').style.display = ['koordinator','user'].includes(role) ? 'block' : 'none';
}
document.getElementById('create-modal').addEventListener('click', function(e) { if (e.target === this) closeCreateModal(); });
</script>
@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection