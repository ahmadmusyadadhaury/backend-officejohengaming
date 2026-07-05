@extends('layouts.app')
@section('title', 'Kelola Booking')
@section('page-title', 'Overview > Kelola Booking')
@section('page-subtitle', 'Kelola pemesanan ruangan dan fasilitas')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 animate-fade-in">
    <div class="gaming-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Ruangan</th>
                        <th>User</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $booking->title }}</td>
                        <td style="color:var(--text-muted);">{{ $booking->room->name }}</td>
                        <td style="color:var(--text-muted);">{{ $booking->user->name }}</td>
                        <td style="color:var(--text-muted);">{{ $booking->start_time->format('d M Y H:i') }}</td>
                        <td style="color:var(--text-muted);">{{ $booking->end_time->format('H:i') }}</td>
                        <td>
                            @php
                                $sc = match($booking->status) {
                                    'approved'  => 'badge-green',
                                    'pending'   => 'badge-yellow',
                                    'cancelled' => 'badge-red',
                                    default     => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $sc }}">{{ ucfirst($booking->status) }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus booking ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($bookings) && method_exists($bookings, 'links'))
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $bookings->links() }}</div>
        @endif
    </div>
</div>
@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection
