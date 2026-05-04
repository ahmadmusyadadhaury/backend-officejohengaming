@extends('layouts.app')
@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Akun Admin')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('admin.admins.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role Admin <span class="text-red-500">*</span></label>
                <select name="role" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                    <option value="">Pilih Role</option>
                    <option value="admin"         {{ old('role') === 'admin'         ? 'selected' : '' }}>Admin Master</option>
                    <option value="head_of_store" {{ old('role') === 'head_of_store' ? 'selected' : '' }}>Head of Store</option>
                    <option value="gm"            {{ old('role') === 'gm'            ? 'selected' : '' }}>General Manager (GM)</option>
                    <option value="hr"            {{ old('role') === 'hr'            ? 'selected' : '' }}>HR (Human Resources)</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">Buat Akun</button>
                <a href="{{ route('admin.admins.index') }}" class="px-5 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
