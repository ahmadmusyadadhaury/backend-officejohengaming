@extends('layouts.app')
@section('title', 'Persetujuan Pembayaran')
@section('page-title', 'Persetujuan Pembayaran')
@section('page-subtitle', 'Pengajuan pembayaran yang menunggu persetujuan')

@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    @if($requests->isEmpty())
    <div class="gaming-card p-8 text-center">
        <svg class="w-16 h-16 mx-auto mb-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p style="color:var(--text-secondary);font-size:14px;">Tidak ada pengajuan yang menunggu persetujuan.</p>
    </div>
    @else
    <div class="gaming-card" style="overflow:hidden;">
        <div class="px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Persetujuan Pembayaran</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Pengajuan pembayaran yang menunggu persetujuan</div>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-0 max-w-full sm:min-w-[200px] sm:max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-approval" placeholder="Cari..." oninput="filterTable()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="{{ route('admin.payment-approvals.export') }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">Download Excel</a>
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
            <table class="gaming-table" style="width:100%;min-width:900px;">
                <colgroup>
                    <col style="width:40px">
                    <col style="width:80px">
                    <col style="width:100px">
                    <col style="width:70px">
                    <col style="width:260px">
                    <col style="width:110px">
                    <col style="width:75px">
                    <col style="width:50px">
                    <col style="width:115px">
                </colgroup>
                <thead>
                    <tr>
                        <th style="width:40px">No</th>
                        <th style="width:80px">Tanggal</th>
                        <th style="width:100px">Pengaju</th>
                        <th style="width:70px">Jenis</th>
                        <th style="width:260px">Detail</th>
                        <th style="width:110px">Nominal</th>
                        <th style="width:75px">Tgl Bayar</th>
                        <th style="width:50px">Bukti</th>
                        <th style="width:115px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="approval-tbody">
                    @foreach($requests as $i => $r)
                    <tr data-jenis="{{ $r['jenis'] }}">
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="font-size:12px;color:var(--text-secondary);">{{ $r['created_at'] }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r['requester_name'] }}</td>
                        <td><span class="text-xs font-semibold" style="color:var(--text-secondary);">{{ $r['jenis_label'] }}</span></td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r['detail'] }}</td>
                        <td style="color:var(--text-primary);white-space:nowrap;">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                        <td style="font-size:13px;color:var(--text-secondary);">{{ $r['tanggal_bayar'] }}</td>
                        <td>
                            @if($r['bukti_url'])
                            <a href="{{ $r['bukti_url'] }}" target="_blank" class="btn btn-secondary btn-sm" style="padding:4px 10px;font-size:11px;">Lihat</a>
                            @else
                            <span class="text-xs" style="color:var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td>
                            @if($isApprover)
                            <div class="flex gap-2">
                                <button type="button" onclick="approve({{ $r['id'] }}, '{{ $r['jenis'] }}')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:#10b981;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Setujui</button>
                                <button type="button" onclick="openReject({{ $r['id'] }}, '{{ $r['jenis'] }}')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:#ef4444;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Tolak</button>
                            </div>
                            @else
                            <span class="text-xs" style="color:var(--text-muted);">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

{{-- Modal Reject --}}
<div id="reject-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Tolak Pengajuan</h3>
            <button type="button" onclick="closeReject()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5">
            <div class="field-group mb-4">
                <label class="gaming-label">Alasan Ditolak <span class="field-req">*</span></label>
                <textarea id="reject-notes" rows="4" class="gaming-input" placeholder="Tuliskan alasan penolakan..." style="resize:vertical;min-height:100px;"></textarea>
            </div>
            <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button type="button" onclick="closeReject()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;">Batal</button>
                <button type="button" onclick="reject()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:#ef4444;color:#fff;border:none;cursor:pointer;">Tolak</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentFilter = 'all';
let rejectId = null;
let rejectJenis = null;

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
    const search = (document.getElementById('search-approval')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#approval-tbody tr');
    rows.forEach(row => {
        const rowJenis = row.dataset.jenis;
        const text = row.textContent.toLowerCase();
        const matchFilter = currentFilter === 'all' || rowJenis === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchFilter && matchSearch ? '' : 'none';
    });
}

function approve(id, jenis) {
    if (!confirm('Setujui pembayaran ini?')) return;

    const form = new FormData();
    form.append('_token', '{{ csrf_token() }}');
    form.append('jenis', jenis);

    fetch('{{ url('admin/payment-approvals') }}/' + id + '/approve', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: form,
    }).then(r => {
        if (r.ok) { location.reload(); }
        else { r.json().then(e => { alert('Gagal: ' + (e.error || JSON.stringify(e))); }); }
    }).catch(() => { location.reload(); });
}

function openReject(id, jenis) {
    rejectId = id;
    rejectJenis = jenis;
    document.getElementById('reject-notes').value = '';
    document.getElementById('reject-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeReject() {
    rejectId = null;
    rejectJenis = null;
    document.getElementById('reject-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function reject() {
    const notes = document.getElementById('reject-notes').value.trim();
    if (!notes) { alert('Alasan penolakan harus diisi.'); return; }

    const form = new FormData();
    form.append('_token', '{{ csrf_token() }}');
    form.append('jenis', rejectJenis);
    form.append('notes', notes);

    fetch('{{ url('admin/payment-approvals') }}/' + rejectId + '/reject', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: form,
    }).then(r => {
        if (r.ok) { location.reload(); }
        else { r.json().then(e => { alert('Gagal: ' + (e.error || JSON.stringify(e))); }); }
    }).catch(() => { location.reload(); });
}

document.getElementById('reject-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeReject();
});
</script>
@endpush