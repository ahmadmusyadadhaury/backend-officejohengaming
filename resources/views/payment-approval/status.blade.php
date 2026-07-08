@extends('layouts.app')
@section('body-class', 'page-leader')
@section('title', 'Status Pengajuan')
@section('page-title', 'Status Pengajuan Pembayaran')
@section('page-subtitle', 'Riwayat pengajuan pembayaran kamu')

@section('sidebar-menu')
    @php $role = auth()->user()->role; @endphp
    @include($role === 'koordinator' ? 'partials.sidebar-leader' : (in_array($role, ['admin','hr','head_of_store','gm','ceo','admin_ga']) ? 'partials.sidebar-admin' : 'partials.sidebar-user'))
@endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    @if($requests->isEmpty())
    <div class="gaming-card p-8 text-center">
        <svg class="w-16 h-16 mx-auto mb-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p style="color:var(--text-secondary);font-size:14px;">Belum ada pengajuan pembayaran.</p>
    </div>
    @else
    <div class="gaming-card" style="overflow:hidden;">
        <div class="card-header">
            <div>
                <div class="card-header-title">Status Pengajuan Pembayaran</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Riwayat pengajuan pembayaran kamu</div>
            </div>
        </div>
        <div class="filter-bar">
            <div class="search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-status" placeholder="Cari..." oninput="filterTable()"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="{{ route('payment-approval.export') }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export</a>
                <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Status</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:fixed;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="lunas" onclick="setFilter('lunas')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Disetujui</button>
                    <button type="button" data-value="pending" onclick="setFilter('pending')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Menunggu</button>
                    <button type="button" data-value="rejected" onclick="setFilter('rejected')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Ditolak</button>
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
                    <col style="width:110px">
                    <col style="width:100px">
                    <col style="width:70px">
                    <col class="hidden md:table-cell" style="width:140px">
                </colgroup>
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th style="width:100px">Jenis</th>
                        <th>Detail</th>
                        <th style="width:130px">Nominal</th>
                        <th style="width:110px">Tgl Bayar</th>
                        <th style="width:100px">Status</th>
                        <th style="width:70px">Bukti</th>
                        <th class="hidden md:table-cell" style="width:140px">Approval</th>
                    </tr>
                </thead>
                <tbody id="status-tbody">
                    @foreach($requests as $i => $r)
                    <tr data-status="{{ $r['status'] }}">
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td><span class="text-xs font-semibold" style="color:var(--text-secondary);">{{ $r['jenis_label'] }}</span></td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r['detail'] }}</td>
                        <td style="color:var(--text-primary);">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                        <td style="color:var(--text-secondary);font-size:13px;">{{ $r['tanggal_bayar'] }}</td>
                        <td>
                            @if($r['status'] === 'lunas')
                                <span class="badge badge-green">Disetujui</span>
                            @elseif($r['status'] === 'pending')
                                <span class="badge badge-yellow">Menunggu</span>
                            @elseif($r['status'] === 'rejected')
                                <span class="badge badge-red">Ditolak</span>
                            @else
                                <span class="badge badge-yellow">{{ ucfirst($r['status']) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($r['bukti_url'])
                            <a href="{{ $r['bukti_url'] }}" target="_blank" class="text-xs font-semibold" style="color:#6c5cff;">Lihat</a>
                            @else
                            <span class="text-xs" style="color:var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td class="hidden md:table-cell" style="font-size:12px;color:var(--text-secondary);">
                            @if($r['status'] === 'lunas')
                                {{ $r['approver_name'] ?? '-' }}<br><span style="font-size:11px;">{{ $r['approved_at'] }}</span>
                            @elseif($r['status'] === 'rejected' && $r['notes'])
                                <span style="color:#ef4444;">{{ $r['notes'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">-</span>
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
@endsection

@push('scripts')
<script>
let currentFilter = 'all';

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    if (menu.style.display !== 'block') {
        const btn = e.currentTarget;
        const rect = btn.getBoundingClientRect();
        menu.style.position = 'fixed';
        menu.style.top = (rect.bottom + 4) + 'px';
        menu.style.right = (window.innerWidth - rect.right) + 'px';
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
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
    const search = (document.getElementById('search-status')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#status-tbody tr');
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowStatus === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}
</script>
@endpush