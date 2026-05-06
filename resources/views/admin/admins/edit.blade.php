@extends('layouts.app')
@section('title', 'Edit Admin')
@section('page-title', 'Edit Akun Admin')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.admins.update', $admin) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                <input type="text" name="username" value="{{ old('username', $admin->username) }}" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Role Admin <span style="color:#f87171;">*</span></label>
                <select name="role" required class="gaming-input gaming-select">
                    <option value="admin"         {{ $admin->role === 'admin'         ? 'selected' : '' }}>Admin Master</option>
                    <option value="head_of_store" {{ $admin->role === 'head_of_store' ? 'selected' : '' }}>Head of Store</option>
                    <option value="gm"            {{ $admin->role === 'gm'            ? 'selected' : '' }}>General Manager (GM)</option>
                    <option value="hr"            {{ $admin->role === 'hr'            ? 'selected' : '' }}>HR (Human Resources)</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $admin->is_active ? 'checked' : '' }} style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="is_active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
