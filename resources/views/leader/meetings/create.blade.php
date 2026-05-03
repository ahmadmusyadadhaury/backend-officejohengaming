@extends('layouts.app')
@section('title', 'Request Meeting')
@section('page-title', 'Request Meeting Baru')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('leader.meetings.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Meeting <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Evaluasi Konten Mingguan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ruangan <span class="text-red-500">*</span></label>
                    <select name="room_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                        <option value="">Pilih Ruangan</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }} (Kapasitas: {{ $room->capacity }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tim Kedua (Opsional)</label>
                    <select name="second_team_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                        <option value="">Tidak ada</option>
                        @foreach($teams->where('id', '!=', auth()->user()->team_id) as $team)
                            <option value="{{ $team->id }}" {{ old('second_team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Meeting <span class="text-red-500">*</span></label>
                    <input type="date" name="meeting_date" value="{{ old('meeting_date') }}" required min="{{ date('Y-m-d') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Selesai <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                    </div>
                </div>
            </div>

            {{-- 5W1H --}}
            <div class="border-t pt-4">
                <h3 class="font-semibold text-primary mb-3 text-sm">Detail Meeting (5W1H)</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WHY — Kenapa meeting ini diadakan? <span class="text-red-500">*</span></label>
                        <textarea name="why" rows="2" required placeholder="Jelaskan alasan diadakannya meeting..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">{{ old('why') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WHAT — Apa yang akan dibahas? <span class="text-red-500">*</span></label>
                        <textarea name="what" rows="2" required placeholder="Topik atau agenda meeting..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">{{ old('what') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WHERE — Lokasi detail</label>
                        <input type="text" name="where_detail" value="{{ old('where_detail') }}" placeholder="Contoh: Meeting Room Lantai 1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WHO — Ringkasan peserta</label>
                        <input type="text" name="who_summary" value="{{ old('who_summary') }}" placeholder="Contoh: Tim Konten + Tim Marketing"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">HOW — Hasil yang diharapkan <span class="text-red-500">*</span></label>
                        <textarea name="how_expected" rows="2" required placeholder="Keputusan atau output yang diharapkan dari meeting..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">{{ old('how_expected') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Peserta --}}
            @if($users->count())
            <div class="border-t pt-4">
                <h3 class="font-semibold text-primary mb-3 text-sm">Undang Peserta dari Tim Kamu</h3>
                <div class="flex flex-wrap gap-2 mb-2">
                    <button type="button" onclick="selectAllParticipants()" class="px-3 py-1 bg-primary/10 text-primary rounded text-xs hover:bg-primary hover:text-white transition">Undang Semua Tim</button>
                    <button type="button" onclick="clearParticipants()" class="px-3 py-1 bg-gray-100 text-gray-600 rounded text-xs hover:bg-gray-200 transition">Kosongkan</button>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($users as $u)
                    <label class="flex items-center gap-2 text-sm text-gray-700 p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="participants[]" value="{{ $u->id }}" class="participant-cb w-4 h-4 text-accent rounded border-gray-300"
                            {{ in_array($u->id, old('participants', [])) ? 'checked' : '' }}>
                        {{ $u->name }}
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Aset --}}
            @if($assets->count())
            <div class="border-t pt-4">
                <h3 class="font-semibold text-primary mb-3 text-sm">Kebutuhan Aset (Opsional)</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($assets as $asset)
                    <div class="flex items-center gap-2 p-2 border border-gray-200 rounded-lg">
                        <span class="text-sm text-gray-700 flex-1">{{ $asset->name }}</span>
                        <input type="number" name="assets[{{ $asset->id }}]" min="0" max="{{ $asset->quantity }}" value="0"
                            class="w-16 px-2 py-1 border border-gray-300 rounded text-sm text-center focus:outline-none focus:ring-1 focus:ring-accent">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex gap-3 pt-2 border-t">
                <button type="submit" class="px-5 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">Kirim Request</button>
                <a href="{{ route('leader.meetings.index') }}" class="px-5 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function selectAllParticipants() {
        document.querySelectorAll('.participant-cb').forEach(cb => cb.checked = true);
    }
    function clearParticipants() {
        document.querySelectorAll('.participant-cb').forEach(cb => cb.checked = false);
    }
</script>
@endpush
