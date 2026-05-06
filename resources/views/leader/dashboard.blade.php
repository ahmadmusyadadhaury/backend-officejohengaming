@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection

@section('content')
<div class="space-y-5 pt-2 stagger-children">

    {{-- Stats --}}
    @php
        $cards = [
            ['label' => 'Menunggu',   'value' => $stats['pending'],   'id' => 'stat-pending',   'color' => 'linear-gradient(135deg,#f59e0b,#fbbf24)', 'glow' => 'rgba(245,158,11,0.4)',  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Disetujui',  'value' => $stats['approved'],  'id' => 'stat-approved',  'color' => 'linear-gradient(135deg,#3b82f6,#60a5fa)', 'glow' => 'rgba(59,130,246,0.4)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Selesai',    'value' => $stats['completed'], 'id' => 'stat-completed', 'color' => 'linear-gradient(135deg,#10b981,#34d399)', 'glow' => 'rgba(16,185,129,0.4)', 'icon' => 'M5 13l4 4L19 7'],
            ['label' => 'Dibatalkan', 'value' => $stats['cancelled'], 'id' => 'stat-cancelled', 'color' => 'linear-gradient(135deg,#ef4444,#f87171)', 'glow' => 'rgba(239,68,68,0.4)',  'icon' => 'M6 18L18 6M6 6l12 12'],
        ];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach($cards as $card)
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $card['color'] }};box-shadow:0 4px 12px {{ $card['glow'] }};">
                <svg class="w-5 h-5" style="color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
            <div>
                <div class="stat-value" id="{{ $card['id'] }}">{{ $card['value'] }}</div>
                <div class="stat-label">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Quick Action Banner --}}
    <div class="gaming-card p-5 relative overflow-hidden"
        style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));">
        <div class="absolute inset-0 grid-pattern opacity-20"></div>
        <div class="relative flex items-center justify-between gap-4">
            <div>
                <h3 class="font-gaming font-bold text-lg text-white tracking-wide">REQUEST MEETING BARU</h3>
                <p style="color:rgba(255,255,255,0.7);font-size:0.8rem;margin-top:2px;">
                    Ajukan permintaan ruang meeting ke Admin HR
                </p>
            </div>
            <a href="{{ route('koordinator.meetings.create') }}" class="btn btn-sm flex-shrink-0"
                style="background:white;color:var(--color-primary);font-family:'Rajdhani',sans-serif;font-weight:700;letter-spacing:0.05em;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                REQUEST
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Upcoming --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING MENDATANG</h3>
                <a href="{{ route('koordinator.meetings.index') }}" class="badge badge-primary">Lihat semua</a>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($upcomingMeetings as $meeting)
                @php $rt = \App\Services\MeetingQueueService::realtimeStatus($meeting); @endphp
                <div class="px-5 py-3 transition"
                    onmouseover="this.style.background='rgba(124,58,237,0.04)'"
                    onmouseout="this.style.background='transparent'">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                        <span class="badge flex-shrink-0" style="{{ str_contains($rt['label'],'Berlangsung') ? 'background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);' : 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);' }}">
                            {{ $rt['label'] }}
                        </span>
                    </div>
                    <p class="text-xs mt-1" style="color:var(--text-muted);">{{ $meeting->room->name }} · {{ $meeting->meeting_date->format('d M Y') }}</p>
                    <p class="text-xs" style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting mendatang</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Recent --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">RIWAYAT MEETING</h3>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($recentMeetings as $meeting)
                @php
                    $badgeStyle = match($meeting->status) {
                        'pending'     => 'background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);',
                        'approved'    => 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);',
                        'confirmed'   => 'background:rgba(99,102,241,0.15);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);',
                        'completed'   => 'background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.3);',
                        'rejected'    => 'background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.3);',
                        'cancelled'   => 'background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid rgba(148,163,184,0.3);',
                        'in_progress' => 'background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);',
                        default       => 'background:rgba(148,163,184,0.15);color:#94a3b8;',
                    };
                @endphp
                <div class="px-5 py-3 flex items-center justify-between gap-2 transition"
                    onmouseover="this.style.background='rgba(124,58,237,0.04)'"
                    onmouseout="this.style.background='transparent'">
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                        <p class="text-xs" style="color:var(--text-muted);">{{ $meeting->meeting_date->format('d M Y') }}</p>
                    </div>
                    <span class="badge flex-shrink-0" style="{{ $badgeStyle }}">{{ ucfirst($meeting->status) }}</span>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Belum ada riwayat meeting</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function refreshLeaderStats() {
        fetch('{{ route("realtime.dashboard") }}')
            .then(r => r.json())
            .then(data => {
                if (data.pending !== undefined)   document.getElementById('stat-pending')?.textContent   !== undefined && (document.getElementById('stat-pending').textContent   = data.pending);
                if (data.approved !== undefined)  document.getElementById('stat-approved')?.textContent  !== undefined && (document.getElementById('stat-approved').textContent  = data.approved);
                if (data.completed !== undefined) document.getElementById('stat-completed')?.textContent !== undefined && (document.getElementById('stat-completed').textContent = data.completed);
            }).catch(() => {});
    }
    setInterval(refreshLeaderStats, 60000);
</script>
@endpush