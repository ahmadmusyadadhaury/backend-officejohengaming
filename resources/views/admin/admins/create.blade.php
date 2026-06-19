@extends('layouts.app')
@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Akun Admin')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.admins.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Password <span style="color:#f87171;">*</span></label>
                <input type="password" name="password" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Role Admin <span style="color:#f87171;">*</span></label>
                <select name="role" required class="gaming-input gaming-select">
                    <option value="">Pilih Role</option>
                    <option value="admin"         {{ old('role') === 'admin'         ? 'selected' : '' }}>Admin Master</option>
                    <option value="head_of_store" {{ old('role') === 'head_of_store' ? 'selected' : '' }}>Head of Store</option>
                    <option value="gm"            {{ old('role') === 'gm'            ? 'selected' : '' }}>General Manager (GM)</option>
                    <option value="ceo"           {{ old('role') === 'ceo'           ? 'selected' : '' }}>Chief Executive Officer (CEO)</option>
                    <option value="hr"            {{ old('role') === 'hr'            ? 'selected' : '' }}>HR (Human Resources)</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
