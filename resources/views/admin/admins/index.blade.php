@extends('layouts.app')
@section('title', 'Kelola Admin')
@section('page-title', 'Kelola Admin')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    <div class="flex justify-between items-center">
        <p class="text-sm" style="color:var(--text-muted);">Total: <span style="color:var(--text-primary);font-weight:600;">{{ $admins->total() }}</span> akun admin</p>
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Admin
        </a>
    </div>
    <div class="gaming-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[500px]">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $admin->name }}</td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;">{{ $admin->username }}</code></td>
                        <td>
                            @php
                                $roleClass = match($admin->role) {
                                    'admin'         => 'badge-primary',
                                    'head_of_store' => 'badge-blue',
                                    'gm'            => 'badge-cyan',
                                    'hr'            => 'badge-green',
                                    default         => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $roleClass }}">{{ $admin->role_label }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $admin->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $admin->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            @if($admin->id !== auth()->id())
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" onsubmit="return confirm('Hapus akun admin ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            @else
                                <span class="badge badge-gray">Akun kamu</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada akun admin.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $admins->links() }}</div>
    </div>
</div>
@endsection
