@extends('layouts.app')
@section('title', 'Detail Meeting')
@section('page-title', 'Detail Meeting')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl space-y-4 animate-fade-in">

    {{-- Info Utama --}}
    <div class="gaming-card p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h2 class="font-gaming font-bold text-xl" style="color:var(--text-primary);">{{ $meeting->title }}</h2>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    <span style="color:var(--color-accent-light);">{{ $meeting->team->name }}</span>
                    @if($meeting->teams->count())
                        @foreach($meeting->teams as $t) <span style="color:var(--text-muted);">+</span> {{ $t->name }} @endforeach
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2 flex-wrap flex-shrink-0">
                @php
                    $sb = match($meeting->status) {
                        'pending'=>'badge-yellow','approved'=>'badge-blue','rejected'=>'badge-red',
                        'confirmed'=>'badge-primary','cancelled'=>'badge-gray',
                        'in_progress'=>'badge-primary','completed'=>'badge-green',default=>'badge-gray'
                    };
                @endphp
                <span class="badge {{ $sb }}">{{ ucfirst($meeting->status) }}</span>
                @if($meeting->queue_position !== null)
                    <span class="badge {{ \App\Services\MeetingQueueService::queueColor($meeting->queue_position) }}">
                        {{ \App\Services\MeetingQueueService::queueLabel($meeting->queue_position) }}
                    </span>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3 mt-4 pt-4" style="border-top:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->meeting_date->format('d M Y') }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">
                    {{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}
                    @if($meeting->actual_end_time)
                        <span class="badge badge-green" style="font-size:0.6rem;margin-left:4px;">Selesai {{ substr($meeting->actual_end_time,0,5) }}</span>
                    @endif
                </p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->room->name }}</p>
            </div>
        </div>
        @if($meeting->teams->count())
        <div class="mt-3 pt-3 flex flex-wrap gap-1.5" style="border-top:1px solid var(--border-color);">
            @foreach($meeting->teams as $t)
                <span class="badge badge-blue">{{ $t->name }}</span>
            @endforeach
        </div>
        @endif
    </div>

    {{-- APPROVED: Tindakan --}}
    @if($meeting->status === 'approved')
    <div class="gaming-card p-5" style="border-color:rgba(59,130,246,0.3);background:rgba(59,130,246,0.05);">
        <p class="font-gaming font-semibold text-sm mb-3" style="color:#60a5fa;letter-spacing:0.05em;">MEETING DISETUJUI — PILIH TINDAKAN</p>
        <div class="flex flex-wrap gap-2">
            <form method="POST" action="{{ route('koordinator.meetings.confirm', $meeting) }}">
                @csrf @method('PATCH')
                <button class="btn btn-primary btn-sm">✓ Konfirmasi Hadir</button>
            </form>
            <form method="POST" action="{{ route('koordinator.meetings.finish', $meeting) }}" class="flex items-center gap-2" onsubmit="return confirm('Selesaikan meeting sekarang?')">
                @csrf @method('PATCH')
                <input type="text" name="actual_end_time" id="actual-end-time-1" value="{{ now()->format('H:i') }}" required class="gaming-input" style="width:130px;" autocomplete="off">
                <button class="btn btn-success btn-sm">✓ Selesaikan</button>
            </form>
            <form method="POST" action="{{ route('koordinator.meetings.cancel', $meeting) }}" onsubmit="return confirm('Batalkan meeting ini?')">
                @csrf @method('PATCH')
                <button class="btn btn-danger btn-sm">✗ Batalkan</button>
            </form>
        </div>
    </div>
    @endif

    {{-- CONFIRMED: Selesaikan --}}
    @if($meeting->status === 'confirmed')
    <div class="gaming-card p-5" style="border-color:rgba(99,102,241,0.3);background:rgba(99,102,241,0.05);">
        <p class="font-gaming font-semibold text-sm mb-3" style="color:#a5b4fc;letter-spacing:0.05em;">MEETING TERKONFIRMASI</p>
            <form method="POST" action="{{ route('koordinator.meetings.finish', $meeting) }}" class="flex flex-wrap items-end gap-3" onsubmit="return confirm('Selesaikan meeting sekarang?')">
                @csrf @method('PATCH')
                <div>
                    <label class="gaming-label">Jam Selesai Aktual</label>
                    <input type="text" name="actual_end_time" id="actual-end-time-2" value="{{ now()->format('H:i') }}" required class="gaming-input" style="width:140px;" autocomplete="off">
                </div>
            <button class="btn btn-success btn-sm">✓ Selesaikan Meeting</button>
        </form>
        <form method="POST" action="{{ route('koordinator.meetings.cancel', $meeting) }}" onsubmit="return confirm('Batalkan meeting ini?')" class="mt-3">
            @csrf @method('PATCH')
            <button class="btn btn-danger btn-sm">✗ Batalkan Meeting</button>
        </form>
    </div>
    @endif

    {{-- REJECTED --}}
    @if($meeting->status === 'rejected')
    <div class="p-4 rounded-xl" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
        <p class="text-sm font-semibold mb-1" style="color:#f87171;">Meeting Ditolak</p>
        <p class="text-sm" style="color:#fca5a5;">{{ $meeting->reject_reason }}</p>
    </div>
    @endif

    {{-- CANCELLED --}}
    @if($meeting->status === 'cancelled')
    <div class="p-4 rounded-xl" style="background:rgba(148,163,184,0.1);border:1px solid rgba(148,163,184,0.3);">
        <p class="text-sm" style="color:var(--text-muted);">Meeting telah dibatalkan.</p>
    </div>
    @endif

    {{-- COMPLETED: MOM --}}
    @if($meeting->status === 'completed')
    <div class="gaming-card p-5" style="border-color:rgba(16,185,129,0.3);background:rgba(16,185,129,0.05);">
        <div class="flex items-center justify-between mb-3">
            <p class="font-gaming font-semibold text-sm" style="color:#34d399;letter-spacing:0.05em;">MINUTES OF MEETING (MOM)</p>
            @if(!$meeting->mom)
                <a href="{{ route('koordinator.meetings.mom.create', $meeting) }}" class="btn btn-success btn-sm">+ Buat MOM</a>
            @endif
        </div>
        @if($meeting->mom)
            <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2">
                    <span style="color:var(--text-muted);">Status:</span>
                    <span class="badge {{ $meeting->mom->status === 'sent' ? 'badge-green' : 'badge-yellow' }}">{{ $meeting->mom->status === 'sent' ? 'Terkirim' : 'Draft' }}</span>
                </div>
                @if($meeting->mom->status === 'sent')
                    <div class="space-y-3 mt-3">
                        @foreach(['summary'=>'Ringkasan Pembahasan','decisions'=>'Keputusan','action_plan'=>'Action Plan'] as $field => $label)
                        <div>
                            <p class="text-xs font-semibold mb-1" style="color:var(--color-accent-light);letter-spacing:0.08em;text-transform:uppercase;">{{ $label }}</p>
                            <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);">{{ $meeting->mom->$field }}</p>
                        </div>
                        @endforeach
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <div>
                                <p class="text-xs font-semibold mb-1" style="color:var(--color-accent-light);letter-spacing:0.08em;text-transform:uppercase;">PIC</p>
                                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->mom->pic }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold mb-1" style="color:var(--color-accent-light);letter-spacing:0.08em;text-transform:uppercase;">Dibuat Oleh</p>
                                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->mom->creator->name ?? '—' }}</p>
                            </div>
                        </div>
                        @if($meeting->mom->file_path)
                        <div>
                            <a href="{{ Storage::url($meeting->mom->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download Lampiran
                            </a>
                        </div>
                        @endif
                        @if($meeting->mom->sent_at)
                        <p class="text-xs" style="color:var(--text-muted);">Dikirim pada {{ $meeting->mom->sent_at->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                @else
                    <div class="space-y-2 mt-3">
                        <p style="color:var(--text-secondary);">PIC: <strong style="color:var(--text-primary);">{{ $meeting->mom->pic }}</strong></p>
                        @if($meeting->mom->file_path)
                        <div>
                            <a href="{{ Storage::url($meeting->mom->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download Lampiran
                            </a>
                        </div>
                        @endif
                        <div class="flex gap-2">
                            <a href="{{ route('koordinator.mom.edit', $meeting->mom) }}" class="btn btn-secondary btn-sm">Edit MOM</a>
                            <form method="POST" action="{{ route('koordinator.mom.send', $meeting->mom) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-success btn-sm">Kirim MOM</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <p class="text-sm" style="color:var(--text-muted);">Belum ada MOM. Buat MOM setelah meeting selesai.</p>
        @endif
    </div>
    @endif

    <a href="{{ route('koordinator.meetings.index') }}" class="inline-flex items-center gap-1.5 text-sm" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>
@endsection

@push('scripts')
<script>
    ['actual-end-time-1', 'actual-end-time-2'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) {
            flatpickr(el, {
                enableTime: true,
                noCalendar: true,
                dateFormat: 'H:i',
                time_24hr: true,
                minTime: '{{ \Carbon\Carbon::parse($meeting->start_time)->format('H:i') }}',
                defaultDate: el.value,
            });
        }
    });
</script>
@endpush
