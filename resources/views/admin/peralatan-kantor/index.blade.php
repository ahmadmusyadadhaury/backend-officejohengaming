@extends('layouts.app')
@section('title', 'Peralatan Kantor')
@section('page-title', 'Data Aset > Peralatan Kantor')
@section('page-subtitle', 'Inventaris peralatan kantor milik perusahaan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- 4 Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-primary);">Total Peralatan</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh peralatan kantor</div>
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
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $stats['kondisi_baik'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Kondisi Baik</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Peralatan dalam kondisi baik</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:0 0 16px rgba(245,158,11,0.2);">
                <svg class="w-6 h-6" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;">{{ $stats['perlu_servis'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Perlu Servis</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Peralatan perlu perbaikan</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:0 0 16px rgba(239,68,68,0.2);">
                <svg class="w-6 h-6" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#ef4444;">{{ $stats['rusak'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Rusak</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Peralatan dalam kondisi rusak</div>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Peralatan Kantor</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Inventaris peralatan kantor milik perusahaan.</div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Peralatan
                </button>
            </div>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-item" placeholder="Cari nama barang atau PIC" oninput="filterItems()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <button type="button" onclick="openImportModal()" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Import Excel
                </button>
                <a href="{{ route('admin.export', ['type' => 'peralatan-kantor', 'filter' => 'all']) }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">Download Excel</a>
                <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Kondisi</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Kondisi</button>
                    <button type="button" data-value="baik" onclick="setFilter('baik')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Kondisi Baik</button>
                    <button type="button" data-value="perlu_servis" onclick="setFilter('perlu_servis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Perlu Servis</button>
                    <button type="button" data-value="rusak" onclick="setFilter('rusak')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Rusak</button>
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[700px]" id="item-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>PIC</th>
                        <th class="hidden md:table-cell">Lokasi Unit</th>
                        <th class="hidden md:table-cell">Nilai (Setelah Penyusutan)</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="item-tbody">
                    @forelse($items as $i)
                    @php
                        $kondisiBadge = match($i->kondisi) {
                            'baik'        => 'badge-green',
                            'perlu_servis' => 'badge-yellow',
                            'rusak'       => 'badge-red',
                            default       => 'badge-gray',
                        };
                        $kondisiLabel = match($i->kondisi) {
                            'baik'        => 'Baik',
                            'perlu_servis' => 'Perlu Servis',
                            'rusak'       => 'Rusak',
                            default       => '-',
                        };
                        $masaBarang = max($i->estimasi_waktu_barang ?: 360, 1);
                        $penyusutanPerHari = $i->nilai / $masaBarang;
                        $hariTerpakai = $i->tanggal_pembelian ? max(abs(now()->diffInDays($i->tanggal_pembelian)), 0) : 0;
                        $nilaiSekarang = max($i->nilai - ($penyusutanPerHari * $hariTerpakai), 0);
                    @endphp
                    <tr data-kondisi="{{ $i->kondisi }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $i->nama_barang }}</td>
                        <td style="color:var(--text-muted);">{{ $i->pic }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $i->lokasi_unit }}</td>
                        <td class="hidden md:table-cell" style="color:{{ $nilaiSekarang > 0 ? 'var(--text-primary)' : '#ef4444' }};font-weight:500;">Rp {{ number_format($nilaiSekarang, 0, ',', '.') }}</td>
                        <td><span class="badge {{ $kondisiBadge }}">{{ $kondisiLabel }}</span></td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $i->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $i->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $i->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.peralatan-kantor.destroy', $i) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus peralatan ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data peralatan kantor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-5xl rounded-[22px] shadow-2xl flex flex-col" style="max-height:90vh;background:var(--bg-surface);border:1px solid var(--border-color);" onclick="event.stopPropagation()">
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <button onclick="closeDetail()" style="color:var(--text-muted);background:none;border:none;cursor:pointer;padding:6px 10px;border-radius:10px;display:flex;align-items:center;gap:6px;font-size:13px;transition:all 0.15s;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7 7-7"/></svg>
                Kembali
            </button>
            <div class="flex items-center gap-2">
                <button id="detail-edit-btn" onclick="openEditModal(currentDetailId)" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;cursor:pointer;">Edit</button>
                <form id="detail-delete-form" method="POST" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus peralatan ini?" data-action="{{ url('admin/peralatan-kantor') }}/" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);cursor:pointer;">Hapus</button>
                </form>
                <button onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        {{-- Title + Badge --}}
        <div class="px-6 pt-5 pb-2 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold" style="color:var(--text-primary);" id="detail-title"></h3>
                    <p class="text-sm mt-1" style="color:var(--text-muted);">Detail lengkap peralatan kantor</p>
                </div>
                <span id="detail-badge" class="badge" style="font-size:0.75rem;padding:4px 14px;"></span>
            </div>
        </div>
        {{-- Body --}}
        <div class="px-6 py-4 overflow-y-auto flex-1" id="detail-body" style="scrollbar-width:thin;"></div>
    </div>
</div>

{{-- Modal Tambah / Edit Peralatan Kantor (6 Step) --}}
<div id="item-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[520px] rounded-3xl shadow-2xl flex flex-col" style="max-height:95vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="modal-title">Tambah Peralatan</h3>
            <button type="button" onclick="closeModal('item-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Steps Indicator --}}
        <div class="px-6 pt-4 pb-2 flex-shrink-0">
            <div class="flex items-center gap-1 text-xs font-semibold" id="step-indicator">
                <div class="step-dot active" data-step="1">1</div>
                <div class="step-line" data-step="1"></div>
                <div class="step-dot" data-step="2">2</div>
                <div class="step-line" data-step="2"></div>
                <div class="step-dot" data-step="3">3</div>
                <div class="step-line" data-step="3"></div>
                <div class="step-dot" data-step="4">4</div>
                <div class="step-line" data-step="4"></div>
                <div class="step-dot" data-step="5">5</div>
                <div class="step-line" data-step="5"></div>
                <div class="step-dot" data-step="6">6</div>
            </div>
        </div>

        {{-- Body --}}
        <div class="px-6 py-4 overflow-y-auto flex-1">
            <form id="item-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">
                <input type="hidden" name="kondisi" id="f-kondisi" value="baik">

                {{-- Step 1 --}}
                <div class="step-content" id="step-1">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Informasi Umum</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Data dasar barang</p>
                    <div class="space-y-4">
                        <div>
                            <label class="gaming-label">Nama Barang <span style="color:#f87171;">*</span></label>
                            <input type="text" name="nama_barang" id="f-nama_barang" required placeholder="Masukan nama barang" class="gaming-input">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Jumlah <span style="color:#f87171;">*</span></label>
                                <input type="number" name="jumlah" id="f-jumlah" required placeholder="Masukan jumlah unit" class="gaming-input" min="1">
                            </div>
                            <div>
                                <label class="gaming-label">Sub Kategori <span style="color:#f87171;">*</span></label>
                                <select name="sub_kategori" id="f-sub_kategori" required class="gaming-input">
                                    <option value="Peralatan Kantor">Peralatan Kantor</option>
                                    <option value="Alat Tulis">Alat Tulis</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="gaming-label">Detail <span style="color:#f87171;">*</span></label>
                            <textarea name="detail" id="f-detail" required placeholder="Masukan detail barang" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                        </div>
                        <div>
                            <label class="gaming-label">Keterangan</label>
                            <textarea name="keterangan" id="f-keterangan" placeholder="Masukan keterangan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="step-content hidden" id="step-2">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Lokasi & Kepemilikan</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Lokasi dan status kepemilikan</p>
                    <div class="space-y-4">
                        <div>
                            <label class="gaming-label">Lokasi Unit <span style="color:#f87171;">*</span></label>
                            <input type="text" name="lokasi_unit" id="f-lokasi_unit" required placeholder="Masukan lokasi unit" class="gaming-input">
                        </div>
                        <div>
                            <label class="gaming-label">Ruangan <span style="color:#f87171;">*</span></label>
                            <input type="text" name="ruangan" id="f-ruangan" required placeholder="Masukan ruangan" class="gaming-input">
                        </div>
                        <div>
                            <label class="gaming-label">Milik <span style="color:#f87171;">*</span></label>
                            <select name="milik" id="f-milik" required class="gaming-input">
                                <option value="Milik Perusahaan">Milik Perusahaan</option>
                                <option value="Sewa">Sewa</option>
                                <option value="Pinjaman">Pinjaman</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="step-content hidden" id="step-3">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Pengadaan & Nilai Aset</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Data pengadaan dan nilai</p>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Pengadaan (Tahun) <span style="color:#f87171;">*</span></label>
                                <input type="number" name="pengadaan_tahun" id="f-pengadaan_tahun" required placeholder="Masukan tahun pengadaan" class="gaming-input" min="1900" max="{{ now()->year + 1 }}">
                            </div>
                            <div>
                                <label class="gaming-label">Tanggal Pembelian <span style="color:#f87171;">*</span></label>
                                <input type="date" name="tanggal_pembelian" id="f-tanggal_pembelian" required class="gaming-input" oninput="hitungPenyusutan()">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Kategori Nilai <span style="color:#f87171;">*</span></label>
                                <select name="kategori_nilai" id="f-kategori_nilai" required class="gaming-input">
                                    <option value="Rendah">Rendah</option>
                                    <option value="Menengah">Menengah</option>
                                    <option value="Tinggi">Tinggi</option>
                                </select>
                            </div>
                            <div>
                                <label class="gaming-label">Kategori Ukuran <span style="color:#f87171;">*</span></label>
                                <select name="kategori_ukuran" id="f-kategori_ukuran" required class="gaming-input">
                                    <option value="Kecil">Kecil</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Besar">Besar</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="gaming-label">Nilai <span style="color:#f87171;">*</span></label>
                            <input type="number" name="nilai" id="f-nilai" required placeholder="Masukan nilai aset" class="gaming-input" min="0" step="0.01" oninput="hitungPenyusutan()">
                        </div>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="step-content hidden" id="step-4">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Penyusutan Umur Aset</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Perhitungan penyusutan otomatis</p>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Waktu Pakai Per Hari (Jam) <span style="color:#f87171;">*</span></label>
                                <input type="number" name="waktu_pakai_per_hari" id="f-waktu_pakai_per_hari" required value="2" class="gaming-input" min="0">
                            </div>
                            <div>
                                <label class="gaming-label">Masa Barang (Hari) <span style="color:#f87171;">*</span></label>
                                <input type="number" name="estimasi_waktu_barang" id="f-estimasi_waktu_barang" required value="360" class="gaming-input" min="1" oninput="hitungPenyusutan()">
                                <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Contoh: 360 hari (1 tahun)</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Penyusutan Per Hari (Rp)</label>
                                <div id="penyusutan-display" class="gaming-input" style="padding:8px 12px;background:var(--bg-surface-2);color:var(--text-muted);border-radius:8px;font-size:13px;cursor:default;">—</div>
                            </div>
                            <div>
                                <label class="gaming-label">Nilai Saat Ini (Rp)</label>
                                <div id="nilai-sekarang-display" class="gaming-input" style="padding:8px 12px;background:var(--bg-surface-2);color:var(--text-muted);border-radius:8px;font-size:13px;cursor:default;">—</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 5 --}}
                <div class="step-content hidden" id="step-5">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Penanggung Jawab</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Data penanggung jawab</p>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">PIC <span style="color:#f87171;">*</span></label>
                                <input type="text" name="pic" id="f-pic" required placeholder="Masukan nama PIC" class="gaming-input">
                            </div>
                            <div>
                                <label class="gaming-label">Jabatan <span style="color:#f87171;">*</span></label>
                                <select name="jabatan" id="f-jabatan" required class="gaming-input gaming-select">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Chief Executive Officer (CEO)">Chief Executive Officer (CEO)</option>
                                    <option value="General Manager (GM)">General Manager (GM)</option>
                                    <option value="Head of Store">Head of Store</option>
                                    <option value="Admin Master">Admin Master</option>
                                    <option value="HR">HR</option>
                                    <option value="Koordinator">Koordinator</option>
                                    <option value="Karyawan">Karyawan</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Atasan <span style="color:#f87171;">*</span></label>
                                <input type="text" name="atasan" id="f-atasan" required placeholder="Masukan nama atasan" class="gaming-input">
                            </div>
                            <div>
                                <label class="gaming-label">Jabatan Atasan <span style="color:#f87171;">*</span></label>
                                <select name="jabatan_atasan" id="f-jabatan_atasan" required class="gaming-input gaming-select">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="Chief Executive Officer (CEO)">Chief Executive Officer (CEO)</option>
                                    <option value="General Manager (GM)">General Manager (GM)</option>
                                    <option value="Head of Store">Head of Store</option>
                                    <option value="Admin Master">Admin Master</option>
                                    <option value="HR">HR</option>
                                    <option value="Koordinator">Koordinator</option>
                                    <option value="Karyawan">Karyawan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 6 Preview --}}
                <div class="step-content hidden" id="step-6">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Pratinjau Data</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Periksa kembali data sebelum menyimpan</p>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3" id="preview-content">
                        {{-- Card 1: Informasi Umum --}}
                        <div style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:14px;">
                            <p style="color:var(--color-accent);font-size:0.75rem;font-weight:700;letter-spacing:0.05em;margin-bottom:10px;text-transform:uppercase;">Informasi Umum</p>
                            <div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Nama Barang</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-nama_barang">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Jumlah</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-jumlah">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Detail</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-detail">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Sub Kategori</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-sub_kategori">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Keterangan</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-keterangan">-</span>
                                </div>
                            </div>
                        </div>
                        {{-- Card 2: Lokasi & Kepemilikan --}}
                        <div style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:14px;">
                            <p style="color:var(--color-accent);font-size:0.75rem;font-weight:700;letter-spacing:0.05em;margin-bottom:10px;text-transform:uppercase;">Lokasi &amp; Kepemilikan</p>
                            <div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Lokasi Unit</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-lokasi_unit">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Ruangan</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-ruangan">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Milik</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-milik">-</span>
                                </div>
                            </div>
                        </div>
                        {{-- Card 3: Pengadaan & Nilai --}}
                        <div style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:14px;">
                            <p style="color:var(--color-accent);font-size:0.75rem;font-weight:700;letter-spacing:0.05em;margin-bottom:10px;text-transform:uppercase;">Pengadaan &amp; Nilai</p>
                            <div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Pengadaan</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-pengadaan_tahun">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Tgl Pembelian</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-tanggal_pembelian">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Kategori Nilai</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-kategori_nilai">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Kategori Ukuran</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-kategori_ukuran">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Nilai</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-nilai">-</span>
                                </div>
                            </div>
                        </div>
                        {{-- Card 4: Penyusutan Umur Aset --}}
                        <div style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:14px;">
                            <p style="color:var(--color-accent);font-size:0.75rem;font-weight:700;letter-spacing:0.05em;margin-bottom:10px;text-transform:uppercase;">Penyusutan Umur Aset</p>
                            <div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Waktu Pakai/Hari</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-waktu_pakai_per_hari">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Masa Barang</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-estimasi_waktu_barang">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Hari Terpakai</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-hari_terpakai">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Penyusutan/Hari</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-pengurangan_harga_per_hari">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Nilai Awal</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-nilai_awal">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Nilai Saat Ini</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-harga_per_hari_ini">-</span>
                                </div>
                            </div>
                        </div>
                        {{-- Card 5: Penanggung Jawab --}}
                        <div style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:14px;">
                            <p style="color:var(--color-accent);font-size:0.75rem;font-weight:700;letter-spacing:0.05em;margin-bottom:10px;text-transform:uppercase;">Penanggung Jawab</p>
                            <div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">PIC</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-pic">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Jabatan</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-jabatan">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border-color);">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Atasan</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-atasan">-</span>
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;">
                                    <span style="color:var(--text-muted);font-size:0.75rem;">Jab Atasan</span>
                                    <span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;" id="pv-jabatan_atasan">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <div class="flex items-center pt-4 mt-4" style="border-top:1px solid var(--border-color);">
                    <div class="flex gap-3">
                        <button type="button" id="prev-btn" onclick="prevStep()" class="btn btn-secondary" style="display:none;">Sebelumnya</button>
                    </div>
                    <div class="flex gap-3 ml-auto">
                        <button type="button" onclick="closeModal('item-modal')" class="btn btn-secondary" id="cancel-btn">Batal</button>
                        <button type="button" id="next-btn" onclick="nextStep()" class="btn btn-primary">Selanjutnya</button>
                        <button type="button" id="submit-btn" class="btn btn-primary" style="display:none;" onclick="submitForm()">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- Modal Import Excel --}}
<div id="import-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Import Excel Peralatan Kantor</h3>
            <button type="button" onclick="closeModal('import-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5">
            <p class="text-sm mb-3" style="color:var(--text-muted);">Download template terlebih dahulu, lalu isi data sesuai format.</p>
            <a href="{{ route('admin.peralatan-kantor.template') }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5 mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                </svg>
                Download Template
            </a>
            <form method="POST" action="{{ route('admin.peralatan-kantor.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="field-group" style="margin-bottom:16px;">
                    <label class="gaming-label">Pilih File Excel <span class="field-req">*</span></label>
                    <input type="file" name="file" id="import-file" accept=".xlsx,.xls,.csv" required
                        class="gaming-input" style="padding:8px 12px;">
                    <p style="font-size:11px;color:var(--text-muted);margin-top:4px;">Format: xlsx, xls, csv. Maksimal 5 MB.</p>
                </div>
                <div class="form-footer" style="padding-top:0;border:none;">
                    <button type="button" onclick="closeModal('import-modal')" class="btn-form btn-form-batal">Batal</button>
                    <button type="submit" class="btn-form btn-form-simpan" id="import-submit-btn">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('import_errors'))
<div class="pt-2">
    <div class="gaming-card p-4" style="border-left:4px solid #f59e0b;">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">
                    Import Selesai: {{ session('import_success_count') }} berhasil, {{ session('import_error_count') }} gagal.
                </p>
                @if(session('import_errors'))
                <div class="mt-2 max-h-[200px] overflow-y-auto" style="scrollbar-width:thin;">
                    <ul style="list-style:none;padding:0;margin:0;">
                        @foreach(session('import_errors') as $error)
                        <li style="font-size:12px;color:#ef4444;padding:2px 0;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <button type="button" onclick="this.closest('.gaming-card').remove()" class="ml-auto p-1" style="background:none;border:none;cursor:pointer;color:var(--text-muted);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
.step-dot {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; flex-shrink: 0;
    background: var(--bg-surface-2); color: var(--text-muted);
    border: 2px solid var(--border-color); transition: all 0.3s;
}
.step-dot.active {
    background: var(--color-accent); color: #fff;
    border-color: var(--color-accent);
    box-shadow: 0 0 12px rgba(124,58,237,0.4);
}
.step-dot.done {
    background: #10b981; color: #fff;
    border-color: #10b981;
}
.step-line {
    flex: 1; height: 2px;
    background: var(--border-color); transition: all 0.3s;
    margin: 0 4px; border-radius: 2px;
}
.step-line.done { background: #10b981; }
#step-indicator { display: flex; align-items: center; }
.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 16px;
    margin-top: 8px;
    border-top: 1px solid var(--border-color);
}
.btn-form {
    padding: 8px 22px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}
.btn-form-batal {
    background: transparent;
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.7);
}
.btn-form-batal:hover {
    border-color: rgba(255,255,255,0.3);
    color: #fff;
}
.btn-form-simpan {
    background: linear-gradient(135deg, #6c5cff, #8b7bff);
    color: #fff;
    box-shadow: 0 4px 15px rgba(108,92,255,0.3);
}
.btn-form-simpan:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(108,92,255,0.4);
}
</style>
@endpush

@push('scripts')
<script>
const itemsData = @json($itemsJson);
let currentStep = 1;
const totalSteps = 6;
let currentDetailId = null;

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Peralatan';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('item-form').action = '{{ route('admin.peralatan-kantor.store') }}';
    document.getElementById('submit-btn').textContent = 'Simpan';
    document.getElementById('item-form').querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') {
            if (el.name === 'waktu_pakai_per_hari' || el.name === 'estimasi_waktu_barang' ||
                el.name === 'pengurangan_harga_per_hari' || el.name === 'harga_per_hari_ini') {
                el.value = '2';
            } else {
                el.value = '';
            }
        }
    });
    document.getElementById('f-sub_kategori').value = 'Peralatan Kantor';
    document.getElementById('f-milik').value = 'Milik Perusahaan';
    document.getElementById('f-kategori_nilai').value = 'Rendah';
    document.getElementById('f-kategori_ukuran').value = 'Kecil';
    document.getElementById('f-kondisi').value = 'baik';
    hitungPenyusutan();
    currentStep = 1;
    showStep(currentStep);
    showModal();
}

function showDetail(id) {
    const i = itemsData.find(x => x.id === id);
    if (!i) return;
    currentDetailId = id;

    document.getElementById('detail-title').textContent = i.nama_barang;

    const kondisiMap = {
        baik: { label: 'Baik', bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
        perlu_servis: { label: 'Perlu Servis', bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
        rusak: { label: 'Rusak', bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
    };
    const k = kondisiMap[i.kondisi] || kondisiMap.baik;
    const badgeEl = document.getElementById('detail-badge');
    badgeEl.textContent = k.label;
    badgeEl.style.background = k.bg;
    badgeEl.style.color = k.text;
    badgeEl.style.border = '1px solid ' + k.border;

    const delForm = document.getElementById('detail-delete-form');
    delForm.action = delForm.dataset.action + id;

    const fmtRp = (v) => v ? 'Rp ' + Number(v).toLocaleString('id-ID') : '-';
    const fmtTgl = (v) => v || '-';

    const cards = [
        {
            title: 'Informasi Umum',
            rows: [
                { label: 'Nama Barang', value: i.nama_barang },
                { label: 'Jumlah', value: i.jumlah },
                { label: 'Detail', value: i.detail || '-' },
                { label: 'Sub Kategori', value: i.sub_kategori },
                { label: 'Keterangan', value: i.keterangan || '-' },
            ]
        },
        {
            title: 'Lokasi & Kepemilikan',
            rows: [
                { label: 'Lokasi Unit', value: i.lokasi_unit },
                { label: 'Ruangan', value: i.ruangan },
                { label: 'Milik', value: i.milik },
            ]
        },
        {
            title: 'Pengadaan & Nilai',
            rows: [
                { label: 'Pengadaan', value: i.pengadaan_tahun },
                { label: 'Tgl Pembelian', value: fmtTgl(i.tanggal_pembelian) },
                { label: 'Kategori Nilai', value: i.kategori_nilai },
                { label: 'Kategori Ukuran', value: i.kategori_ukuran },
                { label: 'Nilai', value: fmtRp(i.nilai) },
            ]
        },
        {
            title: 'Penyusutan Umur Aset',
            rows: [
                { label: 'Waktu Pakai/Hari', value: (i.waktu_pakai_per_hari || 0) + ' Jam' },
                { label: 'Masa Barang', value: (i.estimasi_waktu_barang || 0) + ' Hari' },
                { label: 'Hari Terpakai', value: (i.hari_terpakai || 0) + ' Hari' },
                { label: 'Penyusutan/Hari', value: fmtRp(i.penyusutan_per_hari) },
                { label: 'Nilai Awal', value: fmtRp(i.nilai) },
                { label: 'Nilai Saat Ini', value: fmtRp(i.nilai_sekarang) },
            ]
        },
        {
            title: 'Penanggung Jawab',
            rows: [
                { label: 'PIC', value: i.pic },
                { label: 'Jabatan', value: i.jabatan },
                { label: 'Atasan', value: i.atasan || '-' },
                { label: 'Jab Atasan', value: i.jabatan_atasan || '-' },
            ]
        },
    ];

    let html = '<div class="grid grid-cols-1 lg:grid-cols-2 gap-3">';
    cards.forEach(function (card) {
        html += '<div style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:14px;">';
        html += '<p style="color:var(--color-accent);font-size:0.75rem;font-weight:700;letter-spacing:0.05em;margin-bottom:10px;text-transform:uppercase;">' + card.title + '</p>';
        html += '<div>';
        for (var r = 0; r < card.rows.length; r++) {
            var row = card.rows[r];
            var borderStyle = r < card.rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '';
            html += '<div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;' + borderStyle + '">';
            html += '<span style="color:var(--text-muted);font-size:0.75rem;">' + row.label + '</span>';
            html += '<span style="color:var(--text-primary);font-size:0.8rem;font-weight:600;text-align:right;margin-left:8px;">' + row.value + '</span>';
            html += '</div>';
        }
        html += '</div></div>';
    });
    html += '</div>';

    document.getElementById('detail-body').innerHTML = html;
    openModal('detail-modal');
}

function closeDetail() {
    closeModal('detail-modal');
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function toggleDropdown(btn, id) {
    const all = document.querySelectorAll('.dropdown-menu');
    all.forEach(el => { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    const menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
    }
});

function openEditModal(id) {
    closeDetail();
    const i = itemsData.find(x => x.id === id);
    if (!i) return;

    document.getElementById('modal-title').textContent = 'Edit Peralatan';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = i.id;
    document.getElementById('item-form').action = '{{ url('admin/peralatan-kantor') }}/' + i.id;
    document.getElementById('submit-btn').textContent = 'Simpan Perubahan';

    document.getElementById('f-nama_barang').value = i.nama_barang;
    document.getElementById('f-jumlah').value = i.jumlah;
    document.getElementById('f-detail').value = i.detail || '';
    document.getElementById('f-sub_kategori').value = i.sub_kategori;
    document.getElementById('f-keterangan').value = i.keterangan || '';
    document.getElementById('f-lokasi_unit').value = i.lokasi_unit;
    document.getElementById('f-ruangan').value = i.ruangan;
    document.getElementById('f-milik').value = i.milik;
    document.getElementById('f-pengadaan_tahun').value = i.pengadaan_tahun;
    document.getElementById('f-tanggal_pembelian').value = i.tanggal_pembelian;
    document.getElementById('f-kategori_nilai').value = i.kategori_nilai;
    document.getElementById('f-kategori_ukuran').value = i.kategori_ukuran;
    document.getElementById('f-nilai').value = i.nilai;
    document.getElementById('f-waktu_pakai_per_hari').value = i.waktu_pakai_per_hari;
    document.getElementById('f-estimasi_waktu_barang').value = i.estimasi_waktu_barang;
    document.getElementById('f-pic').value = i.pic;
    document.getElementById('f-jabatan').value = i.jabatan;
    document.getElementById('f-atasan').value = i.atasan;
    document.getElementById('f-jabatan_atasan').value = i.jabatan_atasan;
    document.getElementById('f-kondisi').value = i.kondisi;

    hitungPenyusutan();
    currentStep = 1;
    showStep(currentStep);
    showModal();
}

function showStep(n) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('step-' + n).classList.remove('hidden');

    document.querySelectorAll('.step-dot').forEach(el => {
        const s = parseInt(el.dataset.step);
        el.classList.remove('active', 'done');
        if (s === n) el.classList.add('active');
        else if (s < n) el.classList.add('done');
    });
    document.querySelectorAll('.step-line').forEach(el => {
        const s = parseInt(el.dataset.step);
        el.classList.toggle('done', s < n);
    });

    document.getElementById('prev-btn').style.display = n > 1 ? '' : 'none';
    document.getElementById('next-btn').style.display = n < totalSteps ? '' : 'none';
    document.getElementById('submit-btn').style.display = n === totalSteps ? '' : 'none';

    if (n === totalSteps) updatePreview();
    document.getElementById('item-form').querySelector('.step-content:not(.hidden)');
}

function updatePreview() {
    const map = {
        'pv-nama_barang': 'f-nama_barang',
        'pv-jumlah': 'f-jumlah',
        'pv-detail': 'f-detail',
        'pv-sub_kategori': 'f-sub_kategori',
        'pv-keterangan': 'f-keterangan',
        'pv-lokasi_unit': 'f-lokasi_unit',
        'pv-ruangan': 'f-ruangan',
        'pv-milik': 'f-milik',
        'pv-pengadaan_tahun': 'f-pengadaan_tahun',
        'pv-tanggal_pembelian': 'f-tanggal_pembelian',
        'pv-kategori_nilai': 'f-kategori_nilai',
        'pv-kategori_ukuran': 'f-kategori_ukuran',
        'pv-nilai': 'f-nilai',
        'pv-waktu_pakai_per_hari': 'f-waktu_pakai_per_hari',
        'pv-estimasi_waktu_barang': 'f-estimasi_waktu_barang',
        'pv-pic': 'f-pic',
        'pv-jabatan': 'f-jabatan',
        'pv-atasan': 'f-atasan',
        'pv-jabatan_atasan': 'f-jabatan_atasan',
    };
    for (const [pvId, inputName] of Object.entries(map)) {
        const val = document.getElementById(inputName).value || '-';
        document.getElementById(pvId).textContent = val;
    }
    // Update computed preview values
    const nilai = parseFloat(document.getElementById('f-nilai').value) || 0;
    const masaBarang = parseInt(document.getElementById('f-estimasi_waktu_barang').value) || 1;
    const tglBeli = document.getElementById('f-tanggal_pembelian').value;
    const penyusutan = nilai / masaBarang;
    let hariTerpakai = 0;
    if (tglBeli) {
        const now = new Date();
        const beli = new Date(tglBeli);
        hariTerpakai = Math.max(Math.floor(Math.abs(now - beli) / (1000 * 60 * 60 * 24)), 0);
    }
    const nilaiSekarang = Math.max(nilai - (penyusutan * hariTerpakai), 0);
    document.getElementById('pv-pengurangan_harga_per_hari').textContent = 'Rp ' + Math.round(penyusutan).toLocaleString('id-ID');
    document.getElementById('pv-harga_per_hari_ini').textContent = 'Rp ' + Math.round(nilaiSekarang).toLocaleString('id-ID');
    document.getElementById('pv-hari_terpakai').textContent = hariTerpakai + ' Hari';
    document.getElementById('pv-nilai_awal').textContent = 'Rp ' + Math.round(nilai).toLocaleString('id-ID');
}

function validateStep(step) {
    const stepEl = document.getElementById('step-' + step);
    const requiredInputs = stepEl.querySelectorAll('[required]');
    let valid = true;
    requiredInputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#ef4444';
            input.style.boxShadow = '0 0 0 2px rgba(239,68,68,0.2)';
            valid = false;
        } else {
            input.style.borderColor = '';
            input.style.boxShadow = '';
        }
    });
    if (!valid) {
        alert('Harap isi semua field yang wajib diisi.');
    }
    return valid;
}

function nextStep() {
    if (!validateStep(currentStep)) return;
    if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}

function hitungPenyusutan() {
    const nilai = parseFloat(document.getElementById('f-nilai').value) || 0;
    const masaBarang = parseInt(document.getElementById('f-estimasi_waktu_barang').value) || 1;
    const tglBeli = document.getElementById('f-tanggal_pembelian').value;
    const penyusutan = nilai / masaBarang;
    let hariTerpakai = 0;
    if (tglBeli) {
        const now = new Date();
        const beli = new Date(tglBeli);
        hariTerpakai = Math.max(Math.floor(Math.abs(now - beli) / (1000 * 60 * 60 * 24)), 0);
    }
    const nilaiSekarang = Math.max(nilai - (penyusutan * hariTerpakai), 0);
    document.getElementById('penyusutan-display').textContent = 'Rp ' + Math.round(penyusutan).toLocaleString('id-ID');
    document.getElementById('nilai-sekarang-display').textContent = 'Rp ' + Math.round(nilaiSekarang).toLocaleString('id-ID');
}

function submitForm() {
    for (let s = 1; s < totalSteps; s++) {
        if (!validateStep(s)) {
            const firstInvalid = document.querySelector('#step-' + s + ' [required]');
            if (firstInvalid) {
                currentStep = s;
                showStep(currentStep);
                firstInvalid.focus();
            }
            return;
        }
    }
    document.getElementById('item-form').submit();
}

function showModal() { openModal('item-modal'); }

document.getElementById('item-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('item-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetail(); closeModal('item-modal'); }
});

function iconSvg(name) {
    const icons = {
        'package': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
        'file-text': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
        'building-2': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11m16-11v11M8 14v3m4-3v3m4-3v3"/></svg>',
        'calendar': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
        'credit-card': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>',
        'wallet': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>',
        'clock': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'user': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
        'user-cog': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        'shield-check': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
        'check-circle': '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    };
    return icons[name] || icons['package'];
}

function showToast(type, message) {
    const existing = document.querySelector('.toast-notif');
    if (existing) existing.remove();

    const isSuccess = type === 'success';
    const bg = isSuccess ? '#10b981' : '#ef4444';
    const borderColor = isSuccess ? 'rgba(16,185,129,0.4)' : 'rgba(239,68,68,0.4)';

    const toast = document.createElement('div');
    toast.className = 'toast-notif';
    toast.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;padding:14px 22px;border-radius:12px;font-size:14px;font-weight:500;color:#fff;background:' + bg + ';border:1px solid ' + borderColor + ';box-shadow:0 8px 32px rgba(0,0,0,0.25);display:flex;align-items:center;gap:10px;transform:translateX(120%);transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1);max-width:400px;';
    toast.innerHTML = (isSuccess
        ? '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        : '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>')
        + '<span>' + message + '</span>';
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.style.transform = 'translateX(0)');
    setTimeout(() => { toast.style.transform = 'translateX(120%)'; setTimeout(() => toast.remove(), 350); }, 4000);
}

function openImportModal() {
    document.getElementById('import-file').value = '';
    document.getElementById('import-submit-btn').disabled = false;
    document.getElementById('import-submit-btn').textContent = 'Import';
    openModal('import-modal');
}

document.getElementById('import-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('import-modal');
});

document.getElementById('import-file')?.addEventListener('change', function() {
    const btn = document.getElementById('import-submit-btn');
    btn.disabled = !this.files.length;
});

let currentFilter = 'all';

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

function setFilter(value) {
    currentFilter = value;
    const label = document.querySelector(`.filter-menu button[data-value="${value}"]`).textContent;
    document.getElementById('filter-label').textContent = label;
    document.getElementById('filter-menu').style.display = 'none';
    filterItems();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterItems() {
    const search = (document.getElementById('search-item')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#item-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowKondisi = row.dataset.kondisi;
        const text = row.textContent.toLowerCase();
        const matchKondisi = currentFilter === 'all' || rowKondisi === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchKondisi && matchSearch ? '' : 'none';
    });
}
</script>
@endpush
