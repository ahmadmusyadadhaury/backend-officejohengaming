@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="space-y-4 pt-2">

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        @php
            $cards = [
                ['label' => 'Total Karyawan',    'value' => $stats['total_users'],    'color' => 'bg-primary',    'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Total Tim',         'value' => $stats['total_teams'],    'color' => 'bg-secondary',  'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['label' => 'Menunggu Approval', 'value' => $stats['pending'],        'color' => 'bg-yellow-500', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Meeting Hari Ini',  'value' => $stats['today_meetings'], 'color' => 'bg-accent',     'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['label' => 'Meeting Bulan Ini', 'value' => $stats['this_month'],     'color' => 'bg-green-600',  'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['label' => 'Total Ruangan',     'value' => $stats['total_rooms'],    'color' => 'bg-pink-600',   'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5'],
            ];
        @endphp
        @foreach($cards as $card)
            <div class="bg-white rounded-xl shadow-sm p-4 flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl {{ $card['color'] }} flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xl lg:text-2xl font-bold text-primary">{{ $card['value'] }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $card['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Pending Meetings --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="flex items-center justify-between px-4 lg:px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-primary text-sm">Menunggu Approval</h3>
                <a href="{{ route('admin.meetings.index') }}" class="text-xs text-accent hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($pendingMeetings as $meeting)
                    <div class="px-4 lg:px-6 py-3 flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $meeting->title }}</p>
                            <p class="text-xs text-gray-400">{{ $meeting->requester->name }} · {{ $meeting->team->name }}</p>
                            <p class="text-xs text-gray-400">{{ $meeting->meeting_date->format('d M Y') }} · {{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</p>
                        </div>
                        <a href="{{ route('admin.meetings.show', $meeting) }}" class="flex-shrink-0 px-3 py-1 bg-accent/10 text-accent rounded-lg text-xs font-medium hover:bg-accent hover:text-white transition">Review</a>
                    </div>
                @empty
                    <p class="px-4 lg:px-6 py-4 text-sm text-gray-400">Tidak ada permintaan pending.</p>
                @endforelse
            </div>
        </div>

        {{-- Today's Meetings --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="flex items-center justify-between px-4 lg:px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-primary text-sm">Meeting Hari Ini</h3>
                <span class="text-xs text-gray-400">{{ today()->format('d M Y') }}</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($todayMeetings as $meeting)
                    <div class="px-4 lg:px-6 py-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $meeting->status === 'in_progress' ? 'bg-accent' : 'bg-secondary' }}"></span>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $meeting->title }}</p>
                        </div>
                        <p class="text-xs text-gray-400 ml-4">{{ $meeting->requester->name }} · {{ $meeting->room->name }}</p>
                        <p class="text-xs text-gray-400 ml-4">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p>
                    </div>
                @empty
                    <p class="px-4 lg:px-6 py-4 text-sm text-gray-400">Tidak ada meeting hari ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Undangan untuk gm, head_of_store, hr --}}
    @if(in_array(auth()->user()->role, ['gm','head_of_store','hr']) && $myInvitations->count() > 0)
    <div class="bg-white rounded-xl shadow-sm">
        <div class="flex items-center justify-between px-4 lg:px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-primary text-sm">Undangan Meeting Saya</h3>
            <span class="px-2 py-0.5 bg-accent/10 text-accent rounded-full text-xs font-medium">{{ $myInvitations->count() }} aktif</span>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($myInvitations as $inv)
            <a href="{{ route('invitation.show', $inv) }}" class="flex items-center justify-between px-4 lg:px-6 py-3 hover:bg-gray-50 transition">
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        @if(!$inv->is_read)<span class="w-2 h-2 rounded-full bg-accent flex-shrink-0"></span>@endif
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $inv->meeting->title }}</p>
                    </div>
                    <p class="text-xs text-gray-400">{{ $inv->meeting->team->name }} · {{ $inv->meeting->meeting_date->format('d M Y') }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
