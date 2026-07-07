@extends('layouts.app')
@section('title', 'Aset TIM Saya')
@section('page-title', 'Operasional > Aset TIM')
@section('page-subtitle', 'Daftar aset tim yang menjadi tanggung jawab saya')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.12);">
                <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xl font-bold" style="color:var(--text-primary);">{{ $assets->count() }}</div>
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Total Aset</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(16,185,129,0.12);">
                <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xl font-bold" style="color:#34d399;">{{ $assets->where('is_active', true)->count() }}</div>
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Aktif</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(239,68,68,0.12);">
                <svg class="w-[18px] h-[18px]" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xl font-bold" style="color:#f87171;">{{ $assets->where('is_active', false)->count() }}</div>
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Tidak Aktif</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Aset TIM</div>
                <div style="font-size:0.7rem;margin-top:2px;color:var(--text-muted);">Daftar aset tim yang menjadi tanggung jawab anda.</div>
            </div>
            <button type="button" onclick="openAddModal()" class="btn btn-primary btn-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset TIM
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[800px]">
                <colgroup>
                    <col style="width:44px">
                    <col>
                    <col style="width:100px">
                    <col style="width:140px">
                    <col style="width:100px">
                    <col style="width:150px">
                </colgroup>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Jenis Aset</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $a)
                    <tr>
                        <td style="color:var(--text-muted);font-size:0.8rem;">{{ $loop->iteration }}</td>
                        <td><span class="font-medium" style="color:var(--text-primary);font-size:0.8rem;">{{ $a->nama_aset }}</span></td>
                        <td><span class="badge badge-cyan" style="font-size:0.65rem;">Aset TIM</span></td>
                        <td><span style="color:var(--text-secondary);font-size:0.8rem;">{{ $a->keterangan ? Str::limit($a->keterangan, 40) : '-' }}</span></td>
                        <td><span style="color:var(--text-secondary);font-size:0.8rem;">{{ $a->jumlah }}</span></td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button onclick='openDetailModal(@json($a))' class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.65rem;">Detail</button>
                                <button onclick='openEditModal(@json($a))' class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.65rem;">Edit</button>
                                <form method="POST" action="{{ route('koordinator.aset-tim.destroy', $a) }}" onsubmit="return confirm('Hapus aset ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.65rem;color:#ef4444;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2.5rem;color:var(--text-muted);font-size:0.9rem;">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>Belum ada aset tim yang ditugaskan.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="addModal" class="fixed inset-0 z-50 hidden" style="background:rgba(0,0,0,0.5);" onclick="if(event.target===this)closeAddModal()">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="gaming-card w-full max-w-md p-6" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold" style="color:var(--text-primary);">Tambah Aset TIM</h3>
                <button onclick="closeAddModal()" class="btn btn-secondary btn-sm" style="font-size:1.2rem;padding:2px 8px;">&times;</button>
            </div>
            <form method="POST" action="{{ route('koordinator.aset-tim.store') }}">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Nama Aset <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="nama_aset" required class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;" placeholder="Nama aset">
                    </div>
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Tim</label>
                        <input type="text" name="tim" class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;" placeholder="Nama tim">
                    </div>
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Keterangan</label>
                        <textarea name="keterangan" class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" rows="2" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;" placeholder="Opsional"></textarea>
                    </div>
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Jumlah</label>
                        <input type="number" name="jumlah" min="1" class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;" placeholder="1">
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="closeAddModal()" class="btn btn-secondary text-xs px-4 py-2">Batal</button>
                    <button type="submit" class="btn btn-primary text-xs px-4 py-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div id="editModal" class="fixed inset-0 z-50 hidden" style="background:rgba(0,0,0,0.5);" onclick="if(event.target===this)closeEditModal()">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="gaming-card w-full max-w-md p-6" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold" style="color:var(--text-primary);">Edit Aset TIM</h3>
                <button onclick="closeEditModal()" class="btn btn-secondary btn-sm" style="font-size:1.2rem;padding:2px 8px;">&times;</button>
            </div>
            <form method="POST" id="editForm">
                @csrf @method('PUT')
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Nama Aset <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="nama_aset" id="edit_nama_aset" required class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
                    </div>
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Tim</label>
                        <input type="text" name="tim" id="edit_tim" class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
                    </div>
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" rows="2" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;"></textarea>
                    </div>
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Jumlah</label>
                        <input type="number" name="jumlah" id="edit_jumlah" min="1" class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
                    </div>
                    <div>
                        <label class="text-xs font-medium" style="color:var(--text-secondary);">Status</label>
                        <select name="is_active" id="edit_is_active" class="w-full pl-3 pr-3 py-1.5 rounded-lg text-xs" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="closeEditModal()" class="btn btn-secondary text-xs px-4 py-2">Batal</button>
                    <button type="submit" class="btn btn-primary text-xs px-4 py-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden" style="background:rgba(0,0,0,0.5);" onclick="if(event.target===this)closeDetailModal()">
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="gaming-card w-full max-w-md p-6" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold" style="color:var(--text-primary);">Detail Aset TIM</h3>
                <button onclick="closeDetailModal()" class="btn btn-secondary btn-sm" style="font-size:1.2rem;padding:2px 8px;">&times;</button>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Nama Aset</span>
                    <span class="text-xs font-medium" id="detail_nama_aset" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Jenis Aset</span>
                    <span class="badge badge-cyan" style="font-size:0.65rem;">Aset TIM</span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Tim</span>
                    <span class="text-xs" id="detail_tim" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Keterangan</span>
                    <span class="text-xs" id="detail_keterangan" style="color:var(--text-primary);text-align:right;max-width:60%;"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Jumlah</span>
                    <span class="text-xs font-medium" id="detail_jumlah" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-xs" style="color:var(--text-muted);">Status</span>
                    <span id="detail_status"></span>
                </div>
            </div>
            <div class="flex justify-end mt-5">
                <button type="button" onclick="closeDetailModal()" class="btn btn-secondary text-xs px-4 py-2">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
}

function openEditModal(asset) {
    document.getElementById('editForm').action = '{{ route("koordinator.aset-tim.update", ["asetTim" => "___ID___"]) }}'.replace('___ID___', asset.id);
    document.getElementById('edit_nama_aset').value = asset.nama_aset;
    document.getElementById('edit_tim').value = asset.tim || '';
    document.getElementById('edit_keterangan').value = asset.keterangan || '';
    document.getElementById('edit_jumlah').value = asset.jumlah || '';
    document.getElementById('edit_is_active').value = asset.is_active ? '1' : '0';
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function openDetailModal(asset) {
    document.getElementById('detail_nama_aset').textContent = asset.nama_aset;
    document.getElementById('detail_tim').textContent = asset.tim || '-';
    document.getElementById('detail_keterangan').textContent = asset.keterangan || '-';
    document.getElementById('detail_jumlah').textContent = asset.jumlah || '-';
    var statusEl = document.getElementById('detail_status');
    if (asset.is_active) {
        statusEl.innerHTML = '<span class="badge badge-green" style="font-size:0.65rem;">Aktif</span>';
    } else {
        statusEl.innerHTML = '<span class="badge badge-red" style="font-size:0.65rem;">Tidak Aktif</span>';
    }
    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>
@endpush
