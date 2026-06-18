@extends('layouts.app')
@section('title', 'Kelola Aset')
@section('page-title', 'Overview > Kelola Aset')
@section('page-subtitle', 'Kelola aset dan inventaris perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    <div class="flex justify-end">
        <a href="{{ route('admin.assets.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Aset
        </a>
    </div>
    <div class="gaming-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[500px]">
                <thead>
                    <tr>
                        <th>Nama Aset</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                    <tr>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $asset->name }}</td>
                        <td style="color:var(--text-muted);">{{ $asset->description ?? '—' }}</td>
                        <td>
                            <span class="badge badge-cyan">{{ $asset->quantity }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $asset->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $asset->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.assets.edit', $asset) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.assets.destroy', $asset) }}" onsubmit="return confirm('Hapus aset ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada aset.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $assets->links() }}</div>
    </div>
</div>
@endsection
