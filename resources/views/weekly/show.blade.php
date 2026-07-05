@extends('layouts.app')
@section('title', 'Meeting Mingguan')
@section('page-title', 'Meeting Mingguan')
@section('sidebar-menu')
    @if(auth()->user()->hasFullAccess())
        @include('partials.sidebar-admin')
    @elseif(auth()->user()->role === 'koordinator')
        @include('partials.sidebar-leader')
    @else
        @include('partials.sidebar-user')
    @endif
@endsection

@section('content')
<div class="pt-2 max-w-3xl space-y-4 animate-fade-in">

    {{-- Header --}}
    <div class="gaming-card overflow-hidden">
        <div class="p-6 relative" style="background:linear-gradient(135deg,#0e7490,var(--color-primary-dark));">
            <div class="absolute inset-0 grid-pattern opacity-20"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-2 flex-wrap">
                    <span style="color:rgba(255,255,255,0.6);font-size:0.8rem;">🔁 Meeting Mingguan</span>
                    @php
                        $statusClass = match($session->status) {
                            'active'    => 'badge-green',
                            'extended'  => 'badge-yellow',
                            'completed' => 'badge-gray',
                            default     => 'badge-gray',
                        };
                    @endphp
                    <span id="session-status-badge" class="badge {{ $statusClass }}">{{ ucfirst($session->status) }}</span>
                    <span id="rt-label" class="badge badge-cyan" style="display:none;"></span>
                </div>
                <h2 class="font-gaming font-bold text-xl text-white">{{ $session->weeklyMeeting->title }}</h2>
                <div class="flex flex-wrap gap-4 mt-2" style="color:rgba(255,255,255,0.7);font-size:0.85rem;">
                    <span>📅 {{ $session->session_date->isoFormat('dddd, D MMMM Y') }}</span>
                    <span id="time-display">🕐 {{ substr($session->start_time,0,5) }} – {{ substr($session->end_time,0,5) }}
                        @if($session->actual_end_time && $session->status === 'completed')
                            <span style="color:#34d399;">(Selesai {{ substr($session->actual_end_time,0,5) }})</span>
                        @endif
                    </span>
                    <span>🏢 {{ $session->weeklyMeeting->room->name }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Aksi: Perpanjang & Selesaikan --}}
    @if($session->isActive() && in_array(auth()->user()->role, ['koordinator','head_of_store','gm','admin','hr','ceo']))
    <div class="gaming-card p-5">
        <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">KELOLA MEETING</p>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('weekly.extend', $session) }}" class="flex items-center gap-2">
                @csrf
                <select name="extend_minutes" class="gaming-input gaming-select" style="width:auto;">
                    <option value="15">+15 menit</option>
                    <option value="30">+30 menit</option>
                    <option value="45">+45 menit</option>
                    <option value="60">+60 menit</option>
                    <option value="90">+90 menit</option>
                    <option value="120">+120 menit</option>
                </select>
                <button class="btn btn-sm" style="background:linear-gradient(135deg,#f59e0b,#fbbf24);color:white;">Perpanjang</button>
            </form>
            <form method="POST" action="{{ route('weekly.complete', $session) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Selesaikan meeting mingguan sekarang?">
                @csrf
                <button class="btn btn-success btn-sm">✓ Selesaikan Meeting</button>
            </form>
        </div>
    </div>
    @endif

    {{-- Form Kontribusi --}}
    @if($session->isActive() && in_array(auth()->user()->role, ['koordinator','head_of_store','gm','admin','hr','ceo']))
    <div class="gaming-card p-6">
        <p class="font-gaming font-semibold text-sm mb-4" style="color:var(--text-primary);letter-spacing:0.05em;">TAMBAH AGENDA / PRESENTASI</p>
        <form method="POST" action="{{ route('weekly.contribute', $session) }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <div>
                <label class="gaming-label">Apa yang akan dibahas <span style="color:#f87171;">*</span></label>
                <textarea name="what_to_discuss" rows="3" required placeholder="Tuliskan topik atau agenda yang ingin kamu bahas..." class="gaming-input" style="resize:vertical;">{{ old('what_to_discuss') }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Upload File <span style="color:var(--text-muted);font-weight:400;">(Opsional)</span></label>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" class="gaming-input" style="padding:0.5rem;">
                <p class="text-xs mt-1" style="color:var(--text-muted);">Format: PDF, DOC, DOCX, PPT, PPTX. Maks 10MB.</p>
            </div>
            <button type="submit" class="btn btn-sm" style="background:linear-gradient(135deg,#0891b2,#0e7490);color:white;">Tambahkan</button>
        </form>
    </div>
    @endif

    {{-- List Kontribusi --}}
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">AGENDA & KONTRIBUSI</h3>
            <span class="badge badge-cyan">{{ $session->contributions->count() }} kontribusi</span>
        </div>
        <div id="contributions-list" class="divide-y" style="border-color:var(--border-color);">
            @forelse($session->contributions as $contrib)
            <div class="px-5 py-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 font-gaming font-bold text-sm"
                        style="background:linear-gradient(135deg,#0891b2,var(--color-primary));color:white;">
                        {{ strtoupper(substr($contrib->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $contrib->user->name }}</p>
                            <span class="badge badge-cyan" style="font-size:0.6rem;">{{ $contrib->user->role_label }}</span>
                            @if($contrib->user->team)
                                <span class="badge badge-blue" style="font-size:0.6rem;">{{ $contrib->user->team->name }}</span>
                            @endif
                            <span class="text-xs" style="color:var(--text-muted);">{{ $contrib->created_at->format('H:i') }}</span>
                        </div>
                        <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);">{{ $contrib->what_to_discuss }}</p>
                        @if($contrib->file_path)
                        <a href="{{ Storage::url($contrib->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 mt-2 text-xs" style="color:var(--color-neon-blue);">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Lihat / Download File
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center">
                <p class="text-sm" style="color:var(--text-muted);">Belum ada yang menambahkan agenda.</p>
            </div>
            @endforelse
        </div>
    </div>

    @if($session->status === 'completed')
    <div class="p-4 rounded-xl flex items-center gap-3" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold" style="color:#34d399;">Meeting mingguan telah selesai.</p>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    let currentStatus = '{{ $session->status }}';
    const sessionId = {{ $session->id }};

    function refreshWeekly() {
        fetch('{{ route("realtime.weekly") }}')
            .then(r => r.json())
            .then(data => {
                const s = data.find(d => d.id === sessionId);
                if (!s) return;
                const rtEl = document.getElementById('rt-label');
                if (rtEl) {
                    rtEl.textContent = s.rt_label;
                    rtEl.style.display = s.rt_label ? '' : 'none';
                }
                if (s.status === 'completed' && currentStatus !== 'completed') {
                    window.location.reload();
                }
                currentStatus = s.status;
            }).catch(() => {});
    }

    setInterval(refreshWeekly, 30000);
    refreshWeekly();
</script>
@endpush
