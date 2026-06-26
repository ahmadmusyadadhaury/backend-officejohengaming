@extends('layouts.app')
@section('title', 'Rekap MOM')
@section('page-title', 'Overview > Rekap Minutes of Meeting')
@section('page-subtitle', 'Lihat rekap hasil meeting dan keputusan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $momStats['total_moms'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total MOM</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Total Minutes of Meeting</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(59,130,246,0.15);box-shadow:0 0 16px rgba(59,130,246,0.2);">
                <svg class="w-6 h-6" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#60a5fa;">{{ $momStats['month_moms'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Bulan Ini</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">MOM {{ now()->locale('id')->isoFormat('MMMM YYYY') }}</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $momStats['reviewed_moms'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Sudah Direview</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">MOM sudah dikirim</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:0 0 16px rgba(245,158,11,0.2);">
                <svg class="w-6 h-6" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;">{{ $momStats['unreviewed_moms'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Belum Direview</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">MOM masih draft</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="gaming-card overflow-hidden">
        <div class="px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Rekap Minutes of Meeting</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Dokumentasi hasil setiap meeting yang telah dilaksanakan.</div>
        </div>
        <div class="px-5 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-mom" placeholder="Cari berdasarkan judul meeting" oninput="filterMoms()"
                    class="w-full pl-9 pr-3 py-2 rounded-lg text-sm"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="togglePeriodFilter(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="period-filter-label" data-value="{{ $period }}">{{ $period == 'all' ? 'Semua Periode' : ($period == 'daily' ? 'Hari Ini' : ($period == 'weekly' ? 'Minggu Ini' : 'Bulan Ini')) }}</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="period-filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setPeriodFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Periode</button>
                    <button type="button" data-value="daily" onclick="setPeriodFilter('daily')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hari Ini</button>
                    <button type="button" data-value="weekly" onclick="setPeriodFilter('weekly')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Minggu Ini</button>
                    <button type="button" data-value="monthly" onclick="setPeriodFilter('monthly')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Bulan Ini</button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[900px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Meeting</th>
                        <th>PIC</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal Meeting</th>
                        <th>Dikirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($moms as $mom)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $mom->meeting->title ?? '—' }}</td>
                        <td style="color:var(--text-secondary);">{{ $mom->pic }}</td>
                        <td style="color:var(--text-muted);">{{ $mom->creator->name ?? '—' }}</td>
                        <td style="color:var(--text-muted);">{{ $mom->meeting->meeting_date ? $mom->meeting->meeting_date->format('d M Y') : '—' }}</td>
                        <td style="color:var(--text-muted);">{{ $mom->sent_at ? $mom->sent_at->format('d M Y H:i') : '—' }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="showMomDetail({{ $mom->id }})" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </button>
                                <a href="{{ route('mom.export', $mom->id) }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5" title="Download Excel MOM">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Excel
                                </a>
                                @if($mom->file_path)
                                <a href="{{ asset('storage/' . $mom->file_path) }}" target="_blank" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Download
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada MOM terkirim.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $moms->links() }}</div>
    </div>

    {{-- Detail cards for print --}}
    <div class="print-only space-y-4">
        @foreach($moms as $mom)
        <div class="gaming-card p-6" style="break-inside:avoid;">
            <h3 class="font-gaming font-bold text-lg" style="color:var(--text-primary);">{{ $mom->meeting->title ?? 'Meeting' }}</h3>
            <p class="text-sm mt-1" style="color:var(--text-muted);">
                {{ $mom->meeting->meeting_date ? $mom->meeting->meeting_date->format('d M Y') : '' }}
                · {{ $mom->meeting->room->name ?? '' }}
                · Dibuat oleh: {{ $mom->creator->name ?? '—' }}
                · Dikirim: {{ $mom->sent_at ? $mom->sent_at->format('d M Y H:i') : '—' }}
            </p>
            <div class="mt-4 space-y-3">
                <div><p class="text-xs font-semibold" style="color:var(--color-accent-light);">RINGKASAN PEMBAHASAN</p><p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $mom->summary }}</p></div>
                <div><p class="text-xs font-semibold" style="color:var(--color-accent-light);">KEPUTUSAN</p><p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $mom->decisions }}</p></div>
                <div><p class="text-xs font-semibold" style="color:var(--color-accent-light);">ACTION PLAN</p><p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $mom->action_plan }}</p></div>
                <div><p class="text-xs font-semibold" style="color:var(--color-accent-light);">PIC</p><p class="text-sm mt-1" style="color:var(--text-primary);font-weight:600;">{{ $mom->pic }}</p></div>
            </div>
            @if($mom->file_path)
            <p class="text-xs mt-3" style="color:var(--text-muted);">Lampiran: {{ basename($mom->file_path) }}</p>
            @endif
        </div>
        @endforeach
    </div>
</div>

{{-- Modal Detail MOM --}}
<div id="mom-detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full" style="max-width:920px;width:90vw;max-height:65vh;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:22px;box-shadow:0 25px 60px rgba(0,0,0,0.3);display:flex;flex-direction:column;animation:momFadeIn 0.25s ease;" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(139,92,246,0.18);">
                    <svg class="w-4.5 h-4.5" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail MOM — <span id="mom-modal-judul">Meeting Tim IT</span></h3>
            </div>
            <button type="button" onclick="closeModal('mom-detail-modal')" class="p-1.5 rounded-lg transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 overflow-y-auto flex-1" id="mom-detail-body" style="scrollbar-width:thin;scrollbar-color:rgba(129,140,248,0.25) transparent;">

            {{-- 2-Column Grid: Left Info / Right Permohonan --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Left: Meeting Info --}}
                <div id="mom-info-rows" class="space-y-0"></div>

                {{-- Right: Detail Permohonan --}}
                <div id="mom-permohonan-section" class="hidden">
                    <div id="mom-permohonan-content"></div>
                </div>
            </div>

            {{-- MOM Content Card --}}
            <div class="mt-6" id="mom-mom-section">
                <div style="border:1px solid rgba(16,185,129,0.35);background:var(--bg-base);border-radius:16px;padding:18px;">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <h4 class="text-sm font-bold" style="color:#10b981;">Minutes of Meeting (MOM)</h4>
                    </div>
                    <div style="border:1px solid rgba(16,185,129,0.2);background:var(--bg-surface-2);border-radius:14px;padding:18px;">
                        <div id="mom-ringkasan" class="mb-4"></div>
                        <div id="mom-keputusan" class="mb-4"></div>
                        <div id="mom-action-plan" class="mb-4"></div>
                        <div id="mom-pic-section" class="mb-4"></div>
                        <div id="mom-file-section"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end px-6 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeModal('mom-detail-modal')" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-secondary);border:1px solid var(--border-color);background:var(--bg-surface-2);" onmouseover="this.style.background='var(--bg-surface)'" onmouseout="this.style.background='var(--bg-surface-2)'">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const momsData = @json($momsJson);

const momStatusMap = {
    pending:      { label: '\u25cf MENUNGGU',    bg: 'rgba(245,158,11,0.18)', text: '#fbbf24', border: 'rgba(245,158,11,0.3)' },
    approved:     { label: '\u25cf DISETUJUI',    bg: 'rgba(16,185,129,0.18)', text: '#34d399', border: 'rgba(16,185,129,0.3)' },
    rejected:     { label: '\u25cf DITOLAK',      bg: 'rgba(239,68,68,0.18)', text: '#ef4444', border: 'rgba(239,68,68,0.3)' },
    confirmed:    { label: '\u25cf DIKONFIRMASI', bg: 'rgba(59,130,246,0.18)', text: '#60a5fa', border: 'rgba(59,130,246,0.3)' },
    cancelled:    { label: '\u25cf DIBATALKAN',    bg: 'rgba(107,114,128,0.18)', text: '#9ca3af', border: 'rgba(107,114,128,0.3)' },
    in_progress:  { label: '\u25cf BERLANGSUNG',  bg: 'rgba(59,130,246,0.18)', text: '#60a5fa', border: 'rgba(59,130,246,0.3)' },
    completed:    { label: '\u25cf SELESAI',      bg: 'rgba(16,185,129,0.18)', text: '#34d399', border: 'rgba(16,185,129,0.3)' },
};

function showMomDetail(id) {
    const m = momsData.find(i => i.id === id);
    if (!m) return;

    const st = momStatusMap[m.status] || momStatusMap.completed;

    // Header judul
    document.getElementById('mom-modal-judul').textContent = m.judul_meeting;

    // Left: Meeting info rows
    const rows = document.getElementById('mom-info-rows');
    rows.innerHTML = `
        <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
            <span class="text-xs font-semibold" style="color:var(--text-muted);">Tanggal Meeting</span>
            <span class="text-sm text-right" style="color:var(--text-primary);font-weight:700;">${m.tanggal_meeting}</span>
        </div>
        <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
            <span class="text-xs font-semibold" style="color:var(--text-muted);">Dibuat Oleh</span>
            <span class="text-sm text-right" style="color:var(--text-primary);font-weight:700;">${m.dibuat_oleh}</span>
        </div>
        <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
            <span class="text-xs font-semibold" style="color:var(--text-muted);">PIC</span>
            <span class="text-sm text-right" style="color:var(--text-primary);font-weight:700;">${m.pic}</span>
        </div>
        <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
            <span class="text-xs font-semibold" style="color:var(--text-muted);">Dikirim</span>
            <span class="text-sm text-right" style="color:var(--text-primary);font-weight:700;">${m.dikirim}</span>
        </div>
        <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
            <span class="text-xs font-semibold" style="color:var(--text-muted);">Status</span>
            <span class="text-xs font-bold px-3 py-1.5" style="background:${st.bg};color:${st.text};border-radius:8px;">${st.label}</span>
        </div>
        ${m.file_path ? `
        <div class="pt-3">
            <a href="${m.file_url}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg transition" style="border:1px solid rgba(16,185,129,0.5);background:rgba(16,185,129,0.1);color:#10b981;" onmouseover="this.style.background='rgba(16,185,129,0.2)'" onmouseout="this.style.background='rgba(16,185,129,0.1)'">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download File
            </a>
        </div>` : ''}
    `;

    // Right: Detail Permohonan
    const permohonanSec = document.getElementById('mom-permohonan-section');
    const permohonanContent = document.getElementById('mom-permohonan-content');
    let pHtml = '';
    if (m.why) pHtml += `
        <div class="mb-4">
            <div class="flex items-center gap-1.5 mb-2">
                <svg class="w-4 h-4" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-xs font-bold" style="color:#8b5cf6;">Why — Kenapa meeting ini diadakan?</span>
            </div>
            <div class="text-sm leading-relaxed p-3.5" style="background:var(--bg-surface-2);border-radius:10px;color:var(--text-secondary);line-height:1.6;">${m.why}</div>
        </div>`;
    if (m.what) pHtml += `
        <div class="mb-4">
            <div class="flex items-center gap-1.5 mb-2">
                <svg class="w-4 h-4" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span class="text-xs font-bold" style="color:#8b5cf6;">What — Apa yang dibahas?</span>
            </div>
            <div class="text-sm leading-relaxed p-3.5" style="background:var(--bg-surface-2);border-radius:10px;color:var(--text-secondary);line-height:1.6;">${m.what}</div>
        </div>`;
    if (m.how) pHtml += `
        <div class="mb-4">
            <div class="flex items-center gap-1.5 mb-2">
                <svg class="w-4 h-4" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-xs font-bold" style="color:#8b5cf6;">How — Bagaimana hasil yang diharapkan?</span>
            </div>
            <div class="text-sm leading-relaxed p-3.5" style="background:var(--bg-surface-2);border-radius:10px;color:var(--text-secondary);line-height:1.6;">${m.how}</div>
        </div>`;
    if (pHtml) {
        permohonanContent.innerHTML = pHtml;
        permohonanSec.classList.remove('hidden');
    } else {
        permohonanSec.classList.add('hidden');
    }

    // MOM content items helper
    function momItem(label, content, icon) {
        if (!content) return '';
        return `
        <div class="mb-4">
            <div class="flex items-center gap-1.5 mb-1.5">
                <svg class="w-3.5 h-3.5" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icon}"/></svg>
                <span class="text-xs font-bold uppercase tracking-wider" style="color:#10b981;">${label}</span>
            </div>
            <p class="text-sm" style="color:var(--text-primary);line-height:1.7;">${content}</p>
        </div>`;
    }

    document.getElementById('mom-ringkasan').innerHTML = momItem('Ringkasan Pembahasan', m.summary, 'M7 4V2m17 2v2M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z');
    document.getElementById('mom-keputusan').innerHTML = momItem('Keputusan', m.decisions, 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z');
    document.getElementById('mom-action-plan').innerHTML = momItem('Action Plan', m.action_plan, 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2');
    document.getElementById('mom-pic-section').innerHTML = momItem('Penanggung Jawab (PIC)', m.pic, 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z');
    document.getElementById('mom-file-section').innerHTML = m.file_path
        ? `<div>
            <div class="flex items-center gap-1.5 mb-1.5">
                <svg class="w-3.5 h-3.5" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                <span class="text-xs font-bold uppercase tracking-wider" style="color:#10b981;">File Pendukung</span>
            </div>
            <a href="${m.file_url}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg max-w-full" style="background:rgba(16,185,129,0.12);color:#10b981;border:1px solid rgba(16,185,129,0.3);">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="truncate max-w-[200px]">${m.file_name}</span>
            </a>
        </div>`
        : '';

    openModal('mom-detail-modal');
}

function closeMomDetail() {
    closeModal('mom-detail-modal');
}

document.getElementById('mom-detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('mom-detail-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal('mom-detail-modal');
});

function togglePeriodFilter(e) {
    e.stopPropagation();
    const menu = document.getElementById('period-filter-menu');
    const isHidden = menu.style.display === 'none';
    document.querySelectorAll('.filter-menu').forEach(m => m.style.display = 'none');
    menu.style.display = isHidden ? 'block' : 'none';
}

function setPeriodFilter(value) {
    const params = new URLSearchParams(window.location.search);
    params.set('period', value);
    window.location.search = params.toString();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.querySelectorAll('.filter-menu').forEach(m => m.style.display = 'none');
    }
});

function filterMoms() {
    const search = (document.getElementById('search-mom')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('.gaming-table tbody tr:not([colspan])');
    rows.forEach(row => {
        const judul = (row.querySelector('td:nth-child(2)')?.textContent || '').toLowerCase();
        row.style.display = !search || judul.includes(search) ? '' : 'none';
    });
}
</script>
@endpush

@push('styles')
<style>
    .print-only { display: none; }

    @media print {
        .gaming-sidebar,
        .gaming-topbar,
        nav,
        header,
        .btn,
        form,
        .pagination,
        .gaming-table,
        .space-y-4 > .gaming-card {
            display: none !important;
        }
        body { background: white !important; color: black !important; }
        .gaming-card { border: 1px solid #ddd !important; box-shadow: none !important; }
        .lg\\:ml-64 { margin-left: 0 !important; }
        .page-content { padding: 0 !important; margin-top: 0 !important; }
        .print-only { display: block !important; }
    }

    #mom-detail-body::-webkit-scrollbar {
        width: 4px;
    }
    #mom-detail-body::-webkit-scrollbar-track {
        background: transparent;
    }
    #mom-detail-body::-webkit-scrollbar-thumb {
        background: rgba(129,140,248,0.25);
        border-radius: 4px;
    }

    @keyframes momFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush
