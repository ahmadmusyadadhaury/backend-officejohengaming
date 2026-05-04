@extends('layouts.app')
@section('title', 'Request Meeting')
@section('page-title', 'Request Meeting Baru')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('koordinator.meetings.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Info Dasar --}}
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
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->name }} (Kapasitas: {{ $room->capacity }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Meeting <span class="text-red-500">*</span></label>
                    <input type="date" name="meeting_date" value="{{ old('meeting_date') }}" required min="{{ date('Y-m-d') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                </div>
            </div>

            {{-- Tambah Tim --}}
            <div class="border-t pt-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-primary text-sm">Tambah Tim <span class="text-gray-400 font-normal text-xs">(Opsional — tim kamu otomatis ter-undang)</span></h3>
                    <button type="button" onclick="addTeamRow()"
                        class="px-3 py-1.5 bg-primary/10 text-primary rounded-lg text-xs hover:bg-primary hover:text-white transition">
                        + Tambah Tim
                    </button>
                </div>
                <div id="extra-teams" class="space-y-2">
                    @if(old('extra_teams'))
                        @foreach(old('extra_teams') as $i => $tid)
                        <div class="flex items-center gap-2 team-row">
                            <select name="extra_teams[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                                <option value="">Pilih Tim</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $tid == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="this.closest('.team-row').remove()"
                                class="px-2 py-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition text-xs">✕</button>
                        </div>
                        @endforeach
                    @endif
                </div>
                <p class="text-xs text-gray-400 mt-2">Semua anggota tim yang dipilih akan otomatis ter-undang saat meeting disetujui.</p>
            </div>

            {{-- 5W1H --}}
            <div class="border-t pt-4">
                <h3 class="font-semibold text-primary mb-3 text-sm">Detail Meeting</h3>
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">HOW — Hasil yang diharapkan <span class="text-red-500">*</span></label>
                        <textarea name="how_expected" rows="2" required placeholder="Keputusan atau output yang diharapkan..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">{{ old('how_expected') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Upload File --}}
            <div class="border-t pt-4">
                <h3 class="font-semibold text-primary mb-3 text-sm">Lampiran File <span class="text-gray-400 font-normal">(Opsional)</span></h3>
                <input type="file" name="file" accept=".pdf,.doc,.docx"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                <p class="text-xs text-gray-400 mt-1">Format: PDF, DOC, DOCX. Maks 10MB. File bisa dilihat oleh semua anggota tim yang diundang.</p>
            </div>

            {{-- Aset --}}
            @if($assets->count())
            <div class="border-t pt-4">
                <h3 class="font-semibold text-primary mb-3 text-sm">Kebutuhan Aset <span class="text-gray-400 font-normal">(Opsional)</span></h3>
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
                <a href="{{ route('koordinator.meetings.index') }}" class="px-5 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const teamsData = @json($teams);

    function addTeamRow() {
        const container = document.getElementById('extra-teams');

        // Cek tim yang sudah dipilih
        const selected = [...container.querySelectorAll('select')].map(s => s.value);

        const options = teamsData
            .filter(t => !selected.includes(String(t.id)))
            .map(t => `<option value="${t.id}">${t.name}</option>`)
            .join('');

        if (!options) {
            alert('Semua tim sudah ditambahkan.');
            return;
        }

        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 team-row';
        row.innerHTML = `
            <select name="extra_teams[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                <option value="">Pilih Tim</option>
                ${options}
            </select>
            <button type="button" onclick="this.closest('.team-row').remove()"
                class="px-2 py-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition text-xs">✕</button>
        `;
        container.appendChild(row);
    }
</script>
@endpush
