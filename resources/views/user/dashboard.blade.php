@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)

@section('sidebar-menu')
    @include('partials.sidebar-user')
@endsection

@section('content')
<div class="space-y-6 pt-2">

    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-primary to-accent rounded-xl p-6">
        <p class="text-white font-semibold text-lg">{{ auth()->user()->name }}</p>
        <p class="text-blue-200 text-sm mt-1">
            {{ auth()->user()->team?->name ?? 'Belum ada tim' }} ·
            NIK: {{ auth()->user()->nik }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Meeting yang saya ikuti --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-primary text-sm">Meeting Saya (Mendatang)</h3>
                <a href="{{ route('calendar') }}" class="text-xs text-accent hover:underline">Lihat kalender</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($myMeetings as $meeting)
                    <div class="px-6 py-3">
                        <p class="text-sm font-medium text-gray-800">{{ $meeting->title }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $meeting->room->name }} · {{ $meeting->meeting_date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ substr($meeting->start_time, 0, 5) }} – {{ substr($meeting->end_time, 0, 5) }}</p>
                        <p class="text-xs text-gray-400">Oleh: {{ $meeting->requester->name }}</p>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">Kamu belum diundang ke meeting apapun.</p>
                @endforelse
            </div>
        </div>

        {{-- Meeting Hari Ini --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-primary text-sm">Meeting Hari Ini</h3>
                <span class="text-xs text-gray-400">{{ today()->format('d M Y') }}</span>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($todayMeetings as $meeting)
                    <div class="px-6 py-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full
                                {{ $meeting->status === 'in_progress' ? 'bg-accent animate-pulse' : 'bg-secondary' }}"></span>
                            <p class="text-sm font-medium text-gray-800">{{ $meeting->title }}</p>
                        </div>
                        <p class="text-xs text-gray-400 ml-4 mt-1">{{ $meeting->team->name }} · {{ $meeting->room->name }}</p>
                        <p class="text-xs text-gray-400 ml-4">{{ substr($meeting->start_time, 0, 5) }} – {{ substr($meeting->end_time, 0, 5) }}</p>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">Tidak ada meeting hari ini.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
