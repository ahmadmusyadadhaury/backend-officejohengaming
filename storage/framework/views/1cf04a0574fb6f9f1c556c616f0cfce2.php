<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Peralatan Kantor'); ?>
<?php $__env->startSection('page-title', 'Data Aset > Peralatan Kantor'); ?>
<?php $__env->startSection('page-subtitle', 'Inventaris peralatan kantor milik perusahaan'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total Peralatan</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:none rgba(16,185,129,0.2);">
                <svg class="w-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['kondisi_baik']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Kondisi Baik</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fbbf24;"><?php echo e($stats['perlu_servis']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Perlu Servis</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:none rgba(239,68,68,0.2);">
                <svg class="w-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;"><?php echo e($stats['rusak']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Rusak</div>
            </div>
        </div>
    </div>

    
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Peralatan Kantor</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Inventaris peralatan kantor milik perusahaan.</div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="openScanModal()" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    Scan Barcode
                </button>
                <?php if(auth()->user()->role !== 'gm'): ?>
                <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Peralatan
                </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-item" placeholder="Cari nama barang, kode aset, atau PIC" oninput="filterItems()"
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
                <a href="<?php echo e(route('admin.export', ['type' => 'peralatan-kantor', 'filter' => 'all'])); ?>" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export</a>
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
            <table class="gaming-table min-w-[1100px]" id="item-table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>PIC</th>
                        <th class="hidden lg:table-cell">Lokasi Unit</th>
                        <th class="hidden md:table-cell">Kode Aset</th>
                        <th class="hidden md:table-cell">Nilai (Setelah Penyusutan)</th>
                        <th>Kondisi</th>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="item-tbody">
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
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
                    ?>
                    <tr data-kondisi="<?php echo e($i->kondisi); ?>">
                        <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($i->nama_barang); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($i->jumlah); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($i->pic); ?></td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);"><?php echo e($i->lokasi_unit); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--color-accent);font-weight:500;font-family:monospace;font-size:0.75rem;"><?php echo e($i->kode_aset); ?></td>
                        <td class="hidden md:table-cell" style="color:<?php echo e($nilaiSekarang > 0 ? 'var(--text-primary)' : '#ef4444'); ?>;font-weight:500;">Rp <?php echo e(number_format($nilaiSekarang, 0, ',', '.')); ?></td>
                        <td><span class="badge <?php echo e($kondisiBadge); ?>"><?php echo e($kondisiLabel); ?></span></td>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail(<?php echo e($i->id); ?>)" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, <?php echo e($i->id); ?>)" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-<?php echo e($i->id); ?>" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail(<?php echo e($i->id); ?>)" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal(<?php echo e($i->id); ?>)" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="<?php echo e(route('admin.peralatan-kantor.destroy', $i)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus peralatan ini?" style="margin:0;">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr id="empty-row">
                        <td colspan="9" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data peralatan kantor.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-5xl rounded-[22px] shadow-2xl flex flex-col" style="max-height:90vh;background:var(--bg-surface);border:1px solid var(--border-color);" onclick="event.stopPropagation()">
        
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <button onclick="closeDetail()" style="color:var(--text-muted);background:none;border:none;cursor:pointer;padding:6px 10px;border-radius:10px;display:flex;align-items:center;gap:6px;font-size:13px;transition:all 0.15s;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7 7-7"/></svg>
                Kembali
            </button>
            <div class="flex items-center gap-2">
                <?php if(auth()->user()->role !== 'gm'): ?>
                <button id="detail-qr-btn" onclick="downloadQrCode(currentDetailId)" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition" style="background:rgba(0,212,255,0.15);color:#00d4ff;border:1px solid rgba(0,212,255,0.3);cursor:pointer;display:inline-flex;align-items:center;gap:4px;" title="Download QR Code">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    QR
                </button>
                <button id="detail-label-btn" onclick="printLabel(currentDetailId)" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition" style="background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.3);cursor:pointer;display:inline-flex;align-items:center;gap:4px;" title="Cetak Label">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Label
                </button>
                <button id="detail-edit-btn" onclick="openEditModal(currentDetailId)" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;cursor:pointer;">Edit</button>
                <form id="detail-delete-form" method="POST" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus peralatan ini?" data-action="<?php echo e(url('admin/peralatan-kantor')); ?>/" style="margin:0;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);cursor:pointer;">Hapus</button>
                </form>
                <?php endif; ?>
                <button onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        
        <div class="px-6 pt-5 pb-2 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold" style="color:var(--text-primary);" id="detail-title"></h3>
                    <p class="text-sm mt-1" style="color:var(--text-muted);">Detail lengkap peralatan kantor</p>
                </div>
                <span id="detail-badge" class="badge" style="font-size:0.75rem;padding:4px 14px;"></span>
            </div>
        </div>
        
        <div class="px-6 py-3 flex-shrink-0" id="detail-media-section">
            <div class="detail-media-wrap">
                
                <div id="detail-foto-section" class="detail-foto-col" style="display:none;">
                    <div style="border-radius:14px;overflow:hidden;border:1px solid var(--border-color);">
                        <img id="detail-foto-img" src="" alt="Foto Barang" style="width:100%;height:120px;object-fit:cover;display:block;">
                    </div>
                </div>
                
                <div id="detail-barcode-section" class="detail-barcode-col" style="display:none;">
                    <div style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:14px;text-align:center;">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2 min-w-0">
                                <span style="color:var(--text-muted);font-size:0.7rem;">Kode Aset:</span>
                                <span id="detail-kode-aset" style="color:var(--color-accent);font-weight:700;font-family:monospace;font-size:0.85rem;"></span>
                            </div>
                            <div class="flex items-center gap-1 flex-shrink-0">
                                <button type="button" onclick="printBarcode()" class="btn btn-secondary btn-sm inline-flex items-center gap-1" style="font-size:0.65rem;padding:3px 8px;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Cetak
                                </button>
                                <button type="button" onclick="downloadBarcode()" class="btn btn-secondary btn-sm inline-flex items-center gap-1" style="font-size:0.65rem;padding:3px 8px;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                                    Unduh
                                </button>
                            </div>
                        </div>
                        <div id="detail-barcode-image" style="display:flex;justify-content:center;"></div>
                    </div>
                </div>
                
                <div id="detail-media-placeholder" style="flex:1;text-align:center;padding:20px;color:var(--text-muted);font-size:0.8rem;">Tidak ada foto atau barcode</div>
            </div>
        </div>
        
        <div class="px-6 py-4 overflow-y-auto flex-1" id="detail-body" style="scrollbar-width:thin;"></div>
    </div>
</div>


<div id="label-modal" style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);" onclick="if(event.target===this)closeLabelModal()">
    <div class="w-full max-w-[360px] rounded-[20px] shadow-2xl flex flex-col" style="background:var(--bg-surface);border:1px solid var(--border-color);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-5 py-3" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-sm font-bold" style="color:var(--text-primary);">Preview Label</h3>
            <button onclick="closeLabelModal()" class="p-1 rounded-lg" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-5 py-4 flex flex-col items-center" id="label-preview-content">
            <div id="label-card" style="width:280px;border:2px solid var(--border-color);border-radius:14px;padding:18px;text-align:center;background:var(--bg-surface);">
                <img id="label-logo" src="<?php echo e(asset('images/logo/logo_web.png')); ?>" alt="Logo" style="width:40px;height:40px;object-fit:contain;margin:0 auto 6px;">
                <p style="font-size:9px;font-weight:700;letter-spacing:0.1em;color:var(--text-primary);margin-bottom:10px;">JOHEN OFFICE</p>
                <p id="label-nama" style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:3px;"></p>
                <p id="label-kode" style="font-size:10px;font-family:monospace;color:#7c3aed;font-weight:700;margin-bottom:10px;"></p>
                <div id="label-qr-container" style="margin:0 auto 8px;"></div>
                <p id="label-url" style="font-size:7px;color:var(--text-muted);word-break:break-all;"></p>
            </div>
        </div>
        <div class="px-5 py-3 flex items-center justify-end gap-2" style="border-top:1px solid var(--border-color);">
            <button onclick="printLabelFromModal()" class="btn btn-primary btn-sm inline-flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </button>
            <button onclick="closeLabelModal()" class="btn btn-secondary btn-sm">Tutup</button>
        </div>
    </div>
</div>


<div id="item-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[520px] rounded-3xl shadow-2xl flex flex-col" style="max-height:95vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="modal-title">Tambah Peralatan</h3>
            <button type="button" onclick="closeModal('item-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        
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

        
        <div class="px-6 py-4 overflow-y-auto flex-1">
            <form id="item-form" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">
                <input type="hidden" name="kondisi" id="f-kondisi" value="baik">

                
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
                        <div>
                            <label class="gaming-label">Foto Barang</label>
                            <input type="file" name="foto" id="f-foto" accept="image/jpeg,image/jpg,image/png,image/webp" class="gaming-input" style="padding:6px;">
                            <p class="text-xs mt-1" style="color:var(--text-muted);">Format: JPG, PNG, WebP. Maks 2MB.</p>
                            <div id="f-foto-preview" class="mt-2 hidden">
                                <img id="f-foto-preview-img" src="" alt="Preview" style="max-width:120px;max-height:80px;border-radius:8px;object-fit:cover;border:1px solid var(--border-color);">
                            </div>
                        </div>
                    </div>
                </div>

                
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

                
                <div class="step-content hidden" id="step-3">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Pengadaan & Nilai Aset</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Data pengadaan dan nilai</p>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="gaming-label">Pengadaan (Tahun) <span style="color:#f87171;">*</span></label>
                                <input type="number" name="pengadaan_tahun" id="f-pengadaan_tahun" required placeholder="Masukan tahun pengadaan" class="gaming-input" min="1900" max="<?php echo e(now()->year + 1); ?>">
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

                
                <div class="step-content hidden" id="step-6">
                    <p class="text-sm font-bold mb-1" style="color:var(--text-primary);">Pratinjau Data</p>
                    <p class="text-xs mb-4" style="color:var(--text-muted);">Periksa kembali data sebelum menyimpan</p>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3" id="preview-content">
                        
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
            <a href="<?php echo e(route('admin.peralatan-kantor.template')); ?>" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5 mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                </svg>
                Download Template
            </a>
            <form method="POST" action="<?php echo e(route('admin.peralatan-kantor.import')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
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


<div id="scan-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-lg rounded-3xl shadow-2xl flex flex-col" style="max-height:90vh;background:var(--bg-surface);border:1px solid var(--border-color);" onclick="event.stopPropagation()">
        
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.15);">
                    <svg class="w-5 h-5" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold" style="color:var(--text-primary);">Scan Barcode</h3>
                    <p class="text-xs" style="color:var(--text-muted);">Arahkan kamera ke barcode aset</p>
                </div>
            </div>
            <button type="button" onclick="closeScanModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        
        <div class="px-6 py-4 flex-1 overflow-y-auto">
            
            <div id="scan-status" class="mb-4 text-center">
                <div id="scan-status-idle" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold" style="background:rgba(124,58,237,0.15);color:#a78bfa;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Siap Memindai
                </div>
                <div id="scan-status-scanning" class="hidden inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold" style="background:rgba(59,130,246,0.15);color:#60a5fa;">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                    Memindai...
                </div>
                <div id="scan-status-success" class="hidden inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold" style="background:rgba(16,185,129,0.15);color:#34d399;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Barcode Dikenali!
                </div>
                <div id="scan-status-error" class="hidden inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold" style="background:rgba(239,68,68,0.15);color:#f87171;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="scan-status-error-text">Data aset tidak ditemukan.</span>
                </div>
            </div>

            
            <div id="camera-container" class="relative overflow-hidden rounded-2xl mb-4" style="background:#000;aspect-ratio:4/3;">
                <video id="camera-video" autoplay playsinline muted style="width:100%;height:100%;object-fit:cover;"></video>
                <div id="camera-placeholder" class="absolute inset-0 flex flex-col items-center justify-center" style="background:rgba(0,0,0,0.6);">
                    <svg class="w-16 h-16 mb-3" style="color:rgba(255,255,255,0.3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-xs" style="color:rgba(255,255,255,0.5);">Klik "Mulai Scan" untuk mengaktifkan kamera</p>
                </div>
                
                <div id="scan-line" class="hidden" style="position:absolute;left:10%;right:10%;height:2px;background:linear-gradient(90deg,transparent,#a78bfa,transparent);box-shadow:0 0 12px rgba(124,58,237,0.6);animation:scanLine 2s ease-in-out infinite;"></div>
            </div>

            
            <div class="mb-4">
                <p class="text-xs font-semibold mb-2" style="color:var(--text-muted);">Atau masukkan kode secara manual:</p>
                <div class="flex gap-2">
                    <input type="text" id="manual-code-input" placeholder="Masukkan kode aset atau barcode" class="gaming-input flex-1" style="font-family:monospace;font-size:0.85rem;" onkeypress="if(event.key==='Enter'){manualScan();}">
                    <button type="button" onclick="manualScan()" class="btn btn-primary btn-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari
                    </button>
                </div>
            </div>

            
            <div id="no-camera-warning" class="hidden mb-4 p-3 rounded-xl text-xs" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.3);color:#fbbf24;">
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-semibold">Kamera tidak tersedia</p>
                        <p class="mt-1" style="color:var(--text-muted);">Gunakan input manual di bawah untuk memasukkan kode aset atau barcode.</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="px-6 py-4 flex-shrink-0 flex items-center justify-between" style="border-top:1px solid var(--border-color);">
            <button type="button" id="scan-toggle-btn" onclick="toggleScan()" class="btn btn-primary inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span id="scan-toggle-text">Mulai Scan</span>
            </button>
            <button type="button" onclick="closeScanModal()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>

<?php if(session('import_errors')): ?>
<div class="pt-2">
    <div class="gaming-card p-4" style="border-left:4px solid #f59e0b;">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">
                    Import Selesai: <?php echo e(session('import_success_count')); ?> berhasil, <?php echo e(session('import_error_count')); ?> gagal.
                </p>
                <?php if(session('import_errors')): ?>
                <div class="mt-2 max-h-[200px] overflow-y-auto" style="scrollbar-width:thin;">
                    <ul style="list-style:none;padding:0;margin:0;">
                        <?php $__currentLoopData = session('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="font-size:12px;color:#ef4444;padding:2px 0;"><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            <button type="button" onclick="this.closest('.gaming-card').remove()" class="ml-auto p-1" style="background:none;border:none;cursor:pointer;color:var(--text-muted);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.detail-media-wrap {
    display: flex;
    gap: 10px;
    align-items: flex-start;
}
.detail-media-wrap .detail-foto-col {
    flex: 0 0 38%;
    max-width: 38%;
}
.detail-media-wrap .detail-barcode-col {
    flex: 1;
    min-width: 0;
}
@media (max-width: 640px) {
    .detail-media-wrap {
        flex-direction: column;
    }
    .detail-media-wrap .detail-foto-col,
    .detail-media-wrap .detail-barcode-col {
        flex: none;
        max-width: 100%;
        width: 100%;
    }
}
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
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
@keyframes scanLine {
    0% { top: 10%; }
    50% { top: 85%; }
    100% { top: 10%; }
}
#camera-container { position: relative; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
const itemsData = <?php echo json_encode($itemsJson, 15, 512) ?>;
const scanUrl = '<?php echo e(route("admin.peralatan-kantor.scan")); ?>';
let currentStep = 1;
const totalSteps = 6;
let currentDetailId = null;

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Peralatan';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('item-form').action = '<?php echo e(route('admin.peralatan-kantor.store')); ?>';
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
    document.getElementById('f-foto-preview').classList.add('hidden');
    document.getElementById('f-foto').value = '';
    hitungPenyusutan();
    currentStep = 1;
    showStep(currentStep);
    showModal();
}

function renderDetailCards(i) {
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

    let html = '<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">';
    cards.forEach(function (card) {
        html += '<div style="background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:14px;padding:18px;">';
        html += '<p style="color:var(--color-accent);font-size:0.75rem;font-weight:700;letter-spacing:0.05em;margin-bottom:12px;text-transform:uppercase;">' + card.title + '</p>';
        html += '<div>';
        for (var r = 0; r < card.rows.length; r++) {
            var row = card.rows[r];
            var borderStyle = r < card.rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '';
            html += '<div style="display:flex;justify-content:space-between;align-items:center;padding:7px 0;' + borderStyle + '">';
            html += '<span style="color:var(--text-muted);font-size:0.8rem;">' + row.label + '</span>';
            html += '<span style="color:var(--text-primary);font-size:0.85rem;font-weight:600;text-align:right;margin-left:12px;">' + row.value + '</span>';
            html += '</div>';
        }
        html += '</div></div>';
    });
    html += '</div>';
    return html;
}

function getBarcodeColor() {
    return document.body.classList.contains('dark') ? '#ffffff' : '#000000';
}

function renderBarcode(containerId, code) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    if (!code) {
        document.getElementById('detail-barcode-section').style.display = 'none';
        return;
    }
    document.getElementById('detail-barcode-section').style.display = '';
    document.getElementById('detail-kode-aset').textContent = code;
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.id = 'barcode-svg';
    container.appendChild(svg);
    try {
        const color = getBarcodeColor();
        JsBarcode(svg, code, {
            format: 'CODE128',
            width: 1.2,
            height: 35,
            displayValue: true,
            fontSize: 11,
            font: 'monospace',
            margin: 5,
            background: 'transparent',
            lineColor: color,
            textColor: color,
        });
    } catch (e) {
        container.innerHTML = '<p style="color:var(--text-muted);font-size:12px;">Gagal render barcode</p>';
    }
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

    const fotoSection = document.getElementById('detail-foto-section');
    const fotoImg = document.getElementById('detail-foto-img');
    if (i.foto) {
        fotoImg.src = i.foto;
        fotoSection.style.display = '';
    } else {
        fotoSection.style.display = 'none';
    }

    renderBarcode('detail-barcode-image', i.barcode || i.kode_aset);
    document.getElementById('detail-body').innerHTML = renderDetailCards(i);
    document.getElementById('detail-media-placeholder').style.display = (!i.foto && !i.barcode && !i.kode_aset) ? '' : 'none';
    openModal('detail-modal');
}

function closeDetail() {
    closeModal('detail-modal');
}

function downloadQrCode(id) {
    const i = itemsData.find(x => x.id === id);
    if (!i) return;
    const qrUrl = '<?php echo e(url("/aset")); ?>/' + encodeURIComponent(i.kode_aset) + '/qr';
    const publicUrl = '<?php echo e(url("/aset")); ?>/' + encodeURIComponent(i.kode_aset);

    document.getElementById('label-nama').textContent = i.nama_barang;
    document.getElementById('label-kode').textContent = i.kode_aset;
    document.getElementById('label-url').textContent = publicUrl;
    document.getElementById('label-qr-container').innerHTML = '<img src="' + qrUrl + '" alt="QR Code" style="width:120px;height:120px;">';

    openModal('label-modal');
}

function closeLabelModal() {
    closeModal('label-modal');
}

function printLabelFromModal() {
    const card = document.getElementById('label-card');
    const win = window.open('', '_blank', 'width=400,height=520');
    win.document.write('<!DOCTYPE html><html><head><title>Cetak Label</title><style>@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap");*{box-sizing:border-box;margin:0;padding:0;}body{font-family:"Poppins",sans-serif;display:flex;justify-content:center;padding:20px;background:#fff;}@media print{body{padding:0;}}</style></head><body>' + card.outerHTML + '<script>setTimeout(function(){window.print();},500);<\/script></body></html>');
    win.document.close();
}

function printLabel(id) {
    const i = itemsData.find(x => x.id === id);
    if (!i) return;
    const qrUrl = '<?php echo e(url("/aset")); ?>/' + encodeURIComponent(i.kode_aset) + '/qr';
    const publicUrl = '<?php echo e(url("/aset")); ?>/' + encodeURIComponent(i.kode_aset);
    const logoUrl = '<?php echo e(asset("images/logo/logo_web.png")); ?>';
    const win = window.open('', '_blank', 'width=400,height=500');
    win.document.write(`
        <!DOCTYPE html>
        <html><head><title>Cetak Label - ${i.kode_aset}</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: 'Poppins', sans-serif; display: flex; justify-content: center; padding: 20px; }
            .label { width: 320px; border: 2px solid #1e1e2e; border-radius: 12px; padding: 16px; text-align: center; }
            .logo { width: 48px; height: 48px; object-fit: contain; margin: 0 auto 8px; }
            .brand { font-size: 10px; font-weight: 700; letter-spacing: 0.1em; color: #1e1e2e; margin-bottom: 12px; }
            .name { font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 4px; }
            .code { font-size: 11px; font-family: monospace; color: #7c3aed; font-weight: 700; margin-bottom: 10px; }
            .qr { margin: 0 auto 8px; }
            .qr img { width: 140px; height: 140px; }
            .url { font-size: 7px; color: #94a3b8; word-break: break-all; }
            @media print { body { padding: 0; } .label { border-width: 1px; } }
        </style></head><body>
        <div class="label">
            <img src="${logoUrl}" class="logo" alt="Logo">
            <div class="brand">JOHEN OFFICE</div>
            <div class="name">${i.nama_barang}</div>
            <div class="code">${i.kode_aset}</div>
            <div class="qr"><img src="${qrUrl}" alt="QR Code"></div>
            <div class="url">${publicUrl}</div>
        </div>
        <script>setTimeout(function(){window.print();},800);<\/script>
        </body></html>
    `);
    win.document.close();
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
    document.getElementById('item-form').action = '<?php echo e(url('admin/peralatan-kantor')); ?>/' + i.id;
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

    const fotoPreview = document.getElementById('f-foto-preview');
    const fotoImg = document.getElementById('f-foto-preview-img');
    document.getElementById('f-foto').value = '';
    if (i.foto) {
        fotoImg.src = i.foto;
        fotoPreview.classList.remove('hidden');
    } else {
        fotoPreview.classList.add('hidden');
    }

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
        const el = document.getElementById(pvId);
        const inputEl = document.getElementById(inputName);
        if (el && inputEl) {
            el.textContent = inputEl.value || '-';
        }
    }
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
        showAlertModal('Harap isi semua field yang wajib diisi.');
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

(function() {
    let lastTheme = document.body.classList.contains('dark') ? 'dark' : 'light';
    new MutationObserver(function() {
        const current = document.body.classList.contains('dark') ? 'dark' : 'light';
        if (current !== lastTheme) {
            lastTheme = current;
            const svg = document.getElementById('barcode-svg');
            if (svg && currentDetailId) {
                const item = itemsData.find(x => x.id === currentDetailId);
                if (item) renderBarcode('detail-barcode-image', item.barcode || item.kode_aset);
            }
        }
    }).observe(document.body, { attributes: true, attributeFilter: ['class'] });
})();

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetail(); closeModal('item-modal'); closeScanModal(); closeLabelModal(); }
});

function prepareBlackBarcode() {
    const svg = document.getElementById('barcode-svg');
    if (!svg) return null;
    const clone = svg.cloneNode(true);

    clone.querySelectorAll('*').forEach(el => {
        const tag = el.tagName.toLowerCase();

        if (tag === 'rect' || tag === 'path') {
            const fill = el.getAttribute('fill');
            if (fill && fill !== 'none' && fill !== 'transparent') {
                el.setAttribute('fill', '#000000');
            }
            const stroke = el.getAttribute('stroke');
            if (stroke && stroke !== 'none') {
                el.setAttribute('stroke', '#000000');
            }
        }

        if (tag === 'text') {
            el.setAttribute('fill', '#000000');
            el.setAttribute('stroke', 'none');
            el.setAttribute('font-family', 'monospace');
            if (!el.getAttribute('font-size')) {
                el.setAttribute('font-size', '14');
            }
        }

        if (el.hasAttribute('style')) {
            let s = el.getAttribute('style');
            s = s.replace(/fill\s*:\s*[^;]+/gi, 'fill:#000000');
            s = s.replace(/stroke\s*:\s*[^;]+/gi, 'stroke:#000000');
            s = s.replace(/color\s*:\s*[^;]+/gi, 'color:#000000');
            el.setAttribute('style', s);
        }
    });

    clone.setAttribute('style', 'color:#000000;');
    return clone;
}

function printBarcode() {
    const clone = prepareBlackBarcode();
    if (!clone) return;
    const svgData = new XMLSerializer().serializeToString(clone);
    const win = window.open('', '_blank');
    win.document.write('<html><head><title>Cetak Barcode</title><style>body{display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;font-family:monospace;background:#fff;}svg{max-width:100%;}text,rect,path{fill:#000000 !important;stroke:#000000 !important;}</style></head><body>' + svgData + '<script>setTimeout(function(){window.print();window.close();},500);<\/script></body></html>');
    win.document.close();
}

function downloadBarcode() {
    const clone = prepareBlackBarcode();
    if (!clone) return;
    const svgData = new XMLSerializer().serializeToString(clone);
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const img = new Image();
    img.onload = function() {
        canvas.width = img.width * 2;
        canvas.height = img.height * 2;
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        const a = document.createElement('a');
        a.download = 'barcode-' + (currentDetailId || 'aset') + '.png';
        a.href = canvas.toDataURL('image/png');
        a.click();
    };
    img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
}

/* ===== SCAN BARCODE ===== */
let scanStream = null;
let scanInterval = null;
let scanActive = false;
let html5QrScanner = null;
let scanInProgress = false;

function openScanModal() {
    document.getElementById('scan-status-idle').classList.remove('hidden');
    document.getElementById('scan-status-scanning').classList.add('hidden');
    document.getElementById('scan-status-success').classList.add('hidden');
    document.getElementById('scan-status-error').classList.add('hidden');
    document.getElementById('scan-line').classList.add('hidden');
    document.getElementById('manual-code-input').value = '';
    document.getElementById('no-camera-warning').classList.add('hidden');
    document.getElementById('camera-placeholder').style.display = '';
    document.getElementById('scan-toggle-text').textContent = 'Mulai Scan';
    scanActive = false;
    openModal('scan-modal');
    checkCamera();
    if (!window.BarcodeDetector && !window.Html5Qrcode) {
        const warning = document.getElementById('no-camera-warning');
        warning.innerHTML = '<div class="flex items-start gap-2"><svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div><p class="font-semibold">Pemindaian barcode tidak didukung</p><p class="mt-1" style="color:var(--text-muted);">Browser Anda tidak mendukung pemindaian barcode otomatis. Gunakan Chrome atau Edge, atau masukkan kode secara manual di bawah.</p></div></div>';
        warning.classList.remove('hidden');
    }
}

function closeScanModal() {
    stopScan();
    closeModal('scan-modal');
}

document.getElementById('scan-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeScanModal();
});

async function checkCamera() {
    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videoDevices = devices.filter(d => d.kind === 'videoinput');
        if (videoDevices.length === 0) {
            document.getElementById('no-camera-warning').classList.remove('hidden');
        }
    } catch (e) {
        document.getElementById('no-camera-warning').classList.remove('hidden');
    }
}

function toggleScan() {
    if (!window.BarcodeDetector && !window.Html5Qrcode) {
        showScanStatus('error', 'Pemindaian barcode tidak didukung di browser ini. Gunakan input manual.');
        return;
    }
    if (scanActive) {
        stopScan();
    } else {
        startScan();
    }
}

async function startScan() {
    const video = document.getElementById('camera-video');
    try {
        scanStream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment', width: { ideal: 1280 }, height: { ideal: 720 } }
        });
        video.srcObject = scanStream;
        await video.play();
        document.getElementById('camera-placeholder').style.display = 'none';
        document.getElementById('scan-line').classList.remove('hidden');
        document.getElementById('scan-toggle-text').textContent = 'Hentikan Scan';
        document.getElementById('scan-status-idle').classList.add('hidden');
        document.getElementById('scan-status-scanning').classList.remove('hidden');
        scanActive = true;
        scanInterval = setInterval(captureAndDecode, 1500);
    } catch (err) {
        document.getElementById('no-camera-warning').classList.remove('hidden');
        console.warn('Camera access denied:', err);
    }
}

function stopScan() {
    scanActive = false;
    scanInProgress = false;
    if (scanInterval) { clearInterval(scanInterval); scanInterval = null; }
    if (html5QrScanner) {
        try { html5QrScanner.clear(); } catch(e) {}
        html5QrScanner = null;
    }
    if (scanStream) {
        scanStream.getTracks().forEach(t => t.stop());
        scanStream = null;
    }
    const video = document.getElementById('camera-video');
    video.srcObject = null;
    document.getElementById('scan-line').classList.add('hidden');
    document.getElementById('camera-placeholder').style.display = '';
    document.getElementById('scan-toggle-text').textContent = 'Mulai Scan';
    document.getElementById('scan-status-idle').classList.remove('hidden');
    document.getElementById('scan-status-scanning').classList.add('hidden');
}

async function captureAndDecode() {
    if (!scanActive || scanInProgress) return;
    const video = document.getElementById('camera-video');
    if (video.readyState < video.HAVE_ENOUGH_DATA) return;

    scanInProgress = true;
    try {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0);

        // Method 1: Native BarcodeDetector API
        if (window.BarcodeDetector) {
            try {
                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.8));
                const barcodes = await new BarcodeDetector({ formats: ['code_128', 'ean_13', 'ean_8', 'qr_code', 'code_39'] }).detect(blob);
                if (barcodes.length > 0) {
                    handleScanResult(barcodes[0].rawValue);
                    return;
                }
            } catch (e) {}
        }

        // Method 2: html5-qrcode fallback
        if (window.Html5Qrcode) {
            try {
                if (!html5QrScanner) {
                    let el = document.getElementById('html5qr-region');
                    if (!el) {
                        el = document.createElement('div');
                        el.id = 'html5qr-region';
                        el.style.cssText = 'position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;';
                        document.body.appendChild(el);
                    }
                    html5QrScanner = new Html5Qrcode(el.id);
                }
                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.8));
                const file = new File([blob], 'scan-frame.jpg', { type: 'image/jpeg', lastModified: Date.now() });
                const result = await html5QrScanner.scanFile(file, false);
                if (result) {
                    handleScanResult(result);
                    return;
                }
            } catch (e) {}
        }
    } catch (e) {
        // No barcode detected in this frame
    } finally {
        scanInProgress = false;
    }
}

function manualScan() {
    const code = document.getElementById('manual-code-input').value.trim();
    if (!code) {
        showScanStatus('error', 'Masukkan kode aset atau barcode.');
        return;
    }
    handleScanResult(code);
}

function extractKodeAset(raw) {
    if (!raw) return raw;
    try {
        var u = new URL(raw);
        var parts = u.pathname.replace(/\/+$/, '').split('/');
        var idx = parts.indexOf('aset');
        if (idx !== -1 && parts[idx + 1]) return decodeURIComponent(parts[idx + 1]);
    } catch(e) {}
    var m = raw.match(/\/aset\/([^\/\?#]+)/);
    if (m) return decodeURIComponent(m[1]);
    return raw;
}

function handleScanResult(code) {
    stopScan();
    showScanStatus('scanning', 'Mencari data...');

    var parsedCode = extractKodeAset(code);

    fetch(scanUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ code: parsedCode }),
    })
    .then(res => {
        if (!res.ok) return res.json().then(d => { throw new Error(d.message || 'Data aset tidak ditemukan.'); });
        return res.json();
    })
    .then(data => {
        showScanStatus('success', 'Barcode dikenali! Menampilkan detail...');
        setTimeout(() => {
            closeScanModal();
            const item = itemsData.find(x => x.id === data.id);
            if (item) {
                showDetail(data.id);
            } else {
                showScannedDetail(data);
            }
        }, 1000);
    })
    .catch(err => {
        showScanStatus('error', err.message || 'Data aset tidak ditemukan.');
    });
}

function showScannedDetail(i) {
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

    currentDetailId = i.id;

    var fotoSection = document.getElementById('detail-foto-section');
    var fotoImg = document.getElementById('detail-foto-img');
    if (i.foto) {
        fotoImg.src = i.foto;
        fotoSection.style.display = '';
    } else {
        fotoSection.style.display = 'none';
    }

    renderBarcode('detail-barcode-image', i.barcode || i.kode_aset);
    document.getElementById('detail-body').innerHTML = renderDetailCards(i);
    document.getElementById('detail-media-placeholder').style.display = (!i.foto && !i.barcode && !i.kode_aset) ? '' : 'none';
    openModal('detail-modal');
}

function showScanStatus(type, message) {
    ['idle', 'scanning', 'success', 'error'].forEach(s => {
        const el = document.getElementById('scan-status-' + s);
        if (el) el.classList.add('hidden');
    });
    const el = document.getElementById('scan-status-' + type);
    if (el) {
        el.classList.remove('hidden');
        if (type === 'error') {
            const msgEl = document.getElementById('scan-status-error-text');
            if (msgEl) msgEl.textContent = message;
        }
    }
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

document.getElementById('f-foto')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('f-foto-preview');
    const img = document.getElementById('f-foto-preview-img');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) { img.src = ev.target.result; preview.classList.remove('hidden'); };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/admin/peralatan-kantor/index.blade.php ENDPATH**/ ?>