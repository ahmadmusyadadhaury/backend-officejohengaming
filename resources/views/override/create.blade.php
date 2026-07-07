@extends('layouts.app')
@section('title', 'Ajukan Override Booking')
@section('page-title', 'Ajukan Override Booking')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl animate-fade-in">
    <div class="gaming-card p-6 mb-4" style="border-color:rgba(245,158,11,0.4);background:rgba(245,158,11,0.05);">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-lg" style="background:rgba(245,158,11,0.2);color:#f59e0b;">⚠️</div>
            <div>
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);">Konflik Jadwal Terdeteksi</h3>
                <p class="text-sm mt-1" style="color:var(--text-secondary);">
                    Ruangan <strong style="color:var(--text-primary);">{{ $conflict->room->name }}</strong> sudah dibooking oleh
                    <strong style="color:var(--color-accent-light);">{{ $conflict->requester->name }}</strong>
                    (Tim <strong>{{ $conflict->team->name }}</strong>)
                    pada <strong>{{ \Carbon\Carbon::parse($data['meeting_date'])->format('d M Y') }}</strong>
                    pukul <strong>{{ substr($conflict->start_time,0,5) }} – {{ substr($conflict->end_time,0,5) }}</strong>.
                </p>
                <p class="text-sm mt-2 font-semibold" style="color:#f59e0b;">Kamu bisa mengajukan override dengan memberikan alasan yang jelas.</p>
            </div>
        </div>
    </div>

    <div class="gaming-card p-6">
        <h3 class="font-gaming font-semibold mb-4" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING KAMU</h3>
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Judul</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $data['title'] }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $conflict->room->name }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ \Carbon\Carbon::parse($data['meeting_date'])->format('d M Y') }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ substr($data['start_time'],0,5) }} – {{ substr($data['end_time'],0,5) }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('override.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="gaming-label">Alasan Override <span style="color:#f87171;">*</span></label>
                <textarea name="reason" rows="4" required placeholder="Jelaskan alasan kenapa booking ini harus didahulukan (urgensi, deadline, etc.)..." class="gaming-input" style="resize:vertical;">{{ old('reason') }}</textarea>
                @error('reason')<p class="text-sm mt-1" style="color:#f87171;">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Kirim Permintaan Override</button>
                <a href="{{ route('koordinator.meetings.create') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
