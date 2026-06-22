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
            <div>
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
            <div>
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
            <div>
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
            <div class="relative flex-1 min-w-[200px] max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-meeting" placeholder="Cari berdasarkan nama pemohon" oninput="filterMeetings()"
                    class="w-full pl-9 pr-3 py-2 rounded-lg text-sm"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <select id="status-filter" onchange="filterMeetings(this.value)" class="ml-auto"
                style="padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;">
                <option value="all">Semua Status</option>
                <option value="pending">Menunggu Review</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]" id="meetings-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pemohon</th>
                        <th>Tim</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Antrian</th>
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
                        <td style="color:var(--text-primary);font-weight:500;">{{ $meeting->title }}</td>
                        <td style="color:var(--text-muted);" class="meeting-pemohon">{{ $meeting->requester->name }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->team->name }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->meeting_date->format('d M Y') }}</td>
                        <td style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                        <td><span class="badge {{ $statusStyle }}">{{ ucfirst($meeting->status) }}</span></td>
                        <td>
                            @if($meeting->queue_position !== null && !in_array($meeting->status, ['pending','rejected','cancelled']))
                                <span class="badge {{ $queueBadge }}">{{ $rt['label'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td class="flex items-center gap-2">
                            <button type="button" onclick="showDetail({{ $meeting->id }})" class="btn btn-secondary btn-sm">Detail</button>
                            @if(in_array($meeting->status, ['cancelled','rejected']))
                            <form method="POST" action="{{ route('admin.meetings.destroy', $meeting) }}" class="inline"
                                onsubmit="return confirm('Hapus meeting ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada permintaan meeting.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $meetings->links() }}</div>
    </div>

</div>

{{-- Modal Detail --}}
<div id="detail-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100vh;z-index:50;align-items:flex-start;justify-content:center;padding:80px 16px 16px;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
    <div class="w-full max-w-[560px] rounded-3xl shadow-2xl flex flex-col" style="max-height:88vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Permintaan Meeting</h3>
            <button type="button" onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
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
            <button type="button" onclick="closeDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
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

    let whyHtml = '';
    if (m.why) whyHtml += `<div class="mb-4"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);letter-spacing:0.03em;">Why — Kenapa meeting ini diadakan?</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${m.why}</p></div>`;
    if (m.what) whyHtml += `<div class="mb-4"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);letter-spacing:0.03em;">What — Apa yang dibahas?</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${m.what}</p></div>`;
    if (m.how_expected) whyHtml += `<div class="mb-4"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);letter-spacing:0.03em;">How — Bagaimana hasil yang diharapkan?</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${m.how_expected}</p></div>`;

    let assetsHtml = '';
    if (m.assets && m.assets.length) {
        assetsHtml = `<div class="pt-4" style="border-top:1px solid var(--border-color);">
            <p class="text-xs font-bold mb-2" style="color:var(--color-accent-light);letter-spacing:0.03em;">Aset Dibutuhkan</p>
            <div class="flex flex-wrap gap-2">${m.assets.map(a => `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background:#e0e7ff;color:#4338ca;">${a.name} (${a.quantity})</span>`).join('')}</div>
        </div>`;
    }

    let momHtml = '';
    if (m.mom) {
        momHtml = `<div class="pt-4" style="border-top:1px solid var(--border-color);">
            <div class="p-4 rounded-2xl" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                <div class="flex items-center justify-between gap-3 mb-3">
                    <p class="text-xs font-bold" style="color:#059669;letter-spacing:0.05em;">MINUTES OF MEETING</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background:${m.mom.status === 'sent' ? '#dcfce7' : '#fef3c7'};color:${m.mom.status === 'sent' ? '#059669' : '#d97706'};">${m.mom.status === 'sent' ? 'Terkirim' : 'Draft'}</span>
                </div>`;
        if (m.mom.summary) momHtml += `<div class="mb-3"><p class="text-xs font-bold mb-1" style="color:#059669;">Ringkasan Pembahasan</p><p class="text-sm p-3 rounded-xl" style="color:var(--text-secondary);background:var(--bg-surface);border:1px solid var(--border-color);">${m.mom.summary}</p></div>`;
        if (m.mom.decisions) momHtml += `<div class="mb-3"><p class="text-xs font-bold mb-1" style="color:#059669;">Keputusan</p><p class="text-sm p-3 rounded-xl" style="color:var(--text-secondary);background:var(--bg-surface);border:1px solid var(--border-color);">${m.mom.decisions}</p></div>`;
        if (m.mom.action_plan) momHtml += `<div class="mb-3"><p class="text-xs font-bold mb-1" style="color:#059669;">Action Plan</p><p class="text-sm p-3 rounded-xl" style="color:var(--text-secondary);background:var(--bg-surface);border:1px solid var(--border-color);">${m.mom.action_plan}</p></div>`;
        momHtml += `<div class="grid grid-cols-2 gap-3"><div><p class="text-xs font-bold mb-0.5" style="color:#059669;">PIC</p><p class="text-sm font-semibold" style="color:var(--text-primary);">${m.mom.pic || '-'}</p></div><div><p class="text-xs font-bold mb-0.5" style="color:#059669;">Dibuat Oleh</p><p class="text-sm font-semibold" style="color:var(--text-primary);">${m.mom.creator_name || '-'}</p></div></div>`;
        if (m.mom.file_url) momHtml += `<div class="mt-3"><a href="${m.mom.file_url}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Download Lampiran</a></div>`;
        if (m.mom.sent_at) momHtml += `<p class="text-xs mt-2" style="color:var(--text-muted);">Dikirim pada ${m.mom.sent_at}</p>`;
        momHtml += `</div></div>`;
    }

    const infoRows = [
        { label: 'Pemohon', value: m.requester?.name || '-' },
        { label: 'Judul Meeting', value: m.title },
        { label: 'Tanggal', value: m.meeting_date || '-' },
        { label: 'Ruangan', value: m.room?.name || '-' },
    ];

    body.innerHTML = `
        <div class="space-y-5">
            <div>
                ${infoRows.map((r, i) => `
                    <div class="flex items-center justify-between py-2.5" ${i < infoRows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                        <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                        <p class="text-sm font-semibold" style="color:var(--text-primary);">${r.value}</p>
                    </div>
                `).join('')}
                <div class="flex items-center justify-between py-2.5">
                    <p class="text-sm" style="color:var(--text-muted);">Status</p>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${st.bg};color:${st.text};border:1px solid ${st.border};">${st.label}</span>
                </div>
            </div>

            ${whyHtml ? `
                <div class="pt-1">
                    <p class="text-xs font-bold tracking-wider mb-3" style="color:var(--color-accent-light);">DETAIL PERMOHONAN MEETING</p>
                    ${whyHtml}
                </div>
            ` : ''}

            ${assetsHtml}
            ${momHtml}
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

    document.getElementById('detail-modal').style.display = 'flex';
}

function closeDetail() {
    document.getElementById('detail-modal').style.display = 'none';
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDetail();
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
    const status = document.getElementById('status-filter').value;
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

// Auto-open detail modal from dashboard review link
const reviewId = new URLSearchParams(window.location.search).get('review');
if (reviewId) {
    showDetail(parseInt(reviewId));
}
</script>
@endpush

