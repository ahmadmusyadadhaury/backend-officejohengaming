@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="space-y-5 pt-2 stagger-children">

    {{-- Stats Cards --}}
        @php
        $cards = [
            ['label' => 'Karyawan',          'value' => $stats['total_karyawan'],    'id' => 'stat-karyawan',    'color' => 'linear-gradient(135deg,#1e3a5f,#2d5a8e)', 'glow' => 'rgba(30,58,95,0.4)',   'icon' => null, 'img' => 'images/icon/business-people.png'],
            ['label' => 'Koordinator',       'value' => $stats['total_koordinator'], 'id' => 'stat-koordinator', 'color' => 'linear-gradient(135deg,#3b82f6,#60a5fa)', 'glow' => 'rgba(59,130,246,0.4)', 'icon' => null, 'img' => 'images/icon/coordination.png'],
            ['label' => 'Head of Store',     'value' => $stats['total_head_store'],  'id' => 'stat-headstore',   'color' => 'linear-gradient(135deg,#7c3aed,#a78bfa)', 'glow' => 'rgba(124,58,237,0.4)', 'icon' => null, 'img' => 'images/icon/intelligence.png'],
            ['label' => 'General Manager',   'value' => $stats['total_gm'],          'id' => 'stat-gm',          'color' => 'linear-gradient(135deg,#f59e0b,#fbbf24)', 'glow' => 'rgba(245,158,11,0.4)', 'icon' => null, 'img' => 'images/icon/manager.png'],
            ['label' => 'Chief Executive Officer', 'value' => $stats['total_ceo'], 'id' => 'stat-ceo',        'color' => 'linear-gradient(135deg,#8b5cf6,#a78bfa)', 'glow' => 'rgba(139,92,246,0.4)', 'icon' => null, 'img' => 'images/icon/manager.png'],
            ['label' => 'Human Resources',   'value' => $stats['total_hr'],          'id' => 'stat-hr',          'color' => 'linear-gradient(135deg,#ec4899,#f472b6)', 'glow' => 'rgba(236,72,153,0.4)', 'icon' => null, 'img' => 'images/icon/hr.png'],
            ['label' => 'Total Tim',         'value' => $stats['total_teams'],       'id' => 'stat-teams',       'color' => 'linear-gradient(135deg,#06b6d4,#00d4ff)', 'glow' => 'rgba(6,182,212,0.4)',  'icon' => null, 'img' => 'images/icon/costumer.png'],
            ['label' => 'Menunggu Approval', 'value' => $stats['pending'],           'id' => 'stat-pending',     'color' => 'linear-gradient(135deg,#f97316,#fb923c)', 'glow' => 'rgba(249,115,22,0.4)', 'icon' => null, 'img' => 'images/icon/timestamp.png'],
            ['label' => 'Meeting Hari Ini',  'value' => $stats['today_meetings'],    'id' => 'stat-today',       'color' => 'linear-gradient(135deg,#7c3aed,#a78bfa)', 'glow' => 'rgba(124,58,237,0.4)', 'icon' => null, 'img' => 'images/icon/meeting.png'],
            ['label' => 'Meeting Bulan Ini', 'value' => $stats['this_month'],        'id' => 'stat-month',       'color' => 'linear-gradient(135deg,#10b981,#34d399)', 'glow' => 'rgba(16,185,129,0.4)', 'icon' => null, 'img' => 'images/icon/business.png'],
            ['label' => 'Total Ruangan',     'value' => $stats['total_rooms'],       'id' => 'stat-rooms',       'color' => 'linear-gradient(135deg,#64748b,#94a3b8)', 'glow' => 'rgba(100,116,139,0.4)','icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5'],
        ];
        @endphp

    {{-- Baris 1: Breakdown Akun --}}
    <div>
        <p class="text-xs font-gaming font-semibold mb-2" style="color:var(--text-muted);letter-spacing:0.1em;">BREAKDOWN AKUN</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach(array_slice($cards, 0, 5) as $card)
            <div class="stat-card animate-fade-in">
                <div class="stat-icon" style="background:{{ $card['color'] }};box-shadow:0 4px 12px {{ $card['glow'] }};">
                    @if(!empty($card['img']))
                        <img src="{{ asset($card['img']) }}" class="w-6 h-6 object-contain" style="filter:brightness(0) invert(1);">
                    @else
                        <svg class="w-5 h-5" style="color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                        </svg>
                    @endif
                </div>
                <div class="min-w-0">
                    <div class="stat-value" id="{{ $card['id'] }}">{{ $card['value'] }}</div>
                    <div class="stat-label truncate">{{ $card['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Baris 2: Statistik Meeting --}}
    <div>
        <p class="text-xs font-gaming font-semibold mb-2" style="color:var(--text-muted);letter-spacing:0.1em;">STATISTIK MEETING</p>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach(array_slice($cards, 5, 4) as $card)
            <div class="stat-card animate-fade-in">
                <div class="stat-icon" style="background:{{ $card['color'] }};box-shadow:0 4px 12px {{ $card['glow'] }};">
                    @if(!empty($card['img']))
                        <img src="{{ asset($card['img']) }}" class="w-6 h-6 object-contain" style="filter:brightness(0) invert(1);">
                    @else
                        <svg class="w-5 h-5" style="color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                        </svg>
                    @endif
                </div>
                <div class="min-w-0">
                    <div class="stat-value" id="{{ $card['id'] }}">{{ $card['value'] }}</div>
                    <div class="stat-label truncate">{{ $card['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Pending Meetings --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">
                    MENUNGGU APPROVAL
                </h3>
                <a href="{{ route('admin.meetings.index') }}" class="badge badge-primary">Lihat semua</a>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($pendingMeetings as $meeting)
                    <div class="px-5 py-3 flex items-start justify-between gap-3 transition"
                        style="border-color:var(--border-color);"
                        onmouseover="this.style.background='rgba(124,58,237,0.04)'"
                        onmouseout="this.style.background='transparent'">
                        <div class="min-w-0">
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                            <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $meeting->requester->name }} · {{ $meeting->team->name }}</p>
                            <p class="text-xs" style="color:var(--text-muted);">{{ $meeting->meeting_date->format('d M Y') }} · {{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</p>
                        </div>
                        <a href="{{ route('admin.meetings.show', $meeting) }}" class="btn btn-primary btn-sm flex-shrink-0">Review</a>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm" style="color:var(--text-muted);">Tidak ada permintaan pending</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Today's Meetings --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">
                    MEETING HARI INI
                </h3>
                <span class="badge badge-blue">{{ today()->isoFormat('D MMM') }}</span>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($todayMeetings as $meeting)
                    <div class="px-5 py-3 transition"
                        style="border-color:var(--border-color);"
                        onmouseover="this.style.background='rgba(124,58,237,0.04)'"
                        onmouseout="this.style.background='transparent'">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full flex-shrink-0 animate-glow-pulse"
                                style="background:{{ $meeting->status === 'in_progress' ? 'var(--color-accent)' : 'var(--color-secondary)' }};
                                       box-shadow:0 0 6px {{ $meeting->status === 'in_progress' ? 'rgba(124,58,237,0.6)' : 'rgba(59,130,246,0.6)' }};"></span>
                            <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                        </div>
                        <p class="text-xs ml-4" style="color:var(--text-muted);">{{ $meeting->requester->name }} · {{ $meeting->room->name }}</p>
                        <p class="text-xs ml-4" style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting hari ini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Undangan untuk gm, head_of_store, hr, ceo --}}
    @if(in_array(auth()->user()->role, ['gm','head_of_store','hr','ceo']) && $myInvitations->count() > 0)
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">UNDANGAN MEETING SAYA</h3>
            <span class="badge badge-primary animate-glow-pulse">{{ $myInvitations->count() }} aktif</span>
        </div>
        <div class="divide-y" style="border-color:var(--border-color);">
            @foreach($myInvitations as $inv)
            <a href="{{ route('invitation.show', $inv) }}" class="flex items-center justify-between px-5 py-3 transition"
                style="border-color:var(--border-color);"
                onmouseover="this.style.background='rgba(124,58,237,0.04)'"
                onmouseout="this.style.background='transparent'">
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        @if(!$inv->is_read)
                            <span class="w-2 h-2 rounded-full flex-shrink-0 animate-glow-pulse" style="background:var(--color-accent);"></span>
                        @endif
                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $inv->meeting->title }}</p>
                    </div>
                    <p class="text-xs" style="color:var(--text-muted);">{{ $inv->meeting->team->name }} · {{ $inv->meeting->meeting_date->format('d M Y') }}</p>
                </div>
                <svg class="w-4 h-4 flex-shrink-0" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh stats dashboard setiap 60 detik
    function refreshDashboardStats() {
        fetch('{{ route("realtime.dashboard") }}')
            .then(r => r.json())
            .then(data => {
                if (data.pending !== undefined) {
                    const pendingEl = document.getElementById('stat-pending');
                    if (pendingEl) pendingEl.textContent = data.pending;
                }
                if (data.today_meetings !== undefined) {
                    const todayEl = document.getElementById('stat-today');
                    if (todayEl) todayEl.textContent = data.today_meetings;
                }
            }).catch(() => {});
    }

    setInterval(refreshDashboardStats, 60000);
</script>
@endpush
