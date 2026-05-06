@extends('layouts.app')
@section('title', 'Kelola Akun')
@section('page-title', 'Kelola Akun')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    <div class="flex justify-between items-center">
        <p class="text-sm" style="color:var(--text-muted);">Total: <span style="color:var(--text-primary);font-weight:600;">{{ $users->total() }}</span> akun</p>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Akun
        </a>
    </div>
    <div class="gaming-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[600px]">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Tim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $user->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $user->username }}</code></td>
                        <td>
                            <span class="badge {{ $user->role === 'koordinator' ? 'badge-primary' : 'badge-gray' }}">
                                {{ $user->role_label }}
                            </span>
                        </td>
                        <td style="color:var(--text-muted);">{{ $user->team?->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada akun.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $users->links() }}</div>
    </div>
</div>
@endsection
