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
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Peralatan
            </button>
        </div>
        <div class="px-5 py-3 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-item" placeholder="Cari nama barang atau PIC" oninput="filterItems()"
                    class="w-full pl-9 pr-3 py-2 rounded-lg text-sm"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Kondisi</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;bottom:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-bottom:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Kondisi</button>
                    <button type="button" data-value="baik" onclick="setFilter('baik')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Kondisi Baik</button>
                    <button type="button" data-value="perlu_servis" onclick="setFilter('perlu_servis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Perlu Servis</button>
                    <button type="button" data-value="rusak" onclick="setFilter('rusak')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Rusak</button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]" id="item-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>PIC</th>
                        <th>Lokasi Unit</th>
                        <th>Nilai</th>
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
                    @endphp
                    <tr data-kondisi="{{ $i->kondisi }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $i->nama_barang }}</td>
                        <td style="color:var(--text-muted);">{{ $i->pic }}</td>
                        <td style="color:var(--text-muted);">{{ $i->lokasi_unit }}</td>
                        <td style="color:var(--text-muted);">Rp {{ number_format($i->nilai, 0, ',', '.') }}</td>
                        <td><span class="badge {{ $kondisiBadge }}">{{ $kondisiLabel }}</span></td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $i->id }})" class="btn btn-secondary btn-sm">Detail</button>
                                <a href="{{ route('admin.export', ['type' => 'peralatan-kantor']) }}" class="btn btn-secondary btn-sm" style="padding:4px 8px;line-height:1;" title="Download Excel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                                <div class="relative" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown({{ $i->id }})" class="btn btn-secondary btn-sm" style="padding:4px 8px;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $i->id }}" class="dropdown-menu" style="display:none;position:absolute;right:0;bottom:100%;z-index:40;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-bottom:4px;">
                                        <button type="button" onclick="showDetail({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal({{ $i->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.peralatan-kantor.destroy', $i) }}" onsubmit="return confirm('Hapus peralatan ini?')" style="margin:0;">
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
<div id="detail-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100vh;z-index:50;align-items:flex-start;justify-content:center;padding:60px 16px 16px;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);overflow-y:auto;">
    <div class="w-full max-w-[520px] rounded-3xl shadow-2xl flex flex-col" style="max-height:90vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail Peralatan</h3>
            <button type="button" onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex justify-between items-center" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal Tambah / Edit Peralatan Kantor (6 Step) --}}
<div id="item-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100vh;z-index:50;align-items:flex-start;justify-content:center;padding:40px 16px 16px;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);overflow-y:auto;">
    <div class="w-full max-w-[640px] rounded-3xl shadow-2xl flex flex-col" style="max-height:94vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="modal-title">Tambah Peralatan</h3>
            <button type="button" onclick="closeModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
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
                                <input type="date" name="tanggal_pembelian" id="f-tanggal_pembelian" required class="gaming-input">
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
                            <input type="number" name="nilai" id="f-nilai" required placeholder="Masukan nilai aset" class="gaming-input" min="0" step="0.01">
                        </div>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="step-content hidden" id="step-4">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Penyusutan Umur Aset</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Perhitungan penyusutan</p>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Waktu Pakai Per Hari <span style="color:#f87171;">*</span></label>
                                <input type="number" name="waktu_pakai_per_hari" id="f-waktu_pakai_per_hari" required value="2" class="gaming-input" min="0">
                            </div>
                            <div>
                                <label class="gaming-label">Estimasi Waktu Barang <span style="color:#f87171;">*</span></label>
                                <input type="number" name="estimasi_waktu_barang" id="f-estimasi_waktu_barang" required value="2" class="gaming-input" min="0">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Pengurangan Harga Per Hari <span style="color:#f87171;">*</span></label>
                                <input type="number" name="pengurangan_harga_per_hari" id="f-pengurangan_harga_per_hari" required value="2" class="gaming-input" min="0" step="0.01">
                            </div>
                            <div>
                                <label class="gaming-label">Harga Per Hari Ini <span style="color:#f87171;">*</span></label>
                                <input type="number" name="harga_per_hari_ini" id="f-harga_per_hari_ini" required value="2" class="gaming-input" min="0" step="0.01">
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
                                <input type="text" name="jabatan" id="f-jabatan" required placeholder="Masukan jabatan" class="gaming-input">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Atasan <span style="color:#f87171;">*</span></label>
                                <input type="text" name="atasan" id="f-atasan" required placeholder="Masukan nama atasan" class="gaming-input">
                            </div>
                            <div>
                                <label class="gaming-label">Jabatan Atasan <span style="color:#f87171;">*</span></label>
                                <input type="text" name="jabatan_atasan" id="f-jabatan_atasan" required placeholder="Masukan jabatan atasan" class="gaming-input">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 6 Preview --}}
                <div class="step-content hidden" id="step-6">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Pratinjau Data</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Periksa kembali data sebelum menyimpan</p>
                    <div class="space-y-3" id="preview-content">
                        <div class="grid grid-cols-3 gap-3 text-sm">
                            <div><span style="color:var(--text-muted);">Nama Barang</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-nama_barang">-</span></div>
                            <div><span style="color:var(--text-muted);">Jumlah</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-jumlah">-</span></div>
                            <div><span style="color:var(--text-muted);">Sub Kategori</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-sub_kategori">-</span></div>
                            <div class="col-span-3"><span style="color:var(--text-muted);">Detail</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-detail">-</span></div>
                            <div class="col-span-3"><span style="color:var(--text-muted);">Keterangan</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-keterangan">-</span></div>
                            <div><span style="color:var(--text-muted);">Lokasi Unit</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-lokasi_unit">-</span></div>
                            <div><span style="color:var(--text-muted);">Ruangan</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-ruangan">-</span></div>
                            <div><span style="color:var(--text-muted);">Milik</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-milik">-</span></div>
                            <div><span style="color:var(--text-muted);">Pengadaan (Tahun)</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-pengadaan_tahun">-</span></div>
                            <div><span style="color:var(--text-muted);">Tanggal Pembelian</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-tanggal_pembelian">-</span></div>
                            <div><span style="color:var(--text-muted);">Kategori Nilai</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-kategori_nilai">-</span></div>
                            <div><span style="color:var(--text-muted);">Kategori Ukuran</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-kategori_ukuran">-</span></div>
                            <div><span style="color:var(--text-muted);">Nilai</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-nilai">-</span></div>
                            <div><span style="color:var(--text-muted);">Waktu Pakai Per Hari</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-waktu_pakai_per_hari">-</span></div>
                            <div><span style="color:var(--text-muted);">Estimasi Waktu Barang</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-estimasi_waktu_barang">-</span></div>
                            <div><span style="color:var(--text-muted);">Pengurangan Harga/Hari</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-pengurangan_harga_per_hari">-</span></div>
                            <div><span style="color:var(--text-muted);">Harga Per Hari Ini</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-harga_per_hari_ini">-</span></div>
                            <div><span style="color:var(--text-muted);">PIC</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-pic">-</span></div>
                            <div><span style="color:var(--text-muted);">Jabatan</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-jabatan">-</span></div>
                            <div><span style="color:var(--text-muted);">Atasan</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-atasan">-</span></div>
                            <div><span style="color:var(--text-muted);">Jabatan Atasan</span><br><span style="color:var(--text-primary);font-weight:500;" id="pv-jabatan_atasan">-</span></div>
                        </div>
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <div class="flex gap-3 pt-4 mt-4" style="border-top:1px solid var(--border-color);">
                    <button type="button" id="prev-btn" onclick="prevStep()" class="btn btn-secondary" style="display:none;">Sebelumnya</button>
                    <button type="button" id="next-btn" onclick="nextStep()" class="btn btn-primary">Selanjutnya</button>
                    <button type="submit" id="submit-btn" class="btn btn-primary" style="display:none;">Simpan</button>
                    <button type="button" onclick="closeModal()" class="btn btn-secondary" id="cancel-btn">Batal</button>
                </div>
            </form>
        </div>

    </div>
</div>
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
</style>
@endpush

@push('scripts')
<script>
const itemsData = @json($itemsJson);
let currentStep = 1;
const totalSteps = 6;

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
    currentStep = 1;
    showStep(currentStep);
    showModal();
}

function showDetail(id) {
    const i = itemsData.find(x => x.id === id);
    if (!i) return;
    document.getElementById('detail-title').textContent = i.nama_barang;

    const kondisiMap = {
        baik: { label: 'Baik', bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
        perlu_servis: { label: 'Perlu Servis', bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
        rusak: { label: 'Rusak', bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
    };
    const k = kondisiMap[i.kondisi] || kondisiMap.baik;
    const rp = i.nilai ? 'Rp ' + Number(i.nilai).toLocaleString('id-ID') : '-';

    const rows = [
        { label: 'Nama Barang', value: i.nama_barang, icon: 'package' },
        { label: 'Jumlah', value: i.jumlah, icon: 'package' },
        { label: 'Sub Kategori', value: i.sub_kategori, icon: 'package' },
        { label: 'Detail', value: i.detail || '-', icon: 'file-text' },
        { label: 'Keterangan', value: i.keterangan || '-', icon: 'file-text' },
        { label: 'Lokasi Unit', value: i.lokasi_unit, icon: 'building-2' },
        { label: 'Ruangan', value: i.ruangan, icon: 'building-2' },
        { label: 'Milik', value: i.milik, icon: 'building-2' },
        { label: 'Tahun Pengadaan', value: i.pengadaan_tahun, icon: 'calendar' },
        { label: 'Tanggal Pembelian', value: i.tanggal_pembelian, icon: 'calendar' },
        { label: 'Kategori Nilai', value: i.kategori_nilai, icon: 'credit-card' },
        { label: 'Kategori Ukuran', value: i.kategori_ukuran, icon: 'package' },
        { label: 'Nilai', value: rp, icon: 'wallet' },
        { label: 'Waktu Pakai/Hari', value: i.waktu_pakai_per_hari, icon: 'clock' },
        { label: 'Estimasi Waktu', value: i.estimasi_waktu_barang, icon: 'clock' },
        { label: 'PIC', value: i.pic, icon: 'user' },
        { label: 'Jabatan', value: i.jabatan, icon: 'user-cog' },
        { label: 'Atasan', value: i.atasan, icon: 'shield-check' },
        { label: 'Jabatan Atasan', value: i.jabatan_atasan, icon: 'shield-check' },
    ];

    const detailBody = document.getElementById('detail-body');
    detailBody.innerHTML = `
        <div class="space-y-2">
            ${rows.map((r, i) => `
                <div class="flex items-center justify-between py-3" ${i < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <div class="flex items-center gap-2 min-w-[140px]">
                        <div class="w-6 h-6 rounded-md flex items-center justify-center" style="background:var(--bg-surface-2);color:var(--text-muted);">
                            ${iconSvg(r.icon)}
                        </div>
                        <p class="text-sm font-medium" style="color:var(--text-muted);">${r.label}</p>
                    </div>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:60%;">${r.value}</p>
                </div>
            `).join('')}
            <div class="flex items-center justify-between py-3 mt-2">
                <div class="flex items-center gap-2 min-w-[140px]">
                    <div class="w-6 h-6 rounded-md flex items-center justify-center" style="background:var(--bg-surface-2);color:var(--text-muted);">
                        ${iconSvg('check-circle')}
                    </div>
                    <p class="text-sm font-medium" style="color:var(--text-muted);">Kondisi</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${k.bg};color:${k.text};border:1px solid ${k.border};">${k.label}</span>
            </div>
        </div>
    `;
    document.getElementById('detail-modal').style.display = 'flex';
}

function closeDetail() {
    document.getElementById('detail-modal').style.display = 'none';
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function toggleDropdown(id) {
    const all = document.querySelectorAll('.dropdown-menu');
    all.forEach(el => { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    const menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
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
    document.getElementById('f-pengurangan_harga_per_hari').value = i.pengurangan_harga_per_hari;
    document.getElementById('f-harga_per_hari_ini').value = i.harga_per_hari_ini;
    document.getElementById('f-pic').value = i.pic;
    document.getElementById('f-jabatan').value = i.jabatan;
    document.getElementById('f-atasan').value = i.atasan;
    document.getElementById('f-jabatan_atasan').value = i.jabatan_atasan;
    document.getElementById('f-kondisi').value = i.kondisi;

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
        'pv-pengurangan_harga_per_hari': 'f-pengurangan_harga_per_hari',
        'pv-harga_per_hari_ini': 'f-harga_per_hari_ini',
        'pv-pic': 'f-pic',
        'pv-jabatan': 'f-jabatan',
        'pv-atasan': 'f-atasan',
        'pv-jabatan_atasan': 'f-jabatan_atasan',
    };
    for (const [pvId, inputName] of Object.entries(map)) {
        const val = document.getElementById(inputName).value || '-';
        document.getElementById(pvId).textContent = val;
    }
}

function nextStep() {
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

function showModal() {
    document.getElementById('item-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('item-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('item-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetail(); closeModal(); }
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
