<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Kelola Akun Koordinator'); ?>
<?php $__env->startSection('page-title', 'Overview > Kelola Akun Koordinator'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola akun koordinator divisi dengan akses TERBATAS (menu Meeting saja).'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Akun Koordinator</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Kelola akun koordinator divisi dengan akses TERBATAS (menu Meeting saja).</div>
            </div>
<?php if(auth()->user()->role !== 'gm'): ?>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Koordinator
            </button>
<?php endif; ?>
        </div>
        <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" id="filter-form">
        <input type="hidden" name="status" id="status-input" value="<?php echo e(request('status')); ?>">
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari..."
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label"><?php echo e(request('status') === 'active' ? 'Aktif' : (request('status') === 'inactive' ? 'Nonaktif' : 'Semua Status')); ?></span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="" onclick="setFilter('')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="active" onclick="setFilter('active')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="inactive" onclick="setFilter('inactive')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Nonaktif</button>
                </div>
            </div>
        </div>
        </form>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Divisi</th>
                        <th>Status</th>
<?php if(auth()->user()->role !== 'gm'): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted);"><?php echo e($users->firstItem() + $loop->index); ?></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($user->name); ?></td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;"><?php echo e($user->username); ?></code></td>
                        <td>
                            <span class="badge badge-primary"><?php echo e($user->role_label); ?></span>
                        </td>
                        <td style="color:var(--text-muted);"><?php echo e($user->team?->name ?? '—'); ?></td>
                        <td>
                            <span class="badge <?php echo e($user->is_active ? 'badge-green' : 'badge-red'); ?>">
                                <?php echo e($user->is_active ? 'Aktif' : 'Nonaktif'); ?>

                            </span>
                        </td>
<?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <button type="button" onclick="openDetailModal(<?php echo e(json_encode(['id'=>$user->id,'name'=>$user->name,'username'=>$user->username,'role'=>$user->role,'role_label'=>$user->role_label,'team_name'=>($user->team?->name ?? '—'),'is_active'=>$user->is_active])); ?>)" class="btn btn-secondary btn-sm" style="margin-right:4px;display:inline-flex;align-items:center;gap:4px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Detail
                            </button>
                            <div class="dropdown-wrap" style="display:inline-block;position:relative;">
                                <button type="button" onclick="toggleDropdown(event)" class="btn btn-secondary btn-sm" style="padding:6px 10px;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                                </button>
                                <div class="dropdown-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:140px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                    <button type="button" onclick="openEditModal(<?php echo e(json_encode(['id'=>$user->id,'name'=>$user->name,'username'=>$user->username,'role'=>$user->role,'team_id'=>$user->team_id,'is_active'=>$user->is_active])); ?>)" style="display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:8px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun ini?" style="margin:0;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button style="display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:8px 12px;border:none;background:none;font-size:13px;color:#f87171;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
<?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun koordinator ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);"><?php echo e($users->links()); ?></div>
    </div>

    
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Karyawan</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Akun karyawan biasa dengan akses terbatas.</div>
            </div>
<?php if(auth()->user()->role !== 'gm'): ?>
            <button type="button" onclick="openCreateKaryawanModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Karyawan
            </button>
<?php endif; ?>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Divisi</th>
                        <th>Status</th>
<?php if(auth()->user()->role !== 'gm'): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $karyawans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $karyawan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted);"><?php echo e($karyawans->firstItem() + $loop->index); ?></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($karyawan->name); ?></td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;"><?php echo e($karyawan->username); ?></code></td>
                        <td style="color:var(--text-muted);"><?php echo e($karyawan->team?->name ?? '—'); ?></td>
                        <td>
                            <span class="badge <?php echo e($karyawan->is_active ? 'badge-green' : 'badge-red'); ?>">
                                <?php echo e($karyawan->is_active ? 'Aktif' : 'Nonaktif'); ?>

                            </span>
                        </td>
<?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <button type="button" onclick="openDetailKaryawanModal(<?php echo e(json_encode(['id'=>$karyawan->id,'name'=>$karyawan->name,'username'=>$karyawan->username,'team_name'=>($karyawan->team?->name ?? '—'),'is_active'=>$karyawan->is_active])); ?>)" class="btn btn-secondary btn-sm" style="margin-right:4px;display:inline-flex;align-items:center;gap:4px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Detail
                            </button>
                            <div class="dropdown-wrap" style="display:inline-block;position:relative;">
                                <button type="button" onclick="toggleDropdown(event)" class="btn btn-secondary btn-sm" style="padding:6px 10px;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                                </button>
                                <div class="dropdown-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:140px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                    <button type="button" onclick="openEditKaryawanModal(<?php echo e(json_encode(['id'=>$karyawan->id,'name'=>$karyawan->name,'username'=>$karyawan->username,'team_id'=>$karyawan->team_id,'is_active'=>$karyawan->is_active])); ?>)" style="display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:8px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="<?php echo e(route('admin.users.karyawan.destroy', $karyawan)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun karyawan ini?" style="margin:0;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button style="display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:8px 12px;border:none;background:none;font-size:13px;color:#f87171;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
<?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun karyawan ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);"><?php echo e($karyawans->links()); ?></div>
    </div>
</div>


<div id="detail-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Detail Akun Koordinator</h3>
            <button type="button" onclick="closeDetailModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body space-y-4">
            <div>
                <label class="gaming-label">Nama Lengkap</label>
                <div id="detail-name" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Username</label>
                <div id="detail-username" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--color-neon-blue);font-family:monospace;">—</div>
            </div>
            <div>
                <label class="gaming-label">Role</label>
                <div id="detail-role" style="padding:8px 12px;">—</div>
            </div>
            <div>
                <label class="gaming-label">Divisi / Tim</label>
                <div id="detail-team" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Status</label>
                <div id="detail-status" style="padding:8px 12px;">—</div>
            </div>
        </div>
        <div class="modal-modern-footer gap-2">
            <button type="button" id="detail-edit-btn" class="btn btn-primary">Edit</button>
            <button type="button" onclick="closeDetailModal()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>


<div id="edit-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Akun Koordinator</h3>
            <button type="button" onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-form" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" id="edit-username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Role</label>
                    <select name="role" id="edit-role" onchange="toggleEditTeam(this.value)" class="gaming-input gaming-select">
                        <option value="koordinator">Koordinator</option>
                        <option value="user">Karyawan</option>
                        <option value="admin_ga">Admin General Affairs</option>
                    </select>
                </div>
                <div id="edit-team-field">
                    <label class="gaming-label">Tim</label>
                    <select name="team_id" id="edit-team-id" class="gaming-input gaming-select">
                        <option value="">— Pilih Tim —</option>
                        <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($team->id); ?>"><?php echo e($team->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>


<div id="create-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Koordinator</h3>
            <button type="button" onclick="closeCreateModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-form" method="POST" action="<?php echo e(route('admin.users.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password <span style="color:#f87171;">*</span></label>
                    <input type="password" name="password" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Role <span style="color:#f87171;">*</span></label>
                    <select name="role" id="create-role" required onchange="toggleCreateTeam(this.value)" class="gaming-input gaming-select">
                        <option value="">Pilih Role</option>
                        <option value="koordinator">Koordinator</option>
                        <option value="user">Karyawan</option>
                        <option value="admin_ga">Admin General Affairs</option>
                    </select>
                </div>
                <div id="create-team-field" style="display:none;">
                    <label class="gaming-label">Tim <span style="color:#f87171;">*</span></label>
                    <select name="team_id" class="gaming-input gaming-select">
                        <option value="">Pilih Tim</option>
                        <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($team->id); ?>"><?php echo e($team->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <button type="button" onclick="closeCreateModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>


<div id="detail-karyawan-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Detail Akun Karyawan</h3>
            <button type="button" onclick="closeDetailKaryawanModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body space-y-4">
            <div>
                <label class="gaming-label">Nama Lengkap</label>
                <div id="detail-karyawan-name" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Username</label>
                <div id="detail-karyawan-username" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--color-neon-blue);font-family:monospace;">—</div>
            </div>
            <div>
                <label class="gaming-label">Divisi / Tim</label>
                <div id="detail-karyawan-team" style="padding:8px 12px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:8px;font-size:0.85rem;color:var(--text-primary);">—</div>
            </div>
            <div>
                <label class="gaming-label">Status</label>
                <div id="detail-karyawan-status" style="padding:8px 12px;">—</div>
            </div>
        </div>
        <div class="modal-modern-footer gap-2">
            <button type="button" id="detail-karyawan-edit-btn" class="btn btn-primary">Edit</button>
            <button type="button" onclick="closeDetailKaryawanModal()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>


<div id="edit-karyawan-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Akun Karyawan</h3>
            <button type="button" onclick="closeEditKaryawanModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-karyawan-form" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-karyawan-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" id="edit-karyawan-username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Tim</label>
                    <select name="team_id" id="edit-karyawan-team-id" class="gaming-input gaming-select">
                        <option value="">— Tanpa Tim —</option>
                        <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($team->id); ?>"><?php echo e($team->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-karyawan-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-karyawan-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditKaryawanModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>


<div id="create-karyawan-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Karyawan</h3>
            <button type="button" onclick="closeCreateKaryawanModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-karyawan-form" method="POST" action="<?php echo e(route('admin.users.karyawan.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password <span style="color:#f87171;">*</span></label>
                    <input type="password" name="password" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Tim</label>
                    <select name="team_id" class="gaming-input gaming-select">
                        <option value="">— Tanpa Tim —</option>
                        <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($team->id); ?>"><?php echo e($team->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <button type="button" onclick="closeCreateKaryawanModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleFilterMenu(e) {
    e.stopPropagation();
    var menu = document.getElementById('filter-menu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function setFilter(value) {
    document.getElementById('status-input').value = value;
    document.getElementById('filter-menu').style.display = 'none';
    document.getElementById('filter-form').submit();
}
document.addEventListener('click', function(e) {
    var menu = document.getElementById('filter-menu');
    if (menu && !e.target.closest('.filter-dropdown-wrap')) {
        menu.style.display = 'none';
    }
    document.querySelectorAll('.dropdown-menu').forEach(function(d) {
        if (!e.target.closest('.dropdown-wrap')) d.style.display = 'none';
    });
});

function toggleDropdown(e) {
    e.stopPropagation();
    var parent = e.currentTarget.closest('.dropdown-wrap');
    var menu = parent.querySelector('.dropdown-menu');
    document.querySelectorAll('.dropdown-menu').forEach(function(d) { if (d !== menu) d.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

function openDetailModal(data) {
    document.getElementById('detail-name').textContent = data.name;
    document.getElementById('detail-username').textContent = data.username;
    document.getElementById('detail-role').innerHTML = '<span class="badge badge-primary">' + data.role_label + '</span>';
    document.getElementById('detail-team').textContent = data.team_name;
    document.getElementById('detail-status').innerHTML = data.is_active == 1
        ? '<span class="badge badge-green">Aktif</span>'
        : '<span class="badge badge-red">Nonaktif</span>';
    document.getElementById('detail-edit-btn').onclick = function() {
        closeDetailModal();
        openEditModal(data);
    };
    openModal('detail-modal');
}
function closeDetailModal() { closeModal('detail-modal'); }

function openEditModal(data) {
    document.getElementById('edit-form').action = '/admin/users/' + data.id;
    document.getElementById('edit-name').value = data.name;
    document.getElementById('edit-username').value = data.username;
    document.getElementById('edit-role').value = data.role;
    document.getElementById('edit-team-id').value = data.team_id || '';
    document.getElementById('edit-is-active').checked = data.is_active == 1;
    toggleEditTeam(data.role);
    openModal('edit-modal');
}
function closeEditModal() { closeModal('edit-modal'); }
function toggleEditTeam(role) {
    document.getElementById('edit-team-field').style.display = ['koordinator','user'].includes(role) ? 'block' : 'none';
}

function openCreateModal() {
    document.getElementById('create-form').reset();
    document.getElementById('create-team-field').style.display = 'none';
    openModal('create-modal');
}
function closeCreateModal() { closeModal('create-modal'); }
function toggleCreateTeam(role) {
    document.getElementById('create-team-field').style.display = ['koordinator','user'].includes(role) ? 'block' : 'none';
}

function openDetailKaryawanModal(data) {
    document.getElementById('detail-karyawan-name').textContent = data.name;
    document.getElementById('detail-karyawan-username').textContent = data.username;
    document.getElementById('detail-karyawan-team').textContent = data.team_name;
    document.getElementById('detail-karyawan-status').innerHTML = data.is_active == 1
        ? '<span class="badge badge-green">Aktif</span>'
        : '<span class="badge badge-red">Nonaktif</span>';
    document.getElementById('detail-karyawan-edit-btn').onclick = function() {
        closeDetailKaryawanModal();
        openEditKaryawanModal(data);
    };
    openModal('detail-karyawan-modal');
}
function closeDetailKaryawanModal() { closeModal('detail-karyawan-modal'); }

function openEditKaryawanModal(data) {
    document.getElementById('edit-karyawan-form').action = '/admin/users/karyawan/' + data.id;
    document.getElementById('edit-karyawan-name').value = data.name;
    document.getElementById('edit-karyawan-username').value = data.username;
    document.getElementById('edit-karyawan-team-id').value = data.team_id || '';
    document.getElementById('edit-karyawan-is-active').checked = data.is_active == 1;
    openModal('edit-karyawan-modal');
}
function closeEditKaryawanModal() { closeModal('edit-karyawan-modal'); }

function openCreateKaryawanModal() {
    document.getElementById('create-karyawan-form').reset();
    openModal('create-karyawan-modal');
}
function closeCreateKaryawanModal() { closeModal('create-karyawan-modal'); }

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetailModal(); closeEditModal(); closeCreateModal(); closeDetailKaryawanModal(); closeEditKaryawanModal(); closeCreateKaryawanModal(); }
});
</script>
<?php $__env->startPush('styles'); ?>
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/admin/users/index.blade.php ENDPATH**/ ?>