@extends('layouts.app')
@section('title', 'Kelola Ruangan')
@section('page-title', 'Overview > Kelola Ruangan')
@section('page-subtitle', 'Kelola ruangan dan sumber daya perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <form method="GET" action="{{ route('admin.rooms.index') }}" id="filter-form">
        <input type="hidden" name="status" id="status-input" value="{{ request('status') }}">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Kelola Ruangan</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Kelola ruangan dan sumber daya perusahaan</div>
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Ruangan
            </button>
        </div>
        <div class="px-5 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..."
                    class="w-full pl-9 pr-3 py-2 rounded-lg text-sm"
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
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;bottom:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-bottom:4px;">
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
                        <th>Nama Ruangan</th>
                        <th>Lokasi</th>
                        <th>Kapasitas</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $rooms->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $room->name }}</td>
                        <td style="color:var(--text-muted);">{{ $room->location ?? '—' }}</td>
                        <td>
                            <span class="badge badge-cyan">{{ $room->capacity }} orang</span>
                        </td>
                        <td>
                            @if($room->facilities && count($room->facilities) > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($room->facilities, 0, 3) as $f)
                                        <span class="badge badge-blue" style="font-size:0.65rem;">{{ $f }}</span>
                                    @endforeach
                                    @if(count($room->facilities) > 3)
                                        <span class="badge badge-gray" style="font-size:0.65rem;">+{{ count($room->facilities) - 3 }}</span>
                                    @endif
                                </div>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $room->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $room->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <button type="button" onclick="openEditModal({{ json_encode(['id'=>$room->id,'name'=>$room->name,'capacity'=>$room->capacity,'location'=>$room->location ?? '','facilities'=>is_array($room->facilities) ? implode("\n",$room->facilities) : '','description'=>$room->description ?? '','is_active'=>$room->is_active]) }})" class="btn btn-secondary btn-sm">Edit</button>
                                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Hapus ruangan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada ruangan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $rooms->links() }}</div>
    </div>
</div>

<div id="edit-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100vh;z-index:50;align-items:flex-start;justify-content:center;padding:80px 16px 16px;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
    <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="max-height:88vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Edit Ruangan</h3>
            <button type="button" onclick="closeEditModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="edit-form" method="POST" class="px-6 py-5 space-y-4 overflow-y-auto flex-1">
            @csrf @method('PUT')
            <div>
                <label class="gaming-label">Nama Ruangan <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" id="edit-name" required class="gaming-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="gaming-label">Kapasitas <span style="color:#f87171;">*</span></label>
                    <input type="number" name="capacity" id="edit-capacity" required min="1" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Lokasi <span style="color:#f87171;">*</span></label>
                    <input type="text" name="location" id="edit-location" required class="gaming-input">
                </div>
            </div>
            <div>
                <label class="gaming-label">Fasilitas <span style="color:var(--text-muted);font-weight:400;">(satu per baris)</span></label>
                <textarea name="facilities" id="edit-facilities" rows="4" class="gaming-input" style="resize:vertical;"></textarea>
            </div>
            <div>
                <label class="gaming-label">Deskripsi</label>
                <textarea name="description" id="edit-description" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="edit-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Ruangan Aktif</label>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Create Modal --}}
<div id="create-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100vh;z-index:50;align-items:flex-start;justify-content:center;padding:80px 16px 16px;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
    <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="max-height:88vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Tambah Ruangan</h3>
            <button type="button" onclick="closeCreateModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="create-form" method="POST" action="{{ route('admin.rooms.store') }}" class="px-6 py-5 space-y-4 overflow-y-auto flex-1">
            @csrf
            <div>
                <label class="gaming-label">Nama Ruangan <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" required class="gaming-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="gaming-label">Kapasitas <span style="color:#f87171;">*</span></label>
                    <input type="number" name="capacity" required min="1" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Lokasi <span style="color:#f87171;">*</span></label>
                    <input type="text" name="location" required class="gaming-input">
                </div>
            </div>
            <div>
                <label class="gaming-label">Fasilitas <span style="color:var(--text-muted);font-weight:400;">(satu per baris)</span></label>
                <textarea name="facilities" rows="4" class="gaming-input" style="resize:vertical;"></textarea>
            </div>
            <div>
                <label class="gaming-label">Deskripsi</label>
                <textarea name="description" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Buat Ruangan</button>
                <button type="button" onclick="closeCreateModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
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
document.addEventListener('click', function(e) {
    var menu = document.getElementById('filter-menu');
    if (menu && !e.target.closest('.filter-dropdown-wrap')) {
        menu.style.display = 'none';
    }
});

function openEditModal(data) {
    document.getElementById('edit-form').action = '/admin/rooms/' + data.id;
    document.getElementById('edit-name').value = data.name;
    document.getElementById('edit-capacity').value = data.capacity;
    document.getElementById('edit-location').value = data.location;
    document.getElementById('edit-facilities').value = data.facilities;
    document.getElementById('edit-description').value = data.description;
    document.getElementById('edit-is-active').checked = data.is_active == 1;
    document.getElementById('edit-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('edit-modal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('edit-modal').addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeEditModal(); closeCreateModal(); } });

function openCreateModal() {
    document.getElementById('create-form').reset();
    document.getElementById('create-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeCreateModal() {
    document.getElementById('create-modal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('create-modal').addEventListener('click', function(e) { if (e.target === this) closeCreateModal(); });
</script>
@endsection