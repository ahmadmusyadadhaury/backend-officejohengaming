@extends('layouts.app')
@section('body-class', 'page-leader')
@section('title', 'Aset MES Saya')
@section('page-title', 'Operasional > Aset MES')
@section('page-subtitle', 'Daftar aset MES yang menjadi tanggung jawab saya')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Aset MES</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Daftar aset MES yang menjadi tanggung jawab anda.</div>
            </div>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset MES
            </button>
        </div>

        <div class="table-responsive">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $a)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $a->nama_aset }}</td>
                        <td style="color:var(--text-muted);">{{ $a->jumlah }}</td>
                        <td style="max-width:150px;color:var(--text-muted);">{{ $a->keterangan ?? '-' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="openEditModal({{ $a->id }})" class="btn btn-secondary btn-sm" style="padding:3px 8px;font-size:0.7rem;">Edit</button>
                                <form method="POST" action="{{ route('koordinator.aset-mes.destroy', $a) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset ini?" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding:3px 8px;font-size:0.7rem;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">Belun ada aset MES yang ditugaskan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah / Edit --}}
<div id="aset-modal" class="modal-modern" onclick="if(event.target===this)closeModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="modal-title">Tambah Aset MES</h3>
            <button type="button" onclick="closeModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="aset-form" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <div class="modal-modern-body">
                <div class="form-grid-2">
                    <div class="field-group">
                        <label class="gaming-label">Nama Aset <span class="field-req">*</span></label>
                        <input type="text" name="nama_aset" id="f-nama_aset" required placeholder="Masukan nama aset" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jumlah</label>
                        <input type="number" name="jumlah" id="f-jumlah" placeholder="Jumlah" min="1" class="gaming-input">
                    </div>
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="keterangan" id="f-keterangan" placeholder="Keterangan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary" id="form-submit-btn">Tambah</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 24px; margin-bottom: 16px; }
@media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }
.field-group { display: flex; flex-direction: column; gap: 6px; }
.field-req { color: #f87171; }
</style>
@endpush

@push('scripts')
<script>
function closeModal() { document.getElementById('aset-modal').style.display = 'none'; document.body.style.overflow = ''; }

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Aset MES';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('aset-form').action = '{{ route("koordinator.aset-mes.index") }}';
    document.getElementById('f-nama_aset').value = '';
    document.getElementById('f-jumlah').value = '';
    document.getElementById('f-keterangan').value = '';
    document.getElementById('aset-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openEditModal(id) {
    const a = assets.find(x => x.id === id);
    if (!a) return;
    document.getElementById('modal-title').textContent = 'Edit Aset MES';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-submit-btn').textContent = 'Simpan';
    document.getElementById('aset-form').action = '{{ route("koordinator.aset-mes.update", ["asetMes" => "___ID___"]) }}'.replace('___ID___', id);
    document.getElementById('f-nama_aset').value = a.nama_aset;
    document.getElementById('f-jumlah').value = a.jumlah || '';
    document.getElementById('f-keterangan').value = a.keterangan || '';
    document.getElementById('aset-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
</script>
<script>
const assets = @json($assets->values()->map(fn($a) => [
    'id' => $a->id,
    'nama_aset' => $a->nama_aset,
    'jumlah' => $a->jumlah,
    'keterangan' => $a->keterangan,
]));
</script>
@endpush
