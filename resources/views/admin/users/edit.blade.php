@extends('layouts.app')
@section('title', 'Edit Akun')
@section('page-title', 'Edit Akun')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400 text-xs">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role" id="role" required onchange="toggleTeam(this.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                    <option value="koordinator" {{ $user->role === 'koordinator' ? 'selected' : '' }}>Koordinator</option>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Karyawan</option>
                </select>
            </div>
            <div id="team-field" class="{{ in_array($user->role, ['koordinator','user']) ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tim</label>
                <select name="team_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
                    <option value="">Pilih Tim</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ $user->team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="w-4 h-4 text-accent rounded border-gray-300">
                <label for="is_active" class="text-sm text-gray-700">Akun Aktif</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleTeam(role) {
        const teamField = document.getElementById('team-field');
        teamField.classList.toggle('hidden', !['koordinator', 'user'].includes(role));
    }
</script>
@endpush
