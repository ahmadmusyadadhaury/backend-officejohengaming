@extends('layouts.app')
@section('title', 'Edit Akun')
@section('page-title', 'Edit Akun')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Nama Lengkap <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="gaming-input">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Username <span style="color:#f87171;">*</span></label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="gaming-input">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="gaming-input">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Role</label>
                <select name="role" id="role" onchange="toggleTeam(this.value)" class="gaming-input gaming-select">
                    <option value="koordinator" {{ $user->role === 'koordinator' ? 'selected' : '' }}>Koordinator</option>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Karyawan</option>
                </select>
            </div>
            <div id="team-field" class="{{ in_array($user->role, ['koordinator','user']) ? '' : 'hidden' }}">
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Tim</label>
                <select name="team_id" class="gaming-input gaming-select">
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ $user->team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}
                    style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="is_active" style="font-size:0.85rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function toggleTeam(role) {
        document.getElementById('team-field').classList.toggle('hidden', !['koordinator','user'].includes(role));
    }
</script>
@endpush
