@extends('layouts.app')
@section('body-class', 'page-leader')
@section('title', 'Edit MOM')
@section('page-title', 'Edit Minutes of Meeting')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-2xl animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('koordinator.mom.update', $mom) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="gaming-label">Ringkasan Pembahasan <span style="color:#f87171;">*</span></label>
                <textarea name="summary" rows="3" required class="gaming-input" style="resize:vertical;">{{ old('summary', $mom->summary) }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Keputusan <span style="color:#f87171;">*</span></label>
                <textarea name="decisions" rows="3" required class="gaming-input" style="resize:vertical;">{{ old('decisions', $mom->decisions) }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Action Plan <span style="color:#f87171;">*</span></label>
                <textarea name="action_plan" rows="3" required class="gaming-input" style="resize:vertical;">{{ old('action_plan', $mom->action_plan) }}</textarea>
            </div>
            <div>
                <label class="gaming-label">PIC <span style="color:#f87171;">*</span></label>
                <input type="text" name="pic" value="{{ old('pic', $mom->pic) }}" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Upload File <span style="color:var(--text-muted);font-weight:400;">(Opsional)</span></label>
                @if($mom->file_path)
                <div class="flex items-center gap-2 mb-2 p-2 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                    <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <a href="{{ route('files.show', $mom->file_path) }}" target="_blank" class="text-sm font-medium" style="color:var(--color-accent-light);">File saat ini</a>
                </div>
                @endif
                <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="gaming-input" style="padding:0.5rem;">
                <p class="text-xs mt-1" style="color:var(--text-muted);">Format: PDF, DOC, DOCX, XLS, XLSX (maks. 10MB). Upload ulang untuk mengganti file.</p>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('koordinator.meetings.show', $mom->meeting_id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
