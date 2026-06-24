@extends('layouts.app')
@section('title', 'Meeting')
@section('page-title', 'Meeting')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-user') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 3 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(59,130,246,0.15);box-shadow:0 0 16px rgba(59,130,246,0.25);">
                <svg class="w-6 h-6" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $totalInvitations }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Undangan</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Meeting yang melibatkan kamu.</div>
            </div>
        </div>

        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:0 0 16px rgba(245,158,11,0.2);">
                <svg class="w-6 h-6" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;">{{ $mendatangCount }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Mendatang</div>
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
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $selesaiCount }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Selesai</div>
            </div>
        </div>
    </div>

    {{-- Meeting Hari Ini --}}
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(16,185,129,0.1),rgba(16,185,129,0.05));">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING HARI INI</h3>
            <span class="badge" style="background:rgba(16,185,129,0.2);color:#34d399;border:1px solid rgba(16,185,129,0.3);">{{ today()->isoFormat('D MMM') }}</span>
        </div>
        <div class="divide-y" style="border-color:var(--border-color);">
            @forelse($todayMeetings as $meeting)
            <div class="px-5 py-3 transition hover:bg-slate-100/5">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full flex-shrink-0"
                        style="background:{{ $meeting->status === 'in_progress' ? 'var(--color-accent)' : 'var(--color-secondary)' }};
                               box-shadow:0 0 6px {{ $meeting->status === 'in_progress' ? 'rgba(124,58,237,0.8)' : 'rgba(59,130,246,0.6)' }};
                               {{ $meeting->status === 'in_progress' ? 'animation:glowPulse 2s ease-in-out infinite;' : '' }}"></span>
                    <p class="text-sm font-medium" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                </div>
                <p class="text-xs ml-4" style="color:var(--text-muted);">📍 {{ $meeting->room->name }}</p>
                <p class="text-xs ml-4" style="color:var(--text-muted);">⏰ {{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p>
                <p class="text-xs ml-4" style="color:var(--text-muted);">👤 Oleh: {{ $meeting->requester->name }}</p>
            </div>
            @empty
            <div class="px-5 py-8 text-center">
                <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting hari ini</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Table Card: Semua Undangan --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">SEMUA UNDANGAN MEETING</h3>
            <p class="text-xs mt-0.5" style="color:var(--text-muted);">Daftar meeting yang melibatkan kamu</p>
        </div>

        {{-- Search & Filter --}}
        <div class="px-5 py-3 flex flex-col sm:flex-row items-stretch sm:items-center gap-2" style="border-bottom:1px solid var(--border-color);">
            <form method="GET" action="{{ route('user.dashboard') }}" class="flex items-center gap-2 flex-1" id="filter-form">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul meeting..."
                        class="gaming-input" style="padding-left:2.5rem;">
                </div>
                <input type="hidden" name="status" id="status-input" value="{{ $status }}">
            </form>
            <div class="relative filter-dropdown-wrap flex-shrink-0">
                <button type="button" onclick="toggleFilterMenu(event)"
                    class="btn btn-secondary btn-sm flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    @if($status && $status !== 'all')
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    @else
                        Semua Status
                    @endif
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;bottom:100%;right:0;margin-bottom:6px;min-width:170px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:12px;padding:6px;z-index:9999;">
                    <button type="button" onclick="setFilter('all')" class="w-full text-left px-3 py-2 text-sm rounded-lg transition" style="color:var(--text-secondary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">Semua Status</button>
                    <button type="button" onclick="setFilter('approved')" class="w-full text-left px-3 py-2 text-sm rounded-lg transition" style="color:var(--text-secondary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">Disetujui</button>
                    <button type="button" onclick="setFilter('confirmed')" class="w-full text-left px-3 py-2 text-sm rounded-lg transition" style="color:var(--text-secondary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">Dikonfirmasi</button>
                    <button type="button" onclick="setFilter('in_progress')" class="w-full text-left px-3 py-2 text-sm rounded-lg transition" style="color:var(--text-secondary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">Berlangsung</button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Ruangan</th>
                        <th>Pemohon</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myMeetings as $i => $meeting)
                    @php
                        $badgeStyle = match($meeting->status) {
                            'approved'    => 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);',
                            'confirmed'   => 'background:rgba(99,102,241,0.15);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);',
                            'in_progress' => 'background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);',
                            default       => 'background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid rgba(148,163,184,0.3);',
                        };
                        $statusLabel = match($meeting->status) {
                            'approved'    => 'Disetujui',
                            'confirmed'   => 'Dikonfirmasi',
                            'in_progress' => 'Berlangsung',
                            default       => ucfirst($meeting->status),
                        };
                    @endphp
                    <tr>
                        <td style="color:var(--text-muted);">{{ $myMeetings->firstItem() + $i }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $meeting->title }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->meeting_date->format('d M Y') }}</td>
                        <td style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->room->name }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->requester->name }}</td>
                        <td>
                            <span class="badge" style="{{ $badgeStyle }}">{{ $statusLabel }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">
                            @if($search || $status)
                                Tidak ada meeting ditemukan.
                            @else
                                Kamu belum diundang ke meeting apapun.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($myMeetings->hasPages())
        <div class="px-5 py-3 flex items-center justify-between" style="border-top:1px solid var(--border-color);">
            {{ $myMeetings->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    function toggleFilterMenu(e) {
        e.stopPropagation();
        var menu = document.getElementById('filter-menu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    function setFilter(value) {
        document.getElementById('status-input').value = value;
        document.getElementById('filter-menu').style.display = 'none';
        document.getElementById('filter-form').submit();
    }
    document.addEventListener('click', function(e) {
        var menu = document.getElementById('filter-menu');
        if (menu && !e.target.closest('.filter-dropdown-wrap')) {
            menu.style.display = 'none';
        }
    });

    function refreshTodayMeetings() {
        fetch('{{ route("realtime.meetings") }}')
            .then(r => r.json())
            .then(data => {
                const today = new Date().toISOString().slice(0,10);
                data.filter(m => m.date === today).forEach(m => {
                    const dot = document.querySelector(`.today-dot[data-id="${m.id}"]`);
                    if (!dot) return;
                    const isActive = m.rt_label.includes('Berlangsung');
                    dot.style.background = isActive ? 'var(--color-accent)' : 'var(--color-secondary)';
                    dot.style.boxShadow  = isActive ? '0 0 6px rgba(124,58,237,0.8)' : '0 0 6px rgba(59,130,246,0.6)';
                });
            }).catch(() => {});
    }

    setInterval(refreshTodayMeetings, 30000);
    refreshTodayMeetings();
</script>
@endpush
