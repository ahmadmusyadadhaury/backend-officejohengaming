@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection

@section('content')
<div class="dashboard-section stagger-children">

    {{-- 4 Stat Cards --}}
    <div class="dashboard-section">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 md:gap-3">
            @php
                $statCards = [
                    ['label' => 'Total Meeting Saya', 'count' => $totalMeeting, 'color' => '#a78bfa', 'bg' => 'rgba(124,58,237,0.12)', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['label' => 'Disetujui', 'count' => $disetujui, 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.12)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'Menunggu', 'count' => $menunggu, 'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.12)', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'Ditolak', 'count' => $ditolak, 'color' => '#f87171', 'bg' => 'rgba(239,68,68,0.12)', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            @endphp
            @foreach($statCards as $card)
            <div class="stat-card-compact">
                <div class="stat-icon-box" style="background:{{ $card['bg'] }};box-shadow:0 0 14px {{ $card['color'] }}20;">
                    <svg style="color:{{ $card['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-num" style="color:{{ $card['color'] }};">{{ $card['count'] }}</div>
                    <div class="stat-label-text" style="font-size:0.7rem;">{{ $card['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Ajukan Meeting Baru --}}
    <div class="dashboard-section">
        <div class="gaming-card">
            <div class="card-body">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-gaming font-bold" style="font-size:0.95rem;color:var(--text-primary);">Ajukan Meeting Baru</h3>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">Butuh meeting? Ajukan permintaan meeting sekarang juga.</p>
                        <p class="text-[0.65rem] mt-1" style="color:var(--text-muted);">Ajukan jadwal meeting dengan mengisi detail pertemuan. Sertakan alasan, pembahasan, dan hasil yang diharapkan.</p>
                    </div>
                    <a href="{{ route('koordinator.meetings.index') }}?open_request=1" class="btn btn-primary btn-sm flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Request Meeting
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
