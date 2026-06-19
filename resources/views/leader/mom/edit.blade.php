@extends('layouts.app')
@section('title', 'Edit MOM')
@section('page-title', 'Edit Minutes of Meeting')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-2xl animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('koordinator.mom.update', $mom) }}" class="space-y-4">
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
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('koordinator.meetings.show', $mom->meeting_id) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
