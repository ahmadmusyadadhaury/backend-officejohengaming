@extends('layouts.app')
@section('title', 'Kelola Aset')
@section('page-title', 'Overview > Kelola Aset')
@section('page-subtitle', 'Kelola aset dan inventaris perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $assetStats['total_assets'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Kendaraan</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Jumlah seluruh aset</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $assetStats['pajak_aktif'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Pajak Aktif</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Aset dengan pajak aktif</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:0 0 16px rgba(239,68,68,0.2);">
                <svg class="w-6 h-6" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#ef4444;">{{ $assetStats['pajak_mati'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Pajak Mati</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Aset dengan pajak expired</div>
            </div>
        </div>
    </div>

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
                                <a href="{{ route('admin.export', ['type' => 'assets']) }}" class="btn btn-secondary btn-sm" style="padding:4px 8px;line-height:1;" title="Download Excel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
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
