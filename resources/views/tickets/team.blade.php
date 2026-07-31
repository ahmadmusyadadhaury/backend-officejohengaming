@extends('layouts.app')
@section('title', 'Tim IT')
@section('page-title', 'Tim IT')
@section('page-subtitle', 'Kelola anggota tim helpdesk')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="tk tk-stack">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
        {{-- Tambah anggota --}}
        <div class="tk-card p-4">
            <p class="tk-eyebrow mb-2">Kelola</p>
            <h3 class="tk-h mb-3">Tambah Anggota</h3>
            <form method="POST" action="{{ route('ticket.team.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Pilih User</label>
                    <select name="user_id" required class="gaming-select">
                        <option value="">— Pilih User —</option>
                        @foreach($candidates as $candidate)
                        <option value="{{ $candidate->id }}">{{ $candidate->name }} ({{ $candidate->role_label }})</option>
                        @endforeach
                    </select>
                </div>
                <label class="flex items-center gap-2 text-xs" style="color:var(--tk-text); cursor:pointer;">
                    <input type="checkbox" name="is_leader" value="1" class="rounded">
                    Jadikan Leader IT (dapat menugaskan & konfigurasi)
                </label>
                <button type="submit" class="btn btn-primary btn-sm w-full">+ Tambah Anggota</button>
            </form>
            <div class="mt-4 pt-4 rounded-xl" style="border-top:1px solid var(--tk-border);">
                <p class="tk-eyebrow mb-1">Info</p>
                <p class="tk-note">Admin (role <strong>admin</strong>) otomatis dianggap anggota & leader tim IT. Semua role lain harus ditambahkan di sini untuk mengelola ticket.</p>
            </div>
        </div>

        {{-- Daftar anggota --}}
        <div class="lg:col-span-2 tk-card p-3 overflow-x-auto">
            @if($members->isEmpty())
            <div class="tk-empty">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p>Belum ada anggota tim IT.</p>
            </div>
            @else
            <table class="tk-table w-full">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td class="text-sm font-semibold" style="color:var(--tk-text);">{{ $member->user?->name }}</td>
                        <td class="text-xs" style="color:var(--tk-muted);">{{ $member->user?->role_label }}</td>
                        <td>
                            <form method="POST" action="{{ route('ticket.team.update', $member) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="is_leader" value="{{ $member->is_leader ? 0 : 1 }}"
                                    class="text-[0.62rem] font-bold px-2 py-1 rounded-full transition" style="background:none;border:none;cursor:pointer;background:{{ $member->is_leader ? 'var(--tk-accent-soft)' : 'var(--tk-bg-soft)' }};color:{{ $member->is_leader ? 'var(--tk-accent)' : 'var(--tk-muted)' }};">
                                    {{ $member->is_leader ? 'Leader' : 'Anggota' }}
                                </button>
                            </form>
                        </td>
                        <td class="tk-mono text-xs" style="color:var(--tk-muted);">{{ $member->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('ticket.team.destroy', $member) }}" data-confirm="Hapus {{ $member->user?->name }} dari tim IT?" onsubmit="confirmSubmit(event, this)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
