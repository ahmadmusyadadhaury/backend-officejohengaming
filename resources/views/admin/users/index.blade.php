@extends('layouts.app')
@section('title', 'Kelola User')
@section('page-title', 'Kelola User')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2">
    <div class="flex justify-between items-center mb-4">
        <p class="text-sm text-gray-500">Total: {{ $users->total() }} user</p>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Tambah User</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-4 py-3 text-left">NIK</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Tim</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-xs">{{ $user->nik }}</td>
                    <td class="px-4 py-3 font-medium">{{ $user->name }}
                        @if($user->is_leader) <span class="ml-1 text-xs bg-accent/10 text-accent px-1.5 py-0.5 rounded-full">Kepala Tim</span> @endif
                    </td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $user->role === 'leader' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($user->role) }}</span></td>
                    <td class="px-4 py-3 text-gray-500">{{ $user->team?->name ?? '-' }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1 bg-secondary/10 text-secondary rounded text-xs hover:bg-secondary hover:text-white transition">Edit</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-50 text-red-600 rounded text-xs hover:bg-red-600 hover:text-white transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $users->links() }}</div>
    </div>
</div>
@endsection
