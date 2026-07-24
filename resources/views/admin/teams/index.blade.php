@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Kelola Tim')
@section('page-title', 'Overview > Kelola Tim')
@section('page-subtitle', 'Organisir tim dan departemen perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <form method="GET" action="{{ route('admin.teams.index') }}" id="filter-form">
        <input type="hidden" name="status" id="status-input" value="{{ request('status') }}">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Tim</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Organisir tim dan departemen perusahaan</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <div class="flex items-center gap-2">
                <button type="button" onclick="openAddMemberModal()" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Tambah Anggota
                </button>
                <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Tim
                </button>
            </div>
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
                        <th>Nama Tim</th>
                        <th>Deskripsi</th>
                        <th>Anggota</th>
                        <th>Kepala Tim</th>
                        <th>Status</th>
@if(auth()->user()->role !== 'gm')<th>Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $teams->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $team->name }}</td>
                        <td style="color:var(--text-muted);max-width:250px;word-wrap:break-word;white-space:normal;text-align:justify;">{{ $team->description ?? '—' }}</td>
                        <td>
                            <span class="badge badge-blue">{{ $team->members_count }} orang</span>
                        </td>
                        <td style="color:var(--text-muted);">{{ $team->leader?->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $team->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $team->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
@if(auth()->user()->role !== 'gm')
                        <td>
                            <div class="flex items-center gap-1" style="white-space:nowrap;">
                                <button type="button" onclick="showDetail({{ $team->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $team->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $team->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $team->id }})" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:var(--text-secondary);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </button>
                                        <button type="button" onclick="openEditModal({{ json_encode(['id'=>$team->id,'name'=>$team->name,'description'=>$team->description ?? '','is_active'=>$team->is_active]) }})" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:var(--text-secondary);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.teams.destroy', $team) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus tim ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:#f87171;background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
@endif
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada tim ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $teams->links() }}</div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="modal-modern" onclick="if(event.target===this)closeEditModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Tim</h3>
            <button type="button" onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Tim <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Deskripsi</label>
                    <textarea name="description" id="edit-description" rows="3" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Tim Aktif</label>
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
            <h3>Tambah Tim</h3>
            <button type="button" onclick="closeCreateModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-form" method="POST" action="{{ route('admin.teams.store') }}">
            @csrf
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Tim <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Deskripsi</label>
                    <textarea name="description" rows="3" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="create-is-active" value="1" checked style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="create-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Tim Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Tim</button>
                <button type="button" onclick="closeCreateModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Tambah Anggota Modal --}}
<div id="add-member-modal" class="modal-modern" onclick="if(event.target===this)closeAddMemberModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Anggota ke Tim</h3>
            <button type="button" onclick="closeAddMemberModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="add-member-form" method="POST" action="{{ route('admin.teams.members.store', '_TEAM_') }}" onsubmit="return fixMemberAction(this);">
            @csrf
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Pilih Tim <span style="color:#f87171;">*</span></label>
                    <select name="" id="member-team-select" required class="gaming-input" style="width:100%;">
                        <option value="">— Pilih Tim —</option>
                        @foreach($allTeams as $tid => $tname)
                            <option value="{{ $tid }}">{{ $tname }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="gaming-label">Pilih Anggota <span style="color:#f87171;">*</span></label>
                    @if($availableUsers->isEmpty())
                        <p class="text-xs" style="color:var(--text-muted);">Tidak ada user tersedia yang bisa ditambahkan.</p>
                    @else
                        <select name="user_id" id="member-user-select" required class="gaming-input" style="width:100%;">
                            <option value="">— Pilih User —</option>
                            @foreach($availableUsers as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->username }}) — {{ $u->role_label }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div id="member-preview" class="hidden">
                    <div class="flex items-center gap-3 p-3 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                            id="member-preview-avatar"
                            style="background:linear-gradient(135deg,var(--color-accent),var(--color-secondary));"></div>
                        <div>
                            <p id="member-preview-name" class="text-sm font-semibold" style="color:var(--text-primary);"></p>
                            <p id="member-preview-role" class="text-xs" style="color:var(--text-muted);"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary" id="member-submit-btn" @if($availableUsers->isEmpty()) disabled @endif>Tambahkan</button>
                <button type="button" onclick="closeAddMemberModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Detail Tim Modal --}}
<div id="detail-modal" class="modal-modern" onclick="if(event.target===this)closeDetailModal()">
    <div class="modal-modern-panel lg" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="detail-title">Detail Tim</h3>
            <button type="button" onclick="closeDetailModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body space-y-4" id="detail-body">
            <div class="text-center py-6" id="detail-loading">
                <p class="text-sm" style="color:var(--text-muted);">Memuat data...</p>
            </div>
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

function toggleDropdown(btn, id) {
    var all = document.querySelectorAll('.dropdown-menu');
    all.forEach(function(el) { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    var menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    var filterWrap = document.querySelector('.filter-dropdown-wrap');
    if (filterWrap && !e.target.closest('.filter-dropdown-wrap')) {
        var fm = document.getElementById('filter-menu');
        if (fm) fm.style.display = 'none';
    }
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(function(el) { el.style.display = 'none'; });
    }
});

function openEditModal(data) {
    document.getElementById('edit-form').action = '/admin/teams/' + data.id;
    document.getElementById('edit-name').value = data.name;
    document.getElementById('edit-description').value = data.description;
    document.getElementById('edit-is-active').checked = data.is_active == 1;
    openModal('edit-modal');
}
function closeEditModal() {
    closeModal('edit-modal');
}
document.getElementById('edit-modal').addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeEditModal(); closeCreateModal(); closeAddMemberModal(); closeDetailModal(); } });

function openCreateModal() {
    document.getElementById('create-form').reset();
    var cb = document.getElementById('create-is-active');
    if (cb) cb.checked = true;
    openModal('create-modal');
}
function closeCreateModal() {
    closeModal('create-modal');
}
document.getElementById('create-modal').addEventListener('click', function(e) { if (e.target === this) closeCreateModal(); });

var usersData = @json($availableUsersJson);
var csrfToken = '{{ csrf_token() }}';

function fixMemberAction(form) {
    var teamId = document.getElementById('member-team-select').value;
    if (!teamId) return false;
    form.action = form.action.replace('_TEAM_', teamId);
    return true;
}

function openAddMemberModal() {
    var form = document.getElementById('add-member-form');
    form.action = '{{ route("admin.teams.members.store", "_TEAM_") }}';
    var ts = document.getElementById('member-team-select');
    var us = document.getElementById('member-user-select');
    if (ts) ts.value = '';
    if (us) { us.value = ''; us.dispatchEvent(new Event('change')); }
    document.getElementById('member-preview').classList.add('hidden');
    openModal('add-member-modal');
}
function closeAddMemberModal() {
    closeModal('add-member-modal');
}

var isGm = {{ auth()->user()->role === 'gm' ? 'true' : 'false' }};

function showDetail(teamId) {
    document.getElementById('detail-title').textContent = 'Detail Tim';
    document.getElementById('detail-body').innerHTML = '<div class="text-center py-6"><p class="text-sm" style="color:var(--text-muted);">Memuat data...</p></div>';
    openModal('detail-modal');

    fetch('/admin/teams/' + teamId, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var t = data.team;
            var members = data.members;
            var users = data.available_users;
            var addUrl = data.routes.add_member;
            var removeBase = data.routes.remove_member;

            var statusBadge = t.is_active
                ? '<span class="badge badge-green">Aktif</span>'
                : '<span class="badge badge-red">Nonaktif</span>';

            var html = '';
            html += '<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">';
            html += '<div><p class="text-xs mb-1" style="color:var(--text-muted);">Nama Tim</p><p class="text-sm font-semibold" style="color:var(--text-primary);">' + escHtml(t.name) + '</p></div>';
            html += '<div><p class="text-xs mb-1" style="color:var(--text-muted);">Status</p>' + statusBadge + '</div>';
            html += '<div><p class="text-xs mb-1" style="color:var(--text-muted);">Deskripsi</p><p class="text-sm" style="color:var(--text-primary);">' + escHtml(t.description || '—') + '</p></div>';
            html += '<div><p class="text-xs mb-1" style="color:var(--text-muted);">Kepala Tim</p><p class="text-sm" style="color:var(--text-primary);">' + escHtml(t.leader ? t.leader.name : '—') + '</p></div>';
            html += '</div>';

            html += '<div style="border-top:1px solid var(--border-color);padding-top:1rem;">';
            html += '<div class="flex items-center justify-between mb-3">';
            html += '<p class="font-gaming font-semibold text-xs" style="color:var(--text-primary);letter-spacing:0.05em;">ANGGOTA TIM (' + members.length + ')</p>';
            if (!isGm && users.length > 0) {
                html += '<button type="button" onclick="showInlineAddMember(' + teamId + ')" class="btn btn-primary btn-sm" style="padding:3px 8px;font-size:0.7rem;">+ Tambah</button>';
            }
            html += '</div>';

            html += '<div id="inline-add-form" class="hidden mb-3 p-3 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">';
            html += '<div class="flex items-center gap-2">';
            html += '<select id="inline-add-user" class="gaming-input" style="flex:1;padding:6px 10px;font-size:0.75rem;">';
            html += '<option value="">— Pilih User —</option>';
            for (var i = 0; i < users.length; i++) {
                html += '<option value="' + users[i].id + '">' + escHtml(users[i].name) + ' (' + escHtml(users[i].username) + ') — ' + escHtml(users[i].role) + '</option>';
            }
            html += '</select>';
            html += '<button type="button" onclick="submitInlineAdd(' + teamId + ')" class="btn btn-primary btn-sm" style="padding:6px 12px;font-size:0.7rem;">Tambah</button>';
            html += '<button type="button" onclick="document.getElementById(\'inline-add-form\').classList.add(\'hidden\')" class="btn btn-secondary btn-sm" style="padding:6px 12px;font-size:0.7rem;">Batal</button>';
            html += '</div></div>';

            if (members.length === 0) {
                html += '<p class="text-xs text-center py-4" style="color:var(--text-muted);">Belum ada anggota di tim ini.</p>';
            } else {
                html += '<div style="max-height:260px;overflow-y:auto;">';
                for (var j = 0; j < members.length; j++) {
                    var m = members[j];
                    var avatarHtml = m.avatar_url
                        ? '<img src="' + m.avatar_url + '" class="w-7 h-7 rounded-full object-cover flex-shrink-0">'
                        : '<span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0" style="background:linear-gradient(135deg,var(--color-accent),var(--color-secondary));">' + escHtml(m.initial) + '</span>';
                    var roleBadge = m.role_key === 'koordinator' ? 'badge-purple' : 'badge-blue';
                    var removeBtn = isGm ? '' : '<button type="button" onclick="confirmRemoveMember(' + teamId + ',' + m.id + ',\'' + escHtml(m.name).replace(/'/g, "\\'") + '\')" class="btn btn-danger btn-sm" style="padding:3px 8px;font-size:0.65rem;">Keluarkan</button>';

                    html += '<div class="flex items-center justify-between py-2" style="border-bottom:1px solid var(--border-color);">';
                    html += '<div class="flex items-center gap-2">' + avatarHtml + '<div><p class="text-sm font-medium" style="color:var(--text-primary);">' + escHtml(m.name) + '</p><p class="text-xs" style="color:var(--text-muted);">@' + escHtml(m.username) + '</p></div></div>';
                    html += '<div class="flex items-center gap-2"><span class="badge ' + roleBadge + '" style="font-size:0.6rem;">' + escHtml(m.role) + '</span>' + removeBtn + '</div>';
                    html += '</div>';
                }
                html += '</div>';
            }
            html += '</div>';

            document.getElementById('detail-title').textContent = 'Detail Tim — ' + t.name;
            document.getElementById('detail-body').innerHTML = html;
        })
        .catch(function() {
            document.getElementById('detail-body').innerHTML = '<div class="text-center py-6"><p class="text-sm" style="color:#f87171;">Gagal memuat data tim.</p></div>';
        });
}

function escHtml(str) {
    var div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function showInlineAddMember(teamId) {
    document.getElementById('inline-add-form').classList.remove('hidden');
    document.getElementById('inline-add-user').value = '';
}

function submitInlineAdd(teamId) {
    var sel = document.getElementById('inline-add-user');
    var userId = sel.value;
    if (!userId) return;

    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '/admin/teams/' + teamId + '/members';
    form.innerHTML = '<input type="hidden" name="_token" value="' + csrfToken + '"><input type="hidden" name="user_id" value="' + userId + '">';
    document.body.appendChild(form);
    form.submit();
}

function closeDetailModal() {
    closeModal('detail-modal');
}

function confirmRemoveMember(teamId, userId, userName) {
    if (confirm('Keluarkan ' + userName + ' dari tim ini?')) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/teams/' + teamId + '/members/' + userId;
        form.innerHTML = '<input type="hidden" name="_token" value="' + csrfToken + '"><input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) { if (e.target === this) closeDetailModal(); });

document.getElementById('add-member-modal')?.addEventListener('click', function(e) { if (e.target === this) closeAddMemberModal(); });

var memberSel = document.getElementById('member-user-select');
if (memberSel) {
    memberSel.addEventListener('change', function() {
        var info = document.getElementById('member-preview');
        var u = usersData.find(function(i) { return i.id == memberSel.value; });
        if (u) {
            document.getElementById('member-preview-avatar').textContent = u.initial;
            document.getElementById('member-preview-name').textContent = u.name;
            document.getElementById('member-preview-role').textContent = u.role;
            info.classList.remove('hidden');
        } else {
            info.classList.add('hidden');
        }
    });
}
</script>
@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection