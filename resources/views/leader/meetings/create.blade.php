@extends('layouts.app')
@section('title', 'Request Meeting')
@section('page-title', 'Request Meeting')
@section('page-subtitle', 'Ajukan permintaan ruang meeting baru')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card overflow-hidden">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Request Meeting Baru</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Isi detail pertemuan untuk mengajukan meeting.</div>
            </div>
            <a href="{{ route('koordinator.meetings.index') }}" class="btn btn-secondary btn-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('koordinator.meetings.store') }}" enctype="multipart/form-data" class="p-5 space-y-5">
            @csrf

            {{-- Info Dasar --}}
            <div>
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">INFO DASAR</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="gaming-label">Judul Meeting <span style="color:#f87171;">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Evaluasi Konten Mingguan" class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Ruangan <span style="color:#f87171;">*</span></label>
                        <select name="room_id" required class="gaming-input gaming-select">
                            <option value="">Pilih Ruangan</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} ({{ $room->capacity }} orang)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="gaming-label">Tanggal Meeting <span style="color:#f87171;">*</span></label>
                        <input type="date" name="meeting_date" value="{{ old('meeting_date') }}" required min="{{ date('Y-m-d') }}" class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Jam Mulai <span style="color:#f87171;">*</span></label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Jam Selesai <span style="color:#f87171;">*</span></label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required class="gaming-input">
                    </div>
                </div>
            </div>

            {{-- Tim Utama: hanya untuk head_of_store, gm, hr, ceo --}}
            @if(in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr', 'ceo']))
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">TIM UTAMA</p>
                <label class="gaming-label">Pilih Tim Utama <span style="color:#f87171;">*</span></label>
                <select name="main_team_id" required class="gaming-input gaming-select">
                    <option value="">Pilih Tim Utama</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('main_team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs mt-1" style="color:var(--text-muted);">Tim utama yang akan menjadi penyelenggara meeting.</p>
            </div>
            @endif

            {{-- Tambah Tim --}}
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">TIM TAMBAHAN</p>
                        <p class="text-xs" style="color:var(--text-muted);">Opsional — tim kamu otomatis ter-undang</p>
                    </div>
                    <button type="button" onclick="addTeamRow()" class="btn btn-secondary btn-sm">+ Tambah Tim</button>
                </div>
                <div id="extra-teams" class="space-y-2">
                    @if(old('extra_teams'))
                        @foreach(old('extra_teams') as $i => $tid)
                        <div class="flex items-center gap-2 team-row">
                            <select name="extra_teams[]" class="gaming-input flex-1">
                                <option value="">Pilih Tim</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $tid == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="this.closest('.team-row').remove()" class="btn btn-danger btn-sm">✕</button>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- 5W1H --}}
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">DETAIL MEETING (5W1H)</p>
                <div class="space-y-3">
                    <div>
                        <label class="gaming-label">WHY — Kenapa meeting ini diadakan? <span style="color:#f87171;">*</span></label>
                        <textarea name="why" rows="2" required placeholder="Jelaskan alasan diadakannya meeting..." class="gaming-input" style="resize:vertical;">{{ old('why') }}</textarea>
                    </div>
                    <div>
                        <label class="gaming-label">WHAT — Apa yang akan dibahas? <span style="color:#f87171;">*</span></label>
                        <textarea name="what" rows="2" required placeholder="Topik atau agenda meeting..." class="gaming-input" style="resize:vertical;">{{ old('what') }}</textarea>
                    </div>
                    <div>
                        <label class="gaming-label">HOW — Hasil yang diharapkan <span style="color:#f87171;">*</span></label>
                        <textarea name="how_expected" rows="2" required placeholder="Keputusan atau output yang diharapkan..." class="gaming-input" style="resize:vertical;">{{ old('how_expected') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Upload File --}}
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <p class="font-gaming font-semibold text-sm mb-2" style="color:var(--text-primary);letter-spacing:0.05em;">LAMPIRAN FILE <span style="color:var(--text-muted);font-weight:400;font-family:'Inter',sans-serif;font-size:0.75rem;letter-spacing:0;">(Opsional)</span></p>
                <input type="file" name="file" accept=".pdf,.doc,.docx" class="gaming-input" style="padding:0.5rem;">
                <p class="text-xs mt-1" style="color:var(--text-muted);">Format: PDF, DOC, DOCX. Maks 10MB.</p>
            </div>

            {{-- Aset --}}
            @if($assets->count())
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">KEBUTUHAN ASET <span style="color:var(--text-muted);font-weight:400;font-family:'Inter',sans-serif;font-size:0.75rem;letter-spacing:0;">(Opsional)</span></p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($assets as $asset)
                    <div class="flex items-center gap-3 p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                        <span class="text-sm flex-1" style="color:var(--text-primary);">{{ $asset->name }}</span>
                        <input type="number" name="assets[{{ $asset->id }}]" min="0" max="{{ $asset->quantity }}" value="0"
                            class="gaming-input text-center" style="width:64px;padding:0.35rem 0.5rem;">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-3 pt-4" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Request
                </button>
                <a href="{{ route('koordinator.meetings.index') }}" class="btn btn-secondary">Batal</a>
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
        const selected = [...container.querySelectorAll('select')].map(s => s.value);
        const options = teamsData.filter(t => !selected.includes(String(t.id)))
            .map(t => `<option value="${t.id}">${t.name}</option>`).join('');
        if (!options) { alert('Semua tim sudah ditambahkan.'); return; }
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 team-row';
        row.innerHTML = `
            <select name="extra_teams[]" class="gaming-input flex-1">
                <option value="">Pilih Tim</option>${options}
            </select>
            <button type="button" onclick="this.closest('.team-row').remove()" class="btn btn-danger btn-sm">✕</button>`;
        container.appendChild(row);
    }
</script>
@endpush
