@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Tambah Ruangan')
@section('page-title', 'Tambah Ruangan Baru')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="gaming-label">Nama Ruangan <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Meeting Room Utama" class="gaming-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="gaming-label">Kapasitas <span style="color:#f87171;">*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', 50) }}" required min="1" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Lokasi <span style="color:#f87171;">*</span></label>
                    <input type="text" name="location" value="{{ old('location') }}" required placeholder="Contoh: Lantai 1" class="gaming-input">
                </div>
            </div>
            <div>
                <label class="gaming-label">Fasilitas <span style="color:var(--text-muted);font-weight:400;">(satu per baris)</span></label>
                <textarea name="facilities" rows="4" placeholder="Proyektor&#10;TV&#10;Speaker&#10;Whiteboard" class="gaming-input" style="resize:vertical;">{{ old('facilities') }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Deskripsi</label>
                <textarea name="description" rows="2" class="gaming-input" style="resize:vertical;">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Khusus Divisi <span style="color:var(--text-muted);font-weight:400;">(biarkan Umum jika tidak dipilih)</span></label>
                <select name="team_id" class="gaming-input gaming-select">
                    <option value="">— Umum (Semua Akses) —</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs mt-1" style="color:var(--text-muted);">Hanya koordinator dari divisi ini yang bisa melihat dan memesan ruangan.</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="is_active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Ruangan Aktif</label>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
