@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Tambah Meeting Mingguan')
@section('page-title', 'Tambah Jadwal Meeting Mingguan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.weekly-meetings.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="gaming-label">Judul <span style="color:#f87171;">*</span></label>
                <input type="text" name="title" value="{{ old('title', 'Weekly Meeting') }}" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Ruangan <span style="color:#f87171;">*</span></label>
                <select name="room_id" required class="gaming-input gaming-select">
                    <option value="">Pilih Ruangan</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="gaming-label">Hari <span style="color:#f87171;">*</span></label>
                <select name="day_of_week" required class="gaming-input gaming-select">
                    @foreach([1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'] as $val => $label)
                        <option value="{{ $val }}" {{ old('day_of_week') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="gaming-label">Jam Mulai <span style="color:#f87171;">*</span></label>
                    <input type="text" name="start_time" id="weekly-start" value="{{ old('start_time') }}" required class="gaming-input" placeholder="--:--" autocomplete="off">
                </div>
                <div>
                    <label class="gaming-label">Jam Selesai <span style="color:#f87171;">*</span></label>
                    <input type="text" name="end_time" id="weekly-end" value="{{ old('end_time') }}" required class="gaming-input" placeholder="--:--" autocomplete="off">
                </div>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.weekly-meetings.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const weeklyStart = document.getElementById('weekly-start');
    const weeklyEnd = document.getElementById('weekly-end');
    if (weeklyStart && weeklyEnd) {
        const wsFp = flatpickr(weeklyStart, {
            enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true,
            defaultDate: weeklyStart.value || '08:00',
            onChange: function(sel, str) {
                weFp.set('minTime', str);
                if (weFp.selectedDates.length && weFp.selectedDates[0] <= sel[0]) {
                    weFp.setDate(sel[0].getTime() + 3600000);
                }
            }
        });
        const weFp = flatpickr(weeklyEnd, {
            enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true,
            minTime: wsFp.selectedDates.length ? wsFp.input.value : '09:00',
            defaultDate: weeklyEnd.value || '09:00',
        });
    }
</script>
@endpush
