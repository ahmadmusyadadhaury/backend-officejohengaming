<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Aset Digital'); ?>
<?php $__env->startSection('page-title', 'Data Aset > Digital'); ?>
<?php $__env->startSection('page-subtitle', 'Lisensi software, akun dan layanan digital perusahaan'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zM3 13h18v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Total Aset Digital</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['aktif']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Aset Aktif</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(249,115,22,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#f97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#f97316;"><?php echo e($stats['jatuh_tempo']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fbbf24;"><?php echo e($stats['segera_habis']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Segera Habis</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;"><?php echo e($stats['nonaktif']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Tidak Aktif</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
    </div>

    
    <?php
        $matiCount = $alertAssets->where('status_aset', 'mati')->count();
        $jatuhTempoCount = $alertAssets->where('status_aset', 'jatuh_tempo')->count();
        $segeraCount = $alertAssets->where('status_aset', 'segera_habis')->count();
    ?>
    <?php if($alertAssets->isNotEmpty()): ?>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <?php if($matiCount > 0): ?>
        <div style="flex:1;min-width:260px;">
            <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold" style="color:#ef4444;"><?php echo e($matiCount); ?> Tidak Aktif</div>
                    <div class="text-xs mt-1" style="color:var(--text-secondary);"><?php echo e($matiCount); ?> aset dengan masa berlaku sudah habis.</div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($jatuhTempoCount > 0): ?>
        <div style="flex:1;min-width:260px;">
            <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(249,115,22,0.08);border:1px solid rgba(249,115,22,0.2);">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f97316;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold" style="color:#f97316;"><?php echo e($jatuhTempoCount); ?> Jatuh Tempo</div>
                    <div class="text-xs mt-1" style="color:var(--text-secondary);"><?php echo e($jatuhTempoCount); ?> aset akan berakhir dalam 4-7 hari.</div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($segeraCount > 0): ?>
        <div style="flex:1;min-width:260px;">
            <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold" style="color:#f59e0b;"><?php echo e($segeraCount); ?> Segera Habis</div>
                    <div class="text-xs mt-1" style="color:var(--text-secondary);"><?php echo e($segeraCount); ?> aset akan berakhir dalam 1-3 hari.</div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Data Aset Digital</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Lisensi software, akun dan layanan digital perusahaan.</div>
            </div>
            <?php if(auth()->user()->role !== 'gm'): ?>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset Digital
            </button>
            <?php endif; ?>
        </div>
        <div class="px-6 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-digital" placeholder="Cari nama aset atau PIC" oninput="filterDigital()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="<?php echo e(route('admin.export', ['type' => 'digital-assets', 'filter' => 'all'])); ?>" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export</a>
                <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Status</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="aktif" onclick="setFilter('aktif')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    <button type="button" data-value="segera_habis" onclick="setFilter('segera_habis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Segera Habis</button>
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Tidak Aktif</button>
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[700px]" id="digital-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th class="hidden md:table-cell">Email</th>
                        <th class="hidden md:table-cell">Mulai</th>
                        <th class="hidden md:table-cell">Berakhir</th>
                        <th class="hidden md:table-cell">Biaya</th>
                        <th>Status</th>
                        <th>PIC</th>
                        <th class="hidden lg:table-cell">Jabatan</th>
                        <th class="hidden md:table-cell">Keterangan</th>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="digital-tbody">
                    <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusBadge = match($a->status_aset) {
                            'aktif'        => 'badge-green',
                            'jatuh_tempo'  => 'badge-orange',
                            'segera_habis' => 'badge-yellow',
                            'mati'         => 'badge-red',
                            default        => 'badge-gray',
                        };
                        $statusLabel = match($a->status_aset) {
                            'aktif'        => 'Aktif',
                            'jatuh_tempo'  => 'Jatuh Tempo',
                            'segera_habis' => 'Segera Habis',
                            'mati'         => 'Tidak Aktif',
                            default        => '-',
                        };
                    ?>
                    <tr data-status="<?php echo e($a->status_aset); ?>">
                        <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($a->nama_aset); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($a->email); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($a->mulai?->format('d/m/Y')); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($a->berakhir?->format('d/m/Y')); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">Rp <?php echo e(number_format($a->biaya, 0, ',', '.')); ?></td>
                        <td>
                            <span class="badge <?php echo e($statusBadge); ?>"><?php echo e($statusLabel); ?></span>
                            <?php if(in_array($a->status_aset, ['jatuh_tempo', 'segera_habis', 'mati'])): ?>
                            <br><span class="text-[9px] font-semibold" style="color:var(--text-muted);"><?php echo e($a->hari_aset); ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--text-muted);"><?php echo e($a->pic); ?></td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);"><?php echo e($a->jabatan); ?></td>
                        <td class="hidden md:table-cell" style="max-width:150px;">
                            <div style="display:flex;align-items:center;gap:4px;">
                                <span id="kep-<?php echo e($a->id); ?>" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--text-muted);" title="<?php echo e($a->keperluan); ?>"><?php echo e($a->keperluan ?? '-'); ?></span>
                                <button type="button" onclick="editKeterangan(<?php echo e($a->id); ?>)" style="flex-shrink:0;padding:2px;border:none;background:none;cursor:pointer;color:var(--text-muted);border-radius:4px;" onmouseover="this.style.color='var(--text-primary)'" onmouseout="this.style.color='var(--text-muted)'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                            </div>
                        </td>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail(<?php echo e($a->id); ?>)" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, <?php echo e($a->id); ?>)" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-<?php echo e($a->id); ?>" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail(<?php echo e($a->id); ?>)" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal(<?php echo e($a->id); ?>)" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="<?php echo e(route('admin.digital-assets.destroy', $a)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset digital ini?" style="margin:0;">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr id="empty-row">
                        <td colspan="10" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data aset digital.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<div id="detail-modal" class="modal-modern" onclick="if(event.target===this)closeDetail()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="detail-title">Detail Aset Digital</h3>
            <button type="button" onclick="closeDetail()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body" id="detail-body"></div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetail()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>


<div id="digital-modal" class="modal-modern" onclick="if(event.target===this)closeModal('digital-modal')">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="modal-title">Tambah Aset Digital</h3>
            <button type="button" onclick="closeModal('digital-modal')" class="modal-modern-close">&times;</button>
        </div>
        <form id="digital-form" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="id" id="form-id" value="">
            <div class="modal-modern-body">
                <div class="form-grid-2">
                    <div class="field-group">
                        <label class="gaming-label">Nama Aset <span class="field-req">*</span></label>
                        <input type="text" name="nama_aset" id="f-nama_aset" required placeholder="Masukan nama aset" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Email <span class="field-req">*</span></label>
                        <input type="email" name="email" id="f-email" required placeholder="Masukan email" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Mulai <span class="field-req">*</span></label>
                        <input type="date" name="mulai" id="f-mulai" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Berakhir <span class="field-req">*</span></label>
                        <input type="date" name="berakhir" id="f-berakhir" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Biaya <span class="field-req">*</span></label>
                        <input type="number" name="biaya" id="f-biaya" required placeholder="Masukan biaya" class="gaming-input" min="0" step="0.01">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Status</label>
                        <div style="padding:8px 0;font-size:13px;color:var(--text-muted);">Otomatis berdasarkan tanggal Berakhir</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" id="f-pic" required placeholder="Masukan nama PIC" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
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
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Keterangan <span class="field-req">*</span></label>
                        <textarea name="keperluan" id="f-keperluan" required placeholder="Masukan keperluan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>

            <div class="modal-modern-footer gap-2">
                <button type="button" onclick="closeModal('digital-modal')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary" id="form-submit-btn">Tambah</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px 24px;
    margin-bottom: 16px;
}
@media (max-width: 640px) {
    .form-grid-2 { grid-template-columns: 1fr; }
}
.field-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.field-req { color: #f87171; }
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const digitalData = <?php echo json_encode($assetsJson, 15, 512) ?>;
const csrfToken = '<?php echo e(csrf_token()); ?>';

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Aset Digital';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('digital-form').action = '<?php echo e(route('admin.digital-assets.store')); ?>';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('digital-form').querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') {
            el.value = '';
        }
    });
    showModal();
}

function showDetail(id) {
    const a = digitalData.find(i => i.id === id);
    if (!a) return;
    document.getElementById('detail-title').textContent = a.nama_aset;

    const rp = a.biaya ? 'Rp ' + Number(a.biaya).toLocaleString('id-ID') : '-';
    const statusMap = {
        aktif:        { label: 'Aktif',        bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
        jatuh_tempo:  { label: 'Jatuh Tempo',  bg: '#fff7ed', text: '#f97316', border: '#fed7aa' },
        segera_habis: { label: 'Segera Habis', bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
        mati:         { label: 'Tidak Aktif',  bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
    };
    const st = statusMap[a.status_aset] || statusMap.mati;

    const rows = [
        { label: 'Nama Aset', value: a.nama_aset },
        { label: 'Email', value: a.email },
        { label: 'Mulai', value: a.mulai },
        { label: 'Berakhir', value: a.berakhir },
        { label: 'Biaya', value: rp },
        { label: 'PIC', value: a.pic },
        { label: 'Jabatan', value: a.jabatan },
        { label: 'Keterangan', value: a.keperluan || '-' },
    ];

    const detailBody = document.getElementById('detail-body');
    detailBody.innerHTML = `
        <div class="space-y-1">
            ${rows.map((r, i) => `
                <div class="flex items-center justify-between py-2.5" ${i < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
                </div>
            `).join('')}
            <div class="flex items-center justify-between py-2.5">
                <p class="text-sm" style="color:var(--text-muted);">Status</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${st.bg};color:${st.text};border:1px solid ${st.border};">${st.label}${a.status_aset !== 'aktif' ? ' (' + (a.hari_aset || '') + ')' : ''}</span>
            </div>
        </div>
    `;
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
    const a = digitalData.find(i => i.id === id);
    if (!a) return;

    document.getElementById('modal-title').textContent = 'Edit Aset Digital';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = a.id;
    document.getElementById('digital-form').action = '<?php echo e(url('admin/digital-assets')); ?>/' + a.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    document.getElementById('f-nama_aset').value = a.nama_aset;
    document.getElementById('f-email').value = a.email;
    document.getElementById('f-mulai').value = a.mulai ? a.mulai.split('/').reverse().join('-') : '';
    document.getElementById('f-berakhir').value = a.berakhir ? a.berakhir.split('/').reverse().join('-') : '';
    document.getElementById('f-biaya').value = a.biaya;
    document.getElementById('f-pic').value = a.pic;
    document.getElementById('f-jabatan').value = a.jabatan;
    document.getElementById('f-keperluan').value = a.keperluan;

    showModal();
}

function showModal() { openModal('digital-modal'); }

document.getElementById('digital-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('digital-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetail(); closeModal('digital-modal'); }
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
    filterDigital();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterDigital() {
    const search = (document.getElementById('search-digital')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#digital-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowStatus === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}

function editKeterangan(id) {
    var span = document.getElementById('kep-' + id);
    if (!span) return;
    var current = span.textContent === '-' ? '' : span.textContent;
    var input = document.createElement('input');
    input.type = 'text';
    input.value = current;
    input.style.cssText = 'padding:2px 6px;font-size:13px;width:100%;box-sizing:border-box;border-radius:6px;background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;';
    span.style.display = 'none';
    span.parentNode.insertBefore(input, span.nextSibling);
    input.focus();
    input.select();

    function done() {
        var val = input.value.trim();
        fetch('/admin/digital-assets/' + id, {
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ keperluan: val || '' }),
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                span.textContent = val || '-';
                span.title = val || '';
                var a = digitalData.find(function(i) { return i.id === id; });
                if (a) a.keperluan = val;
            }
        })
        .catch(function() {})
        .finally(function() {
            span.style.display = '';
            input.remove();
        });
    }

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); done(); }
        if (e.key === 'Escape') { span.style.display = ''; input.remove(); }
    });
    input.addEventListener('blur', done);
}

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\digital-assets\index.blade.php ENDPATH**/ ?>