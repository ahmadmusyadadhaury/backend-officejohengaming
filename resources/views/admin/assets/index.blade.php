@extends('layouts.app')
@section('title', 'Kelola Aset')
@section('page-title', 'Kelola Aset')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2">
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.assets.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Tambah Aset</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Aset</th>
                    <th class="px-4 py-3 text-left">Deskripsi</th>
                    <th class="px-4 py-3 text-left">Jumlah</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($assets as $asset)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $asset->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $asset->description ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $asset->quantity }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $asset->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $asset->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.assets.edit', $asset) }}" class="px-3 py-1 bg-secondary/10 text-secondary rounded text-xs hover:bg-secondary hover:text-white transition">Edit</a>
                        <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}" onsubmit="return confirm('Hapus aset ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-50 text-red-600 rounded text-xs hover:bg-red-600 hover:text-white transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada aset.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $assets->links() }}</div>
    </div>
</div>
@endsection
