@extends('layouts.app')
@section('title', 'Permintaan Meeting')
@section('page-title', 'Permintaan Meeting')
@section('page-subtitle', 'Kelola semua permintaan meeting perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total Permintaan --}}
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $totalMeeting }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Permintaan</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh daftar permintaan meeting yang masuk.</div>
            </div>
        </div>

        {{-- Menunggu Review --}}
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:0 0 16px rgba(245,158,11,0.2);">
                <svg class="w-6 h-6" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;">{{ $menungguMeeting }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Menunggu Review</div>
            </div>
        </div>

        {{-- Disetujui --}}
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $disetujuiMeeting }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Disetujui</div>
            </div>
        </div>

        {{-- Ditolak --}}
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:0 0 16px rgba(239,68,68,0.2);">
                <svg class="w-6 h-6" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:#f87171;">{{ $ditolakMeeting }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Ditolak</div>
            </div>
        </div>

    </div>

    {{-- Tabel --}}
    <div class="gaming-card overflow-hidden">
        <div class="px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Permintaan Meeting</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Tinjau dan kelola permintaan meeting dari seluruh tim.</div>
        </div>
        <div class="px-5 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-0">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-meeting" placeholder="Cari berdasarkan nama pemohon" oninput="filterMeetings()"
                    class="w-full pl-9 pr-3 py-2 rounded-lg text-sm"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
                <div class="flex items-center gap-2 ml-auto">
                <div id="meeting-month-wrap">
                    <input type="month" id="meeting-month-input" value="{{ $meetingMonth ?? now()->format('Y-m') }}" onchange="setMeetingMonth()" class="gaming-input" style="padding:6px 10px;font-size:13px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;">
                </div>
                <a href="{{ route('admin.export', ['type' => 'meetings', 'meeting_month' => $meetingMonth ?? now()->format('Y-m')]) }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5" title="Download Excel" id="meeting-export-link">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Excel
                </a>
                <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleMeetingFilter(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="meeting-filter-label" data-value="all">Semua Status</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="meeting-filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setMeetingFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="pending" onclick="setMeetingFilter('pending')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Menunggu Review</button>
                    <button type="button" data-value="approved" onclick="setMeetingFilter('approved')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Disetujui</button>
                    <button type="button" data-value="rejected" onclick="setMeetingFilter('rejected')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Ditolak</button>
                </div>
            </div>

        </div>
        <div class="overflow-x-auto w-full">
            <table class="gaming-table min-w-full" id="meetings-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th class="hidden sm:table-cell">Pemohon</th>
                        <th class="hidden lg:table-cell">Tim</th>
                        <th>Tanggal</th>
                        <th class="hidden sm:table-cell">Waktu</th>
                        <th>Status</th>
                        <th class="hidden md:table-cell">Antrian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="meetings-tbody">
                    @forelse($meetings as $meeting)
                    @php
                        $statusStyle = match($meeting->status) {
                            'pending'     => 'badge-yellow',
                            'approved'    => 'badge-blue',
                            'rejected'    => 'badge-red',
                            'confirmed'   => 'badge-primary',
                            'cancelled'   => 'badge-gray',
                            'in_progress' => 'badge-primary',
                            'completed'   => 'badge-green',
                            default       => 'badge-gray',
                        };
                        $rt = \App\Services\MeetingQueueService::realtimeStatus($meeting);
                        $queueBadge = match(true) {
                            str_contains($rt['label'], 'Berlangsung') => 'badge-primary',
                            str_contains($rt['label'], 'Antrian')     => 'badge-orange',
                            str_contains($rt['label'], 'Di Booking')  => 'badge-blue',
                            str_contains($rt['label'], 'Selesai')     => 'badge-green',
                            str_contains($rt['label'], 'Menunggu')    => 'badge-yellow',
                            default                                   => 'badge-gray',
                        };
                    @endphp
                    <tr data-status="{{ $meeting->status }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;max-width:200px;" class="truncate">{{ $meeting->title }}</td>
                        <td style="color:var(--text-muted);" class="meeting-pemohon hidden sm:table-cell">{{ $meeting->requester->name }}</td>
                        <td style="color:var(--text-muted);" class="hidden lg:table-cell">{{ $meeting->team->name }}</td>
                        <td style="color:var(--text-muted);white-space:nowrap;">
                            <span class="sm:hidden">{{ $meeting->meeting_date->format('d/m') }}</span>
                            <span class="hidden sm:inline">{{ $meeting->meeting_date->format('d M Y') }}</span>
                            <span class="sm:hidden text-[10px]" style="color:var(--text-muted);"> {{ substr($meeting->start_time,0,5) }}</span>
                        </td>
                        <td style="color:var(--text-muted);" class="hidden sm:table-cell">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                        <td><span class="badge {{ $statusStyle }}" style="white-space:nowrap;">{{ ucfirst($meeting->status) }}</span></td>
                        <td class="hidden md:table-cell">
                            @if($meeting->queue_position !== null && !in_array($meeting->status, ['pending','rejected','cancelled']))
                                <span class="badge {{ $queueBadge }}" style="white-space:nowrap;">{{ $rt['label'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1 justify-end" style="white-space:nowrap;">
                                <button type="button" onclick="showDetail({{ $meeting->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:3px;padding:3px 6px;font-size:0.7rem;" title="Lihat detail">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat detail
                                </button>
                                <div class="relative dropdown-actions">
                                    <button type="button" onclick="toggleActionMenu(event, {{ $meeting->id }})" class="btn btn-secondary btn-sm" style="padding:4px 6px;line-height:1;font-size:0.7rem;" title="Aksi">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/>
                                        </svg>
                                    </button>
                                    <div id="action-menu-{{ $meeting->id }}" style="display:none;position:fixed;min-width:160px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:12px;padding:6px;z-index:99999;">
                                        <button type="button" onclick="showDetail({{ $meeting->id }})" class="w-full text-left px-3 py-2 text-sm rounded-lg transition" style="color:var(--text-secondary);display:flex;align-items:center;gap:8px;background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat Detail
                                        </button>
                                        @if(in_array($meeting->status, ['cancelled','rejected']))
                                        <form method="POST" action="{{ route('admin.meetings.destroy', $meeting) }}" onsubmit="return confirm('Hapus meeting ini?')" class="w-full">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full text-left px-3 py-2 text-sm rounded-lg transition" style="color:#f87171;display:flex;align-items:center;gap:8px;background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="9" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada permintaan meeting.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $meetings->links() }}</div>
    </div>

</div>

{{-- Modal Detail --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:50px 16px 16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[680px] rounded-3xl shadow-2xl flex flex-col" style="max-height:85vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Permintaan Meeting</h3>
            <button type="button" onclick="closeModal('detail-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>

        {{-- Reject reason --}}
        <div id="d-reject-section" class="hidden px-6 pb-4 flex-shrink-0">
            <div class="p-4 rounded-2xl" style="background:#fef2f2;border:1px solid #fecaca;">
                <p class="text-sm font-semibold mb-1" style="color:#ef4444;">Alasan Penolakan</p>
                <p class="text-sm" style="color:#f87171;" id="d-reject-reason"></p>
            </div>
        </div>

        {{-- Actions --}}
        <div id="d-actions-section" class="hidden px-6 pb-5 flex-shrink-0">
            <p class="text-[11px] font-bold tracking-[0.1em] mb-3" style="color:var(--text-muted);">UPDATE STATUS PERMINTAAN</p>
            <div class="flex flex-col gap-3">
                <form id="d-approve-form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <button type="submit" class="w-full px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition" style="background:#10b981;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">✓ Setujui</button>
                </form>
                <form id="d-reject-form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <textarea name="reject_reason" id="d-reject-input" placeholder="Alasan penolakan..." required rows="2" class="w-full px-4 py-2.5 rounded-xl text-sm border transition" style="resize:none;border-color:var(--border-color);color:var(--text-primary);background:var(--bg-surface-2);" onfocus="this.style.borderColor='#f87171';this.style.background='var(--bg-surface)'" onblur="this.style.borderColor='var(--border-color)';this.style.background='var(--bg-surface-2)'"></textarea>
                    <button type="submit" class="w-full px-5 py-2.5 rounded-xl text-sm font-semibold transition mt-2" style="color:#e11d48;background:#ffe4e6;" onmouseover="this.style.background='#fecdd3'" onmouseout="this.style.background='#ffe4e6'">× Tolak</button>
                </form>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 flex-shrink-0 flex justify-end" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeModal('detail-modal')" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const meetingsData = @json($meetingsJson);
const csrfToken = '{{ csrf_token() }}';
const statusMap = {
    pending:     { label: '● MENUNGGU',  bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
    approved:    { label: '● DISETUJUI',  bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
    rejected:    { label: '● DITOLAK',    bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
    confirmed:   { label: '● DIKONFIRMASI', bg: '#eff6ff', text: '#2563eb', border: '#bfdbfe' },
    cancelled:   { label: '● DIBATALKAN', bg: '#f9fafb', text: '#6b7280', border: '#e5e7eb' },
    in_progress: { label: '● BERLANGSUNG', bg: '#eff6ff', text: '#2563eb', border: '#bfdbfe' },
    completed:   { label: '● SELESAI',    bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
};

function showDetail(id) {
    const m = meetingsData.find(i => i.id === id);
    if (!m) return;

    const body = document.getElementById('detail-body');
    const st = statusMap[m.status] || statusMap.cancelled;

    const infoRows = [
        { label: 'Pemohon', value: m.requester?.name || '-' },
        { label: 'Judul Meeting', value: m.title },
        { label: 'Tanggal', value: m.meeting_date || '-' },
        { label: 'Ruangan', value: m.room?.name || '-' },
    ];

    let detailHtml = '';
    if (m.why || m.what || m.how_expected) {
        if (m.why) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">Why</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${m.why}</p></div>`;
        if (m.what) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">What</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${m.what}</p></div>`;
        if (m.how_expected) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">How</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${m.how_expected}</p></div>`;
    }

    let assetsHtml = '';
    if (m.assets && m.assets.length) {
        assetsHtml += `<div class="flex flex-wrap gap-1.5">${m.assets.map(a => `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background:#e0e7ff;color:#4338ca;">${a.name} (${a.quantity})</span>`).join('')}</div>`;
    }

    let momHtml = '';
    if (m.mom) {
        momHtml += `<div class="flex items-center gap-2 mb-3"><span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${m.mom.status === 'sent' ? '#dcfce7' : '#fef3c7'};color:${m.mom.status === 'sent' ? '#059669' : '#d97706'};">${m.mom.status === 'sent' ? 'Terkirim' : 'Draft'}</span></div>`;
        if (m.mom.summary) momHtml += `<div class="mb-3 p-4 rounded-xl" style="background:var(--bg-surface);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1" style="color:#059669;">Ringkasan</p><p class="text-sm" style="color:var(--text-secondary);line-height:1.6;">${m.mom.summary}</p></div>`;
        if (m.mom.decisions) momHtml += `<div class="mb-3 p-4 rounded-xl" style="background:var(--bg-surface);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1" style="color:#059669;">Keputusan</p><p class="text-sm" style="color:var(--text-secondary);line-height:1.6;">${m.mom.decisions}</p></div>`;
        if (m.mom.action_plan) momHtml += `<div class="mb-3 p-4 rounded-xl" style="background:var(--bg-surface);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1" style="color:#059669;">Action Plan</p><p class="text-sm" style="color:var(--text-secondary);line-height:1.6;">${m.mom.action_plan}</p></div>`;
        momHtml += `<div class="grid grid-cols-2 gap-3 text-sm"><div><span class="text-xs font-bold" style="color:#059669;">PIC</span><p class="font-semibold mt-0.5" style="color:var(--text-primary);">${m.mom.pic || '-'}</p></div><div><span class="text-xs font-bold" style="color:#059669;">Dibuat</span><p class="font-semibold mt-0.5" style="color:var(--text-primary);">${m.mom.creator_name || '-'}</p></div></div>`;
        if (m.mom.file_url) momHtml += `<div class="mt-3"><a href="${m.mom.file_url}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Download</a></div>`;
        if (m.mom.sent_at) momHtml += `<p class="text-xs mt-2" style="color:var(--text-muted);">Dikirim ${m.mom.sent_at}</p>`;
    }

    body.innerHTML = `
        <div class="space-y-4">
            <!-- Info Card -->
            <div class="rounded-2xl overflow-hidden" style="border:1px solid var(--border-color);">
                <div class="px-5 py-3 flex items-center justify-between" style="background:var(--bg-surface-2);border-bottom:1px solid var(--border-color);">
                    <p class="text-xs font-bold tracking-wider" style="color:var(--text-muted);">INFORMASI MEETING</p>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${st.bg};color:${st.text};border:1px solid ${st.border};">${st.label}</span>
                </div>
                <div class="grid grid-cols-2 gap-0">
                    ${infoRows.map((r, i) => `
                        <div class="px-5 py-3" ${i < 2 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                            <p class="text-xs mb-0.5" style="color:var(--text-muted);">${r.label}</p>
                            <p class="text-sm font-semibold" style="color:var(--text-primary);">${r.value}</p>
                        </div>
                    `).join('')}
                </div>
            </div>

            ${detailHtml ? `
            <!-- Detail Permohonan -->
            <div>
                <p class="text-xs font-bold tracking-wider mb-2.5 px-1" style="color:var(--color-accent-light);">DETAIL PERMOHONAN</p>
                <div class="space-y-2.5">
                    ${detailHtml}
                </div>
            </div>` : ''}

            ${assetsHtml ? `
            <!-- Aset -->
            <div>
                <p class="text-xs font-bold tracking-wider mb-2 px-1" style="color:var(--color-accent-light);">ASET DIBUTUHKAN</p>
                ${assetsHtml}
            </div>` : ''}

            ${momHtml ? `
            <!-- MOM -->
            <div class="rounded-2xl p-5" style="background:rgba(16,185,129,0.06);border:1px solid rgba(16,185,129,0.25);">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-xs font-bold" style="color:#059669;letter-spacing:0.05em;">MINUTES OF MEETING</p>
                </div>
                ${momHtml}
            </div>` : ''}
        </div>
    `;

    const rejectSec = document.getElementById('d-reject-section');
    const rejectReason = document.getElementById('d-reject-reason');
    if (m.reject_reason) {
        rejectSec.classList.remove('hidden');
        rejectReason.textContent = m.reject_reason;
    } else {
        rejectSec.classList.add('hidden');
    }

    const actionsSec = document.getElementById('d-actions-section');
    if (m.status === 'pending') {
        actionsSec.classList.remove('hidden');
        const approveForm = document.getElementById('d-approve-form');
        approveForm.action = '/admin/meetings/' + m.id + '/approve';
        const rejectForm = document.getElementById('d-reject-form');
        rejectForm.action = '/admin/meetings/' + m.id + '/reject';
        document.getElementById('d-reject-input').value = '';
    } else {
        actionsSec.classList.add('hidden');
    }

    openModal('detail-modal');
}

function closeDetail() {
    closeModal('detail-modal');
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('detail-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal('detail-modal');
});

document.getElementById('d-approve-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const id = this.action.match(/\/(\d+)\/approve/)[1];
    fetch(this.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH' })
    }).then(r => r.json()).then(() => { location.reload(); }).catch(() => { location.reload(); });
});

document.getElementById('d-reject-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const reason = document.getElementById('d-reject-input').value;
    if (!reason.trim()) return;
    const id = this.action.match(/\/(\d+)\/reject/)[1];
    fetch(this.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH', reject_reason: reason })
    }).then(r => r.json()).then(() => { location.reload(); }).catch(() => { location.reload(); });
});

function filterMeetings() {
    const status = document.getElementById('meeting-filter-label').dataset.value || 'all';
    const search = (document.getElementById('search-meeting')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#meetings-tbody tr:not(#empty-row)');

    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const pemohon = (row.querySelector('.meeting-pemohon')?.textContent || '').toLowerCase();
        const matchStatus = status === 'all' || rowStatus === status;
        const matchSearch = !search || pemohon.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}

function toggleMeetingFilter(e) {
    e.stopPropagation();
    const menu = document.getElementById('meeting-filter-menu');
    const isHidden = menu.style.display === 'none';
    document.querySelectorAll('.filter-menu').forEach(m => m.style.display = 'none');
    menu.style.display = isHidden ? 'block' : 'none';
}

function setMeetingFilter(value) {
    const label = document.getElementById('meeting-filter-label');
    const map = { all: 'Semua Status', pending: 'Menunggu Review', approved: 'Disetujui', rejected: 'Ditolak' };
    label.textContent = map[value] || value;
    label.dataset.value = value;
    document.getElementById('meeting-filter-menu').style.display = 'none';
    filterMeetings();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.querySelectorAll('.filter-menu').forEach(m => m.style.display = 'none');
    }
});

function setMeetingMonth() {
    const month = document.getElementById('meeting-month-input').value;
    const url = new URL(window.location.href);
    url.searchParams.set('meeting_month', month);
    window.location.href = url.toString();
}

// Auto-open detail modal from dashboard review link
const reviewId = new URLSearchParams(window.location.search).get('review');
if (reviewId) {
    showDetail(parseInt(reviewId));
}

// Dropdown titik tiga
function toggleActionMenu(e, id) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const rect = btn.getBoundingClientRect();
    const menu = document.getElementById('action-menu-' + id);
    const isHidden = menu.style.display === 'none';
    document.querySelectorAll('[id^="action-menu-"]').forEach(m => m.style.display = 'none');
    if (isHidden) {
        menu.style.top = (rect.bottom + 4) + 'px';
        menu.style.left = Math.min(rect.left, window.innerWidth - 170) + 'px';
        menu.style.right = 'auto';
        menu.style.display = 'block';
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-actions')) {
        document.querySelectorAll('[id^="action-menu-"]').forEach(m => m.style.display = 'none');
    }
});
</script>
@endpush

