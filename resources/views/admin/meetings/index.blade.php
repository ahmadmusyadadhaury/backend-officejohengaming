@extends('layouts.app')
@section('title', 'Permintaan Meeting')
@section('page-title', 'Permintaan Meeting')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2">
    @php
        $statusColors = ['pending'=>'bg-yellow-100 text-yellow-700','approved'=>'bg-blue-100 text-blue-700','rejected'=>'bg-red-100 text-red-700','confirmed'=>'bg-indigo-100 text-indigo-700','cancelled'=>'bg-gray-100 text-gray-600','in_progress'=>'bg-purple-100 text-purple-700','completed'=>'bg-green-100 text-green-700'];
    @endphp
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[700px]">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Pemohon</th>
                    <th class="px-4 py-3 text-left">Tim</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Waktu</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Antrian</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($meetings as $meeting)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $meeting->title }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $meeting->requester->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $meeting->team->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $meeting->meeting_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$meeting->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($meeting->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($meeting->queue_position !== null)
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ \App\Services\MeetingQueueService::queueColor($meeting->queue_position) }}">
                                {{ \App\Services\MeetingQueueService::queueLabel($meeting->queue_position) }}
                            </span>
                        @else
                            <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.meetings.show', $meeting) }}" class="px-3 py-1 bg-primary/10 text-primary rounded text-xs hover:bg-primary hover:text-white transition">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada permintaan meeting.</td></tr>
                @endforelse
            </tbody>
        </table>
        </table>
        </div>
        <div class="px-4 py-3 border-t">{{ $meetings->links() }}</div>
    </div>
</div>
@endsection
