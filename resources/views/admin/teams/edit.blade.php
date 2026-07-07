@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Edit Tim')
@section('page-title', 'Edit Tim')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.teams.update', $team) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="gaming-label">Nama Tim <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $team->name) }}" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Deskripsi</label>
                <textarea name="description" rows="3" class="gaming-input" style="resize:vertical;">{{ old('description', $team->description) }}</textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $team->is_active ? 'checked' : '' }} style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="is_active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Tim Aktif</label>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
