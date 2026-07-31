@extends('layouts.app')
@section('title', 'Kategori Ticket')
@section('page-title', 'Kategori Ticket')
@section('page-subtitle', 'Kelola kategori bantuan IT')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="tk tk-stack">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
        {{-- Tambah --}}
        <div class="tk-card p-4">
            <p class="tk-eyebrow mb-2">Kelola</p>
            <h3 class="tk-h mb-3">Tambah Kategori</h3>
            <form method="POST" action="{{ route('ticket.categories.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Nama Kategori</label>
                    <input type="text" name="name" required maxlength="191" placeholder="Contoh: Hardware" class="gaming-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Deskripsi</label>
                    <textarea name="description" rows="3" maxlength="500" placeholder="Deskripsi singkat kategori" class="gaming-input"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm w-full">+ Tambah Kategori</button>
            </form>
        </div>

        {{-- Daftar --}}
        <div class="lg:col-span-2 tk-card p-3 overflow-x-auto">
            @if($categories->isEmpty())
            <div class="tk-empty">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p>Belum ada kategori.</p>
            </div>
            @else
            <table class="tk-table w-full">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Ticket</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td class="text-sm font-semibold" style="color:var(--tk-text);">{{ $category->name }}</td>
                        <td class="text-xs" style="color:var(--tk-muted);">{{ $category->description ?? '-' }}</td>
                        <td><span class="tk-slip" style="color:var(--tk-muted);background:var(--tk-bg-soft);border-color:var(--tk-border);">{{ $category->tickets_count }}</span></td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <button type="button" onclick="openEditModal({{ $category->id }}, {{ json_encode($category->name) }}, {{ json_encode($category->description) }})" class="btn btn-sm btn-secondary">Edit</button>
                                <form method="POST" action="{{ route('ticket.categories.destroy', $category) }}" data-confirm="Hapus kategori '{{ $category->name }}'?" onsubmit="confirmSubmit(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $categories->links() }}</div>
            @endif
        </div>
    </div>
</div>

<div id="edit-category-modal" class="modal-modern" onclick="if(event.target===this)closeModal('edit-category-modal')">
    <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Kategori</h3>
            <button type="button" onclick="closeModal('edit-category-modal')" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-category-form" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="modal-modern-body space-y-3">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Nama Kategori</label>
                    <input type="text" name="name" id="edit-name" required maxlength="191" class="gaming-input">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Deskripsi</label>
                    <textarea name="description" id="edit-description" rows="3" maxlength="500" class="gaming-input"></textarea>
                </div>
            </div>
            <div class="modal-modern-footer justify-end">
                <button type="button" onclick="closeModal('edit-category-modal')" class="btn btn-sm btn-secondary">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditModal(id, name, description) {
        document.getElementById('edit-category-form').action = '{{ route('ticket.categories.update', ':id') }}'.replace(':id', id);
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-description').value = description || '';
        openModal('edit-category-modal');
    }
</script>
@endpush
