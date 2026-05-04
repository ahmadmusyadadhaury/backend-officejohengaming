@extends('layouts.app')
@section('title', 'Kelola Admin')
@section('page-title', 'Kelola Admin')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2">
    <div class="flex justify-between items-center mb-4">
        <p class="text-sm text-gray-500">Total: {{ $admins->total() }} akun admin</p>
        <a href="{{ route('admin.admins.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Tambah Admin</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Username</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $admin->name }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $admin->username }}</td>
                    <td class="px-4 py-3">
                        @php
                            $roleColor = match($admin->role) {
                                'admin'         => 'bg-purple-100 text-purple-700',
                                'head_of_store' => 'bg-blue-100 text-blue-700',
                                'gm'            => 'bg-indigo-100 text-indigo-700',
                                'hr'            => 'bg-green-100 text-green-700',
                                default         => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $roleColor }}">
                            {{ $admin->role_label }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $admin->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $admin->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        @if($admin->id !== auth()->id())
                            <a href="{{ route('admin.admins.edit', $admin) }}" class="px-3 py-1 bg-secondary/10 text-secondary rounded text-xs hover:bg-secondary hover:text-white transition">Edit</a>
                            <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}" onsubmit="return confirm('Hapus akun admin ini?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 bg-red-50 text-red-600 rounded text-xs hover:bg-red-600 hover:text-white transition">Hapus</button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400 italic">Akun kamu</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada akun admin.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $admins->links() }}</div>
    </div>
</div>
@endsection
