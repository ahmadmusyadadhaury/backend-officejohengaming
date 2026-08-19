@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Ticketing IT')
@section('page-title', 'Overview > Ticketing IT')
@section('page-subtitle', 'Permintaan bantuan dan pekerjaan lintas divisi')
@section('sidebar-menu')
    @if(in_array(auth()->user()->role, \App\Models\User::FULL_ACCESS_ROLES) || auth()->user()->isItStaff() || auth()->user()->role === 'admin_ga')
        @include('partials.sidebar-admin')
    @elseif(auth()->user()->isKoordinator())
        @include('partials.sidebar-leader')
    @else
        @include('partials.sidebar-user')
    @endif
@endsection

@php
$statusLabels = ['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'dijeda' => 'Dijeda', 'dilanjutkan' => 'Dilanjutkan', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'];
$statusBadge = ['menunggu' => 'badge-blue', 'diproses' => 'badge-yellow', 'dijeda' => 'badge-orange', 'dilanjutkan' => 'badge-primary', 'selesai' => 'badge-green', 'ditolak' => 'badge-red'];
$priorityLabels = ['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Tinggi', 'mendesak' => 'Mendesak'];
$priorityBadge = ['rendah' => 'badge-gray', 'sedang' => 'badge-blue', 'tinggi' => 'badge-yellow', 'mendesak' => 'badge-red'];
$kategoriLabels = ['perangkat' => 'Perangkat', 'aplikasi' => 'Aplikasi', 'akun_akses' => 'Akun & Akses', 'jaringan' => 'Jaringan', 'lainnya' => 'Lainnya'];
$fmtDurasi = fn (int $detik) => sprintf('%02d:%02d:%02d', intdiv($detik, 3600), intdiv($detik % 3600, 60), $detik % 60);
$countChip = fn ($key) => $key === 'semua' ? $tickets->count() : $tickets->where('status', $key)->count();
@endphp

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

@if($canManage)
{{-- ============ STAT CARDS (IT Staff / Admin) ============ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
    <div class="gaming-card p-4 flex items-center gap-3" style="cursor:pointer;" onclick="setFilter('semua')" id="stat-semua">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.15);">
            <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div class="min-w-0">
            <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $countChip('semua') }}</div>
            <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Semua Tiket</div>
            <div class="text-[10px] mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh tiket</div>
        </div>
    </div>
    <div class="gaming-card p-4 flex items-center gap-3" style="cursor:pointer;" onclick="setFilter('menunggu')" id="stat-menunggu">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(59,130,246,0.15);">
            <svg class="w-[18px] h-[18px]" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <div class="text-xl font-gaming font-bold" style="color:#60a5fa;">{{ $countChip('menunggu') }}</div>
            <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Menunggu</div>
            <div class="text-[10px] mt-0.5 leading-tight" style="color:var(--text-muted);">Belum ditangani</div>
        </div>
    </div>
    <div class="gaming-card p-4 flex items-center gap-3" style="cursor:pointer;" onclick="setFilter('diproses')" id="stat-diproses">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(245,158,11,0.15);">
            <svg class="w-[18px] h-[18px]" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <div class="text-xl font-gaming font-bold" style="color:#fbbf24;">{{ $countChip('diproses') }}</div>
            <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Diproses</div>
            <div class="text-[10px] mt-0.5 leading-tight" style="color:var(--text-muted);">Sedang dikerjakan</div>
        </div>
    </div>
    <div class="gaming-card p-4 flex items-center gap-3" style="cursor:pointer;" onclick="setFilter('dijeda')" id="stat-dijeda">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(249,115,22,0.15);">
            <svg class="w-[18px] h-[18px]" style="color:#f97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <div class="text-xl font-gaming font-bold" style="color:#f97316;">{{ $countChip('dijeda') }}</div>
            <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Dijeda</div>
            <div class="text-[10px] mt-0.5 leading-tight" style="color:var(--text-muted);">Ditunda sementara</div>
        </div>
    </div>
    <div class="gaming-card p-4 flex items-center gap-3" style="cursor:pointer;" onclick="setFilter('selesai')" id="stat-selesai">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(16,185,129,0.15);">
            <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <div class="text-xl font-gaming font-bold" style="color:#34d399;">{{ $countChip('selesai') }}</div>
            <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Selesai</div>
            <div class="text-[10px] mt-0.5 leading-tight" style="color:var(--text-muted);">Sudah diselesaikan</div>
        </div>
    </div>
</div>
@endif

@if($canManage || $canViewAll)
{{-- ============ TICKETS TABLE ============ --}}
<div class="gaming-card" style="overflow:visible;">
    <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
        <div>
            <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Ticketing IT</div>
            <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Kelola tiket bantuan teknis dan permintaan akses</div>
        </div>
        @if(!$canManage && !$canViewAll)
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Tiket
            </button>
        @endif
    </div>
    <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
        <div class="relative flex-1 min-w-[200px] max-w-[260px]">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari kode, judul, pengaju..." oninput="applyFilter()"
                class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
        </div>
        <div class="flex items-center gap-2" style="margin-left:auto;">
            <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Status</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" onclick="setFilter('semua')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" onclick="setFilter('menunggu')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Menunggu</button>
                    <button type="button" onclick="setFilter('diproses')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Diproses</button>
                    <button type="button" onclick="setFilter('dijeda')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Dijeda</button>
                    <button type="button" onclick="setFilter('selesai')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Selesai</button>
                    <button type="button" onclick="setFilter('ditolak')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Ditolak</button>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="gaming-table min-w-[800px]">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Pengaju</th>
                    <th>Kategori</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>PIC</th>
                    <th>Waktu Kerja</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    @php
                        $td = [
                            "id" => $ticket->id,
                            "kode" => $ticket->kode,
                            "judul" => $ticket->judul,
                            "deskripsi" => $ticket->deskripsi,
                            "bukti_kendala" => $ticket->bukti_kendala,
                            "kategori" => $ticket->kategori,
                            "prioritas" => $ticket->prioritas,
                            "status" => $ticket->status,
                            "catatan_it" => $ticket->catatan_it,
                            "alasan_jeda" => $ticket->alasan_jeda,
                            "feedback_atasan" => $ticket->feedback_atasan,
                            "mulai_ditangani_at" => $ticket->mulai_ditangani_at,
                            "selesai_at" => $ticket->selesai_at,
                            "durasi_detik" => $ticket->durasi_detik,
                            "proses_mulai_at" => $ticket->proses_mulai_at,
                            "requester_id" => $ticket->requester_id,
                            "assignee_id" => $ticket->assignee_id,
                            "created_at" => $ticket->created_at,
                            "requester_name" => $ticket->requester->name,
                            "assignee_name" => $ticket->assignee->name ?? "—",
                        ];
                    @endphp
                    <tr class="ticket-row"
                        data-status="{{ $ticket->status }}"
                        data-search="{{ strtolower($ticket->kode . ' ' . $ticket->judul . ' ' . $ticket->requester->name) }}"
                        data-ticket='@json($td)'
                    >
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td><span style="font-family:monospace;font-weight:600;color:var(--text-primary);">{{ $ticket->kode }}</span></td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ Str::limit($ticket->judul, 40) }}</td>
                        <td style="color:var(--text-muted);">{{ $ticket->requester->name }}</td>
                        <td><span style="color:var(--text-muted);font-size:0.8rem;">{{ $kategoriLabels[$ticket->kategori] ?? $ticket->kategori }}</span></td>
                        <td><span class="badge {{ $priorityBadge[$ticket->prioritas] ?? 'badge-gray' }}">{{ $priorityLabels[$ticket->prioritas] ?? $ticket->prioritas }}</span></td>
                        <td><span class="badge {{ $statusBadge[$ticket->status] ?? 'badge-gray' }}">{{ $statusLabels[$ticket->status] ?? $ticket->status }}</span></td>
                        <td style="color:var(--text-muted);">{{ $ticket->assignee->name ?? '—' }}</td>
                        <td>
                            @if($ticket->status === 'selesai')
                                <span style="font-family:monospace;font-size:0.8rem;color:var(--text-muted);">{{ $fmtDurasi($ticket->durasi_detik ?? 0) }}</span>
                            @elseif(in_array($ticket->status, ['diproses', 'dilanjutkan']) && $ticket->proses_mulai_at)
                                <span class="timer-display" style="font-family:monospace;font-size:0.8rem;color:var(--text-primary);" data-start="{{ $ticket->proses_mulai_at->timestamp }}">{{ $fmtDurasi(max(0, now()->timestamp - $ticket->proses_mulai_at->timestamp)) }}</span>
                            @else
                                <span style="font-family:monospace;font-size:0.8rem;color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1" style="white-space:nowrap;">
                                <button type="button" onclick="openDetail(this.closest('.ticket-row'))" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $ticket->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $ticket->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="openDetail(this.closest('.ticket-row'))" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:var(--text-secondary);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </button>
                                        @if($canDelete)
                                            <button type="button" onclick="openDetail(this.closest('.ticket-row'));setTimeout(function(){confirmDelete();},100);" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:#f87171;background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada tiket ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if(method_exists($tickets, 'links') && $tickets->hasPages())
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">
            {{ $tickets->links() }}
        </div>
        @endif
    </div>
</div>
@else
{{-- ============ REGULAR USER VIEW ============ --}}
<div class="gaming-card" style="overflow:visible;">
    <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
        <div>
            <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Riwayat Pengajuan Saya</div>
            <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Semua tiket yang telah Anda ajukan</div>
        </div>
        <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Tiket Baru
        </button>
    </div>
    <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
        <div class="relative flex-1 min-w-[200px] max-w-[260px]">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari kode, judul..." oninput="applyFilter()"
                class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
        </div>
        <div class="flex items-center gap-2" style="margin-left:auto;">
            <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Status</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" onclick="setFilter('semua')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    @foreach($statusLabels as $key => $label)
                        <button type="button" onclick="setFilter('{{ $key }}')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">{{ $label }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="gaming-table min-w-[700px]">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tiket</th>
                    <th>Diajukan</th>
                    <th>Status</th>
                    <th>PIC</th>
                    <th>Catatan Tim IT</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr class="ticket-row"
                        data-status="{{ $ticket->status }}"
                        data-search="{{ strtolower($ticket->kode . ' ' . $ticket->judul) }}"
                        data-ticket='{!! json_encode(["id"=>$ticket->id,"kode"=>$ticket->kode,"judul"=>$ticket->judul,"deskripsi"=>$ticket->deskripsi,"bukti_kendala"=>$ticket->bukti_kendala,"kategori"=>$ticket->kategori,"prioritas"=>$ticket->prioritas,"status"=>$ticket->status,"catatan_it"=>$ticket->catatan_it,"alasan_jeda"=>$ticket->alasan_jeda,"feedback_atasan"=>$ticket->feedback_atasan,"mulai_ditangani_at"=>$ticket->mulai_ditangani_at,"selesai_at"=>$ticket->selesai_at,"durasi_detik"=>$ticket->durasi_detik,"requester_name"=>$ticket->requester->name,"assignee_name"=>$ticket->assignee->name ?? "—"]) !!}'
                    >
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td>
                            <div>
                                <span style="font-family:monospace;font-weight:600;color:var(--text-primary);">{{ $ticket->kode }}</span>
                                <div style="font-size:0.8rem;color:var(--text-primary);margin-top:0.15rem;">{{ Str::limit($ticket->judul, 40) }}</div>
                            </div>
                        </td>
                        <td style="color:var(--text-muted);font-size:0.8rem;">{{ $ticket->created_at->format('d M Y') }}</td>
                        <td><span class="badge {{ $statusBadge[$ticket->status] ?? 'badge-gray' }}">{{ $statusLabels[$ticket->status] ?? $ticket->status }}</span></td>
                        <td style="color:var(--text-muted);">{{ $ticket->assignee->name ?? '—' }}</td>
                        <td style="color:var(--text-muted);font-size:0.85rem;">{{ Str::limit($ticket->catatan_it ?? '—', 50) }}</td>
                        <td>
                            <div class="flex items-center gap-1" style="white-space:nowrap;">
                                <button type="button" onclick="openDetail(this.closest('.ticket-row'))" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $ticket->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $ticket->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="openDetail(this.closest('.ticket-row'))" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:var(--text-secondary);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada tiket yang diajukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if(method_exists($tickets, 'links') && $tickets->hasPages())
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">
            {{ $tickets->links() }}
        </div>
        @endif
    </div>
</div>
@endif

</div>
@endsection

{{-- ============ DETAIL MODAL ============ --}}
<div class="modal-modern" id="detailModal" style="display:none;">
    <div class="modal-modern-bg" onclick="closeDetail()"></div>
    <div class="modal-modern-panel" style="max-width:640px;width:95%;">
        <div class="modal-modern-header">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);">
                <span id="modalKode" style="font-family:monospace;margin-right:0.5rem;"></span>
                <span id="modalJudul"></span>
            </h3>
            <button class="modal-modern-close" onclick="closeDetail()">&times;</button>
        </div>
        <div class="modal-modern-body">
            {{-- Info Grid --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem 1.5rem;margin-bottom:1rem;">
                <div>
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.15rem;">Pengaju</div>
                    <div style="font-size:0.85rem;color:var(--text-primary);" id="modalRequester"></div>
                </div>
                <div>
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.15rem;">Tanggal</div>
                    <div style="font-size:0.85rem;color:var(--text-primary);" id="modalTanggal"></div>
                </div>
                <div>
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.15rem;">Kategori</div>
                    <div style="font-size:0.85rem;color:var(--text-primary);" id="modalKategori"></div>
                </div>
                <div>
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.15rem;">Prioritas</div>
                    <div id="modalPrioritas"></div>
                </div>
                <div>
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.15rem;">Status</div>
                    <div id="modalStatus"></div>
                </div>
                <div>
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.15rem;">Waktu Pengerjaan</div>
                    <div style="font-family:monospace;font-size:0.85rem;color:var(--text-primary);" id="modalDurasi"></div>
                </div>
            </div>

            {{-- PIC (editable for canManage, read-only otherwise) --}}
            @if($canManage)
                <div style="margin-bottom:0.75rem;">
                    <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">PIC</label>
                    <select id="modalAssignee" class="gaming-input" style="width:100%;">
                        <option value="">Belum Ditugaskan</option>
                        @foreach($itUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div style="margin-bottom:0.75rem;">
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.15rem;">PIC</div>
                    <div style="font-size:0.85rem;color:var(--text-primary);" id="modalAssigneeDisplay"></div>
                </div>
            @endif

            {{-- Deskripsi --}}
            <div style="margin-bottom:0.75rem;">
                <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.25rem;">Deskripsi</div>
                <div style="background:var(--bg-surface,#1a1a2e);border:1px solid var(--border-color,#2a2a4a);border-radius:6px;padding:0.75rem;font-size:0.85rem;color:var(--text-primary);white-space:pre-wrap;min-height:60px;" id="modalDeskripsi"></div>
            </div>

            {{-- Bukti Kendala --}}
            <div id="modalBuktiWrap" style="display:none;margin-bottom:0.75rem;">
                <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.25rem;">Bukti Kendala</div>
                <div id="modalBuktiContainer" style="max-height:200px;overflow:hidden;border-radius:6px;border:1px solid var(--border-color,#2a2a4a);"></div>
            </div>

            {{-- Alasan Jeda --}}
            <div id="modalJedaWrap" style="display:none;margin-bottom:0.75rem;">
                <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.25rem;">Alasan Jeda</div>
                <div style="background:var(--bg-surface,#1a1a2e);border:1px solid var(--border-color,#2a2a4a);border-radius:6px;padding:0.75rem;font-size:0.85rem;color:var(--text-primary);white-space:pre-wrap;" id="modalAlasanJeda"></div>
            </div>

            {{-- Status (editable for canManage) --}}
            @if($canManage)
                <div style="margin-bottom:0.75rem;">
                    <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Status</label>
                    <select id="modalStatusSelect" class="gaming-input" style="width:100%;" onchange="toggleJedaField()">
                        @foreach($statusLabels as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Alasan Jeda (editable, shown when status=dijeda) --}}
                <div id="modalJedaEditWrap" style="display:none;margin-bottom:0.75rem;">
                    <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Alasan Jeda <span style="color:#ef4444;">*</span></label>
                    <textarea id="modalAlasanJedaEdit" class="gaming-input" rows="3" style="width:100%;resize:vertical;" placeholder="Masukkan alasan penundaan..."></textarea>
                </div>

                {{-- Catatan IT --}}
                <div style="margin-bottom:0.75rem;">
                    <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Catatan IT</label>
                    <textarea id="modalCatatanIT" class="gaming-input" rows="3" style="width:100%;resize:vertical;" placeholder="Tambahkan catatan teknis..."></textarea>
                </div>
            @else
                {{-- Catatan IT (read-only) --}}
                <div style="margin-bottom:0.75rem;">
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin-bottom:0.25rem;">Catatan IT</div>
                    <div style="background:var(--bg-surface,#1a1a2e);border:1px solid var(--border-color,#2a2a4a);border-radius:6px;padding:0.75rem;font-size:0.85rem;color:var(--text-primary);white-space:pre-wrap;min-height:40px;" id="modalCatatanDisplay">—</div>
                </div>
            @endif

            {{-- Feedback form for viewers (canViewAll but not canManage) --}}
            @if($canViewAll && !$canManage)
                <div style="margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid var(--border-color,#2a2a4a);">
                    <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Feedback Atasan</label>
                    <textarea id="modalFeedbackAtasan" class="gaming-input" rows="3" style="width:100%;resize:vertical;" placeholder="Berikan feedback atau catatan...">{{ old('feedback_atasan') }}</textarea>
                    <div id="feedbackError" style="color:#ef4444;font-size:0.7rem;margin-top:0.25rem;display:none;"></div>
                </div>
            @endif
        </div>

        <div class="modal-modern-footer">
            @if($canDelete)
                <button type="button" class="btn btn-sm" style="background:#ef4444;color:#fff;margin-right:auto;" onclick="confirmDelete()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:3px;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    Hapus
                </button>
            @endif
            <button type="button" class="btn btn-sm" onclick="closeDetail()" style="background:var(--bg-surface-2,#2a2a4a);color:var(--text-primary);border:1px solid var(--border-color,#2a2a4a);">Batal</button>
            @if($canManage)
                <button type="button" class="btn btn-primary btn-sm" onclick="saveTicket()">Simpan Perubahan</button>
            @elseif($canViewAll)
                <button type="button" class="btn btn-primary btn-sm" onclick="submitFeedback()">Kirim Feedback</button>
            @endif
        </div>
    </div>
</div>

{{-- ============ CREATE MODAL (Regular User) ============ --}}
@if(!$canManage && !$canViewAll)
<div class="modal-modern" id="createModal" style="display:none;">
    <div class="modal-modern-bg" onclick="closeCreateModal()"></div>
    <div class="modal-modern-panel" style="max-width:560px;width:95%;">
        <div class="modal-modern-header">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);">Buat Tiket Baru</h3>
            <button class="modal-modern-close" onclick="closeCreateModal()">&times;</button>
        </div>
        <form action="{{ route('it-tickets.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
            @csrf
            <div class="modal-modern-body">
                <div style="margin-bottom:0.75rem;">
                    <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Judul <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="judul" class="gaming-input" style="width:100%;" placeholder="Judul permasalahan..." value="{{ old('judul') }}" required>
                    @error('judul')
                        <p style="color:var(--color-secondary);font-size:0.7rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:0.75rem;">
                    <div>
                        <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Kategori <span style="color:#ef4444;">*</span></label>
                        <select name="kategori" class="gaming-input" style="width:100%;" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriLabels as $key => $label)
                                <option value="{{ $key }}" {{ old('kategori') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p style="color:var(--color-secondary);font-size:0.7rem;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Prioritas <span style="color:#ef4444;">*</span></label>
                        <select name="prioritas" class="gaming-input" style="width:100%;" required>
                            <option value="">Pilih Prioritas</option>
                            @foreach($priorityLabels as $key => $label)
                                <option value="{{ $key }}" {{ old('prioritas') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('prioritas')
                            <p style="color:var(--color-secondary);font-size:0.7rem;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div style="margin-bottom:0.75rem;">
                    <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Deskripsi <span style="color:#ef4444;">*</span></label>
                    <textarea name="deskripsi" class="gaming-input" rows="4" style="width:100%;resize:vertical;" placeholder="Jelaskan permasalahan Anda..." required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p style="color:var(--color-secondary);font-size:0.7rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div style="margin-bottom:0.75rem;">
                    <label style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);display:block;margin-bottom:0.25rem;">Bukti Kendala (Opsional)</label>
                    <input type="file" name="bukti_kendala" id="buktiKendalaInput" class="gaming-input" style="width:100%;padding:0.5rem;" accept="image/*" onchange="previewBukti(this)">
                    @error('bukti_kendala')
                        <p style="color:var(--color-secondary);font-size:0.7rem;">{{ $message }}</p>
                    @enderror
                    <div id="buktiPreview" style="margin-top:0.5rem;display:none;">
                        <img id="buktiPreviewImg" src="" alt="Preview" style="max-width:100%;max-height:150px;border-radius:6px;border:1px solid var(--border-color,#2a2a4a);">
                    </div>
                </div>
                <div id="createErrors" style="display:none;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:6px;padding:0.75rem;margin-bottom:0.75rem;">
                    <div style="font-size:0.75rem;color:#ef4444;font-weight:600;margin-bottom:0.25rem;">Terjadi Kesalahan:</div>
                    <ul id="createErrorList" style="font-size:0.75rem;color:#ef4444;margin:0;padding-left:1rem;"></ul>
                </div>
            </div>
            <div class="modal-modern-footer">
                <button type="button" class="btn btn-sm" onclick="closeCreateModal()" style="background:var(--bg-surface-2,#2a2a4a);color:var(--text-primary);border:1px solid var(--border-color,#2a2a4a);">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Kirim Tiket</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ============ DELETE CONFIRMATION MODAL ============ --}}
@if($canDelete)
<div class="modal-modern" id="deleteModal" style="display:none;">
    <div class="modal-modern-bg" onclick="closeDeleteModal()"></div>
    <div class="modal-modern-panel" style="max-width:400px;width:95%;">
        <div class="modal-modern-header">
            <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);">Hapus Tiket</h3>
            <button class="modal-modern-close" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-modern-body">
            <p style="font-size:0.85rem;color:var(--text-muted);margin:0;">Apakah Anda yakin ingin menghapus tiket <strong style="color:var(--text-primary);" id="deleteKodeDisplay"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-modern-footer">
            <button type="button" class="btn btn-sm" onclick="closeDeleteModal()" style="background:var(--bg-surface-2,#2a2a4a);color:var(--text-primary);border:1px solid var(--border-color,#2a2a4a);">Batal</button>
            <button type="button" class="btn btn-sm" style="background:#ef4444;color:#fff;" onclick="executeDelete()">Hapus</button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
(function () {
    var CURRENT_TICKET_ID = null;
    var CURRENT_TICKET_DATA = null;

    function fmtDurasi(total) {
        total = Math.max(0, Math.floor(total));
        var h = Math.floor(total / 3600);
        var m = Math.floor((total % 3600) / 60);
        var s = total % 60;
        return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    }
    window.fmtDurasi = fmtDurasi;

    function getCsrf() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    // --- Timer ---
    setInterval(function () {
        var els = document.querySelectorAll('.timer-display[data-start]');
        els.forEach(function (el) {
            var startTs = parseInt(el.getAttribute('data-start'), 10);
            if (isNaN(startTs)) return;
            var now = Math.floor(Date.now() / 1000);
            el.textContent = fmtDurasi(now - startTs);
        });
    }, 1000);

    // --- Filter ---
    window.applyFilter = function () {
        var search = (document.getElementById('searchInput').value || '').toLowerCase();
        var labelEl = document.getElementById('filter-label');
        var filterText = labelEl ? labelEl.textContent.trim().toLowerCase() : 'semua status';
        var filterMap = { 'semua status': 'semua', 'menunggu': 'menunggu', 'diproses': 'diproses', 'dijeda': 'dijeda', 'dilanjutkan': 'dilanjutkan', 'selesai': 'selesai', 'ditolak': 'ditolak' };
        var status = filterMap[filterText] || 'semua';
        var rows = document.querySelectorAll('.ticket-row');
        rows.forEach(function (row) {
            var matchSearch = !search || (row.getAttribute('data-search') || '').indexOf(search) !== -1;
            var matchStatus = status === 'semua' || row.getAttribute('data-status') === status;
            row.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });
    };

    window.setFilter = function (status) {
        var filterLabel = document.getElementById('filter-label');
        var filterMenu = document.getElementById('filter-menu');
        var statusLabels = @json($statusLabels);
        if (filterLabel) {
            filterLabel.textContent = status === 'semua' ? 'Semua Status' : (statusLabels[status] || status);
        }
        if (filterMenu) filterMenu.style.display = 'none';
        applyFilter();
        document.querySelectorAll('.gaming-card.p-4').forEach(function (card) {
            card.style.outline = 'none';
            card.style.outlineOffset = '0';
        });
        var target = document.getElementById('stat-' + status);
        if (target) {
            target.style.outline = '2px solid var(--color-primary,#6366f1)';
            target.style.outlineOffset = '-2px';
        }
    };

    // --- Filter Dropdown ---
    window.toggleFilterMenu = function (e) {
        e.stopPropagation();
        var menu = document.getElementById('filter-menu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    };

    // --- Dropdown ---
    window.toggleDropdown = function (btn, id) {
        var all = document.querySelectorAll('.dropdown-menu');
        all.forEach(function (el) { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
        var menu = document.getElementById('dropdown-' + id);
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    };

    document.addEventListener('click', function (e) {
        var filterWrap = document.querySelector('.filter-dropdown-wrap');
        if (filterWrap && !e.target.closest('.filter-dropdown-wrap')) {
            var fm = document.getElementById('filter-menu');
            if (fm) fm.style.display = 'none';
        }
        if (!e.target.closest('.dropdown-wrap')) {
            document.querySelectorAll('.dropdown-menu').forEach(function (el) { el.style.display = 'none'; });
        }
    });

    // --- Detail Modal ---
    window.openDetail = function (row) {
        try {
            CURRENT_TICKET_DATA = JSON.parse(row.getAttribute('data-ticket'));
        } catch (e) { return; }
        CURRENT_TICKET_ID = CURRENT_TICKET_DATA.id;

        document.getElementById('modalKode').textContent = CURRENT_TICKET_DATA.kode;
        document.getElementById('modalJudul').textContent = CURRENT_TICKET_DATA.judul;
        document.getElementById('modalRequester').textContent = CURRENT_TICKET_DATA.requester_name;
        document.getElementById('modalTanggal').textContent = CURRENT_TICKET_DATA.created_at ? new Date(CURRENT_TICKET_DATA.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '—';

        var kategoriLabels = @json($kategoriLabels);
        document.getElementById('modalKategori').textContent = kategoriLabels[CURRENT_TICKET_DATA.kategori] || CURRENT_TICKET_DATA.kategori;

        var priorityLabels = @json($priorityLabels);
        var priorityBadge = @json($priorityBadge);
        document.getElementById('modalPrioritas').innerHTML = '<span class="badge ' + (priorityBadge[CURRENT_TICKET_DATA.prioritas] || 'badge-gray') + '">' + (priorityLabels[CURRENT_TICKET_DATA.prioritas] || CURRENT_TICKET_DATA.prioritas) + '</span>';

        var statusLabels = @json($statusLabels);
        var statusBadge = @json($statusBadge);
        document.getElementById('modalStatus').innerHTML = '<span class="badge ' + (statusBadge[CURRENT_TICKET_DATA.status] || 'badge-gray') + '">' + (statusLabels[CURRENT_TICKET_DATA.status] || CURRENT_TICKET_DATA.status) + '</span>';

        var durasiEl = document.getElementById('modalDurasi');
        if (CURRENT_TICKET_DATA.status === 'selesai') {
            durasiEl.textContent = fmtDurasi(CURRENT_TICKET_DATA.durasi_detik || 0);
        } else if (['diproses', 'dilanjutkan'].indexOf(CURRENT_TICKET_DATA.status) !== -1 && CURRENT_TICKET_DATA.proses_mulai_at) {
            var startTs = Math.floor(new Date(CURRENT_TICKET_DATA.proses_mulai_at).getTime() / 1000);
            durasiEl.textContent = fmtDurasi(Math.floor(Date.now() / 1000) - startTs);
        } else {
            durasiEl.textContent = '—';
        }

        document.getElementById('modalDeskripsi').textContent = CURRENT_TICKET_DATA.deskripsi || '—';

        var buktiWrap = document.getElementById('modalBuktiWrap');
        var buktiContainer = document.getElementById('modalBuktiContainer');
        if (CURRENT_TICKET_DATA.bukti_kendala) {
            buktiWrap.style.display = '';
            buktiContainer.innerHTML = '<img src="/storage/' + CURRENT_TICKET_DATA.bukti_kendala + '" alt="Bukti Kendala" style="width:100%;max-height:200px;object-fit:contain;border-radius:4px;">';
        } else {
            buktiWrap.style.display = 'none';
            buktiContainer.innerHTML = '';
        }

        var jedaWrap = document.getElementById('modalJedaWrap');
        var jedaEditWrap = document.getElementById('modalJedaEditWrap');
        if (CURRENT_TICKET_DATA.status === 'dijeda' && CURRENT_TICKET_DATA.alasan_jeda) {
            jedaWrap.style.display = '';
            document.getElementById('modalAlasanJeda').textContent = CURRENT_TICKET_DATA.alasan_jeda;
        } else {
            jedaWrap.style.display = 'none';
        }

        var assigneeSelect = document.getElementById('modalAssignee');
        if (assigneeSelect) {
            assigneeSelect.value = CURRENT_TICKET_DATA.assignee_id || '';
        }
        var assigneeDisplay = document.getElementById('modalAssigneeDisplay');
        if (assigneeDisplay) {
            assigneeDisplay.textContent = CURRENT_TICKET_DATA.assignee_name || '—';
        }

        var statusSelect = document.getElementById('modalStatusSelect');
        if (statusSelect) {
            statusSelect.value = CURRENT_TICKET_DATA.status;
            toggleJedaField();
        }

        var catatanEdit = document.getElementById('modalCatatanIT');
        if (catatanEdit) {
            catatanEdit.value = CURRENT_TICKET_DATA.catatan_it || '';
        }
        var catatanDisplay = document.getElementById('modalCatatanDisplay');
        if (catatanDisplay) {
            catatanDisplay.textContent = CURRENT_TICKET_DATA.catatan_it || '—';
        }

        var alasanJedaEdit = document.getElementById('modalAlasanJedaEdit');
        if (alasanJedaEdit) {
            alasanJedaEdit.value = CURRENT_TICKET_DATA.alasan_jeda || '';
        }

        var feedbackEl = document.getElementById('modalFeedbackAtasan');
        if (feedbackEl) {
            feedbackEl.value = CURRENT_TICKET_DATA.feedback_atasan || '';
        }

        document.getElementById('detailModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.closeDetail = function () {
        document.getElementById('detailModal').style.display = 'none';
        document.body.style.overflow = '';
        CURRENT_TICKET_ID = null;
        CURRENT_TICKET_DATA = null;
    };

    window.toggleJedaField = function () {
        var sel = document.getElementById('modalStatusSelect');
        var wrap = document.getElementById('modalJedaEditWrap');
        if (sel && wrap) {
            wrap.style.display = sel.value === 'dijeda' ? '' : 'none';
        }
    };

    // --- Save Ticket ---
    window.saveTicket = function () {
        if (!CURRENT_TICKET_ID) return;

        var payload = {};
        var assigneeSelect = document.getElementById('modalAssignee');
        var statusSelect = document.getElementById('modalStatusSelect');
        var catatanEdit = document.getElementById('modalCatatanIT');
        var alasanJedaEdit = document.getElementById('modalAlasanJedaEdit');

        if (assigneeSelect) payload.assignee_id = assigneeSelect.value || null;
        if (statusSelect) payload.status = statusSelect.value;
        if (catatanEdit) payload.catatan_it = catatanEdit.value;
        if (statusSelect && statusSelect.value === 'dijeda' && alasanJedaEdit) {
            if (!alasanJedaEdit.value.trim()) {
                alasanJedaEdit.style.borderColor = '#ef4444';
                alasanJedaEdit.focus();
                return;
            }
            payload.alasan_jeda = alasanJedaEdit.value;
        }

        var url = '/it/tickets/' + CURRENT_TICKET_ID;
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrf(),
                'X-HTTP-Method-Override': 'PATCH',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(function (res) {
            if (res.ok) {
                window.location.reload();
            } else {
                return res.json().then(function (data) {
                    var msg = data.message || 'Gagal menyimpan perubahan.';
                    if (data.errors) {
                        var details = Object.values(data.errors).flat().join('; ');
                        msg = details || msg;
                    }
                    alert(msg);
                });
            }
        })
        .catch(function (err) {
            alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
        });
    };

    // --- Feedback ---
    window.submitFeedback = function () {
        if (!CURRENT_TICKET_ID) return;
        var feedbackEl = document.getElementById('modalFeedbackAtasan');
        var errorEl = document.getElementById('feedbackError');
        if (!feedbackEl) return;

        var val = feedbackEl.value.trim();
        if (!val) {
            if (errorEl) { errorEl.textContent = 'Feedback tidak boleh kosong.'; errorEl.style.display = ''; }
            feedbackEl.style.borderColor = '#ef4444';
            feedbackEl.focus();
            return;
        }
        if (errorEl) { errorEl.style.display = 'none'; }
        feedbackEl.style.borderColor = '';

        var url = '/it/tickets/' + CURRENT_TICKET_ID + '/feedback';
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrf(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ feedback_atasan: val })
        })
        .then(function (res) {
            if (res.ok) {
                window.location.reload();
            } else {
                return res.json().then(function (data) {
                    var msg = data.message || 'Gagal mengirim feedback.';
                    if (errorEl) { errorEl.textContent = msg; errorEl.style.display = ''; }
                });
            }
        })
        .catch(function () {
            alert('Terjadi kesalahan jaringan.');
        });
    };

    // --- Delete ---
    window.confirmDelete = function () {
        if (!CURRENT_TICKET_ID) return;
        document.getElementById('deleteKodeDisplay').textContent = CURRENT_TICKET_DATA ? CURRENT_TICKET_DATA.kode : '';
        document.getElementById('deleteModal').style.display = 'flex';
    };

    window.closeDeleteModal = function () {
        document.getElementById('deleteModal').style.display = 'none';
    };

    window.executeDelete = function () {
        if (!CURRENT_TICKET_ID) return;
        var url = '/it/tickets/' + CURRENT_TICKET_ID;
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrf(),
                'X-HTTP-Method-Override': 'DELETE',
                'Accept': 'application/json'
            }
        })
        .then(function (res) {
            if (res.ok) {
                window.location.reload();
            } else {
                return res.json().then(function (data) {
                    alert(data.message || 'Gagal menghapus tiket.');
                });
            }
        })
        .catch(function () {
            alert('Terjadi kesalahan jaringan.');
        });
    };

    // --- Create Modal ---
    window.openCreateModal = function () {
        document.getElementById('createModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.closeCreateModal = function () {
        document.getElementById('createModal').style.display = 'none';
        document.body.style.overflow = '';
    };

    // --- File Preview ---
    window.previewBukti = function (input) {
        var wrap = document.getElementById('buktiPreview');
        var img = document.getElementById('buktiPreviewImg');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                wrap.style.display = '';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.style.display = 'none';
            img.src = '';
        }
    };

    // --- Close modals on Escape ---
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (document.getElementById('detailModal') && document.getElementById('detailModal').style.display === 'flex') closeDetail();
            if (document.getElementById('createModal') && document.getElementById('createModal').style.display === 'flex') closeCreateModal();
            if (document.getElementById('deleteModal') && document.getElementById('deleteModal').style.display === 'flex') closeDeleteModal();
        }
    });
})();
</script>
@endpush

@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
