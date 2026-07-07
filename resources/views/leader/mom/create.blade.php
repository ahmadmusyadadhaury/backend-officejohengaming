@extends('layouts.app')
@section('body-class', 'page-leader')
@section('title', 'Buat MOM')
@section('page-title', 'Buat Minutes of Meeting')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-2xl animate-fade-in">
    <div class="gaming-card p-6">
        <div class="flex items-center gap-2 mb-4 p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm" style="color:var(--text-secondary);">
                <span style="color:var(--text-primary);font-weight:600;">{{ $meeting->title }}</span>
                · {{ $meeting->meeting_date->format('d M Y') }}
            </p>
        </div>
        <form method="POST" action="{{ route('koordinator.meetings.mom.store', $meeting) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="gaming-label">Ringkasan Pembahasan <span style="color:#f87171;">*</span></label>
                <textarea name="summary" rows="3" required class="gaming-input" style="resize:vertical;">{{ old('summary') }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Keputusan <span style="color:#f87171;">*</span></label>
                <textarea name="decisions" rows="3" required class="gaming-input" style="resize:vertical;">{{ old('decisions') }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Action Plan <span style="color:#f87171;">*</span></label>
                <textarea name="action_plan" rows="3" required class="gaming-input" style="resize:vertical;">{{ old('action_plan') }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Penanggung Jawab (PIC) <span style="color:#f87171;">*</span></label>
                <input type="text" name="pic" value="{{ old('pic') }}" required placeholder="Nama penanggung jawab" class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Upload File <span style="color:var(--text-muted);font-weight:400;">(Opsional)</span></label>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="gaming-input" style="padding:0.5rem;">
                <p class="text-xs mt-1" style="color:var(--text-muted);">Format: PDF, DOC, DOCX, XLS, XLSX (maks. 10MB)</p>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan Draft</button>
                <a href="{{ route('koordinator.meetings.show', $meeting) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
