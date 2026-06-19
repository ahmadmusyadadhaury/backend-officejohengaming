@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-user') @endsection

@section('content')
<div class="space-y-6 pt-2 stagger-children">

    {{-- Welcome Banner --}}
    <div class="gaming-card p-6 relative overflow-hidden" style="background:#6C63FF80;border:1px solid rgba(108,99,255,0.3);">
        <div class="absolute inset-0 grid-pattern opacity-20"></div>
        <div class="relative">
            <h2 class="font-gaming font-bold text-2xl text-white tracking-wide mb-1">Selamat Datang Kembali</h2>
            <p class="text-white/80" style="font-size:0.95rem;">Kelola Meeting, Pembayaran, Aset Perusahaan dalam Satu Sistem</p>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="gaming-card p-5 relative overflow-hidden"
        style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-primary));">
        <div class="absolute inset-0 grid-pattern opacity-20"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl overflow-hidden flex items-center justify-center font-gaming font-bold text-xl flex-shrink-0"
                style="background:linear-gradient(135deg,var(--color-accent),var(--color-neon-blue));color:white;box-shadow:0 4px 16px rgba(124,58,237,0.4);">
                @if(auth()->user()->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div>
                <h2 class="font-gaming font-bold text-xl text-white tracking-wide">{{ auth()->user()->name }}</h2>
                <div class="flex items-center gap-2 mt-1 flex-wrap">
                    <span class="badge badge-cyan">{{ auth()->user()->role_label }}</span>
                    @if(auth()->user()->team)
                        <span class="badge badge-blue">{{ auth()->user()->team->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Main Meeting Section - Two Columns --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Meeting Saya --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(59,130,246,0.1),rgba(59,130,246,0.05));">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING SAYA</h3>
                <a href="{{ route('calendar') }}" class="badge badge-primary">Kalender</a>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($myMeetings as $meeting)
                <div class="px-5 py-3 transition hover:bg-slate-100/5">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <p class="text-sm font-medium flex-1" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                        <span class="badge text-xs flex-shrink-0" style="background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);">Mendatang</span>
                    </div>
                    <p class="text-xs" style="color:var(--text-muted);">📍 {{ $meeting->room->name }}</p>
                    <p class="text-xs" style="color:var(--text-muted);">📅 {{ $meeting->meeting_date->format('d M Y') }}</p>
                    <p class="text-xs mt-1" style="color:var(--text-muted);">⏰ {{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p>
                    <p class="text-xs mt-1" style="color:var(--text-muted);">👤 Oleh: {{ $meeting->requester->name }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Kamu belum diundang ke meeting apapun</p>
                </div>
                @endforelse
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
                    <p class="text-xs ml-4" style="color:var(--text-muted);">👥 {{ $meeting->team->name }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting hari ini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
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

