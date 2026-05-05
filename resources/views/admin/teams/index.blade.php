@extends('layouts.app')
@section('title', 'Kelola Tim')
@section('page-title', 'Kelola Tim')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2">
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.teams.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Tambah Tim</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[600px]">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Tim</th>
                    <th class="px-4 py-3 text-left">Deskripsi</th>
                    <th class="px-4 py-3 text-left">Jumlah Anggota</th>
                    <th class="px-4 py-3 text-left">Kepala Tim</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($teams as $team)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $team->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $team->description ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $team->members_count }} orang</td>
                    <td class="px-4 py-3 text-gray-600">{{ $team->leader?->name ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $team->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $team->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.teams.edit', $team) }}" class="px-3 py-1 bg-secondary/10 text-secondary rounded text-xs hover:bg-secondary hover:text-white transition">Edit</a>
                        <form method="POST" action="{{ route('admin.teams.destroy', $team) }}" onsubmit="return confirm('Hapus tim ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-50 text-red-600 rounded text-xs hover:bg-red-600 hover:text-white transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada tim.</td></tr>
                @endforelse
            </tbody>
        </table>
        </table>
        </div>
        <div class="px-4 py-3 border-t">{{ $teams->links() }}</div>
    </div>
</div>
@endsection
