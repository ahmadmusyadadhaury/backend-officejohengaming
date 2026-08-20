@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Rekap Rapat')
@section('page-title', 'Overview > Rekap Hasil Rangkuman Rapat')
@section('page-subtitle', 'Rekam dan kelola hasil rangkuman rapat')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 md:gap-3">
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:rgba(239,68,68,0.15);box-shadow:0 0 14px rgba(239,68,68,0.20);">
                <svg style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:#f87171;">{{ $stats['total'] }}</div>
                <div class="stat-label-text" style="font-size:0.7rem;">Total Rekaman</div>
            </div>
        </div>
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:rgba(59,130,246,0.15);box-shadow:0 0 14px rgba(59,130,246,0.20);">
                <svg style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:#60a5fa;">{{ $stats['this_month'] }}</div>
                <div class="stat-label-text" style="font-size:0.7rem;">Bulan Ini</div>
            </div>
        </div>
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:rgba(16,185,129,0.15);box-shadow:0 0 14px rgba(16,185,129,0.20);">
                <svg style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:#34d399;">{{ $stats['finalized'] }}</div>
                <div class="stat-label-text" style="font-size:0.7rem;">Final</div>
            </div>
        </div>
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:rgba(245,158,11,0.15);box-shadow:0 0 14px rgba(245,158,11,0.20);">
                <svg style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:#fbbf24;">{{ $stats['draft'] }}</div>
                <div class="stat-label-text" style="font-size:0.7rem;">Draft</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="gaming-card overflow-hidden">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Rekap Hasil Rangkuman Rapat</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Daftar rekaman rapat dan hasil transkrip otomatis.</div>
            </div>
            <a href="{{ route('admin.recordings.create') }}" class="btn btn-primary btn-sm inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Rekam Rapat Baru
            </a>
        </div>
        <div class="px-6 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-recording" placeholder="Cari berdasarkan judul meeting" oninput="filterRecordings()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table" style="width:100%;min-width:900px;">
                <colgroup>
                    <col style="width:50px">
                    <col>
                    <col style="width:130px">
                    <col class="hidden sm:table-cell" style="width:140px">
                    <col style="width:120px">
                    <col style="width:100px">
                    <col class="hidden md:table-cell" style="width:100px">
                    <col style="width:100px">
                </colgroup>
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th>Judul Meeting</th>
                        <th style="width:130px">Ruangan</th>
                        <th class="hidden sm:table-cell" style="width:140px">Dibuat Oleh</th>
                        <th style="width:120px">Tanggal</th>
                        <th style="width:100px">Durasi</th>
                        <th class="hidden md:table-cell" style="width:100px">Status</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recordings as $rec)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $rec->meeting->title ?? '—' }}</td>
                        <td style="color:var(--text-secondary);">{{ $rec->meeting->room->name ?? '—' }}</td>
                        <td class="hidden sm:table-cell" style="color:var(--text-muted);">{{ $rec->creator->name ?? '—' }}</td>
                        <td style="color:var(--text-muted);">{{ $rec->meeting->meeting_date ? $rec->meeting->meeting_date->format('d M Y') : '—' }}</td>
                        <td style="color:var(--text-secondary);font-family:monospace;">{{ $rec->duration_formatted }}</td>
                        <td class="hidden md:table-cell">
                            @if($rec->status === 'finalized')
                                <span class="inline-block text-[11px] font-bold px-2 py-1" style="background:rgba(16,185,129,0.15);color:#34d399;border-radius:6px;">Final</span>
                            @else
                                <span class="inline-block text-[11px] font-bold px-2 py-1" style="background:rgba(245,158,11,0.15);color:#fbbf24;border-radius:6px;">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1" style="white-space:nowrap;">
                                <a href="{{ route('admin.recordings.show', $rec) }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5" style="padding:4px 8px;font-size:0.7rem;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat
                                </a>
                                <div class="relative dropdown-actions-rec">
                                    <button type="button" onclick="toggleRecMenu(event, {{ $rec->id }})" style="padding:6px 10px;line-height:1;font-size:1.1rem;font-weight:700;border:1px solid var(--border-color);border-radius:8px;background:var(--bg-surface);color:var(--text-primary);cursor:pointer;" title="Aksi">⋮</button>
                                    <div id="rec-menu-{{ $rec->id }}" style="display:none;position:absolute;top:100%;right:0;min-width:160px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:12px;padding:6px;z-index:99999;margin-top:4px;">
                                        <a href="{{ route('admin.recordings.edit', $rec) }}" class="w-full text-left px-2.5 py-1.5 text-xs rounded-lg transition" style="color:var(--text-secondary);display:flex;align-items:center;gap:8px;background:none;border:none;cursor:pointer;text-decoration:none;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit Rekap
                                        </a>
                                        <form method="POST" action="{{ route('admin.recordings.destroy', $rec) }}" onsubmit="return confirm('Hapus rekaman ini?')" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full text-left px-2.5 py-1.5 text-xs rounded-lg transition" style="color:#f87171;display:flex;align-items:center;gap:8px;background:none;border:none;cursor:pointer;text-decoration:none;" onmouseover="this.style.background='rgba(239,68,68,0.1)'" onmouseout="this.style.background='transparent'">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada rekaman rapat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3" style="border-top:1px solid var(--border-color);">{{ $recordings->links() }}</div>
    </div>
</div>

{{-- Modal Detail Rekaman --}}
<div id="rec-detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[380px] lg:max-w-[480px] xl:max-w-[580px] 2xl:max-w-[720px]" style="max-height:90vh;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:22px;box-shadow:0 25px 60px rgba(0,0,0,0.3);display:flex;flex-direction:column;animation:recFadeIn 0.25s ease;" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(239,68,68,0.18);">
                    <svg class="w-4.5 h-4.5" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                </div>
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Rekap Rapat — <span id="rec-modal-judul">Meeting</span></h3>
            </div>
            <button type="button" onclick="closeModal('rec-detail-modal')" class="p-1.5 rounded-lg transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-4 overflow-y-auto flex-1" id="rec-detail-body" style="scrollbar-width:thin;">
            <div id="rec-modal-info" class="space-y-3"></div>
            <div id="rec-modal-audio" class="mt-4 hidden"></div>
            <div id="rec-modal-transcript" class="mt-4 hidden"></div>
            <div id="rec-modal-summary" class="mt-4 hidden"></div>
        </div>
        <div class="flex items-center justify-end px-6 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeModal('rec-detail-modal')" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-secondary);border:1px solid var(--border-color);background:var(--bg-surface-2);" onmouseover="this.style.background='var(--bg-surface)'" onmouseout="this.style.background='var(--bg-surface-2)'">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const recordingsData = @json($recordingsJson);

function showRecDetail(id) {
    const r = recordingsData.find(i => i.id === id);
    if (!r) return;

    document.getElementById('rec-modal-judul').textContent = r.judul_meeting;

    const info = document.getElementById('rec-modal-info');
    info.innerHTML = `
        <div class="flex items-center justify-between py-2" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Tanggal Meeting</span>
            <span class="text-xs" style="color:var(--text-primary);font-weight:700;">${r.tanggal_meeting}</span>
        </div>
        <div class="flex items-center justify-between py-2" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Ruangan</span>
            <span class="text-xs" style="color:var(--text-primary);font-weight:700;">${r.ruangan}</span>
        </div>
        <div class="flex items-center justify-between py-2" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Dibuat Oleh</span>
            <span class="text-xs" style="color:var(--text-primary);font-weight:700;">${r.dibuat_oleh}</span>
        </div>
        <div class="flex items-center justify-between py-2" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Durasi</span>
            <span class="text-xs" style="color:var(--text-primary);font-weight:700;font-family:monospace;">${r.durasi}</span>
        </div>
        <div class="flex items-center justify-between py-2">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Status</span>
            <span class="text-[11px] font-bold px-2 py-1" style="background:${r.status === 'finalized' ? 'rgba(16,185,129,0.15)' : 'rgba(245,158,11,0.15)'};color:${r.status === 'finalized' ? '#34d399' : '#fbbf24'};border-radius:8px;">${r.status === 'finalized' ? 'FINAL' : 'DRAFT'}</span>
        </div>
    `;

    const audioSec = document.getElementById('rec-modal-audio');
    if (r.audio_url) {
        audioSec.classList.remove('hidden');
        audioSec.innerHTML = `
            <div style="border:1px solid rgba(239,68,68,0.3);background:var(--bg-surface-2);border-radius:14px;padding:14px;">
                <p class="text-[11px] font-bold mb-2" style="color:#f87171;">REKAMAN AUDIO</p>
                <audio controls style="width:100%;height:36px;border-radius:8px;">
                    <source src="${r.audio_url}" type="audio/webm">
                </audio>
            </div>`;
    } else {
        audioSec.classList.add('hidden');
    }

    const transcriptSec = document.getElementById('rec-modal-transcript');
    if (r.transcript) {
        transcriptSec.classList.remove('hidden');
        transcriptSec.innerHTML = `
            <div style="border:1px solid rgba(59,130,246,0.3);background:var(--bg-surface-2);border-radius:14px;padding:14px;">
                <p class="text-[11px] font-bold mb-2" style="color:#60a5fa;">TRANSKRIP OTOMATIS</p>
                <p class="text-xs whitespace-pre-wrap" style="color:var(--text-secondary);line-height:1.7;">${r.transcript}</p>
            </div>`;
    } else {
        transcriptSec.classList.add('hidden');
    }

    const summarySec = document.getElementById('rec-modal-summary');
    if (r.summary) {
        summarySec.classList.remove('hidden');
        summarySec.innerHTML = `
            <div style="border:1px solid rgba(16,185,129,0.3);background:var(--bg-surface-2);border-radius:14px;padding:14px;">
                <p class="text-[11px] font-bold mb-2" style="color:#10b981;">REKAP RAPAT</p>
                <p class="text-xs whitespace-pre-wrap" style="color:var(--text-primary);line-height:1.7;">${r.summary}</p>
            </div>`;
    } else {
        summarySec.classList.add('hidden');
    }

    openModal('rec-detail-modal');
}

function toggleRecMenu(e, id) {
    e.stopPropagation();
    const menu = document.getElementById('rec-menu-' + id);
    const isHidden = menu.style.display === 'none';
    document.querySelectorAll('[id^="rec-menu-"]').forEach(m => m.style.display = 'none');
    if (isHidden) menu.style.display = 'block';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-actions-rec')) {
        document.querySelectorAll('[id^="rec-menu-"]').forEach(m => m.style.display = 'none');
    }
});

function filterRecordings() {
    const search = (document.getElementById('search-recording')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('.gaming-table tbody tr:not([colspan])');
    rows.forEach(row => {
        const judul = (row.querySelector('td:nth-child(2)')?.textContent || '').toLowerCase();
        row.style.display = !search || judul.includes(search) ? '' : 'none';
    });
}

document.getElementById('rec-detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('rec-detail-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal('rec-detail-modal');
});
</script>
@endpush

@push('styles')
<style>
    .gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
    .gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
    @keyframes recFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush
