<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'SIM Card'); ?>
<?php $__env->startSection('page-title', 'Data Aset > SIM Card'); ?>
<?php $__env->startSection('page-subtitle', 'Seluruh nomor SIM Card operasional perusahaan'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    
    <?php
        $alertGroups = $alerts->groupBy(function($c) {
            $s = $c->status_sim;
            if ($s === 'mati') return 'mati';
            if ($s === 'segera_habis') return 'segera_habis';
            if ($s === 'jatuh_tempo') return 'jatuh_tempo';
            return 'other';
        });
    ?>
    <?php if($alerts->isNotEmpty()): ?>
    <div class="space-y-2">
        <?php if(isset($alertGroups['mati'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #ef4444;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['mati']->count()); ?> SIM Card</span>
                <span style="color:var(--text-muted);"> dengan masa tenggang sudah lewat.</span>
                <button type="button" onclick="setFilter('mati')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($alertGroups['segera_habis'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #f59e0b;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['segera_habis']->count()); ?> SIM Card</span>
                <span style="color:var(--text-muted);"> akan segera habis masa tenggangnya (≤3 hari).</span>
                <button type="button" onclick="setFilter('segera_habis')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($alertGroups['jatuh_tempo'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #f97316;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['jatuh_tempo']->count()); ?> SIM Card</span>
                <span style="color:var(--text-muted);"> akan jatuh tempo (≤7 hari).</span>
                <button type="button" onclick="setFilter('jatuh_tempo')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zM3 13h18v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total SIM Card</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh nomor SIM Card</div>
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
                <div class="text-xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['aktif']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Aktif</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(249,115,22,0.15);box-shadow:none rgba(249,115,22,0.2);">
                <svg class="w-[18px]" style="color:#fb923c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fb923c;"><?php echo e($stats['jatuh_tempo']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#f59e0b;"><?php echo e($stats['segera_habis']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Segera Habis</div>
                
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
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;"><?php echo e($stats['mati']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Mati</div>
                
            </div>
        </div>
    </div>

    
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Data SIM Card</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Seluruh nomor SIM Card operasional perusahaan.</div>
            </div>
            <?php if(auth()->user()->role !== 'gm'): ?>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah SIM Card
            </button>
            <?php endif; ?>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-sim" placeholder="Cari nomor SIM atau PIC" oninput="filterSim()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="<?php echo e(route('admin.export', ['type' => 'sim-cards', 'filter' => 'all'])); ?>" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export</a>
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
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Mati</button>
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[800px]" id="sim-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No SIM Card</th>
                        <th>PIC</th>
                        <th class="hidden md:table-cell">Keperluan</th>
                        <th class="hidden md:table-cell">Masa Aktif</th>
                        <th class="hidden lg:table-cell">Masa Tenggang</th>
                        <th style="color:var(--text-muted);font-size:0.65rem;">Hari</th>
                        <th>Status</th>
                        <?php if(auth()->user()->role !== 'gm'): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody id="sim-tbody">
                    <?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusSim = $c->status_sim;
                        $badgeClass = match($statusSim) {
                            'aktif' => 'badge-green',
                            'jatuh_tempo' => 'badge-orange',
                            'segera_habis' => 'badge-yellow',
                            'mati' => 'badge-red',
                            default => 'badge-red',
                        };
                        $statusLabel = match($statusSim) {
                            'aktif' => 'Aktif',
                            'jatuh_tempo' => 'Jatuh Tempo',
                            'segera_habis' => 'Segera Habis',
                            'mati' => 'Mati',
                            default => 'Nonaktif',
                        };
                    ?>
                    <tr data-status="<?php echo e($statusSim); ?>">
                        <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
                        <td style="color:var(--text-primary);font-weight:600;font-family:monospace;"><?php echo e($c->nomor_sim_card); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($c->pic); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="<?php echo e($c->keperluan); ?>"><?php echo e($c->keperluan ?? '—'); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($c->masa_aktif?->format('d M Y')); ?></td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);"><?php echo e($c->masa_tenggang?->format('d M Y')); ?></td>
                        <td style="color:var(--text-muted);font-size:0.7rem;"><?php echo e($c->hari_sim); ?></td>
                        <td><span class="badge <?php echo e($badgeClass); ?>"><?php echo e($statusLabel); ?></span></td>
                        <?php if(auth()->user()->role !== 'gm'): ?><td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail(<?php echo e($c->id); ?>)" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, <?php echo e($c->id); ?>)" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-<?php echo e($c->id); ?>" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail(<?php echo e($c->id); ?>)" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal(<?php echo e($c->id); ?>)" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="<?php echo e(route('admin.sim-cards.destroy', $c)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus SIM Card ini?" style="margin:0;">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td><?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr id="empty-row">
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data SIM Card.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<div id="detail-modal" class="modal-modern" onclick="if(event.target===this)closeDetail()">
    <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Detail SIM Card</h3>
            <button type="button" onclick="closeDetail()" class="modal-modern-close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-modern-body" id="detail-body"></div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetail()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>


<div id="sim-modal" class="modal-modern" onclick="if(event.target===this)closeModal('sim-modal')">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">

        <div class="modal-modern-header">
            <h3 id="modal-title">Tambah SIM Card</h3>
            <button type="button" onclick="closeModal('sim-modal')" class="modal-modern-close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="sim-form" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="id" id="form-id" value="">

            <div class="modal-modern-body">
                <div class="form-grid-2">
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Nomor SIM Card <span class="field-req">*</span></label>
                        <input type="text" name="nomor_sim_card" id="f-nomor_sim_card" required placeholder="Masukan nomor SIM Card" class="gaming-input">
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
                    <div class="field-group">
                        <label class="gaming-label">Masa Aktif <span class="field-req">*</span></label>
                        <input type="date" name="masa_aktif" id="f-masa_aktif" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Masa Tenggang <span class="field-req">*</span></label>
                        <input type="date" name="masa_tenggang" id="f-masa_tenggang" required class="gaming-input">
                    </div>
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Status Kartu <span class="field-req">*</span></label>
                        <select name="status_kartu" id="f-status_kartu" required class="gaming-input">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Keperluan <span class="field-req">*</span></label>
                        <textarea name="keperluan" id="f-keperluan" required placeholder="Masukan keperluan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-modern-footer gap-2">
                <button type="button" onclick="closeModal('sim-modal')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary" id="form-submit-btn">Simpan</button>
            </div>
        </form>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
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
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const simData = <?php echo json_encode($cardsJson, 15, 512) ?>;

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah SIM Card';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('sim-form').action = '<?php echo e(route('admin.sim-cards.store')); ?>';
    document.getElementById('form-submit-btn').textContent = 'Simpan';
    document.getElementById('sim-form').querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') {
            el.value = '';
        }
    });
    document.getElementById('f-status_kartu').value = '1';
    showModal();
}

function showDetail(id) {
    const c = simData.find(i => i.id === id);
    if (!c) return;
    document.getElementById('detail-title').textContent = c.nomor_sim_card;

    const statusMap = {
        'aktif': { label: 'Aktif', color: '#059669', bg: '#ecfdf5', border: '#a7f3d0' },
        'jatuh_tempo': { label: 'Jatuh Tempo', color: '#c2410c', bg: '#fff7ed', border: '#fed7aa' },
        'segera_habis': { label: 'Segera Habis', color: '#b45309', bg: '#fefce8', border: '#fde68a' },
        'mati': { label: 'Mati', color: '#dc2626', bg: '#fef2f2', border: '#fecaca' },
    };
    const s = statusMap[c.status_sim] || statusMap['mati'];

    const rows = [
        { label: 'Nomor SIM Card', value: c.nomor_sim_card },
        { label: 'PIC', value: c.pic },
        { label: 'Jabatan', value: c.jabatan },
        { label: 'Masa Aktif', value: c.masa_aktif },
        { label: 'Masa Tenggang', value: c.masa_tenggang },
        { label: 'Hari', value: c.hari_sim },
        { label: 'Keperluan', value: c.keperluan || '-' },
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
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${s.bg};color:${s.color};border:1px solid ${s.border};">${s.label}</span>
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
    const c = simData.find(i => i.id === id);
    if (!c) return;

    document.getElementById('modal-title').textContent = 'Edit SIM Card';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = c.id;
    document.getElementById('sim-form').action = '<?php echo e(url('admin/sim-cards')); ?>/' + c.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    document.getElementById('f-nomor_sim_card').value = c.nomor_sim_card;
    document.getElementById('f-pic').value = c.pic;
    document.getElementById('f-jabatan').value = c.jabatan;
    document.getElementById('f-masa_aktif').value = c.masa_aktif ? c.masa_aktif.split('/').reverse().join('-') : '';
    document.getElementById('f-masa_tenggang').value = c.masa_tenggang ? c.masa_tenggang.split('/').reverse().join('-') : '';
    document.getElementById('f-status_kartu').value = c.status_kartu ? '1' : '0';
    document.getElementById('f-keperluan').value = c.keperluan;

    showModal();
}

function showModal() { openModal('sim-modal'); }

document.getElementById('sim-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('sim-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetail(); closeModal('sim-modal'); }
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
    filterSim();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterSim() {
    const search = (document.getElementById('search-sim')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#sim-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowStatus === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\sim-cards\index.blade.php ENDPATH**/ ?>