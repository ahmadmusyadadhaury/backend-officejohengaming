@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Kelola Ruangan')
@section('page-title', 'Overview > Kelola Ruangan')
@section('page-subtitle', 'Kelola ruangan dan aset meeting')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="pill-switcher">
        <button type="button" class="pill-btn active" onclick="switchTab('rooms')">Kelola Ruangan</button>
        <button type="button" class="pill-btn" onclick="switchTab('assets')">Kelola Aset Meeting</button>
    </div>

    {{-- ═══════════════════ TAB KELOLA RUANGAN ═══════════════════ --}}
    <div id="tab-rooms">
    <div class="gaming-card" style="overflow:visible;">
        <form method="GET" action="{{ route('admin.rooms.index') }}" id="filter-form">
        <input type="hidden" name="status" id="status-input" value="{{ request('status') }}">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Ruangan</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Kelola ruangan dan sumber daya perusahaan</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openRoomCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Ruangan
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
                <button type="button" onclick="toggleRoomFilter(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="room-filter-label">{{ request('status') === 'active' ? 'Aktif' : (request('status') === 'inactive' ? 'Nonaktif' : 'Semua Status') }}</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="room-filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" onclick="setRoomFilter('')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" onclick="setRoomFilter('active')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" onclick="setRoomFilter('inactive')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Nonaktif</button>
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
                        <th>Divisi</th>
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
                        <td>
                            @if($room->team)
                                <span class="badge badge-primary">{{ $room->team->name }}</span>
                            @else
                                <span style="color:var(--text-muted);">Umum</span>
                            @endif
                        </td>
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
                            <div class="flex flex-wrap items-center gap-1">
                                <span class="badge {{ $room->is_active ? 'badge-green' : 'badge-red' }}">
                                    {{ $room->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if($room->is_weekly_only)
                                    <span class="badge badge-purple" style="font-size:0.65rem;">Weekly Only</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $roomDetail = json_encode([
                                    'id'=>$room->id,
                                    'name'=>$room->name,
                                    'capacity'=>$room->capacity,
                                    'location'=>$room->location ?? '',
                                    'facilities'=>is_array($room->facilities) ? implode("\n", $room->facilities) : '',
                                    'facilities_list'=>is_array($room->facilities) ? array_values($room->facilities) : [],
                                    'description'=>$room->description ?? '',
                                    'is_active'=>$room->is_active,
                                    'is_weekly_only'=>$room->is_weekly_only,
                                    'team_id'=>$room->team_id,
                                    'team'=>$room->team?->name ?? '',
                                ]);
                            @endphp
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showRoomDetail({{ $roomDetail }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, 'room-{{ $room->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-room-{{ $room->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showRoomDetail({{ $roomDetail }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        @if(!in_array(auth()->user()->role, ['gm', 'ceo']))
                                        <button type="button" onclick="openRoomEditModal({{ $roomDetail }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus ruangan ini?" style="margin:0;">
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
                    <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada ruangan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $rooms->links() }}</div>
    </div>
    </div>

    {{-- ═══════════════════ TAB KELOLA ASET MEETING ═══════════════════ --}}
    <div id="tab-assets" style="display:none;">
    <div class="gaming-card" style="overflow:visible;">
        <form method="GET" action="{{ route('admin.rooms.index') }}" id="asset-filter-form">
        <input type="hidden" name="asset_status" id="asset-status-input" value="{{ request('asset_status') }}">
        <input type="hidden" name="tab" value="assets">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Aset Meeting</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Inventaris perlengkapan pendukung meeting.</div>
            </div>
@if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openAssetCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset
            </button>
@endif
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="asset_search" value="{{ request('asset_search') }}" placeholder="Cari..."
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleAssetFilter(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="asset-filter-label">{{ request('asset_status') === 'active' ? 'Aktif' : (request('asset_status') === 'inactive' ? 'Nonaktif' : 'Semua Status') }}</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="asset-filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" onclick="setAssetFilter('')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" onclick="setAssetFilter('active')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" onclick="setAssetFilter('inactive')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Nonaktif</button>
                </div>
            </div>
        </div>
        </form>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[600px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th>Status</th>
<th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $assets->firstItem() + $loop->index }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $asset->name }}</td>
                        <td style="color:var(--text-muted);">{{ $asset->description ?? '—' }}</td>
                        <td>
                            <span class="badge badge-cyan">{{ $asset->quantity }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $asset->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $asset->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            @php $assetDetail = json_encode(['id'=>$asset->id,'name'=>$asset->name,'description'=>$asset->description ?? '','quantity'=>$asset->quantity,'is_active'=>$asset->is_active]); @endphp
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showAssetDetail({{ $assetDetail }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, 'asset-{{ $asset->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-asset-{{ $asset->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showAssetDetail({{ $assetDetail }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        @if(!in_array(auth()->user()->role, ['gm', 'ceo']))
                                        <button type="button" onclick="openAssetEditModal({{ $assetDetail }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset ini?" style="margin:0;">
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
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada aset ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $assets->links() }}</div>
    </div>
    </div>
</div>

{{-- ═══════════════════ ROOM MODALS ═══════════════════ --}}
<div id="room-edit-modal" class="modal-modern" onclick="if(event.target===this)closeRoomEditModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Ruangan</h3>
            <button type="button" onclick="closeRoomEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="room-edit-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Ruangan <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="room-edit-name" required class="gaming-input">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="gaming-label">Kapasitas <span style="color:#f87171;">*</span></label>
                        <input type="number" name="capacity" id="room-edit-capacity" required min="1" class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Lokasi <span style="color:#f87171;">*</span></label>
                        <input type="text" name="location" id="room-edit-location" required class="gaming-input">
                    </div>
                </div>
                <div>
                    <label class="gaming-label">Fasilitas <span style="color:var(--text-muted);font-weight:400;">(satu per baris)</span></label>
                    <textarea name="facilities" id="room-edit-facilities" rows="4" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Deskripsi</label>
                    <textarea name="description" id="room-edit-description" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Khusus Divisi</label>
                    <select name="team_id" id="room-edit-team-id" class="gaming-input gaming-select">
                        <option value="">— Umum (Semua Akses) —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="room-edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="room-edit-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Ruangan Aktif</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_weekly_only" id="room-edit-is-weekly-only" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="room-edit-is-weekly-only" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Khusus Weekly Meeting</label>
                </div>
                <p class="text-xs -mt-1" style="color:var(--text-muted);">Ruangan ini hanya boleh dipakai untuk kegiatan weekly meeting, tidak bisa dipesan untuk meeting biasa.</p>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" onclick="closeRoomEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="room-create-modal" class="modal-modern" onclick="if(event.target===this)closeRoomCreateModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Ruangan</h3>
            <button type="button" onclick="closeRoomCreateModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="room-create-form" method="POST" action="{{ route('admin.rooms.store') }}">
            @csrf
            <div class="modal-modern-body space-y-4">
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
                <div>
                    <label class="gaming-label">Khusus Divisi</label>
                    <select name="team_id" class="gaming-input gaming-select">
                        <option value="">— Umum (Semua Akses) —</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_weekly_only" id="room-create-is-weekly-only" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="room-create-is-weekly-only" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Khusus Weekly Meeting</label>
                </div>
                <p class="text-xs -mt-1" style="color:var(--text-muted);">Ruangan ini hanya boleh dipakai untuk kegiatan weekly meeting, tidak bisa dipesan untuk meeting biasa.</p>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Ruangan</button>
                <button type="button" onclick="closeRoomCreateModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="room-detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="room-detail-title">Detail Ruangan</h3>
            <button type="button" onclick="closeRoomDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="room-detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex justify-between items-center" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeRoomDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>

{{-- ═══════════════════ ASSET MODALS ═══════════════════ --}}
<div id="asset-edit-modal" class="modal-modern" onclick="if(event.target===this)closeAssetEditModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Aset</h3>
            <button type="button" onclick="closeAssetEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="asset-edit-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Aset <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="asset-edit-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Deskripsi</label>
                    <textarea name="description" id="asset-edit-description" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Jumlah <span style="color:#f87171;">*</span></label>
                    <input type="number" name="quantity" id="asset-edit-quantity" required min="1" class="gaming-input">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="asset-edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="asset-edit-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Aset Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" onclick="closeAssetEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="asset-create-modal" class="modal-modern" onclick="if(event.target===this)closeAssetCreateModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Aset</h3>
            <button type="button" onclick="closeAssetCreateModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="asset-create-form" method="POST" action="{{ route('admin.assets.store') }}">
            @csrf
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Aset <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Deskripsi</label>
                    <textarea name="description" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Jumlah <span style="color:#f87171;">*</span></label>
                    <input type="number" name="quantity" required min="1" class="gaming-input">
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Aset</button>
                <button type="button" onclick="closeAssetCreateModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="asset-detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="asset-detail-title">Detail Aset Meeting</h3>
            <button type="button" onclick="closeAssetDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="asset-detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex justify-between items-center" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeAssetDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    document.getElementById('tab-rooms').style.display = tab === 'rooms' ? '' : 'none';
    document.getElementById('tab-assets').style.display = tab === 'assets' ? '' : 'none';
    document.querySelectorAll('.pill-btn').forEach(function(btn) { btn.classList.remove('active'); });
    document.querySelectorAll('.pill-btn').forEach(function(btn) {
        if ((tab === 'rooms' && btn.textContent.trim() === 'Kelola Ruangan') || (tab === 'assets' && btn.textContent.trim() === 'Kelola Aset Meeting')) {
            btn.classList.add('active');
        }
    });
    if (tab === 'assets') {
        history.replaceState(null, '', '{{ route("admin.rooms.index") }}?tab=assets');
    } else {
        history.replaceState(null, '', '{{ route("admin.rooms.index") }}');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    var params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'assets') switchTab('assets');
});

// ── Room Filter ──
function toggleRoomFilter(e) {
    e.stopPropagation();
    var menu = document.getElementById('room-filter-menu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function setRoomFilter(value) {
    document.getElementById('status-input').value = value;
    document.getElementById('room-filter-menu').style.display = 'none';
    document.getElementById('filter-form').submit();
}

// ── Asset Filter ──
function toggleAssetFilter(e) {
    e.stopPropagation();
    var menu = document.getElementById('asset-filter-menu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function setAssetFilter(value) {
    document.getElementById('asset-status-input').value = value;
    document.getElementById('asset-filter-menu').style.display = 'none';
    document.getElementById('asset-filter-form').submit();
}

document.addEventListener('click', function(e) {
    ['room-filter-menu', 'asset-filter-menu'].forEach(function(id) {
        var menu = document.getElementById(id);
        if (menu && !e.target.closest('.filter-dropdown-wrap')) {
            menu.style.display = 'none';
        }
    });
});

// ── Shared Dropdown ──
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

// ── Shared Helpers ──
function escHtml(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function(ch) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch];
    });
}
function renderDetailRows(modalId, titleId, bodyId, rows) {
    const html = rows.map(function(r, i) {
        const border = i < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : '';
        if (r.badge !== undefined) {
            const active = r.badge;
            return '<div class="flex items-center justify-between py-2.5" ' + border + '><p class="text-sm" style="color:var(--text-muted);">' + r.label + '</p><span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:' + (active ? '#ecfdf5' : '#fef2f2') + ';color:' + (active ? '#059669' : '#dc2626') + ';border:1px solid ' + (active ? '#a7f3d0' : '#fecaca') + ';">' + (active ? 'Aktif' : 'Nonaktif') + '</span></div>';
        }
        if (r.html) {
            return '<div class="flex items-center justify-between py-2.5" ' + border + '><p class="text-sm" style="color:var(--text-muted);">' + r.label + '</p><div class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">' + r.html + '</div></div>';
        }
        return '<div class="flex items-center justify-between py-2.5" ' + border + '><p class="text-sm" style="color:var(--text-muted);">' + r.label + '</p><p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">' + escHtml(r.value) + '</p></div>';
    }).join('');
    document.getElementById(bodyId).innerHTML = '<div class="space-y-1">' + html + '</div>';
    document.getElementById(modalId).style.display = 'flex';
    document.body.classList.add('modal-open');
}
function closeModalById(id) {
    var el = document.getElementById(id);
    if (el) { el.style.display = 'none'; document.body.classList.remove('modal-open'); }
}

// ── Room CRUD ──
function openRoomEditModal(data) {
    document.getElementById('room-edit-form').action = '/admin/rooms/' + data.id;
    document.getElementById('room-edit-name').value = data.name;
    document.getElementById('room-edit-capacity').value = data.capacity;
    document.getElementById('room-edit-location').value = data.location;
    document.getElementById('room-edit-facilities').value = data.facilities;
    document.getElementById('room-edit-description').value = data.description;
    document.getElementById('room-edit-is-active').checked = data.is_active == 1;
    document.getElementById('room-edit-is-weekly-only').checked = data.is_weekly_only == 1;
    document.getElementById('room-edit-team-id').value = data.team_id || '';
    document.getElementById('room-edit-modal').classList.add('active');
    document.body.classList.add('modal-open');
}
function closeRoomEditModal() {
    document.getElementById('room-edit-modal').classList.remove('active');
    document.body.classList.remove('modal-open');
}
document.getElementById('room-edit-modal')?.addEventListener('click', function(e) { if (e.target === this) closeRoomEditModal(); });

function openRoomCreateModal() {
    document.getElementById('room-create-form').reset();
    document.getElementById('room-create-modal').classList.add('active');
    document.body.classList.add('modal-open');
}
function closeRoomCreateModal() {
    document.getElementById('room-create-modal').classList.remove('active');
    document.body.classList.remove('modal-open');
}
document.getElementById('room-create-modal')?.addEventListener('click', function(e) { if (e.target === this) closeRoomCreateModal(); });

function showRoomDetail(data) {
    document.getElementById('room-detail-title').textContent = 'Detail Ruangan';
    const facilities = (data.facilities_list || []).filter(Boolean);
    const facHtml = facilities.length
        ? facilities.map(function(f) { return '<span class="badge badge-blue" style="font-size:0.65rem;margin:2px;">' + escHtml(f) + '</span>'; }).join('')
        : '—';
    renderDetailRows('room-detail-modal', 'room-detail-title', 'room-detail-body', [
        { label: 'Nama Ruangan', value: data.name },
        { label: 'Divisi', value: data.team || 'Umum' },
        { label: 'Lokasi', value: data.location || '—' },
        { label: 'Kapasitas', value: data.capacity + ' orang' },
        { label: 'Fasilitas', html: facHtml },
        { label: 'Deskripsi', value: data.description || '—' },
        { label: 'Khusus Weekly Meeting', value: data.is_weekly_only == 1 ? 'Ya' : 'Tidak' },
        { label: 'Status', value: data.is_active, badge: data.is_active == 1 },
    ]);
}
function closeRoomDetail() { closeModalById('room-detail-modal'); }
document.getElementById('room-detail-modal')?.addEventListener('click', function(e) { if (e.target === this) closeRoomDetail(); });

// ── Asset CRUD ──
function openAssetEditModal(data) {
    document.getElementById('asset-edit-form').action = '/admin/assets/' + data.id;
    document.getElementById('asset-edit-name').value = data.name;
    document.getElementById('asset-edit-description').value = data.description;
    document.getElementById('asset-edit-quantity').value = data.quantity;
    document.getElementById('asset-edit-is-active').checked = data.is_active == 1;
    document.getElementById('asset-edit-modal').classList.add('active');
    document.body.classList.add('modal-open');
}
function closeAssetEditModal() {
    document.getElementById('asset-edit-modal').classList.remove('active');
    document.body.classList.remove('modal-open');
}
document.getElementById('asset-edit-modal')?.addEventListener('click', function(e) { if (e.target === this) closeAssetEditModal(); });

function openAssetCreateModal() {
    document.getElementById('asset-create-form').reset();
    document.getElementById('asset-create-modal').classList.add('active');
    document.body.classList.add('modal-open');
}
function closeAssetCreateModal() {
    document.getElementById('asset-create-modal').classList.remove('active');
    document.body.classList.remove('modal-open');
}
document.getElementById('asset-create-modal')?.addEventListener('click', function(e) { if (e.target === this) closeAssetCreateModal(); });

function showAssetDetail(data) {
    document.getElementById('asset-detail-title').textContent = 'Detail Aset Meeting';
    renderDetailRows('asset-detail-modal', 'asset-detail-title', 'asset-detail-body', [
        { label: 'Nama Aset', value: data.name },
        { label: 'Deskripsi', value: data.description || '—' },
        { label: 'Jumlah', value: data.quantity },
        { label: 'Status', value: data.is_active, badge: data.is_active == 1 },
    ]);
}
function closeAssetDetail() { closeModalById('asset-detail-modal'); }
document.getElementById('asset-detail-modal')?.addEventListener('click', function(e) { if (e.target === this) closeAssetDetail(); });

// ── Escape Key ──
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRoomEditModal(); closeRoomCreateModal(); closeRoomDetail();
        closeAssetEditModal(); closeAssetCreateModal(); closeAssetDetail();
    }
});
</script>
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
