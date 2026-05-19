@extends('layouts.app')
@section('title', 'Permintaan Meeting')
@section('page-title', 'Permintaan Meeting')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 animate-fade-in">
    <div class="gaming-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pemohon</th>
                        <th>Tim</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Antrian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($meetings as $meeting)
                    @php
                        $statusStyle = match($meeting->status) {
                            'pending'     => 'badge-yellow',
                            'approved'    => 'badge-blue',
                            'rejected'    => 'badge-red',
                            'confirmed'   => 'badge-primary',
                            'cancelled'   => 'badge-gray',
                            'in_progress' => 'badge-primary',
                            'completed'   => 'badge-green',
                            default       => 'badge-gray',
                        };
                        $rt = \App\Services\MeetingQueueService::realtimeStatus($meeting);
                        $queueBadge = match(true) {
                            str_contains($rt['label'], 'Berlangsung') => 'badge-primary',
                            str_contains($rt['label'], 'Antrian')     => 'badge-orange',
                            str_contains($rt['label'], 'Di Booking')  => 'badge-blue',
                            str_contains($rt['label'], 'Selesai')     => 'badge-green',
                            str_contains($rt['label'], 'Menunggu')    => 'badge-yellow',
                            default                                   => 'badge-gray',
                        };
                    @endphp
                    <tr>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $meeting->title }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->requester->name }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->team->name }}</td>
                        <td style="color:var(--text-muted);">{{ $meeting->meeting_date->format('d M Y') }}</td>
                        <td style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                        <td><span class="badge {{ $statusStyle }}">{{ ucfirst($meeting->status) }}</span></td>
                        <td>
                            @if($meeting->queue_position !== null && !in_array($meeting->status, ['pending','rejected','cancelled']))
                                <span class="badge {{ $queueBadge }}">
                                    {{ $rt['label'] }}
                                </span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.meetings.show', $meeting) }}" class="btn btn-secondary btn-sm">Detail</a>
                            @if(!in_array($meeting->status, ['approved','confirmed','in_progress']))
                            <form method="POST" action="{{ route('admin.meetings.destroy', $meeting) }}" class="inline" onsubmit="return confirm('Hapus meeting ini? Data tidak bisa dikembalikan.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada permintaan meeting.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $meetings->links() }}</div>
    </div>
</div>
@endsection
