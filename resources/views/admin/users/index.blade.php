@extends('layouts.app')
@section('title', 'Kelola Akun')
@section('page-title', 'Overview > Kelola Akun')
@section('page-subtitle', 'Kelola akun pengguna sistem')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- BREAKDOWN AKUN --}}
    <div>
        <h3 class="text-xs font-gaming font-bold uppercase tracking-widest mb-3" style="color:var(--text-muted);">Breakdown Akun</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
            @php
                $items = [
                    ['label' => 'Chief Executive Officer', 'short' => 'CEO', 'count' => $breakdown['total_ceo'], 'bg' => 'linear-gradient(135deg,#8b5cf6,#a855f7)', 'accent' => '#a855f7'],
                    ['label' => 'General Manager', 'short' => 'GM', 'count' => $breakdown['total_gm'], 'bg' => 'linear-gradient(135deg,#f59e0b,#fbbf24)', 'accent' => '#fbbf24'],
                    ['label' => 'Head of Store', 'short' => 'Head Store', 'count' => $breakdown['total_head_store'], 'bg' => 'linear-gradient(135deg,#7c3aed,#a855f7)', 'accent' => '#a855f7'],
                    ['label' => 'Human Resources', 'short' => 'HR', 'count' => $breakdown['total_hr'], 'bg' => 'linear-gradient(135deg,#ec4899,#f472b6)', 'accent' => '#f472b6'],
                    ['label' => 'Koordinator', 'short' => 'Koordinator', 'count' => $breakdown['total_koordinator'], 'bg' => 'linear-gradient(135deg,#3b82f6,#60a5fa)', 'accent' => '#60a5fa'],
                    ['label' => 'Karyawan', 'short' => 'Karyawan', 'count' => $breakdown['total_karyawan'], 'bg' => 'linear-gradient(135deg,#1e40af,#3b82f6)', 'accent' => '#60a5fa'],
                    ['label' => 'Total Tim', 'short' => 'Total Tim', 'count' => $breakdown['total_team'], 'bg' => 'linear-gradient(135deg,#06b6d4,#22d3ee)', 'accent' => '#22d3ee'],
                ];
            @endphp
            @foreach($items as $item)
            <div class="gaming-card p-4 flex flex-col items-center text-center gap-2" style="border-top:2px solid {{ $item['accent'] }};">
                <div class="text-2xl font-gaming font-bold leading-none" style="color:var(--text-primary);">{{ $item['count'] }}</div>
                <div class="text-xs font-medium leading-tight" style="color:var(--text-muted);">{{ $item['short'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

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
