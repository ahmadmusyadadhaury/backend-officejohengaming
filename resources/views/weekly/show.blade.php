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
<div class="pt-2 max-w-3xl space-y-4">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-cyan-700 to-primary rounded-xl overflow-hidden">
        <div class="p-6">
            <div class="flex items-center gap-2 mb-2">
                <span class="text-cyan-200 text-xs font-medium">🔁 Meeting Mingguan</span>
                @php
                    $statusColor = match($session->status) {
                        'active'    => 'bg-green-400/20 text-green-200',
                        'extended'  => 'bg-yellow-400/20 text-yellow-200',
                        'completed' => 'bg-gray-400/20 text-gray-200',
                    };
                @endphp
                <span id="session-status-badge" class="px-2 py-0.5 rounded-full text-xs {{ $statusColor }}">
                    {{ ucfirst($session->status) }}
                </span>
                <span id="rt-label" class="px-2 py-0.5 rounded-full text-xs bg-white/20 text-white"></span>
            </div>
            <h2 class="text-xl font-bold text-white">{{ $session->weeklyMeeting->title }}</h2>
            <div class="flex flex-wrap gap-4 mt-3 text-sm text-cyan-100">
                <span>📅 {{ $session->session_date->isoFormat('dddd, D MMMM Y') }}</span>
                <span id="time-display">🕐 {{ substr($session->start_time,0,5) }} – {{ substr($session->end_time,0,5) }}
                    @if($session->actual_end_time && $session->status === 'completed')
                        <span class="text-green-300">(Selesai {{ substr($session->actual_end_time,0,5) }})</span>
                    @endif
                </span>
                <span>🏢 {{ $session->weeklyMeeting->room->name }}</span>
            </div>
        </div>
    </div>

    {{-- Aksi: Perpanjang & Selesaikan --}}
    @if($session->isActive() && in_array(auth()->user()->role, ['koordinator','head_of_store','gm','admin','hr']))
    <div id="action-panel" class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-semibold text-primary text-sm mb-3">Kelola Meeting</h3>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('weekly.extend', $session) }}" class="flex items-center gap-2">
                @csrf
                <select name="extend_minutes" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    <option value="15">+15 menit</option>
                    <option value="30">+30 menit</option>
                    <option value="45">+45 menit</option>
                    <option value="60">+60 menit</option>
                    <option value="90">+90 menit</option>
                    <option value="120">+120 menit</option>
                </select>
                <button class="px-4 py-2 bg-yellow-500 text-white rounded-lg text-sm hover:bg-yellow-600 transition">Perpanjang</button>
            </form>
            <form method="POST" action="{{ route('weekly.complete', $session) }}" onsubmit="return confirm('Selesaikan meeting mingguan sekarang?')">
                @csrf
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">✓ Selesaikan Meeting</button>
            </form>
        </div>
    </div>
    @endif

    {{-- Form Kontribusi --}}
    @if($session->isActive() && in_array(auth()->user()->role, ['koordinator','head_of_store','gm','admin','hr']))
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-primary text-sm mb-4">Tambah Agenda / Presentasi</h3>
        <form method="POST" action="{{ route('weekly.contribute', $session) }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Apa yang akan dibahas <span class="text-red-500">*</span></label>
                <textarea name="what_to_discuss" rows="3" required placeholder="Tuliskan topik atau agenda yang ingin kamu bahas..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">{{ old('what_to_discuss') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File <span class="text-gray-400 text-xs">(Opsional)</span></label>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <p class="text-xs text-gray-400 mt-1">Format: PDF, DOC, DOCX, PPT, PPTX. Maks 10MB.</p>
            </div>
            <button type="submit" class="px-5 py-2 bg-cyan-600 text-white rounded-lg text-sm hover:bg-cyan-700 transition">Tambahkan</button>
        </form>
    </div>
    @endif

    {{-- List Kontribusi --}}
    <div class="bg-white rounded-xl shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-primary text-sm">Agenda & Kontribusi</h3>
            <span class="text-xs text-gray-400">{{ $session->contributions->count() }} kontribusi</span>
        </div>
        <div id="contributions-list" class="divide-y divide-gray-50">
            @forelse($session->contributions as $contrib)
            <div class="px-6 py-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                        <span class="text-primary font-bold text-sm">{{ strtoupper(substr($contrib->user->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $contrib->user->name }}</p>
                            <span class="px-2 py-0.5 bg-primary/10 text-primary rounded-full text-xs">{{ $contrib->user->role_label }}</span>
                            @if($contrib->user->team)
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">{{ $contrib->user->team->name }}</span>
                            @endif
                            <span class="text-xs text-gray-400">{{ $contrib->created_at->format('H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3 mt-1">{{ $contrib->what_to_discuss }}</p>
                        @if($contrib->file_path)
                        <a href="{{ Storage::url($contrib->file_path) }}" target="_blank"
                            class="inline-flex items-center gap-1.5 mt-2 text-xs text-cyan-600 hover:text-cyan-800 hover:underline">
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
            <div class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada yang menambahkan agenda.</div>
            @endforelse
        </div>
    </div>

    @if($session->status === 'completed')
    <div id="completed-banner" class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm text-green-700 font-medium">Meeting mingguan telah selesai.</p>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    let currentStatus = '{{ $session->status }}';
    const sessionId   = {{ $session->id }};

    function refreshWeekly() {
        fetch('{{ route("realtime.weekly") }}')
            .then(r => r.json())
            .then(data => {
                const s = data.find(d => d.id === sessionId);
                if (!s) return;

                // Update rt-label badge
                const rtEl = document.getElementById('rt-label');
                if (rtEl) {
                    rtEl.textContent = s.rt_label;
                    rtEl.style.display = s.rt_label ? '' : 'none';
                }

                // Jika status berubah jadi completed, reload halaman
                if (s.status === 'completed' && currentStatus !== 'completed') {
                    window.location.reload();
                }

                currentStatus = s.status;
            }).catch(() => {});
    }

    // Polling setiap 30 detik
    setInterval(refreshWeekly, 30000);
    refreshWeekly();
</script>
@endpush
