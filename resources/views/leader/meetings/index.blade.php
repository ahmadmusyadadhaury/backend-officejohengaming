@extends('layouts.app')
@section('title', 'Meeting Saya')
@section('page-title', 'Meeting Saya')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total Meeting --}}
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
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh daftar meeting yang anda ajukan akan tampil disini.</div>
            </div>
        </div>

        {{-- Menunggu --}}
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

    {{-- Tombol Request --}}
    <div class="flex justify-end">
        <a href="{{ route('koordinator.meetings.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Request Meeting
        </a>
    </div>

    {{-- Tabel --}}
    <div class="gaming-card overflow-hidden">
        <div class="px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">DAFTAR MEETING SAYA</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[550px]">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Ruangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($meetings as $meeting)
                    @php
                        $rt = \App\Services\MeetingQueueService::realtimeStatus($meeting);
                        $rtStyle = '';
                        if (str_contains($rt['label'], 'Berlangsung'))    $rtStyle = 'background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);';
                        elseif (str_contains($rt['label'], 'Antrian'))    $rtStyle = 'background:rgba(249,115,22,0.15);color:#fb923c;border:1px solid rgba(249,115,22,0.3);';
                        elseif (str_contains($rt['label'], 'Di Booking')) $rtStyle = 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);';
                        elseif (str_contains($rt['label'], 'Selesai'))    $rtStyle = 'background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid rgba(148,163,184,0.3);';
                        else $rtStyle = 'background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);';
                    @endphp
                    <tr data-meeting-id="{{ $meeting->id }}">
                        <td style="color:var(--text-primary);font-weight:500;">{{ $meeting->title }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->meeting_date->format('d M Y') }}</td>
                        <td style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->room->name }}</td>
                        <td>
                            <span class="rt-badge badge" style="{{ $rtStyle }}">{{ $rt['label'] }}</span>
                        </td>
                        <td>
                            <a href="{{ route('koordinator.meetings.show', $meeting) }}" class="btn btn-secondary btn-sm">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada meeting.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 flex items-center justify-between" style="border-top:1px solid var(--border-color);">
            {{ $meetings->links() }}
            <span id="rt-update" style="font-size:0.7rem;color:var(--text-muted);"></span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
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
</script>
@endpush
