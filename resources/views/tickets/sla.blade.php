@extends('layouts.app')
@section('title', 'Pengaturan SLA')
@section('page-title', 'Pengaturan SLA')
@section('page-subtitle', 'Atur target waktu penyelesaian per prioritas')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="tk tk-stack">
    <div class="tk-card p-5 max-w-2xl mx-auto">
        <div class="mb-5">
            <p class="tk-eyebrow mb-1">Konfigurasi · SLA</p>
            <h2 class="text-base font-bold" style="color:var(--tk-text);">Target SLA</h2>
            <p class="text-xs" style="color:var(--tk-muted);">Durasi dalam menit. SLA dihitung sejak ticket dibuat.</p>
        </div>

        <form method="POST" action="{{ route('ticket.sla.update') }}">
            @csrf
            @method('PUT')

            <div class="space-y-3">
                @foreach($priorities as $priority)
                @php
                    $current = $slas->firstWhere('priority', $priority);
                    $defaults = ['low' => 4320, 'medium' => 1440, 'high' => 240, 'urgent' => 120];
                    $color = \App\Support\Ticket::priorityColor($priority);
                @endphp
                <div class="flex items-center gap-3 p-3 rounded-xl" style="border:1px solid var(--tk-border);">
                    <span class="tk-chip" style="background:{{ $color }}1a;color:{{ $color }};border-color:{{ $color }}40;flex-shrink:0;">
                        <span class="tk-chip-dot" style="background:{{ $color }};"></span>
                        {{ $priority }}
                    </span>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <input type="number" name="duration_minutes[{{ $priority }}]" required min="1" value="{{ $current?->duration_minutes ?? $defaults[$priority] }}" class="gaming-input" style="max-width:140px;">
                            <span class="text-xs" style="color:var(--tk-muted);">menit</span>
                        </div>
                        <p class="tk-mono text-[0.62rem] mt-1" style="color:var(--tk-muted);">
                            ≈ {{ (new \App\Models\TicketSla)->durationLabel($current?->duration_minutes ?? $defaults[$priority]) }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-5 flex items-center justify-end gap-3">
                <a href="{{ route('ticket.dashboard') }}" class="btn btn-secondary btn-sm">Batal</a>
                <button type="submit" class="btn btn-primary btn-sm">💾 Simpan Pengaturan</button>
            </div>
        </form>

        <div class="mt-5 pt-4 rounded-xl" style="border-top:1px solid var(--tk-border);">
            <p class="tk-eyebrow mb-1.5">Info</p>
            <ul class="tk-note space-y-1">
                <li>• SLA dihitung sejak ticket dibuat dan berhenti saat ticket <strong>resolved</strong>.</li>
                <li>• Ticket yang melewati batas SLA akan diberi tanda <strong style="color:var(--tk-over);">OVER SLA</strong>.</li>
                <li>• Durasi default: Low 3 hari · Medium 1 hari · High 4 jam · Urgent 2 jam.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
