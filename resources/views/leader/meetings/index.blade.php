@extends('layouts.app')
@section('title', 'Meeting Saya')
@section('page-title', 'Meeting Saya')
@section('page-subtitle', 'Kelola seluruh meeting yang kamu ajukan')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.12);">
                <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xl font-bold" style="color:var(--text-primary);">{{ $totalMeeting }}</div>
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Total Meeting</div>
            </div>
        </div>

        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.12);">
                <svg class="w-[18px] h-[18px]" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xl font-bold" style="color:#fbbf24;">{{ $menungguMeeting }}</div>
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Menunggu</div>
            </div>
        </div>

        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.12);">
                <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xl font-bold" style="color:#34d399;">{{ $disetujuiMeeting }}</div>
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Disetujui</div>
            </div>
        </div>

        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.12);">
                <svg class="w-[18px] h-[18px]" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xl font-bold" style="color:#f87171;">{{ $ditolakMeeting }}</div>
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Ditolak</div>
            </div>
        </div>

    </div>

    {{-- Table --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Meeting Saya</div>
                <div style="font-size:0.7rem;margin-top:2px;color:var(--text-muted);">Daftar seluruh meeting yang telah kamu ajukan.</div>
            </div>
            <button type="button" onclick="openRequestModal()" class="btn btn-primary btn-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Request Meeting
            </button>
        </div>
        <div class="px-6 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-meeting" placeholder="Cari berdasarkan judul meeting" oninput="filterMeetings()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
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
                <colgroup>
                    <col style="width:44px">
                    <col>
                    <col style="width:115px">
                    <col style="width:105px">
                    <col class="hidden md:table-cell" style="width:130px">
                    <col style="width:85px">
                    <col class="hidden md:table-cell" style="width:85px">
                    <col style="width:75px">
                </colgroup>
                <thead>
                    <tr>
                        <th style="width:44px">No</th>
                        <th>Judul</th>
                        <th style="width:115px">Tanggal</th>
                        <th style="width:105px">Waktu</th>
                        <th class="hidden md:table-cell" style="width:130px">Ruangan</th>
                        <th style="width:85px">Status</th>
                        <th class="hidden md:table-cell" style="width:85px">Antrian</th>
                        <th style="width:75px">Aksi</th>
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
                    <tr data-meeting-id="{{ $meeting->id }}" data-status="{{ $meeting->status }}" data-title="{{ strtolower($meeting->title) }}" class="meeting-row">
                        <td style="color:var(--text-muted);font-size:0.8rem;">{{ $loop->iteration }}</td>
                        <td><span class="font-medium" style="color:var(--text-primary);font-size:0.8rem;">{{ $meeting->title }}</span></td>
                        <td><span style="color:var(--text-secondary);font-size:0.8rem;">{{ $meeting->meeting_date->format('d M Y') }}</span></td>
                        <td><span style="color:var(--text-secondary);font-size:0.8rem;">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</span></td>
                        <td class="hidden md:table-cell"><span style="color:var(--text-secondary);font-size:0.8rem;">{{ $meeting->room->name }}</span></td>
                        <td><span class="badge {{ $statusStyle }}" style="font-size:0.65rem;">{{ ucfirst($meeting->status) }}</span></td>
                        <td class="hidden md:table-cell">
                            @if($meeting->queue_position !== null && !in_array($meeting->status, ['pending','rejected','cancelled']))
                                <span class="badge {{ $queueBadge }}" style="font-size:0.65rem;">{{ $rt['label'] }}</span>
                            @else
                                <span style="color:var(--text-muted);font-size:0.8rem;">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1" style="white-space:nowrap;">
                                <button type="button" onclick="showDetail({{ $meeting->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:2px;padding:3px 6px;font-size:0.65rem;" title="Lihat detail">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="8" style="text-align:center;padding:2.5rem;color:var(--text-muted);font-size:0.9rem;">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Belum ada meeting.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 flex items-center justify-end" style="border-top:1px solid var(--border-color);">
            <span id="rt-update" style="font-size:0.7rem;color:var(--text-muted);"></span>
        </div>
    </div>

</div>

@push('modals')
{{-- Modal Detail Meeting --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
    <div class="w-full max-w-[560px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

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
<div id="request-modal" style="display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
    <div class="w-full max-w-[820px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div>
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Request Meeting Baru</h3>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);">Isi detail pertemuan untuk mengajukan meeting.</p>
            </div>
            <button type="button" onclick="closeModal('request-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('koordinator.meetings.store') }}" enctype="multipart/form-data" class="px-6 py-5 space-y-4 overflow-y-auto flex-1">
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
                                    <input type="text" name="start_time" id="modal-start-time" value="{{ old('start_time') }}" required class="gaming-input" placeholder="--:--" autocomplete="off">
                                </div>
                            </div>
                            <div>
                                <label class="gaming-label">Jam Selesai <span style="color:#f87171;">*</span></label>
                                <input type="text" name="end_time" id="modal-end-time" value="{{ old('end_time') }}" required class="gaming-input" placeholder="--:--" autocomplete="off">
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
            <div class="flex gap-3 pt-3" style="border-top:1px solid var(--border-color);">
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
@endpush

{{-- MOM Modal (terpisah dari modal detail) --}}
<div id="mom-modal" style="display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);" data-meeting-id="">
    <div class="w-full max-w-[560px] rounded-3xl shadow-2xl flex flex-col" style="max-height:75vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div>
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Buat Minutes of Meeting</h3>
                <p class="text-xs mt-0.5" style="color:var(--text-muted);" id="mom-modal-meeting-info">Meeting: -</p>
            </div>
            <button type="button" onclick="closeMomModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1 space-y-4">
            <div>
                <label class="gaming-label">Ringkasan Pembahasan <span style="color:#f87171;">*</span></label>
                <textarea id="mom-summary" rows="2" class="gaming-input" style="resize:vertical;" placeholder="Ringkasan hasil pembahasan meeting"></textarea>
            </div>
            <div>
                <label class="gaming-label">Keputusan <span style="color:#f87171;">*</span></label>
                <textarea id="mom-decisions" rows="2" class="gaming-input" style="resize:vertical;" placeholder="Keputusan yang diambil"></textarea>
            </div>
            <div>
                <label class="gaming-label">Action Plan <span style="color:#f87171;">*</span></label>
                <textarea id="mom-action" rows="2" class="gaming-input" style="resize:vertical;" placeholder="Rencana tindak lanjut"></textarea>
            </div>
            <div>
                <label class="gaming-label">Penanggung Jawab (PIC) <span style="color:#f87171;">*</span></label>
                <select id="mom-pic" class="gaming-input gaming-select">
                    <option value="">Pilih PIC</option>
                    @foreach($users as $u)
                        <option value="{{ $u->name }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="gaming-label">Upload File <span style="color:var(--text-muted);font-weight:400;">(Opsional)</span></label>
                <input type="file" id="mom-file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="gaming-input" style="padding:0.4rem;font-size:0.8rem;">
            </div>
        </div>
        <div class="px-6 py-4 flex-shrink-0 flex items-center gap-2" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="submitMomWithAction('send', event)" class="btn btn-success">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Kirim
            </button>
            <button type="button" onclick="submitMomWithAction('draft', event)" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Simpan Draft
            </button>
            <button type="button" onclick="closeMomModal()" class="btn btn-secondary">Batal</button>
        </div>
    </div>
</div>

{{-- Modal Sukses Kirim MOM --}}
<div id="mom-success-modal" style="display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
    <div class="w-full max-w-[400px] rounded-3xl shadow-2xl p-8 text-center" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background:rgba(16,185,129,0.15);">
            <svg class="w-8 h-8" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold mb-2" style="color:var(--text-primary);">MOM Terkirim!</h3>
        <p class="text-sm mb-6" style="color:var(--text-secondary);" id="mom-success-message">Minutes of Meeting berhasil dikirim ke seluruh peserta.</p>
        <button type="button" onclick="closeMomSuccessModal()" class="btn btn-primary px-8">Tutup</button>
    </div>
</div>

{{-- Modal Draft MOM (Belum Terkirim) --}}
<div id="mom-draft-modal" style="display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
    <div class="w-full max-w-[400px] rounded-3xl shadow-2xl p-8 text-center" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background:rgba(245,158,11,0.15);">
            <svg class="w-8 h-8" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold mb-2" style="color:var(--text-primary);">MOM Disimpan!</h3>
        <p class="text-sm mb-1" style="color:var(--text-secondary);" id="mom-draft-message">MOM berhasil disimpan sebagai draft.</p>
        <p class="text-xs font-semibold mb-6" style="color:#f59e0b;">⚠ MOM Belum Terkirim</p>
        <div class="flex gap-3 justify-center">
            <button type="button" onclick="sendDraftMom()" class="btn btn-success">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Kirim Sekarang
            </button>
            <button type="button" onclick="closeMomDraftModal()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Flatpickr for request modal
let modalStartFp = null;
let modalEndFp = null;

function initModalTimeRestrictions() {
    const form = document.querySelector('#request-modal form');
    if (!form) return;
    const dateInput = form.querySelector('input[name="meeting_date"]');
    const startInput = document.getElementById('modal-start-time');
    const endInput = document.getElementById('modal-end-time');

    if (modalStartFp) modalStartFp.destroy();
    if (modalEndFp) modalEndFp.destroy();

    const today = getTodayStr();
    const isToday = dateInput.value === today;
    const min = isToday ? nowTime() : '00:00';
    const startVal = isToday ? nowTime() : (startInput.value || '08:00');
    const endVal = isToday ? addHour(nowTime()) : (endInput.value || '09:00');

    modalStartFp = flatpickr(startInput, {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        time_24hr: true,
        minTime: min,
        defaultDate: startVal,
        onChange: function(selectedDates, dateStr) {
            if (modalEndFp) {
                modalEndFp.set('minTime', dateStr);
                if (modalEndFp.selectedDates.length && modalEndFp.selectedDates[0] <= selectedDates[0]) {
                    modalEndFp.setDate(addHour(dateStr));
                }
            }
        }
    });

    modalEndFp = flatpickr(endInput, {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        time_24hr: true,
        minTime: modalStartFp.selectedDates.length ? modalStartFp.input.value : startVal,
        defaultDate: endVal,
    });

    dateInput.addEventListener('change', function() {
        const isToday = this.value === getTodayStr();
        if (isToday) {
            modalStartFp.set('minTime', nowTime());
            modalStartFp.setDate(nowTime());
            modalEndFp.set('minTime', nowTime());
            modalEndFp.setDate(addHour(nowTime()));
        } else {
            modalStartFp.set('minTime', '00:00');
            if (!modalStartFp.selectedDates.length) modalStartFp.setDate('08:00');
            modalEndFp.set('minTime', modalStartFp.input.value);
            if (!modalEndFp.selectedDates.length) modalEndFp.setDate('09:00');
        }
    });
}

document.addEventListener('DOMContentLoaded', initModalTimeRestrictions);

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
    if (!options) { showAlertModal('Semua tim sudah ditambahkan.'); return; }
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
                <button onclick="showFinishForm(${m.id})" class="btn btn-success btn-sm">✓ Selesaikan</button>
                <button onclick="submitAction(${m.id},'cancel')" class="btn btn-danger btn-sm">✗ Batalkan</button>
            </div>
            <div id="d-finish-form-${m.id}" class="hidden mt-3 p-3 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <label class="gaming-label">Jam Selesai Aktual</label>
                <div class="flex items-center gap-2 mt-1">
                    <input type="text" id="d-finish-time-${m.id}" value="${getCurrentTime()}" data-min="${m.start_time ? m.start_time.substring(0,5) : '00:00'}" class="gaming-input finish-time-fp" style="width:140px;" autocomplete="off">
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
                    <input type="text" id="d-finish-time-${m.id}" value="${getCurrentTime()}" data-min="${m.start_time ? m.start_time.substring(0,5) : '00:00'}" class="gaming-input finish-time-fp" style="width:140px;" autocomplete="off">
                    <button onclick="submitFinish(${m.id})" class="btn btn-success btn-sm">✓ Selesaikan Meeting</button>
                    <button onclick="document.getElementById('d-finish-form-${m.id}').classList.add('hidden')" class="btn btn-secondary btn-sm">Batal</button>
                </div>
            </div>`;
    } else if (m.status === 'completed' && !m.mom) {
        actionsHtml = `
            <p class="text-[11px] font-bold tracking-[0.1em] mb-3" style="color:var(--text-muted);">MINUTES OF MEETING (MOM)</p>
            <div class="flex flex-wrap gap-2">
                <button onclick="closeDetailAndOpenMom(${m.id})" class="btn btn-success btn-sm">+ Buat MOM</button>
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

function executeAction(id, action) {
    const urlMap = { confirm: '/koordinator/meetings/' + id + '/confirm', cancel: '/koordinator/meetings/' + id + '/cancel' };
    fetch(urlMap[action], {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH' })
    }).then(r => r.json()).then(() => location.reload()).catch(() => location.reload());
}

function submitAction(id, action) {
    if (action === 'cancel') { showConfirmModal('Batalkan meeting ini?', function() { executeAction(id, action); }, { buttonText: 'Ya, Batalkan', buttonColor: '#10b981', buttonHoverColor: '#059669' }); return; }
    executeAction(id, action);
}

function showFinishForm(id) {
    const form = document.getElementById('d-finish-form-' + id);
    form.classList.remove('hidden');
    const el = document.getElementById('d-finish-time-' + id);
    if (el && !el._flatpickr) {
        flatpickr(el, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            minTime: el.dataset.min || '00:00',
            defaultDate: el.value,
        });
    }
}

function submitFinish(id) {
    const time = document.getElementById('d-finish-time-' + id).value;
    if (!time) { showAlertModal('Isi jam selesai terlebih dahulu.'); return; }
    fetch('/koordinator/meetings/' + id + '/finish', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH', actual_end_time: time })
    }).then(r => r.json()).then(data => {
        if (data.show_mom) {
            closeModal('detail-modal');
            showMomModal(data.meeting_id);
        } else {
            location.reload();
        }
    }).catch(() => location.reload());
}

function closeDetailAndOpenMom(id) {
    closeModal('detail-modal');
    showMomModal(id);
}

function sendMom(meetingId) {
    const m = meetingsData.find(i => i.id === meetingId);
    if (!m || !m.mom || !m.mom.id) return;
    const momId = m.mom.id;
    showConfirmModal('Kirim MOM ini ke semua peserta?', function() {
    fetch('/koordinator/mom/' + momId + '/send', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH' })
    }).then(r => r.json()).then(() => location.reload()).catch(() => location.reload());
    }, { icon: 'success', buttonText: 'Ya, Kirim', buttonColor: '#10b981', buttonHoverColor: '#059669' });
}

// ─── MOM Modal (terpisah) ───
function showMomModal(meetingId) {
    const m = meetingsData.find(i => i.id === meetingId);
    if (!m) return;
    const modal = document.getElementById('mom-modal');
    modal.dataset.meetingId = meetingId;
    document.getElementById('mom-modal-meeting-info').textContent = 'Meeting: ' + (m.title || '') + ' · ' + (m.meeting_date || '');
    document.getElementById('mom-summary').value = '';
    document.getElementById('mom-decisions').value = '';
    document.getElementById('mom-action').value = '';
    document.getElementById('mom-pic').value = '';
    document.getElementById('mom-file').value = '';
    modal.style.display = 'flex';
}

function closeMomModal() {
    document.getElementById('mom-modal').style.display = 'none';
}

function submitMomWithAction(action, event) {
    const modal = document.getElementById('mom-modal');
    const meetingId = modal.dataset.meetingId;
    if (!meetingId) return;
    const summary = document.getElementById('mom-summary').value.trim();
    const decisions = document.getElementById('mom-decisions').value.trim();
    const actionPlan = document.getElementById('mom-action').value.trim();
    const pic = document.getElementById('mom-pic').value;
    const fileInput = document.getElementById('mom-file');
    if (!summary || !decisions || !actionPlan || !pic) { showAlertModal('Semua field harus diisi.'); return; }
    const formData = new FormData();
    formData.append('summary', summary);
    formData.append('decisions', decisions);
    formData.append('action_plan', actionPlan);
    formData.append('pic', pic);
    formData.append('action', action);
    if (fileInput && fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }
    const btn = event.target;
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';
    fetch('/koordinator/meetings/' + meetingId + '/mom', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: formData
    }).then(r => r.json()).then(data => {
        if (action === 'send') {
            closeMomModal();
            showMomSuccessModal(data.message || 'MOM berhasil dikirim.');
        } else {
            closeMomModal();
            showMomDraftModal(data.message || 'MOM berhasil disimpan sebagai draft.', data.mom_id);
        }
    }).catch(() => location.reload());
}

function showMomSuccessModal(message) {
    document.getElementById('mom-success-message').textContent = message || 'Minutes of Meeting berhasil dikirim ke seluruh peserta.';
    document.getElementById('mom-success-modal').style.display = 'flex';
}

function closeMomSuccessModal() {
    document.getElementById('mom-success-modal').style.display = 'none';
    location.reload();
}

// ─── Draft Modal ───
let _draftMomId = null;
let _draftMeetingId = null;

function showMomDraftModal(message, momId) {
    _draftMomId = momId;
    _draftMeetingId = document.getElementById('mom-modal').dataset.meetingId;
    document.getElementById('mom-draft-message').textContent = message || 'MOM berhasil disimpan sebagai draft.';
    document.getElementById('mom-draft-modal').style.display = 'flex';
}

function closeMomDraftModal() {
    document.getElementById('mom-draft-modal').style.display = 'none';
    location.reload();
}

function sendDraftMom() {
    if (!_draftMomId) return;
    showConfirmModal('Kirim MOM ini ke semua peserta?', function() {
    fetch('/koordinator/mom/' + _draftMomId + '/send', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: new URLSearchParams({ _method: 'PATCH' })
    }).then(r => r.json()).then(data => {
        closeMomDraftModal();
        showMomSuccessModal(data.message || 'MOM berhasil dikirim.');
    }).catch(() => location.reload());
    }, { icon: 'success', buttonText: 'Ya, Kirim', buttonColor: '#10b981', buttonHoverColor: '#059669' });
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('detail-modal');
});

document.getElementById('mom-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeMomModal();
});

document.getElementById('mom-success-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeMomSuccessModal();
});

document.getElementById('mom-draft-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeMomDraftModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (document.getElementById('mom-success-modal').style.display === 'flex') {
            closeMomSuccessModal();
        } else if (document.getElementById('mom-draft-modal').style.display === 'flex') {
            closeMomDraftModal();
        } else if (document.getElementById('mom-modal').style.display === 'flex') {
            closeMomModal();
        } else {
            closeModal('detail-modal');
        }
    }
});

// Page load: cek flash session untuk auto-buka MOM modal
(function() {
    const momId = '{{ session('mom_meeting_id') }}';
    if (momId) {
        showMomModal(parseInt(momId));
    }
})();
</script>
@endpush

@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
.meeting-row + .meeting-row > td { padding-top: 0; }
</style>
@endpush
