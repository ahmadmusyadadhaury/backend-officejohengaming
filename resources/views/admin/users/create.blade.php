@extends('layouts.app')
@section('title', 'Tambah Akun')
@section('page-title', 'Tambah Akun Baru')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
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
                <label class="gaming-label">Role <span style="color:#f87171;">*</span></label>
                <select name="role" id="role" required onchange="toggleTeam(this.value)" class="gaming-input gaming-select">
                    <option value="">Pilih Role</option>
                    <option value="koordinator" {{ old('role') === 'koordinator' ? 'selected' : '' }}>Koordinator</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Karyawan</option>
                </select>
            </div>
            <div id="team-field" class="{{ in_array(old('role'), ['koordinator','user']) ? '' : 'hidden' }}">
                <label class="gaming-label">Tim <span style="color:#f87171;">*</span></label>
                <select name="team_id" class="gaming-input gaming-select">
                    <option value="">Pilih Tim</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
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
