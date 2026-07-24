@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Permintaan Meeting')
@section('page-title', 'Permintaan Meeting')
@section('page-subtitle', 'Kelola semua permintaan meeting perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-5 animate-fade-in">

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
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Total Permintaan</div>
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
                <div class="text-[11px] font-medium mt-px" style="color:var(--text-muted);">Menunggu Review</div>
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
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Daftar Permintaan</div>
                <div style="font-size:0.7rem;margin-top:2px;color:var(--text-muted);">Tinjau dan kelola permintaan meeting dari seluruh tim.</div>
            </div>
        </div>

        <div class="px-6 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-0 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-meeting" placeholder="Cari pemohon..." oninput="filterMeetings()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2 ml-auto">
                <div>
                    <input type="month" id="meeting-month-input" value="{{ $meetingMonth ?? now()->format('Y-m') }}" onchange="setMeetingMonth()"
                        class="" style="padding:6px 10px;font-size:13px;border-radius:8px;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;">
                </div>
                <a href="{{ route('admin.export', ['type' => 'meetings', 'meeting_month' => $meetingMonth ?? now()->format('Y-m')]) }}"
                    class="btn btn-secondary btn-sm inline-flex items-center gap-1.5" title="Export" id="meeting-export-link">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
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
        </div>

        <div class="table-responsive">
            <table class="gaming-table" id="meetings-table" style="width:100%;min-width:750px;">
                <colgroup>
                    <col style="width:44px">
                    <col>
                    <col class="hidden sm:table-cell" style="width:160px">
                    <col class="hidden lg:table-cell" style="width:120px">
                    <col style="width:115px">
                    <col class="hidden sm:table-cell" style="width:95px">
                    <col style="width:85px">
                    <col class="hidden md:table-cell" style="width:85px">
                    <col style="width:80px">
                </colgroup>
                <thead>
                    <tr>
                        <th style="width:44px">No</th>
                        <th>Judul</th>
                        <th class="hidden sm:table-cell" style="width:160px">Pemohon</th>
                        <th class="hidden lg:table-cell" style="width:120px">Tim</th>
                        <th style="width:115px">Tanggal</th>
                        <th class="hidden sm:table-cell" style="width:95px">Waktu</th>
                        <th style="width:85px">Status</th>
                        <th class="hidden md:table-cell" style="width:85px">Antrian</th>
                        @if(auth()->user()->role !== 'gm')
                        <th style="width:80px">Aksi</th>
                        @endif
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
                    <tr data-status="{{ $meeting->status }}" class="meeting-row">
                        <td style="color:var(--text-muted);font-size:0.8rem;">{{ $loop->iteration }}</td>
                        <td>
                            <span class="font-medium" style="color:var(--text-primary);font-size:0.8rem;">{{ $meeting->title }}</span>
                        </td>
                        <td class="meeting-pemohon hidden sm:table-cell">
                            <div class="flex items-center gap-1.5">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0"
                                    style="background:rgba(124,58,237,0.1);color:var(--color-accent-light);">
                                    {{ strtoupper(substr($meeting->requester->name, 0, 1)) }}
                                </div>
                                <span style="color:var(--text-secondary);font-size:0.8rem;">{{ $meeting->requester->name }}</span>
                            </div>
                        </td>
                        <td class="hidden lg:table-cell"><span style="color:var(--text-secondary);font-size:0.8rem;">{{ $meeting->team->name }}</span></td>
                        <td>
                            <span style="color:var(--text-secondary);font-size:0.8rem;white-space:nowrap;">{{ $meeting->meeting_date->format('d M Y') }}</span>
                        </td>
                        <td class="hidden sm:table-cell"><span style="color:var(--text-secondary);font-size:0.8rem;">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</span></td>
                        <td><span class="badge {{ $statusStyle }}" style="white-space:nowrap;font-size:0.65rem;">{{ ucfirst($meeting->status) }}</span></td>
                        <td class="hidden md:table-cell">
                            @if($meeting->queue_position !== null && !in_array($meeting->status, ['pending','rejected','cancelled']))
                                <span class="badge {{ $queueBadge }}" style="white-space:nowrap;font-size:0.65rem;">{{ $rt['label'] }}</span>
                            @else
                                <span style="color:var(--text-muted);font-size:0.8rem;">—</span>
                            @endif
                        </td>
                        @if(auth()->user()->role !== 'gm')
                        <td>
                            <div class="flex items-center gap-1" style="white-space:nowrap;">
                                <button type="button" onclick="showDetail({{ $meeting->id }})" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5" style="padding:4px 8px;font-size:0.7rem;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Detail
                                </button>
                                <div class="relative dropdown-actions">
                                    <button type="button" onclick="toggleActionMenu(event, {{ $meeting->id }})" style="padding:6px 10px;line-height:1;font-size:0.8rem;font-weight:700;border:1px solid var(--border-color);border-radius:8px;background:var(--bg-surface);color:var(--text-primary);cursor:pointer;" title="Aksi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 5v.01M12 12v.01M12 19v.01"/>
                                        </svg>
                                    </button>
                                    <div id="action-menu-{{ $meeting->id }}" style="display:none;position:absolute;top:100%;right:0;min-width:155px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;z-index:99999;margin-top:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);">
                                        <button type="button" onclick="showDetail({{ $meeting->id }})" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:var(--text-secondary);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail
                                        </button>
                                        <button type="button" onclick="showEditModal({{ $meeting->id }})" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:var(--text-secondary);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </button>
                                        @if(in_array($meeting->status, ['cancelled','rejected']))
                                        <button type="button" onclick="confirmDeleteMeeting({{ $meeting->id }})" class="w-full text-left px-2.5 py-1.5 text-xs rounded-md transition flex items-center gap-2" style="color:#f87171;background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="9" style="text-align:center;padding:2.5rem;color:var(--text-muted);font-size:0.9rem;">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Belum ada permintaan meeting.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 flex items-center justify-end" style="border-top:1px solid var(--border-color);font-size:0.8rem;">
            {{ $meetings->links() }}
        </div>
    </div>

</div>
@endsection

@push('modals')
{{-- Detail Modal --}}
<div id="detail-modal" class="modal-modern" onclick="if(event.target===this)closeDetail()">
    <div class="modal-modern-panel lg" onclick="event.stopPropagation()">

        <div class="modal-modern-header">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(139,92,246,0.15);">
                    <svg class="w-3.5 h-3.5" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 style="color:var(--text-primary);">Detail Meeting — <span id="detail-judul">Meeting</span></h3>
            </div>
            <button type="button" onclick="closeDetail()" class="modal-modern-close">&times;</button>
        </div>

        <div class="modal-modern-body">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                <div id="meeting-info-rows" class="space-y-0"></div>
                <div id="meeting-permohonan-section" class="hidden">
                    <div id="meeting-permohonan-content"></div>
                </div>
            </div>

            <div class="mt-3" id="meeting-assets-section" style="display:none;">
                <div style="border:1px solid var(--border-color);background:var(--bg-surface-2);border-radius:12px;padding:10px;">
                    <div id="meeting-assets-content"></div>
                </div>
            </div>

            <div class="mt-3" id="meeting-mom-section" style="display:none;">
                <div style="border:1px solid rgba(16,185,129,0.35);background:var(--bg-base);border-radius:12px;padding:12px;">
                    <div class="flex items-center gap-2 mb-2.5">
                        <svg class="w-4 h-4" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <h4 class="text-xs font-bold" style="color:#10b981;">Minutes of Meeting (MOM)</h4>
                    </div>
                    <div style="border:1px solid rgba(16,185,129,0.2);background:var(--bg-surface-2);border-radius:10px;padding:10px;">
                        <div id="mom-ringkasan" class="mb-2"></div>
                        <div id="mom-keputusan" class="mb-2"></div>
                        <div id="mom-action-plan" class="mb-2"></div>
                        <div id="mom-pic-section" class="mb-2"></div>
                        <div id="mom-file-section"></div>
                    </div>
                </div>
            </div>

            <div id="d-reject-section" class="hidden">
                <div class="p-3 rounded-xl" style="background:#fef2f2;border:1px solid #fecaca;">
                    <p class="text-xs font-semibold mb-0.5" style="color:#ef4444;">Alasan Penolakan</p>
                    <p class="text-xs" style="color:#f87171;" id="d-reject-reason"></p>
                </div>
            </div>

            <div id="d-actions-section" class="hidden">
                <div class="flex items-center justify-between gap-3" style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:10px 14px;">
                    <p class="text-[10px] font-bold tracking-[0.1em] flex-shrink-0" style="color:var(--text-muted);">UPDATE STATUS</p>
                    <div class="flex items-center gap-2">
                        <form id="d-approve-form" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PATCH">
                            <button type="submit" class="px-4 py-1.5 rounded-lg text-xs font-semibold text-white transition" style="background:#10b981;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">✓ Setujui</button>
                        </form>
                        <div class="flex items-center gap-2">
                            <textarea name="reject_reason" id="d-reject-input" placeholder="Alasan tolak..." rows="1" class="w-40 px-3 py-1.5 rounded-lg text-xs border transition" style="resize:none;border-color:var(--border-color);color:var(--text-primary);background:var(--bg-surface);" onfocus="this.style.borderColor='#f87171'" onblur="this.style.borderColor='var(--border-color)'"></textarea>
                            <form id="d-reject-form" method="POST" class="flex-shrink-0">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PATCH">
                                <button type="submit" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="color:#e11d48;background:#ffe4e6;" onmouseover="this.style.background='#fecdd3'" onmouseout="this.style.background='#ffe4e6'">× Tolak</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetail()" class="px-4 py-1.5 rounded-lg text-xs font-medium transition" style="color:var(--text-secondary);border:1px solid var(--border-color);background:var(--bg-surface-2);" onmouseover="this.style.background='var(--bg-surface)'" onmouseout="this.style.background='var(--bg-surface-2)'">Tutup</button>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="modal-modern" onclick="if(event.target===this)closeEditModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">

        <div class="modal-modern-header">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(139,92,246,0.15);">
                    <svg class="w-3.5 h-3.5" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <h3 style="color:var(--text-primary);">Edit Meeting</h3>
            </div>
            <button type="button" onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>

        <form id="edit-form" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" id="edit-meeting-id" name="meeting_id" value="">
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label text-xs">Judul Meeting <span style="color:#f87171;">*</span></label>
                    <input type="text" id="edit-title" name="title" required class="gaming-input mt-1" placeholder="Judul meeting">
                </div>

                <div>
                    <label class="gaming-label text-xs">Ruangan <span style="color:#f87171;">*</span></label>
                    <select id="edit-room" name="room_id" required class="gaming-input gaming-select mt-1">
                        <option value="">Pilih Ruangan</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }} ({{ $room->capacity }} orang)</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="gaming-label text-xs">Tanggal Meeting <span style="color:#f87171;">*</span></label>
                    <input type="date" id="edit-date" name="meeting_date" required class="gaming-input mt-1">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="gaming-label text-xs">Jam Mulai <span style="color:#f87171;">*</span></label>
                        <input type="time" id="edit-start-time" name="start_time" required class="gaming-input mt-1">
                    </div>
                    <div>
                        <label class="gaming-label text-xs">Jam Selesai <span style="color:#f87171;">*</span></label>
                        <input type="time" id="edit-end-time" name="end_time" required class="gaming-input mt-1">
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary btn-sm">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirm Modal --}}
<div id="delete-confirm-modal" class="modal-modern" onclick="if(event.target===this)closeDeleteModal()">
    <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Hapus Meeting</h3>
            <button type="button" onclick="closeDeleteModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body text-center">
            <div class="w-12 h-12 mx-auto mb-4 rounded-full flex items-center justify-center" style="background:rgba(239,68,68,0.12);">
                <svg class="w-6 h-6" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <p style="color:var(--text-secondary);margin-bottom:24px;">Apakah kamu yakin ingin menghapus meeting ini? Tindakan ini tidak dapat dibatalkan.</p>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex items-center gap-3 justify-center">
                    <button type="submit" class="btn btn-danger btn-sm px-5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Ya, Hapus
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="btn btn-secondary btn-sm">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@include('partials.file-preview-modal')
@include('partials.file-upload-modal')

@push('scripts')
<script>
function checkAndOpenFile(filePath, fileUrl, uploadUrl) {
    fetch('/files/check/' + encodeURIComponent(filePath))
        .then(r => r.json())
        .then(data => {
            if (data.exists) {
                openFilePreviewModal(filePath, fileUrl);
            } else if (uploadUrl) {
                openFileUploadModal(uploadUrl, filePath);
            } else {
                window.open(fileUrl, '_blank');
            }
        })
        .catch(() => { window.open(fileUrl, '_blank'); });
}

const meetingsData = @json($meetingsJson);
const roomsData = @json($rooms);
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

    const st = statusMap[m.status] || statusMap.cancelled;

    document.getElementById('detail-judul').textContent = m.title;

    const rows = document.getElementById('meeting-info-rows');
    rows.innerHTML = `
        <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Pemohon</span>
            <span class="text-xs text-right font-semibold" style="color:var(--text-primary);">${m.requester?.name || '-'}</span>
        </div>
        <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Judul Meeting</span>
            <span class="text-xs text-right font-semibold" style="color:var(--text-primary);">${m.title}</span>
        </div>
        <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Tanggal</span>
            <span class="text-xs text-right font-semibold" style="color:var(--text-primary);">${m.meeting_date || '-'}</span>
        </div>
        <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Ruangan</span>
            <span class="text-xs text-right font-semibold" style="color:var(--text-primary);">${m.room?.name || '-'}</span>
        </div>
        <div class="flex items-center justify-between py-2.5" style="border-bottom:1px solid var(--border-color);">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Waktu</span>
            <span class="text-xs text-right font-semibold" style="color:var(--text-primary);">${m.start_time || '-'}${m.end_time ? ' - ' + m.end_time : ''}</span>
        </div>
        <div class="flex items-center justify-between py-2.5">
            <span class="text-[11px] font-semibold" style="color:var(--text-muted);">Status</span>
            <span class="text-[11px] font-bold px-2.5 py-1 rounded-md" style="background:${st.bg};color:${st.text};">${st.label}</span>
        </div>
    `;

    const permohonanSec = document.getElementById('meeting-permohonan-section');
    const permohonanContent = document.getElementById('meeting-permohonan-content');
    let pHtml = '';
    if (m.why) pHtml += `
        <div class="mb-2.5">
            <div class="flex items-center gap-1.5 mb-1.5">
                <svg class="w-3.5 h-3.5" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[11px] font-bold" style="color:#8b5cf6;">Why — Kenapa meeting ini diadakan?</span>
            </div>
            <div class="text-xs leading-relaxed p-2.5 rounded-lg" style="background:var(--bg-surface-2);color:var(--text-secondary);line-height:1.5;border:1px solid var(--border-color);">${m.why}</div>
        </div>`;
    if (m.what) pHtml += `
        <div class="mb-2.5">
            <div class="flex items-center gap-1.5 mb-1.5">
                <svg class="w-3.5 h-3.5" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span class="text-[11px] font-bold" style="color:#8b5cf6;">What — Apa yang dibahas?</span>
            </div>
            <div class="text-xs leading-relaxed p-2.5 rounded-lg" style="background:var(--bg-surface-2);color:var(--text-secondary);line-height:1.5;border:1px solid var(--border-color);">${m.what}</div>
        </div>`;
    if (m.how_expected) pHtml += `
        <div class="mb-2.5">
            <div class="flex items-center gap-1.5 mb-1.5">
                <svg class="w-3.5 h-3.5" style="color:#8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-[11px] font-bold" style="color:#8b5cf6;">How — Bagaimana hasil yang diharapkan?</span>
            </div>
            <div class="text-xs leading-relaxed p-2.5 rounded-lg" style="background:var(--bg-surface-2);color:var(--text-secondary);line-height:1.5;border:1px solid var(--border-color);">${m.how_expected}</div>
        </div>`;
    if (pHtml) {
        permohonanContent.innerHTML = pHtml;
        permohonanSec.classList.remove('hidden');
    } else {
        permohonanSec.classList.add('hidden');
    }

    const assetsSection = document.getElementById('meeting-assets-section');
    const assetsContent = document.getElementById('meeting-assets-content');
    if (m.assets && m.assets.length) {
        assetsContent.innerHTML = `
            <p class="text-[11px] font-bold tracking-wider mb-2.5" style="color:var(--color-accent-light);">ASET DIBUTUHKAN</p>
            <div class="flex flex-wrap gap-2">${m.assets.map(a => `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background:#e0e7ff;color:#4338ca;">${a.name} (${a.quantity})</span>`).join('')}</div>
        `;
        assetsSection.style.display = '';
    } else {
        assetsSection.style.display = 'none';
    }

    const momSection = document.getElementById('meeting-mom-section');
    const hasMom = m.mom && (m.mom.summary || m.mom.decisions || m.mom.action_plan || m.mom.pic || m.mom.file_url);
    if (hasMom) {
        function momItem(label, content, icon) {
            if (!content) return '';
            return '<div class="mb-2"><div class="flex items-center gap-1 mb-1"><svg class="w-3 h-3" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + icon + '"/></svg><span class="text-[11px] font-bold uppercase tracking-wider" style="color:#10b981;">' + label + '</span></div><p class="text-xs" style="color:var(--text-primary);line-height:1.5;">' + content + '</p></div>';
        }

        let ringkasanHtml = '';
        if (m.mom.status) {
            const isSent = m.mom.status === 'sent';
            ringkasanHtml += '<div class="flex items-center gap-2 mb-2.5"><span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold" style="background:' + (isSent ? '#dcfce7' : '#fef3c7') + ';color:' + (isSent ? '#059669' : '#d97706') + ';">' + (isSent ? 'Terkirim' : 'Draft') + '</span></div>';
        }
        ringkasanHtml += momItem('Ringkasan Pembahasan', m.mom.summary, 'M7 4V2m17 2v2M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z');
        document.getElementById('mom-ringkasan').innerHTML = ringkasanHtml;
        document.getElementById('mom-keputusan').innerHTML = momItem('Keputusan', m.mom.decisions, 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z');
        document.getElementById('mom-action-plan').innerHTML = momItem('Action Plan', m.mom.action_plan, 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2');
        document.getElementById('mom-pic-section').innerHTML = momItem('Penanggung Jawab (PIC)', m.mom.pic, 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z');
        document.getElementById('mom-file-section').innerHTML = m.mom.file_url
            ? '<div><div class="flex items-center gap-1 mb-1"><svg class="w-3 h-3" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg><span class="text-[11px] font-bold uppercase tracking-wider" style="color:#10b981;">File Pendukung</span></div><a href="javascript:void(0)" onclick="checkAndOpenFile(\'' + m.mom.file_path + '\',\'' + m.mom.file_url + '\',null)" class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-medium rounded-lg max-w-full" style="background:rgba(16,185,129,0.12);color:#10b981;border:1px solid rgba(16,185,129,0.3);"><svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg><span class="truncate max-w-[160px]">' + (m.mom.file_name || 'Download') + '</span></a></div>'
            : '';
        momSection.style.display = '';
    } else {
        momSection.style.display = 'none';
    }

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
        document.getElementById('d-approve-form').action = '/admin/meetings/' + m.id + '/approve';
        document.getElementById('d-reject-form').action = '/admin/meetings/' + m.id + '/reject';
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

const reviewId = new URLSearchParams(window.location.search).get('review');
if (reviewId) {
    showDetail(parseInt(reviewId));
}

function toggleActionMenu(e, id) {
    e.stopPropagation();
    const menu = document.getElementById('action-menu-' + id);
    const isHidden = menu.style.display === 'none';
    document.querySelectorAll('[id^="action-menu-"]').forEach(m => m.style.display = 'none');
    if (isHidden) {
        menu.style.display = 'block';
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-actions')) {
        document.querySelectorAll('[id^="action-menu-"]').forEach(m => m.style.display = 'none');
    }
});

// ─── Edit Modal ───
function showEditModal(id) {
    const m = meetingsData.find(i => i.id === id);
    if (!m) return;

    document.getElementById('edit-meeting-id').value = m.id;
    document.getElementById('edit-title').value = m.title || '';
    document.getElementById('edit-room').value = m.room?.id || '';
    document.getElementById('edit-date').value = m.meeting_date_raw || '';
    document.getElementById('edit-start-time').value = m.start_time || '';
    document.getElementById('edit-end-time').value = m.end_time || '';

    document.getElementById('edit-form').action = '/admin/meetings/' + m.id;
    openModal('edit-modal');
}

function closeEditModal() {
    closeModal('edit-modal');
}

document.getElementById('edit-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// ─── Delete Modal ───
function confirmDeleteMeeting(id) {
    document.getElementById('delete-form').action = '/admin/meetings/' + id;
    openModal('delete-confirm-modal');
}

function closeDeleteModal() {
    closeModal('delete-confirm-modal');
}

document.getElementById('delete-confirm-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endpush

@push('styles')
<style>
#detail-body::-webkit-scrollbar { width: 5px; }
#detail-body::-webkit-scrollbar-track { background: transparent; }
#detail-body::-webkit-scrollbar-thumb { background: rgba(129,140,248,0.25); border-radius: 4px; }

@keyframes momFadeIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}

.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
.meeting-row + .meeting-row > td { padding-top: 0; }
</style>
@endpush
