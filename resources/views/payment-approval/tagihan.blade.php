@extends('layouts.app')
@section('title', 'Tagihan')
@section('page-title', 'Tagihan Pembayaran')
@section('page-subtitle', 'Daftar tagihan yang perlu dibayar')

@section('sidebar-menu')
    @php $role = auth()->user()->role; @endphp
    @include($role === 'koordinator' ? 'partials.sidebar-leader' : (in_array($role, ['admin','hr','head_of_store','gm','ceo','admin_ga']) ? 'partials.sidebar-admin' : 'partials.sidebar-user'))
@endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    @if($tagihan->isEmpty())
    <div class="gaming-card p-8 text-center">
        <svg class="w-16 h-16 mx-auto mb-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p style="color:var(--text-secondary);font-size:14px;">Tidak ada tagihan yang perlu dibayar.</p>
    </div>
    @else
    <div class="gaming-card" style="overflow:hidden;">
        <div class="px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Tagihan Pembayaran</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Daftar tagihan yang perlu dibayar</div>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-0 max-w-full sm:min-w-[200px] sm:max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-tagihan" placeholder="Cari..." oninput="filterTable()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="{{ route('payment-approval.export-tagihan') }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">Download Excel</a>
                <div class="filter-dropdown-wrap" style="position:relative;">
                    <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                        style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                        <span id="filter-label">Semua Jenis</span>
                        <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                        <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Jenis</button>
                        <button type="button" data-value="internet" onclick="setFilter('internet')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Internet</button>
                        <button type="button" data-value="listrik" onclick="setFilter('listrik')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Listrik</button>
                        <button type="button" data-value="aset_digital" onclick="setFilter('aset_digital')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aset Digital</button>
                        <button type="button" data-value="ipl_ruko" onclick="setFilter('ipl_ruko')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">IPL Ruko</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table" style="width:100%;min-width:700px;">
                <colgroup>
                    <col style="width:50px">
                    <col style="width:100px">
                    <col>
                    <col style="width:130px">
                    <col style="width:100px">
                    <col style="width:90px">
                </colgroup>
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th style="width:100px">Jenis</th>
                        <th>Detail</th>
                        <th style="width:130px">Nominal</th>
                        <th style="width:100px">Status</th>
                        <th style="width:90px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tagihan-tbody">
                    @foreach($tagihan as $i => $r)
                    <tr data-jenis="{{ $r['jenis'] }}">
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td><span class="text-xs font-semibold" style="color:var(--text-secondary);">{{ $r['jenis_label'] }}</span></td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r['detail'] }}</td>
                        <td style="color:var(--text-primary);">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                        <td><span class="badge badge-red" style="white-space:nowrap;">Jatuh Tempo</span></td>
                        <td>
                            <button type="button" onclick="openBayar({{ $r['id'] }}, '{{ $r['jenis'] }}', '{{ $r['detail'] }}', {{ $r['nominal'] }})" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">Bayar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

{{-- Modal Bayar --}}
<div id="bayar-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Bayar Tagihan</h3>
            <button type="button" onclick="closeBayar()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5">
            <div style="margin-bottom:16px;padding:12px;border-radius:10px;background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div id="bayar-detail" style="font-weight:600;font-size:14px;color:var(--text-primary);"></div>
                <div id="bayar-nominal" style="font-size:13px;color:var(--text-muted);margin-top:4px;"></div>
            </div>
            <form id="bayar-form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis" id="bayar-jenis">
                <div class="field-group mb-4">
                    <label class="gaming-label">PIC <span class="field-req">*</span></label>
                    <input type="text" name="pic" required class="gaming-input" value="{{ auth()->user()->name }}" placeholder="Nama PIC">
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
                    <select name="jabatan" required class="gaming-input">
                        <option value="">— Pilih Jabatan —</option>
                        @foreach($jabatanList as $j)
                        <option value="{{ $j }}">{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                    <input type="date" name="tanggal_bayar" required class="gaming-input" value="{{ date('Y-m-d') }}">
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Upload Bukti Bayar <span class="field-req">*</span></label>
                    <input type="file" name="bukti_bayar" accept="image/jpeg,image/png" required class="gaming-input" style="padding:8px;">
                    <p class="text-xs mt-1" style="color:var(--text-muted);">Format: JPEG/PNG, maks 2MB</p>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;">
                    <button type="button" onclick="closeBayar()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;box-shadow:0 4px 15px rgba(16,185,129,0.3);cursor:pointer;">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.field-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.field-req { color: #f87171; }
.gaming-input { width: 100%; }
</style>
@endpush

@push('scripts')
<script>
let currentFilter = 'all';

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

function setFilter(value) {
    currentFilter = value;
    const label = document.querySelector(`.filter-menu button[data-value="${value}"]`).textContent;
    document.getElementById('filter-label').textContent = label;
    document.getElementById('filter-menu').style.display = 'none';
    filterTable();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterTable() {
    const search = (document.getElementById('search-tagihan')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#tagihan-tbody tr');
    rows.forEach(row => {
        const rowJenis = row.dataset.jenis;
        const text = row.textContent.toLowerCase();
        const matchFilter = currentFilter === 'all' || rowJenis === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchFilter && matchSearch ? '' : 'none';
    });
}

function openBayar(id, jenis, detail, nominal) {
    document.getElementById('bayar-detail').textContent = detail;
    document.getElementById('bayar-nominal').textContent = 'Rp ' + Number(nominal).toLocaleString('id-ID');
    document.getElementById('bayar-jenis').value = jenis;
    document.getElementById('bayar-form').action = '{{ url('payment-approval/tagihan') }}/' + id + '/bayar';
    document.getElementById('bayar-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeBayar() {
    document.getElementById('bayar-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('bayar-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeBayar();
});
</script>
@endpush