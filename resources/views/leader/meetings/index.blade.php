@extends('layouts.app')
@section('title', 'Meeting Saya')
@section('page-title', 'Meeting Saya')
@section('page-subtitle', 'Kelola seluruh meeting yang kamu ajukan')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

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
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Meeting</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh daftar meeting yang kamu ajukan.</div>
            </div>
        </div>

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
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Menunggu</div>
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
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $disetujuiMeeting }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Disetujui</div>
            </div>
        </div>

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
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Meeting Saya</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Daftar seluruh meeting yang telah kamu ajukan.</div>
            </div>
            <button type="button" onclick="openRequestModal()" class="btn btn-primary btn-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Request Meeting
            </button>
        </div>
        <div class="px-5 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-meeting" placeholder="Cari berdasarkan judul meeting" oninput="filterMeetings()"
                    class="w-full pl-9 pr-3 py-2 rounded-lg text-sm"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <select id="status-filter" onchange="filterMeetings(this.value)" class="ml-auto"
                style="padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;">
                <option value="all">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
                <option value="confirmed">Dikonfirmasi</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]" id="meetings-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th class="hidden md:table-cell">Ruangan</th>
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
                    <tr data-meeting-id="{{ $meeting->id }}" data-status="{{ $meeting->status }}" data-title="{{ strtolower($meeting->title) }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $meeting->title }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->meeting_date->format('d M Y') }}</td>
                        <td style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $meeting->room->name }}</td>
                        <td><span class="badge {{ $statusStyle }}">{{ ucfirst($meeting->status) }}</span></td>
                        <td class="hidden md:table-cell">
                            @if($meeting->queue_position !== null && !in_array($meeting->status, ['pending','rejected','cancelled']))
                                <span class="badge {{ $queueBadge }}">{{ $rt['label'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" onclick="showDetail({{ $meeting->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;">Detail</button>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada meeting.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 flex items-center justify-end" style="border-top:1px solid var(--border-color);">
            <span id="rt-update" style="font-size:0.7rem;color:var(--text-muted);"></span>
        </div>
    </div>

</div>

{{-- Modal Detail Meeting --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:50px 16px 16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[680px] rounded-3xl shadow-2xl flex flex-col" style="max-height:85vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Meeting</h3>
            <button type="button" onclick="closeModal('detail-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
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
        <div id="d-actions-section" class="hidden px-6 pb-4 flex-shrink-0"></div>

        {{-- Footer --}}
        <div class="px-6 py-4 flex-shrink-0 flex justify-end" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeModal('detail-modal')" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>

{{-- Request Meeting Modal --}}
<div id="request-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:flex-start;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[820px] rounded-3xl shadow-2xl flex flex-col" style="max-height:calc(100vh - 32px);background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-5 py-3 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div>
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Request Meeting Baru</h3>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);">Isi detail pertemuan untuk mengajukan meeting.</p>
            </div>
            <button type="button" onclick="closeModal('request-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('koordinator.meetings.store') }}" enctype="multipart/form-data" class="px-5 py-4 overflow-y-auto flex-1">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- LEFT COLUMN --}}
                <div class="space-y-4">

                    {{-- Info Dasar --}}
                    <div>
                        <p class="font-gaming font-semibold text-xs mb-2" style="color:var(--text-primary);letter-spacing:0.05em;">INFO DASAR</p>
                        <div class="space-y-2">
                            <div>
                                <label class="gaming-label">Judul Meeting <span style="color:#f87171;">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Evaluasi Konten Mingguan" class="gaming-input">
                            </div>
                            <div>
                                <label class="gaming-label">Ruangan <span style="color:#f87171;">*</span></label>
                                <select name="room_id" required class="gaming-input gaming-select">
                                    <option value="">Pilih Ruangan</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} ({{ $room->capacity }} orang)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="gaming-label">Tanggal <span style="color:#f87171;">*</span></label>
                                    <input type="date" name="meeting_date" value="{{ old('meeting_date') }}" required min="{{ date('Y-m-d') }}" class="gaming-input">
                                </div>
                                <div>
                                    <label class="gaming-label">Jam Mulai <span style="color:#f87171;">*</span></label>
                                    <input type="time" name="start_time" value="{{ old('start_time') }}" required class="gaming-input">
                                </div>
                            </div>
                            <div>
                                <label class="gaming-label">Jam Selesai <span style="color:#f87171;">*</span></label>
                                <input type="time" name="end_time" value="{{ old('end_time') }}" required class="gaming-input">
                            </div>
                        </div>
                    </div>

                    {{-- Tim --}}
                    <div style="border-top:1px solid var(--border-color);padding-top:0.75rem;">
                        <p class="font-gaming font-semibold text-xs mb-2" style="color:var(--text-primary);letter-spacing:0.05em;">TIM</p>
                        @if(in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr', 'ceo']))
                        <div class="mb-2">
                            <label class="gaming-label">Tim Utama <span style="color:#f87171;">*</span></label>
                            <select name="main_team_id" required class="gaming-input gaming-select">
                                <option value="">Pilih Tim Utama</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('main_team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="gaming-label mb-0">Tim Tambahan <span style="color:var(--text-muted);font-weight:400;font-size:0.7rem;">(Opsional)</span></label>
                                <button type="button" onclick="addTeamRowModal()" class="btn btn-secondary btn-sm" style="padding:3px 8px;font-size:0.7rem;">+ Tambah</button>
                            </div>
                            <div id="modal-extra-teams" class="space-y-1.5"></div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-4">

                    {{-- 5W1H --}}
                    <div>
                        <p class="font-gaming font-semibold text-xs mb-2" style="color:var(--text-primary);letter-spacing:0.05em;">DETAIL MEETING (5W1H)</p>
                        <div class="space-y-2">
                            <div>
                                <label class="gaming-label">WHY <span style="color:#f87171;">*</span></label>
                                <textarea name="why" rows="2" required placeholder="Kenapa meeting ini diadakan?" class="gaming-input" style="resize:vertical;">{{ old('why') }}</textarea>
                            </div>
                            <div>
                                <label class="gaming-label">WHAT <span style="color:#f87171;">*</span></label>
                                <textarea name="what" rows="2" required placeholder="Apa yang akan dibahas?" class="gaming-input" style="resize:vertical;">{{ old('what') }}</textarea>
                            </div>
                            <div>
                                <label class="gaming-label">HOW <span style="color:#f87171;">*</span></label>
                                <textarea name="how_expected" rows="2" required placeholder="Hasil yang diharapkan?" class="gaming-input" style="resize:vertical;">{{ old('how_expected') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Lampiran & Aset --}}
                    <div style="border-top:1px solid var(--border-color);padding-top:0.75rem;">
                        <p class="font-gaming font-semibold text-xs mb-2" style="color:var(--text-primary);letter-spacing:0.05em;">LAMPIRAN & ASET</p>
                        <div class="space-y-2">
                            <div>
                                <label class="gaming-label">Lampiran File <span style="color:var(--text-muted);font-weight:400;font-size:0.7rem;">(Opsional)</span></label>
                                <input type="file" name="file" accept=".pdf,.doc,.docx" class="gaming-input" style="padding:0.4rem;font-size:0.8rem;">
                            </div>
                            @if($assets->count())
                            <div>
                                <label class="gaming-label">Kebutuhan Aset</label>
                                <div class="space-y-1">
                                    @foreach($assets->take(4) as $asset)
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs flex-1" style="color:var(--text-secondary);">{{ $asset->name }}</span>
                                        <input type="number" name="assets[{{ $asset->id }}]" min="0" max="{{ $asset->quantity }}" value="0"
                                            class="gaming-input text-center" style="width:50px;padding:0.2rem 0.3rem;font-size:0.75rem;">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

            {{-- Actions --}}
            <div class="flex gap-3 mt-4 pt-3" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Request
                </button>
                <button type="button" onclick="closeModal('request-modal')" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function filterMeetings() {
    const status = document.getElementById('status-filter').value;
    const search = (document.getElementById('search-meeting')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#meetings-tbody tr:not(#empty-row)');

    let visible = 0;
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const title = (row.dataset.title || '');
        const matchStatus = status === 'all' || rowStatus === status;
        const matchSearch = !search || title.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
        if (matchStatus && matchSearch) visible++;
    });

    const emptyRow = document.getElementById('empty-row');
    if (emptyRow) emptyRow.style.display = visible === 0 ? '' : 'none';
}

function getRtStyleInline(label) {
    if (!label) return '';
    if (label.includes('Berlangsung')) return 'background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);';
    if (label.includes('Antrian'))     return 'background:rgba(249,115,22,0.15);color:#fb923c;border:1px solid rgba(249,115,22,0.3);';
    if (label.includes('Di Booking'))  return 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);';
    if (label.includes('Selesai'))     return 'background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid rgba(148,163,184,0.3);';
    return 'background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);';
}

function refreshStatus() {
    fetch('{{ route("realtime.meetings") }}')
        .then(r => r.json())
        .then(data => {
            data.forEach(m => {
                const row = document.querySelector(`tr[data-meeting-id="${m.id}"]`);
                if (!row) return;
                const badge = row.querySelector('.rt-badge');
                if (!badge) return;
                badge.textContent = m.rt_label;
                badge.style.cssText = getRtStyleInline(m.rt_label);
            });
            const el = document.getElementById('rt-update');
            if (el) el.textContent = '⟳ ' + new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'});
        }).catch(() => {});
}

setInterval(refreshStatus, 30000);
refreshStatus();

// Request Modal
const teamsData = @json($teams);

function openRequestModal() {
    openModal('request-modal');
}

function closeRequestModal() {
    closeModal('request-modal');
}

document.getElementById('request-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal('request-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal('request-modal');
});

function addTeamRowModal() {
    const container = document.getElementById('modal-extra-teams');
    const selected = [...container.querySelectorAll('select')].map(s => s.value);
    const options = teamsData.filter(t => !selected.includes(String(t.id)))
        .map(t => `<option value="${t.id}">${t.name}</option>`).join('');
    if (!options) { alert('Semua tim sudah ditambahkan.'); return; }
    const row = document.createElement('div');
    row.className = 'flex items-center gap-2';
    row.innerHTML = `
        <select name="extra_teams[]" class="gaming-input flex-1" style="font-size:0.8rem;">
            <option value="">Pilih Tim</option>${options}
        </select>
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm" style="padding:4px 8px;font-size:0.7rem;">✕</button>`;
    container.appendChild(row);
}

if (new URLSearchParams(window.location.search).get('open_request') === '1') {
    openRequestModal();
    history.replaceState(null, '', window.location.pathname);
}

// ─── Detail Modal ───
const meetingsData = @json($meetingsJson);
const csrfToken = '{{ csrf_token() }}';
const usersData = @json($users->map(fn($u) => ['id' => $u->id, 'name' => $u->name]));

const statusMap = {
    pending:     { label: '● MENUNGGU',  cls: 'badge-yellow' },
    approved:    { label: '● DISETUJUI',  cls: 'badge-blue' },
    rejected:    { label: '● DITOLAK',    cls: 'badge-red' },
    confirmed:   { label: '● DIKONFIRMASI', cls: 'badge-primary' },
    cancelled:   { label: '● DIBATALKAN', cls: 'badge-gray' },
    in_progress: { label: '● BERLANGSUNG', cls: 'badge-primary' },
    completed:   { label: '● SELESAI',    cls: 'badge-green' },
};

function showDetail(id) {
    const m = meetingsData.find(i => i.id === id);
    if (!m) return;

    const body = document.getElementById('detail-body');
    const st = statusMap[m.status] || statusMap.cancelled;

    const infoRows = [
        { label: 'Pemohon', value: m.requester?.name || '-' },
        { label: 'Judul', value: m.title },
        { label: 'Tanggal', value: m.meeting_date || '-' },
        { label: 'Waktu', value: (m.start_time?.substring(0,5)||'') + ' – ' + (m.end_time?.substring(0,5)||'') },
        { label: 'Ruangan', value: m.room?.name || '-' },
        { label: 'Tim', value: m.team?.name || '-' },
    ];

    let detailHtml = '';
    if (m.why) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">Why</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${escHtml(m.why)}</p></div>`;
    if (m.what) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">What</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${escHtml(m.what)}</p></div>`;
    if (m.how_expected) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">How</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${escHtml(m.how_expected)}</p></div>`;

    let extraTeamsHtml = '';
    if (m.teams && m.teams.length) {
        extraTeamsHtml = `<div class="flex flex-wrap gap-1.5">${m.teams.map(t => `<span class="badge badge-blue">${escHtml(t)}</span>`).join('')}</div>`;
    }

    let assetsHtml = '';
    if (m.assets && m.assets.length) {
        assetsHtml = `<div class="flex flex-wrap gap-1.5">${m.assets.map(a => `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background:#e0e7ff;color:#4338ca;">${escHtml(a.name)} (${a.quantity})</span>`).join('')}</div>`;
    }

    let momHtml = '';
    if (m.mom) {
        momHtml += `<div class="flex items-center gap-2 mb-3"><span class="badge ${m.mom.status === 'sent' ? 'badge-green' : 'badge-yellow'}">${m.mom.status === 'sent' ? 'Terkirim' : 'Draft'}</span></div>`;
        if (m.mom.summary) momHtml += `<div class="mb-3 p-4 rounded-xl" style="background:var(--bg-surface);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1" style="color:#059669;">Ringkasan</p><p class="text-sm" style="color:var(--text-secondary);line-height:1.6;">${escHtml(m.mom.summary)}</p></div>`;
        if (m.mom.decisions) momHtml += `<div class="mb-3 p-4 rounded-xl" style="background:var(--bg-surface);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1" style="color:#059669;">Keputusan</p><p class="text-sm" style="color:var(--text-secondary);line-height:1.6;">${escHtml(m.mom.decisions)}</p></div>`;
        if (m.mom.action_plan) momHtml += `<div class="mb-3 p-4 rounded-xl" style="background:var(--bg-surface);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1" style="color:#059669;">Action Plan</p><p class="text-sm" style="color:var(--text-secondary);line-height:1.6;">${escHtml(m.mom.action_plan)}</p></div>`;
        momHtml += `<div class="grid grid-cols-2 gap-3 text-sm"><div><span class="text-xs font-bold" style="color:#059669;">PIC</span><p class="font-semibold mt-0.5" style="color:var(--text-primary);">${escHtml(m.mom.pic || '-')}</p></div><div><span class="text-xs font-bold" style="color:#059669;">Dibuat</span><p class="font-semibold mt-0.5" style="color:var(--text-primary);">${escHtml(m.mom.creator_name || '-')}</p></div></div>`;
        if (m.mom.file_url) {
            momHtml += `<div class="mt-3"><a href="${m.mom.file_url}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition" style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Download</a></div>`;
        }
        if (m.mom.sent_at) momHtml += `<p class="text-xs mt-2" style="color:var(--text-muted);">Dikirim ${escHtml(m.mom.sent_at)}</p>`;
    }

    let rtBadge = '';
    if (m.queue_position !== null && !['pending','rejected','cancelled'].includes(m.status)) {
        const isBerlangsung = m.rt_label && m.rt_label.includes('Berlangsung');
        const isAntrian = m.rt_label && m.rt_label.includes('Antrian');
        const isBooking = m.rt_label && m.rt_label.includes('Di Booking');
        const isSelesai = m.rt_label && m.rt_label.includes('Selesai');
        let qCls = 'badge-gray';
        if (isBerlangsung) qCls = 'badge-primary';
        else if (isAntrian) qCls = 'badge-orange';
        else if (isBooking) qCls = 'badge-blue';
        else if (isSelesai) qCls = 'badge-green';
        rtBadge = `<span class="badge ${qCls}">${escHtml(m.rt_label)}</span>`;
    }

    body.innerHTML = `
        <div class="space-y-4">
            <!-- Info Card -->
            <div class="rounded-2xl overflow-hidden" style="border:1px solid var(--border-color);">
                <div class="px-5 py-3 flex items-center justify-between flex-wrap gap-2" style="background:var(--bg-surface-2);border-bottom:1px solid var(--border-color);">
                    <p class="text-xs font-bold tracking-wider" style="color:var(--text-muted);">INFORMASI MEETING</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="badge ${st.cls}">${st.label}</span>
                        ${rtBadge}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-0">
                    ${infoRows.map((r, i) => `
                        <div class="px-5 py-3" ${i < infoRows.length - 2 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                            <p class="text-xs mb-0.5" style="color:var(--text-muted);">${r.label}</p>
                            <p class="text-sm font-semibold" style="color:var(--text-primary);">${escHtml(r.value)}</p>
                        </div>
                    `).join('')}
                </div>
            </div>

            ${extraTeamsHtml ? `
            <!-- Tim Tambahan -->
            <div>
                <p class="text-xs font-bold tracking-wider mb-2 px-1" style="color:var(--color-accent-light);">TIM TAMBAHAN</p>
                ${extraTeamsHtml}
            </div>` : ''}

            ${detailHtml ? `
            <!-- Detail Permohonan -->
            <div>
                <p class="text-xs font-bold tracking-wider mb-2.5 px-1" style="color:var(--color-accent-light);">DETAIL PERMOHONAN</p>
                <div class="space-y-2.5">${detailHtml}</div>
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

    // Reject reason
    const rejectSec = document.getElementById('d-reject-section');
    const rejectReason = document.getElementById('d-reject-reason');
    if (m.reject_reason) {
        rejectSec.classList.remove('hidden');
        rejectReason.textContent = m.reject_reason;
    } else {
        rejectSec.classList.add('hidden');
    }

    // Actions
    const actionsSec = document.getElementById('d-actions-section');
    let actionsHtml = '';
    if (m.status === 'approved') {
        actionsHtml = `
            <p class="text-[11px] font-bold tracking-[0.1em] mb-3" style="color:var(--text-muted);">TINDAKAN</p>
            <div class="flex flex-wrap gap-2">
                <button onclick="submitAction(${m.id},'confirm')" class="btn btn-primary btn-sm">✓ Konfirmasi Hadir</button>
                <button onclick="showFinishForm(${m.id})" class="btn btn-success btn-sm">✓ Selesaikan</button>
                <button onclick="submitAction(${m.id},'cancel')" class="btn btn-danger btn-sm">✗ Batalkan</button>
            </div>
            <div id="d-finish-form-${m.id}" class="hidden mt-3 p-3 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <label class="gaming-label">Jam Selesai Aktual</label>
                <div class="flex items-center gap-2 mt-1">
                    <input type="time" id="d-finish-time-${m.id}" value="${getCurrentTime()}" class="gaming-input" style="width:140px;">
                    <button onclick="submitFinish(${m.id})" class="btn btn-success btn-sm">✓ Selesaikan Meeting</button>
                    <button onclick="document.getElementById('d-finish-form-${m.id}').classList.add('hidden')" class="btn btn-secondary btn-sm">Batal</button>
                </div>
            </div>`;
    } else if (m.status === 'confirmed' || m.status === 'in_progress') {
        actionsHtml = `
            <p class="text-[11px] font-bold tracking-[0.1em] mb-3" style="color:var(--text-muted);">TINDAKAN</p>
            <div class="flex flex-wrap gap-2">
                <button onclick="showFinishForm(${m.id})" class="btn btn-success btn-sm">✓ Selesaikan</button>
                <button onclick="submitAction(${m.id},'cancel')" class="btn btn-danger btn-sm">✗ Batalkan</button>
            </div>
            <div id="d-finish-form-${m.id}" class="hidden mt-3 p-3 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <label class="gaming-label">Jam Selesai Aktual</label>
                <div class="flex items-center gap-2 mt-1">
                    <input type="time" id="d-finish-time-${m.id}" value="${getCurrentTime()}" class="gaming-input" style="width:140px;">
                    <button onclick="submitFinish(${m.id})" class="btn btn-success btn-sm">✓ Selesaikan Meeting</button>
                    <button onclick="document.getElementById('d-finish-form-${m.id}').classList.add('hidden')" class="btn btn-secondary btn-sm">Batal</button>
                </div>
            </div>`;
    } else if (m.status === 'completed' && !m.mom) {
        actionsHtml = `
            <p class="text-[11px] font-bold tracking-[0.1em] mb-3" style="color:var(--text-muted);">MINUTES OF MEETING (MOM)</p>
            <button onclick="showMomForm(${m.id})" class="btn btn-success btn-sm">+ Buat MOM</button>
            <div id="d-mom-form-${m.id}" class="hidden mt-3 space-y-3 p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div>
                    <label class="gaming-label">Ringkasan Pembahasan <span style="color:#f87171;">*</span></label>
                    <textarea id="mom-summary-${m.id}" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Keputusan <span style="color:#f87171;">*</span></label>
                    <textarea id="mom-decisions-${m.id}" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Action Plan <span style="color:#f87171;">*</span></label>
                    <textarea id="mom-action-${m.id}" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Penanggung Jawab (PIC) <span style="color:#f87171;">*</span></label>
                    <select id="mom-pic-${m.id}" class="gaming-input gaming-select">
                        <option value="">Pilih PIC</option>
                        ${usersData.map(u => `<option value="${escHtml(u.name)}">${escHtml(u.name)}</option>`).join('')}
                    </select>
                </div>
                <div class="flex gap-2">
                    <button onclick="submitMom(${m.id})" class="btn btn-primary btn-sm">Simpan Draft</button>
                    <button onclick="document.getElementById('d-mom-form-${m.id}').classList.add('hidden')" class="btn btn-secondary btn-sm">Batal</button>
                </div>
            </div>`;
    } else if (m.status === 'completed' && m.mom && m.mom.status === 'draft') {
        actionsHtml = `
            <p class="text-[11px] font-bold tracking-[0.1em] mb-3" style="color:var(--text-muted);">MINUTES OF MEETING (MOM)</p>
            <div class="flex flex-wrap gap-2">
                <button onclick="sendMom(${m.id})" class="btn btn-success btn-sm">Kirim MOM</button>
            </div>`;
    }
    if (actionsHtml) {
        actionsSec.classList.remove('hidden');
        actionsSec.innerHTML = actionsHtml;
    } else {
        actionsSec.classList.add('hidden');
    }

    openModal('detail-modal');
}

function escHtml(str) {
    if (!str) return '';
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

function getCurrentTime() {
    const now = new Date();
    return String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');
}

function submitAction(id, action) {
    if (action === 'cancel' && !confirm('Batalkan meeting ini?')) return;
    const urlMap = { confirm: '/koordinator/meetings/' + id + '/confirm', cancel: '/koordinator/meetings/' + id + '/cancel' };
    fetch(urlMap[action], {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH' })
    }).then(r => r.json()).then(() => location.reload()).catch(() => location.reload());
}

function showFinishForm(id) {
    document.getElementById('d-finish-form-' + id).classList.remove('hidden');
}

function submitFinish(id) {
    const time = document.getElementById('d-finish-time-' + id).value;
    if (!time) { alert('Isi jam selesai terlebih dahulu.'); return; }
    fetch('/koordinator/meetings/' + id + '/finish', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH', actual_end_time: time })
    }).then(r => r.json()).then(() => location.reload()).catch(() => location.reload());
}

function showMomForm(id) {
    document.getElementById('d-mom-form-' + id).classList.remove('hidden');
}

function submitMom(id) {
    const summary = document.getElementById('mom-summary-' + id).value.trim();
    const decisions = document.getElementById('mom-decisions-' + id).value.trim();
    const actionPlan = document.getElementById('mom-action-' + id).value.trim();
    const pic = document.getElementById('mom-pic-' + id).value;
    if (!summary || !decisions || !actionPlan || !pic) { alert('Semua field harus diisi.'); return; }
    fetch('/koordinator/meetings/' + id + '/mom', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify({ summary, decisions, action_plan: actionPlan, pic })
    }).then(r => r.json()).then(() => location.reload()).catch(() => location.reload());
}

function sendMom(meetingId) {
    const m = meetingsData.find(i => i.id === meetingId);
    if (!m || !m.mom || !m.mom.id) return;
    const momId = m.mom.id;
    if (!confirm('Kirim MOM ini ke semua peserta?')) return;
    fetch('/koordinator/mom/' + momId + '/send', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH' })
    }).then(r => r.json()).then(() => location.reload()).catch(() => location.reload());
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('detail-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal('detail-modal');
});
</script>
@endpush
