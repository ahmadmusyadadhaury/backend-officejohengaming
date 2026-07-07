@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Tambah Tim')
@section('page-title', 'Tambah Tim Baru')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.teams.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="gaming-label">Nama Tim <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Tim Konten" class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Deskripsi singkat tentang tim ini..." class="gaming-input" style="resize:vertical;">{{ old('description') }}</textarea>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
