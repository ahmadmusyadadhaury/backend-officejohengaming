@extends('layouts.app')
@section('title', 'Undangan Meeting')
@section('page-title', 'Undangan Meeting')
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
<div class="pt-2">
    <div class="space-y-3">
        @forelse($invitations as $inv)
        @php
            $statusColors = ['approved'=>'bg-blue-100 text-blue-700','confirmed'=>'bg-indigo-100 text-indigo-700','in_progress'=>'bg-purple-100 text-purple-700','cancelled'=>'bg-red-100 text-red-700','rejected'=>'bg-red-100 text-red-700'];
        @endphp
        <a href="{{ route('invitation.show', $inv) }}"
            class="block bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition border-l-4 {{ !$inv->is_read ? 'border-accent' : 'border-gray-200' }}">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        @if(!$inv->is_read)
                            <span class="w-2 h-2 rounded-full bg-accent flex-shrink-0"></span>
                        @endif
                        <p class="font-semibold text-primary">{{ $inv->meeting->title }}</p>
                    </div>
                    <p class="text-sm text-gray-500">{{ $inv->meeting->team->name }} · {{ $inv->meeting->room->name }}</p>
                    <p class="text-sm text-gray-500">{{ $inv->meeting->meeting_date->isoFormat('dddd, D MMMM Y') }} · {{ substr($inv->meeting->start_time,0,5) }} – {{ substr($inv->meeting->end_time,0,5) }}</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$inv->meeting->status] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ ucfirst($inv->meeting->status) }}
                </span>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-xl shadow-sm p-8 text-center text-gray-400">
            Tidak ada undangan meeting aktif.
        </div>
        @endforelse
    </div>
</div>
@endsection
