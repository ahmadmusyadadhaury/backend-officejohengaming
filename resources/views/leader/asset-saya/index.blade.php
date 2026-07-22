@extends('layouts.app')
@section('body-class', 'page-leader')
@section('title', 'Data Aset Saya')
@section('page-title', 'Operasional > Data Aset Saya')
@section('page-subtitle', 'Seluruh aset yang menjadi tanggung jawab saya')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Stat Cards --}}
    @php
        $statCards = [
            ['label' => 'Total', 'count' => $assets->count(), 'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.12)', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label' => 'Kendaraan', 'count' => $kategoriCounts['Kendaraan'] ?? 0, 'color' => '#a78bfa', 'bg' => 'rgba(124,58,237,0.12)', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
            ['label' => 'Digital', 'count' => $kategoriCounts['Digital'] ?? 0, 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.12)', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ['label' => 'Sosmed', 'count' => $kategoriCounts['Sosial Media'] ?? 0, 'color' => '#fb923c', 'bg' => 'rgba(251,146,60,0.12)', 'icon' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5a17.92 17.92 0 01-8.716-2.247m0 0A9 9 0 013 12c0-1.605.42-3.113 1.157-4.418'],
            ['label' => 'SIM Card', 'count' => $kategoriCounts['SIM Card'] ?? 0, 'color' => '#f87171', 'bg' => 'rgba(248,113,113,0.12)', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
            ['label' => 'Peralatan', 'count' => $kategoriCounts['Peralatan Kantor'] ?? 0, 'color' => '#38bdf8', 'bg' => 'rgba(56,189,248,0.12)', 'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ['label' => 'Aset MES', 'count' => $kategoriCounts['Aset MES'] ?? 0, 'color' => '#c084fc', 'bg' => 'rgba(192,132,252,0.12)', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ['label' => 'Aset TIM', 'count' => $kategoriCounts['Aset TIM'] ?? 0, 'color' => '#fbbf24', 'bg' => 'rgba(251,191,36,0.12)', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ];
    @endphp
    <div class="flex flex-nowrap gap-3 overflow-x-auto pb-1">
        @foreach($statCards as $card)
        <div class="stat-card-compact min-w-[130px] flex-shrink-0">
            <div class="stat-icon-box" style="background:{{ $card['bg'] }};">
                <svg style="color:{{ $card['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:{{ $card['color'] }};">{{ $card['count'] }}</div>
                <div class="stat-label-text">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Data Aset Saya</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Seluruh aset yang menjadi tanggung jawab anda</div>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <form method="GET" action="{{ route('koordinator.asset-saya.index') }}" id="filter-form" class="flex flex-wrap items-center gap-3 w-full">
                <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aset..."
                        class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                        style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
                </div>
                <div class="relative" style="min-width:160px;">
                    <select name="kategori" onchange="this.form.submit()" class="gaming-input gaming-select" style="padding:6px 30px 6px 12px;font-size:0.75rem;">
                        <option value="">Semua Kategori</option>
                        @foreach($allKategoris as $k)
                            <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('koordinator.asset-saya.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[900px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Aset</th>
                        <th>Kode Aset</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>PIC</th>
                        <th>Jabatan PIC</th>
                        <th>Atasan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paginator as $item)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $paginator->firstItem() + $loop->index }}</td>
                        <td><span class="badge badge-blue" style="font-size:0.65rem;">{{ $item['kategori'] }}</span></td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $item['nama_aset'] }}</td>
                        <td style="color:var(--text-secondary);">{{ $item['kode_aset'] }}</td>
                        <td style="color:var(--text-secondary);">{{ $item['lokasi'] }}</td>
                        <td>
                            @php
                                $statusColor = match($item['status']) {
                                    'Aktif' => 'badge-green',
                                    'Nonaktif', 'Tidak Aktif' => 'badge-red',
                                    'Baik' => 'badge-green',
                                    'Perlu Servis' => 'badge-yellow',
                                    default => 'badge-blue',
                                };
                            @endphp
                            <span class="badge {{ $statusColor }}" style="font-size:0.65rem;">{{ $item['status'] }}</span>
                        </td>
                        <td style="color:var(--text-secondary);">{{ $item['pic'] }}</td>
                        <td style="color:var(--text-secondary);">{{ $item['jabatan'] }}</td>
                        <td style="color:var(--text-secondary);">{{ $item['atasan'] }}</td>
                        <td style="color:var(--text-muted);font-size:0.7rem;">{{ \Carbon\Carbon::parse($item['created_at'])->format('d M Y') }}</td>
                        <td>
                            <button onclick='openDetailModal(@json($item))' class="btn btn-secondary btn-sm">Detail</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" style="text-align:center;padding:2.5rem;color:var(--text-muted);font-size:0.9rem;">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <span>Belum ada aset yang ditugaskan kepada anda.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $paginator->links() }}</div>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detailModal" class="modal-modern" onclick="if(event.target===this)closeDetailModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Detail Aset</h3>
            <button onclick="closeDetailModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body">
            <div class="space-y-3">
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Kategori</span>
                    <span class="text-xs font-medium" id="detail_kategori" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Nama Aset</span>
                    <span class="text-xs font-medium" id="detail_nama_aset" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Kode Aset</span>
                    <span class="text-xs" id="detail_kode_aset" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Lokasi</span>
                    <span class="text-xs" id="detail_lokasi" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Status</span>
                    <span id="detail_status"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">PIC</span>
                    <span class="text-xs" id="detail_pic" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Jabatan PIC</span>
                    <span class="text-xs" id="detail_jabatan" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Atasan</span>
                    <span class="text-xs" id="detail_atasan" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-xs" style="color:var(--text-muted);">Tanggal Dibuat</span>
                    <span class="text-xs" id="detail_tanggal" style="color:var(--text-primary);"></span>
                </div>
            </div>
        </div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetailModal()" class="btn btn-secondary btn-sm">Tutup</button>
        </div>
    </div>
</div>

<style>
.gaming-table tbody td { padding: 0.625rem 1rem; vertical-align: middle; font-size:0.75rem; }
.gaming-table thead th { padding: 0.5rem 1rem; font-size:0.65rem; letter-spacing:0.03em; }
.badge-yellow { background:rgba(251,191,36,0.15); color:#fbbf24; }
</style>

@push('scripts')
<script>
function openDetailModal(item) {
    document.getElementById('detail_kategori').textContent = item.kategori;
    document.getElementById('detail_nama_aset').textContent = item.nama_aset;
    document.getElementById('detail_kode_aset').textContent = item.kode_aset || '-';
    document.getElementById('detail_lokasi').textContent = item.lokasi || '-';
    document.getElementById('detail_pic').textContent = item.pic;
    document.getElementById('detail_jabatan').textContent = item.jabatan || '-';
    document.getElementById('detail_atasan').textContent = item.atasan || '-';
    document.getElementById('detail_tanggal').textContent = item.created_at ? new Date(item.created_at).toLocaleDateString('id-ID', {day:'numeric',month:'long',year:'numeric'}) : '-';
    var statusEl = document.getElementById('detail_status');
    var color = item.status === 'Aktif' || item.status === 'Baik' ? '#34d399' : '#ef4444';
    statusEl.innerHTML = '<span class="badge ' + (item.status === 'Aktif' || item.status === 'Baik' ? 'badge-green' : 'badge-red') + '" style="font-size:0.65rem;">' + item.status + '</span>';
    openModal('detailModal');
}
function closeDetailModal() {
    closeModal('detailModal');
}
</script>
@endpush
@endsection
