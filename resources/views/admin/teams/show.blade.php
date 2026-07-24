@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Detail Tim')
@section('page-title', 'Overview > Kelola Tim > Detail')
@section('page-subtitle', $team->name)
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        @if(auth()->user()->role !== 'gm')
        <button type="button" onclick="openAddMemberModal()" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Tambah Anggota
        </button>
        @endif
    </div>

    {{-- Info Tim --}}
    <div class="gaming-card overflow-hidden">
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">INFO TIM</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs font-medium mb-1" style="color:var(--text-muted);">Nama Tim</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $team->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium mb-1" style="color:var(--text-muted);">Deskripsi</p>
                    <p class="text-sm" style="color:var(--text-primary);">{{ $team->description ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium mb-1" style="color:var(--text-muted);">Status</p>
                    <span class="badge {{ $team->is_active ? 'badge-green' : 'badge-red' }}">
                        {{ $team->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-medium mb-1" style="color:var(--text-muted);">Kepala Tim</p>
                    <p class="text-sm" style="color:var(--text-primary);">{{ $team->leader?->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium mb-1" style="color:var(--text-muted);">Jumlah Anggota</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $team->members->count() }} orang</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Anggota --}}
    <div class="gaming-card overflow-hidden">
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">ANGGOTA TIM</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[500px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        @if(auth()->user()->role !== 'gm')
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($team->members as $member)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">
                            <div class="flex items-center gap-2">
                                @if($member->avatar_url)
                                    <img src="{{ $member->avatar_url }}" alt="" class="w-7 h-7 rounded-full object-cover flex-shrink-0">
                                @else
                                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                        style="background:linear-gradient(135deg,var(--color-accent),var(--color-secondary));">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </span>
                                @endif
                                {{ $member->name }}
                            </div>
                        </td>
                        <td style="color:var(--text-muted);">{{ $member->username }}</td>
                        <td>
                            <span class="badge {{ $member->role === 'koordinator' ? 'badge-purple' : 'badge-blue' }}">
                                {{ $member->role_label }}
                            </span>
                        </td>
                        @if(auth()->user()->role !== 'gm')
                        <td>
                            <form method="POST" action="{{ route('admin.teams.members.destroy', [$team, $member]) }}"
                                onsubmit="confirmSubmit(event, this)" data-confirm="Hapus {{ $member->name }} dari tim ini?">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" style="padding:4px 10px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/>
                                    </svg>
                                    Keluarkan
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">
                            Belum ada anggota di tim ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Anggota --}}
<div id="add-member-modal" class="modal-modern" onclick="if(event.target===this)closeAddMemberModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Anggota ke {{ $team->name }}</h3>
            <button type="button" onclick="closeAddMemberModal()" class="modal-modern-close">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.teams.members.store', $team) }}">
            @csrf
            <div class="modal-modern-body space-y-4">
                @if($availableUsers->isEmpty())
                    <div class="text-center py-6">
                        <p class="text-sm" style="color:var(--text-muted);">Tidak ada user tersedia yang bisa ditambahkan.</p>
                        <p class="text-xs mt-1" style="color:var(--text-muted);">Semua user aktif sudah tergabung di tim lain.</p>
                    </div>
                @else
                    <div>
                        <label class="gaming-label">Pilih Anggota <span style="color:#f87171;">*</span></label>
                        <select name="user_id" id="add-member-select" required class="gaming-input" style="width:100%;">
                            <option value="">— Pilih User —</option>
                            @foreach($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->username }}) — {{ $user->role_label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="selected-info" class="hidden">
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                            <div id="selected-avatar" class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                style="background:linear-gradient(135deg,var(--color-accent),var(--color-secondary));"></div>
                            <div>
                                <p id="selected-name" class="text-sm font-semibold" style="color:var(--text-primary);"></p>
                                <p id="selected-role" class="text-xs" style="color:var(--text-muted);"></p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-modern-footer gap-2">
                @if(!$availableUsers->isEmpty())
                <button type="submit" class="btn btn-primary">Tambahkan</button>
                @endif
                <button type="button" onclick="closeAddMemberModal()" class="btn btn-secondary">Tutup</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddMemberModal() {
    openModal('add-member-modal');
    var sel = document.getElementById('add-member-select');
    if (sel) {
        sel.value = '';
        sel.dispatchEvent(new Event('change'));
    }
}
function closeAddMemberModal() {
    closeModal('add-member-modal');
}

var usersData = @json($availableUsersJson);

document.getElementById('add-member-modal')?.addEventListener('click', function(e) { if (e.target === this) closeAddMemberModal(); });

var selEl = document.getElementById('add-member-select');
if (selEl) {
    selEl.addEventListener('change', function() {
        var info = document.getElementById('selected-info');
        var u = usersData.find(i => i.id == this.value);
        if (u) {
            document.getElementById('selected-avatar').textContent = u.initial;
            document.getElementById('selected-name').textContent = u.name;
            document.getElementById('selected-role').textContent = u.role;
            info.classList.remove('hidden');
        } else {
            info.classList.add('hidden');
        }
    });
}

document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeAddMemberModal(); });
</script>

@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection
