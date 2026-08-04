@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Rekam Rapat')
@section('page-title', 'Rekam Hasil Rangkuman Rapat')
@section('page-subtitle', 'Nyalakan mikrofon untuk merekam dan mendapatkan transkrip otomatis')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl animate-fade-in space-y-4">

    {{-- Pilih Meeting --}}
    @if(!$meeting)
    <div class="gaming-card p-6">
        <div class="flex items-center gap-2 mb-4 p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
            </svg>
            <p class="text-sm" style="color:var(--text-secondary);">Pilih meeting yang ingin direkam</p>
        </div>
        <form method="GET" action="{{ route('admin.recordings.create') }}">
            <div class="space-y-3">
                <div>
                    <label class="gaming-label">Meeting <span style="color:#f87171;">*</span></label>
                    <select name="meeting" required class="gaming-input">
                        <option value="">— Pilih Meeting —</option>
                        @foreach($meetings as $m)
                            <option value="{{ $m->id }}" {{ $meeting && $meeting->id == $m->id ? 'selected' : '' }}>
                                {{ $m->title }} — {{ $m->meeting_date->format('d M Y') }} ({{ ucfirst($m->status) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-primary">Pilih Meeting</button>
                    <a href="{{ route('admin.recordings.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
    @endif

    {{-- Panel Rekaman --}}
    @if($meeting)
    <input type="hidden" id="meeting-id" value="{{ $meeting->id }}">
    <input type="hidden" id="store-url" value="{{ route('admin.recordings.store') }}">
    <input type="hidden" id="show-url" value="">

    {{-- Info Meeting --}}
    <div class="gaming-card p-6">
        <div class="flex items-center gap-2 mb-4 p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm" style="color:var(--text-secondary);">
                <span style="color:var(--text-primary);font-weight:600;">{{ $meeting->title }}</span>
                · {{ $meeting->meeting_date->format('d M Y') }}
                · {{ $meeting->room->name ?? '' }}
                @if($meeting->start_time)
                    · {{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}
                @endif
            </p>
        </div>

        {{-- Status Browser Support --}}
        <div id="browser-support-warning" class="hidden mb-4 p-4 rounded-xl" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 flex-shrink-0" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p class="text-sm font-semibold" style="color:#f87171;">Browser tidak mendukung fitur rekaman.</p>
            </div>
            <p class="text-xs mt-1" style="color:#fca5a5;">Gunakan browser Chrome atau Edge untuk fitur rekaman dan transkrip otomatis.</p>
        </div>

        {{-- Panel Rekaman --}}
        <div class="text-center py-6">
            {{-- Timer --}}
            <div id="recording-timer" class="text-4xl font-mono font-bold mb-6" style="color:var(--text-primary);letter-spacing:0.05em;">
                00:00:00
            </div>

            {{-- Status Label --}}
            <div id="recording-status" class="text-sm font-medium mb-6" style="color:var(--text-muted);">
                Siap untuk merekam
            </div>

            {{-- Visualizer --}}
            <div id="visualizer-container" class="hidden mb-6" style="height:60px;display:flex;align-items:center;justify-content:center;gap:2px;">
                <div id="visualizer-bars" class="flex items-end gap-[3px]" style="height:50px;"></div>
            </div>

            {{-- Tombol Rekam --}}
            <div class="flex items-center justify-center gap-4">
                <button type="button" id="btn-start" onclick="startRecording()" class="btn btn-primary btn-lg inline-flex items-center gap-2" style="padding:12px 28px;font-size:0.9rem;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                    Mulai Rekam
                </button>
                <button type="button" id="btn-stop" onclick="stopRecording()" class="btn btn-danger btn-lg inline-flex items-center gap-2 hidden" style="padding:12px 28px;font-size:0.9rem;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="6" y="6" width="12" height="12" rx="2"/></svg>
                    Hentikan Rekaman
                </button>
            </div>
        </div>
    </div>

    {{-- Hasil Rekaman (muncul setelah stop) --}}
    <div id="result-section" class="hidden">
        {{-- Audio Preview --}}
        <div class="gaming-card p-5">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M9 10a1 1 0 011-1h1a1 1 0 011 1v4a1 1 0 01-1 1h-1a1 1 0 01-1-1v-4zM5.636 15.364A9 9 0 015 12a9 9 0 01.636-3.364"/></svg>
                <span class="text-xs font-bold" style="color:#f87171;">REKAMAN AUDIO</span>
            </div>
            <audio id="audio-preview" controls style="width:100%;height:40px;border-radius:10px;"></audio>
            <div class="flex items-center gap-4 mt-2">
                <span class="text-xs" style="color:var(--text-muted);">Durasi: <strong id="final-duration" style="color:var(--text-primary);">00:00:00</strong></span>
                <span class="text-xs" style="color:var(--text-muted);">Ukuran: <strong id="final-size" style="color:var(--text-primary);">—</strong></span>
            </div>
        </div>

        {{-- Transcript --}}
        <div class="gaming-card p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-xs font-bold" style="color:#60a5fa;">TRANSKRIP OTOMATIS</span>
                </div>
                <span id="transcript-status" class="text-[11px] px-2 py-0.5 rounded-full" style="background:rgba(245,158,11,0.15);color:#fbbf24;">Memproses...</span>
            </div>
            <div id="transcript-content" class="p-4 rounded-xl text-sm whitespace-pre-wrap" style="min-height:80px;background:var(--bg-surface-2);border:1px solid var(--border-color);color:var(--text-secondary);line-height:1.8;font-size:0.8rem;">
                <span style="color:var(--text-muted);font-style:italic;">Menunggu hasil transkrip...</span>
            </div>
        </div>

        {{-- Summary / Rekap --}}
        <div class="gaming-card p-5">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-xs font-bold" style="color:#10b981;">REKAP RAPAT</span>
            </div>
            <p class="text-xs mb-3" style="color:var(--text-muted);">Ringkas hasil rapat di bawah ini berdasarkan transkrip yang didapat.</p>
            <textarea id="summary-content" rows="6" class="gaming-input" style="resize:vertical;" placeholder="Tulis rekap/kesimpulan rapat di sini..."></textarea>
        </div>

        {{-- Aksi --}}
        <div class="flex gap-3">
            <button type="button" onclick="saveRecording('draft')" id="btn-save" class="btn btn-primary inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Simpan Draft
            </button>
            <button type="button" onclick="saveRecording('finalize')" class="btn btn-success inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Simpan & Finalisasi
            </button>
            <a href="{{ route('admin.recordings.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
// ========================
// State
// ========================
let mediaRecorder = null;
let audioChunks = [];
let recognition = null;
let transcriptText = '';
let timerInterval = null;
let seconds = 0;
let audioStream = null;
let analyser = null;
let animFrame = null;
let isRecording = false;

// ========================
// Init
// ========================
(function() {
    const hasMediaDevices = !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const hasSpeechRecognition = !!SpeechRecognition;

    if (!hasMediaDevices) {
        document.getElementById('browser-support-warning')?.classList.remove('hidden');
        document.getElementById('btn-start').disabled = true;
        document.getElementById('btn-start').style.opacity = '0.5';
        document.getElementById('btn-start').style.cursor = 'not-allowed';
    }
})();

// ========================
// Recording
// ========================
async function startRecording() {
    try {
        audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });

        // Setup MediaRecorder
        const options = { mimeType: 'audio/webm;codecs=opus' };
        if (!MediaRecorder.isTypeSupported(options.mimeType)) {
            delete options.mimeType;
        }
        mediaRecorder = new MediaRecorder(audioStream, options);
        audioChunks = [];

        mediaRecorder.ondataavailable = (e) => {
            if (e.data.size > 0) audioChunks.push(e.data);
        };

        mediaRecorder.onstop = () => {
            const blob = new Blob(audioChunks, { type: mediaRecorder.mimeType || 'audio/webm' });
            const url = URL.createObjectURL(blob);
            document.getElementById('audio-preview').src = url;

            const sizeMB = (blob.size / (1024 * 1024)).toFixed(2);
            document.getElementById('final-size').textContent = sizeMB + ' MB';

            // Stop speech recognition
            if (recognition) {
                try { recognition.stop(); } catch(e) {}
            }

            // Stop all tracks
            if (audioStream) {
                audioStream.getTracks().forEach(t => t.stop());
            }

            // Cancel animation
            if (animFrame) cancelAnimationFrame(animFrame);

            isRecording = false;
        };

        mediaRecorder.start(500); // collect data every 500ms
        isRecording = true;

        // Setup SpeechRecognition
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (SpeechRecognition) {
            recognition = new SpeechRecognition();
            recognition.lang = 'id-ID';
            recognition.continuous = true;
            recognition.interimResults = true;

            let finalTranscript = '';

            recognition.onresult = (event) => {
                let interim = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    const t = event.results[i][0].transcript;
                    if (event.results[i].isFinal) {
                        finalTranscript += t + '\n';
                    } else {
                        interim += t;
                    }
                }
                transcriptText = finalTranscript + interim;
                document.getElementById('transcript-content').innerHTML = transcriptText.replace(/\n/g, '<br>') || '<span style="color:var(--text-muted);font-style:italic;">Mendengarkan...</span>';
            };

            recognition.onerror = (event) => {
                if (event.error === 'no-speech') return; // normal
                console.warn('Speech recognition error:', event.error);
            };

            recognition.onend = () => {
                // Auto-restart if still recording
                if (isRecording && recognition) {
                    try { recognition.start(); } catch(e) {}
                }
            };

            try { recognition.start(); } catch(e) {}
        }

        // Update UI
        document.getElementById('btn-start').classList.add('hidden');
        document.getElementById('btn-stop').classList.remove('hidden');
        document.getElementById('recording-status').innerHTML = '<span style="color:#f87171;font-weight:600;">MEREKAM...</span>';
        document.getElementById('result-section')?.classList.add('hidden');

        // Show visualizer
        const vc = document.getElementById('visualizer-container');
        vc.classList.remove('hidden');
        vc.style.display = 'flex';
        startVisualizer(audioStream);

        // Start timer
        seconds = 0;
        timerInterval = setInterval(() => {
            seconds++;
            document.getElementById('recording-timer').textContent = formatTime(seconds);
        }, 1000);

    } catch (err) {
        console.error('Error accessing microphone:', err);
        alert('Gagal mengakses mikrofon. Pastikan Anda memberikan izin akses mikrofon.\n\nError: ' + err.message);
    }
}

function stopRecording() {
    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
        mediaRecorder.stop();
    }

    clearInterval(timerInterval);

    document.getElementById('btn-stop').classList.add('hidden');
    document.getElementById('btn-start').classList.remove('hidden');
    document.getElementById('recording-status').innerHTML = '<span style="color:#34d399;">Rekaman selesai</span>';
    document.getElementById('recording-timer').textContent = formatTime(seconds);

    // Hide visualizer
    const vc = document.getElementById('visualizer-container');
    vc.classList.add('hidden');
    vc.style.display = 'none';

    // Show result section
    document.getElementById('result-section').classList.remove('hidden');
    document.getElementById('final-duration').textContent = formatTime(seconds);

    // Mark transcript as done
    const ts = document.getElementById('transcript-status');
    if (ts) {
        ts.textContent = 'Selesai';
        ts.style.background = 'rgba(16,185,129,0.15)';
        ts.style.color = '#34d399';
    }
}

// ========================
// Visualizer
// ========================
function startVisualizer(stream) {
    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    const source = audioCtx.createMediaStreamSource(stream);
    analyser = audioCtx.createAnalyser();
    analyser.fftSize = 64;
    source.connect(analyser);

    const barsContainer = document.getElementById('visualizer-bars');
    barsContainer.innerHTML = '';
    const barCount = 20;
    const barWidth = 4;
    for (let i = 0; i < barCount; i++) {
        const bar = document.createElement('div');
        bar.style.width = barWidth + 'px';
        bar.style.height = '4px';
        bar.style.borderRadius = '2px';
        bar.style.background = '#f87171';
        bar.style.transition = 'height 0.05s ease';
        barsContainer.appendChild(bar);
    }
    const bars = barsContainer.children;

    const dataArray = new Uint8Array(analyser.frequencyBinCount);

    function draw() {
        if (!isRecording) return;
        analyser.getByteFrequencyData(dataArray);
        for (let i = 0; i < barCount; i++) {
            const idx = Math.floor(i * dataArray.length / barCount);
            const val = dataArray[idx] || 0;
            const h = Math.max(4, (val / 255) * 50);
            bars[i].style.height = h + 'px';
        }
        animFrame = requestAnimationFrame(draw);
    }
    draw();
}

// ========================
// Save
// ========================
async function saveRecording(action) {
    const meetingId = document.getElementById('meeting-id').value;
    const storeUrl = document.getElementById('store-url').value;
    const summary = document.getElementById('summary-content').value;

    if (!summary.trim()) {
        alert('Silakan isi rekap rapat terlebih dahulu.');
        return;
    }

    const btn = document.getElementById('btn-save');
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg> Menyimpan...';

    const formData = new FormData();
    formData.append('meeting_id', meetingId);
    formData.append('transcript', transcriptText);
    formData.append('summary', summary);
    formData.append('duration', seconds);
    formData.append('action', action);

    // Append audio blob
    if (audioChunks.length > 0) {
        const blob = new Blob(audioChunks, { type: mediaRecorder.mimeType || 'audio/webm' });
        const ext = blob.type.includes('webm') ? 'webm' : 'mp3';
        formData.append('audio', blob, 'recording_' + Date.now() + '.' + ext);
    }

    try {
        const resp = await fetch(storeUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData,
        });

        const data = await resp.json();

        if (data.success) {
            window.location.href = '{{ route("admin.recordings.index") }}';
        } else {
            alert('Gagal menyimpan: ' + (data.message || 'Unknown error'));
            btn.disabled = false;
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Simpan Draft';
        }
    } catch (err) {
        alert('Gagal menyimpan: ' + err.message);
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Simpan Draft';
    }
}

// ========================
// Helpers
// ========================
function formatTime(totalSeconds) {
    const h = Math.floor(totalSeconds / 3600);
    const m = Math.floor((totalSeconds % 3600) / 60);
    const s = totalSeconds % 60;
    return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
}
</script>
@endpush
