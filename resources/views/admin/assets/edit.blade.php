@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Edit Aset')
@section('page-title', 'Edit Aset')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.assets.update', $asset) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="gaming-label">Nama Aset <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $asset->name) }}" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Deskripsi</label>
                <textarea name="description" rows="2" class="gaming-input" style="resize:vertical;">{{ old('description', $asset->description) }}</textarea>
            </div>
            <div>
                <label class="gaming-label">Jumlah <span style="color:#f87171;">*</span></label>
                <input type="number" name="quantity" value="{{ old('quantity', $asset->quantity) }}" required min="1" class="gaming-input">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $asset->is_active ? 'checked' : '' }} style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="is_active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Aset Aktif</label>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
