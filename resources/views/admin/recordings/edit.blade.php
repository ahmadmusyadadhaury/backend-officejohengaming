@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Edit Rekap Rapat')
@section('page-title', 'Edit Rekap Hasil Rangkuman Rapat')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl animate-fade-in space-y-4">

    {{-- Info Meeting --}}
    <div class="gaming-card p-6">
        <div class="flex items-center gap-2 mb-4 p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm" style="color:var(--text-secondary);">
                <span style="color:var(--text-primary);font-weight:600;">{{ $recording->meeting->title ?? '—' }}</span>
                · {{ $recording->meeting->meeting_date ? $recording->meeting->meeting_date->format('d M Y') : '—' }}
                · {{ $recording->meeting->room->name ?? '' }}
            </p>
        </div>

        <form method="POST" action="{{ route('admin.recordings.update', $recording) }}" class="space-y-4">
            @csrf @method('PUT')

            {{-- Audio Preview --}}
            @if($recording->audio_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($recording->audio_path))
            <div>
                <label class="gaming-label">Rekaman Audio</label>
                <audio controls style="width:100%;height:40px;border-radius:10px;">
                    <source src="{{ Storage::disk('public')->url($recording->audio_path) }}" type="audio/webm">
                </audio>
                <p class="text-xs mt-1" style="color:var(--text-muted);">Durasi: {{ $recording->duration_formatted }}</p>
            </div>
            @endif

            {{-- Transcript (readonly) --}}
            @if($recording->transcript)
            <div>
                <label class="gaming-label">Transkrip Otomatis <span style="color:var(--text-muted);font-weight:400;">(Referensi)</span></label>
                <textarea name="transcript" rows="6" class="gaming-input" style="resize:vertical;background:var(--bg-surface-2);" readonly>{{ $recording->transcript }}</textarea>
                <p class="text-xs mt-1" style="color:var(--text-muted);">Transkrip hanya bisa dilihat, tidak bisa diedit dari sini.</p>
            </div>
            @endif

            {{-- Summary (editable) --}}
            <div>
                <label class="gaming-label">Rekap / Kesimpulan Rapat <span style="color:#f87171;">*</span></label>
                <textarea name="summary" rows="8" required class="gaming-input" style="resize:vertical;" placeholder="Tulis rekap/kesimpulan rapat...">{{ old('summary', $recording->summary) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.recordings.show', $recording) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
