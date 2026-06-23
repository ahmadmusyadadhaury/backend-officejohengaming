@extends('layouts.app')
@section('title', 'Kelola Tim')
@section('page-title', 'Overview > Kelola Tim')
@section('page-subtitle', 'Organisir tim dan departemen perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    <div class="flex justify-end">
        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Tim
        </a>
    </div>
    <div class="gaming-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[600px]">
                <thead>
                    <tr>
                        <th>Nama Tim</th>
                        <th>Deskripsi</th>
                        <th>Anggota</th>
                        <th>Kepala Tim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                    <tr>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $team->name }}</td>
                        <td style="color:var(--text-muted);">{{ $team->description ?? '—' }}</td>
                        <td>
                            <span class="badge badge-blue">{{ $team->members_count }} orang</span>
                        </td>
                        <td style="color:var(--text-muted);">{{ $team->leader?->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $team->is_active ? 'badge-green' : 'badge-red' }}">
                                {{ $team->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="{{ route('admin.export', ['type' => 'teams']) }}" class="btn btn-secondary btn-sm" style="padding:4px 8px;line-height:1;" title="Download Excel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.teams.destroy', $team) }}" onsubmit="return confirm('Hapus tim ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada tim.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);">{{ $teams->links() }}</div>
    </div>
</div>
@endsection
