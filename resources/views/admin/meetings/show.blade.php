@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Detail Meeting')
@section('page-title', 'Detail Permintaan Meeting')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-3xl space-y-4 animate-fade-in">

    <div class="gaming-card p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-gaming font-bold text-xl" style="color:var(--text-primary);">{{ $meeting->title }}</h2>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    Oleh: {{ $meeting->requester->name }} · <span style="color:var(--color-accent-light);">{{ $meeting->team->name }}</span>
                    @if($meeting->teams->count()) @foreach($meeting->teams as $t) + {{ $t->name }} @endforeach @endif
                </p>
            </div>
            @php $sb = match($meeting->status) {'pending'=>'badge-yellow','approved'=>'badge-blue','rejected'=>'badge-red','confirmed'=>'badge-primary','cancelled'=>'badge-gray','in_progress'=>'badge-primary','completed'=>'badge-green',default=>'badge-gray'}; @endphp
            <span class="badge {{ $sb }} flex-shrink-0">{{ ucfirst($meeting->status) }}</span>
        </div>
        <div class="grid grid-cols-3 gap-3 mt-4 pt-4" style="border-top:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3"><p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p><p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->meeting_date->format('d M Y') }}</p></div>
            <div class="gaming-card-flat p-3"><p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p><p class="text-sm font-semibold" style="color:var(--text-primary);">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p></div>
            <div class="gaming-card-flat p-3"><p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p><p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->room->name }}</p></div>
        </div>
        @if($meeting->teams->count())
        <div class="mt-3 pt-3" style="border-top:1px solid var(--border-color);">
            <p class="text-xs mb-2" style="color:var(--text-muted);">Tim Tambahan</p>
            <div class="flex flex-wrap gap-1.5">@foreach($meeting->teams as $t)<span class="badge badge-blue">{{ $t->name }}</span>@endforeach</div>
        </div>
        @endif
    </div>

    <div class="gaming-card p-6">
        <h3 class="font-gaming font-semibold mb-4" style="color:var(--text-primary);letter-spacing:0.05em;">DETAIL MEETING</h3>
        <div class="space-y-3">
            @foreach(['why'=>'WHY — Alasan','what'=>'WHAT — Yang Dibahas','how_expected'=>'HOW — Hasil yang Diharapkan'] as $field => $label)
                @if($meeting->$field)
                <div>
                    <p class="text-xs font-semibold mb-1" style="color:var(--color-accent-light);letter-spacing:0.08em;text-transform:uppercase;">{{ $label }}</p>
                    <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);">{{ $meeting->$field }}</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    @if($meeting->assets->count())
    <div class="gaming-card p-6">
        <h3 class="font-gaming font-semibold mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">ASET DIBUTUHKAN</h3>
        <div class="flex flex-wrap gap-2">@foreach($meeting->assets as $a)<span class="badge badge-cyan">{{ $a->name }} ({{ $a->pivot->quantity }})</span>@endforeach</div>
    </div>
    @endif

    @if($meeting->status === 'pending')
    <div class="gaming-card p-6">
        <h3 class="font-gaming font-semibold mb-4" style="color:var(--text-primary);letter-spacing:0.05em;">TINDAKAN</h3>
        <form method="POST" action="{{ route('admin.meetings.approve', $meeting) }}" class="mb-4">
            @csrf @method('PATCH')
            <button class="btn btn-success">✓ Setujui Meeting</button>
        </form>
        <form method="POST" action="{{ route('admin.meetings.reject', $meeting) }}">
            @csrf @method('PATCH')
            <textarea name="reject_reason" placeholder="Alasan penolakan..." required rows="2" class="gaming-input mb-3" style="resize:none;"></textarea>
            <button class="btn btn-danger">✗ Tolak Meeting</button>
        </form>
    </div>
    @endif

    @if($meeting->reject_reason)
    <div class="p-4 rounded-xl" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
        <p class="text-sm font-semibold mb-1" style="color:#f87171;">Alasan Penolakan</p>
        <p class="text-sm" style="color:#fca5a5;">{{ $meeting->reject_reason }}</p>
    </div>
    @endif

    @if($meeting->mom)
    <div class="gaming-card p-6" style="border-color:rgba(16,185,129,0.3);background:rgba(16,185,129,0.03);">
        <div class="flex items-center justify-between gap-3 mb-4">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">
                MINUTES OF MEETING (MOM)
            </h3>
            <span class="badge {{ $meeting->mom->status === 'sent' ? 'badge-green' : 'badge-yellow' }} flex-shrink-0">
                {{ $meeting->mom->status === 'sent' ? 'Terkirim' : 'Draft' }}
            </span>
        </div>
        <div class="space-y-3">
            @foreach(['summary'=>'Ringkasan Pembahasan','decisions'=>'Keputusan','action_plan'=>'Action Plan'] as $field => $label)
            <div>
                <p class="text-xs font-semibold mb-1" style="color:var(--color-accent-light);letter-spacing:0.08em;text-transform:uppercase;">{{ $label }}</p>
                <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);">{{ $meeting->mom->$field }}</p>
            </div>
            @endforeach
            <div class="grid grid-cols-2 gap-3 pt-2">
                <div>
                    <p class="text-xs font-semibold mb-1" style="color:var(--color-accent-light);letter-spacing:0.08em;text-transform:uppercase;">Penanggung Jawab (PIC)</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->mom->pic }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold mb-1" style="color:var(--color-accent-light);letter-spacing:0.08em;text-transform:uppercase;">Dibuat Oleh</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->mom->creator->name ?? '—' }}</p>
                </div>
            </div>
            @if($meeting->mom->file_path)
            <div class="pt-2">
                <a href="{{ asset('storage/'.$meeting->mom->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">
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
    </div>
    @endif

    <a href="{{ route('admin.meetings.index') }}" class="inline-flex items-center gap-1.5 text-sm" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>
@endsection
