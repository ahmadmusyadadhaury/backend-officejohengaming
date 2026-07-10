<?php $__env->startSection('title', 'Meeting'); ?>
<?php $__env->startSection('page-title', 'Meeting'); ?>
<?php $__env->startSection('page-subtitle', 'Selamat datang, ' . auth()->user()->name); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-section stagger-children">

    
    <?php if(($dueTagihanCount ?? 0) > 0): ?>
    <div class="dashboard-section">
        <a href="<?php echo e(route('payment-approval.tagihan')); ?>" style="text-decoration:none;display:block;">
            <div class="stat-card-compact" style="border-color:rgba(239,68,68,0.2);background:rgba(239,68,68,0.03);">
                <div class="stat-icon-box" style="background:rgba(239,68,68,0.12);width:2.5rem;height:2.5rem;">
                    <svg class="w-4 h-4" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold" style="color:#ef4444;"><?php echo e($dueTagihanCount); ?> Tagihan Jatuh Tempo</p>
                    <p class="text-xs" style="color:var(--text-muted);">Klik untuk lihat dan bayar tagihan</p>
                </div>
                <svg class="w-4 h-4 flex-shrink-0" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>
    </div>
    <?php endif; ?>

    
    <div class="dashboard-section">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 md:gap-3">
            <?php
                $userStatCards = [
                    ['label' => 'Total Undangan', 'desc' => 'Meeting yang melibatkan kamu.', 'count' => $totalInvitations, 'color' => '#60a5fa', 'bg' => 'rgba(59,130,246,0.12)', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['label' => 'Mendatang', 'count' => $mendatangCount, 'color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.12)', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['label' => 'Selesai', 'count' => $selesaiCount, 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.12)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            ?>
            <?php $__currentLoopData = $userStatCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="stat-card-compact">
                <div class="stat-icon-box" style="background:<?php echo e($card['bg']); ?>;box-shadow:0 0 14px <?php echo e($card['color']); ?>20;">
                    <svg style="color:<?php echo e($card['color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($card['icon']); ?>"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-num" style="color:<?php echo e($card['color']); ?>;"><?php echo e($card['count']); ?></div>
                    <div class="stat-label-text" style="font-size:0.7rem;"><?php echo e($card['label']); ?></div>
                    <?php if(isset($card['desc'])): ?>
                    <div class="text-[0.6rem]" style="color:var(--text-muted);margin-top:1px;"><?php echo e($card['desc']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="dashboard-section">
        <div class="gaming-card overflow-hidden">
            <div class="card-header">
                <span class="card-header-title">
                    <svg style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Meeting Hari Ini
                </span>
                <span class="badge badge-green text-[0.6rem]"><?php echo e(today()->isoFormat('D MMM')); ?></span>
            </div>
            <div>
                <?php $__empty_1 = true; $__currentLoopData = $todayMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card-list-item flex-col items-start gap-1">
                    <div class="flex items-center gap-2 w-full">
                        <span class="w-2 h-2 rounded-full flex-shrink-0"
                            style="background:<?php echo e($meeting->status === 'in_progress' ? 'var(--color-accent)' : 'var(--color-secondary)'); ?>;
                                   box-shadow:0 0 6px <?php echo e($meeting->status === 'in_progress' ? 'rgba(124,58,237,0.8)' : 'rgba(59,130,246,0.6)'); ?>;
                                   <?php echo e($meeting->status === 'in_progress' ? 'animation:glowPulse 2s ease-in-out infinite;' : ''); ?>"></span>
                        <p class="text-sm font-medium truncate flex-1" style="color:var(--text-primary);"><?php echo e($meeting->title); ?></p>
                    </div>
                    <div class="flex flex-wrap gap-x-3 gap-y-0.5 text-[0.65rem]" style="color:var(--text-muted);padding-left:1rem;">
                        <span>📍 <?php echo e($meeting->room->name); ?></span>
                        <span>⏰ <?php echo e(substr($meeting->start_time,0,5)); ?>–<?php echo e(substr($meeting->end_time,0,5)); ?></span>
                        <span>👤 <?php echo e($meeting->requester->name); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p>Tidak ada meeting hari ini</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="dashboard-section">
        <div class="gaming-card">
            <div class="card-header">
                <span class="card-header-title">
                    <svg style="color:var(--color-accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Semua Undangan Meeting
                </span>
                <span class="text-[0.6rem]" style="color:var(--text-muted);">Daftar meeting yang melibatkan kamu</span>
            </div>

            
            <div class="filter-bar">
                <form method="GET" action="<?php echo e(route('user.dashboard')); ?>" class="flex items-center gap-2 flex-1" id="filter-form">
                    <div class="search-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Cari judul meeting..." class="gaming-input">
                    </div>
                    <input type="hidden" name="status" id="status-input" value="<?php echo e($status); ?>">
                </form>
                <div class="relative filter-dropdown-wrap flex-shrink-0">
                    <button type="button" onclick="toggleFilterMenu(event)" class="btn btn-secondary btn-sm flex items-center gap-1.5 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <?php if($status && $status !== 'all'): ?>
                            <?php echo e(ucfirst(str_replace('_', ' ', $status))); ?>

                        <?php else: ?>
                            Semua Status
                        <?php endif; ?>
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="filter-menu" style="display:none;position:absolute;bottom:100%;right:0;margin-bottom:6px;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:12px;padding:4px;z-index:9999;box-shadow:var(--shadow-md);">
                        <button type="button" onclick="setFilter('all')" class="w-full text-left px-3 py-1.5 text-xs rounded-lg transition" style="color:var(--text-secondary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">Semua Status</button>
                        <button type="button" onclick="setFilter('approved')" class="w-full text-left px-3 py-1.5 text-xs rounded-lg transition" style="color:var(--text-secondary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">Disetujui</button>
                        <button type="button" onclick="setFilter('confirmed')" class="w-full text-left px-3 py-1.5 text-xs rounded-lg transition" style="color:var(--text-secondary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">Dikonfirmasi</button>
                        <button type="button" onclick="setFilter('in_progress')" class="w-full text-left px-3 py-1.5 text-xs rounded-lg transition" style="color:var(--text-secondary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">Berlangsung</button>
                    </div>
                </div>
            </div>

            
            <div class="table-responsive">
                <table class="gaming-table min-w-[650px]">
                    <thead>
                        <tr>
                            <th style="width:3rem;">No</th>
                            <th>Judul</th>
                            <th style="width:7rem;">Tanggal</th>
                            <th style="width:6rem;">Waktu</th>
                            <th class="hidden md:table-cell" style="width:8rem;">Ruangan</th>
                            <th class="hidden md:table-cell" style="width:8rem;">Pemohon</th>
                            <th style="width:6rem;">Status</th>
                            <th style="width:4rem;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $myMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $badgeStyle = match($meeting->status) {
                                'approved'    => 'badge-blue',
                                'confirmed'   => 'badge-primary',
                                'in_progress' => 'badge-primary',
                                default       => 'badge-gray',
                            };
                            $statusLabel = match($meeting->status) {
                                'approved'    => 'Disetujui',
                                'confirmed'   => 'Dikonfirmasi',
                                'in_progress' => 'Berlangsung',
                                default       => ucfirst($meeting->status),
                            };
                        ?>
                        <tr data-meeting-id="<?php echo e($meeting->id); ?>">
                            <td style="color:var(--text-muted);"><?php echo e($myMeetings->firstItem() + $i); ?></td>
                            <td><span style="font-weight:500;color:var(--text-primary);"><?php echo e($meeting->title); ?></span></td>
                            <td style="color:var(--text-muted);"><?php echo e($meeting->meeting_date->format('d M Y')); ?></td>
                            <td style="color:var(--text-muted);"><?php echo e(substr($meeting->start_time,0,5)); ?>–<?php echo e(substr($meeting->end_time,0,5)); ?></td>
                            <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($meeting->room->name); ?></td>
                            <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($meeting->requester->name); ?></td>
                            <td><span class="badge <?php echo e($badgeStyle); ?>"><?php echo e($statusLabel); ?></span></td>
                            <td>
                                <button type="button" onclick="showDetail(<?php echo e($meeting->id); ?>)" class="btn btn-secondary btn-sm">Detail</button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">
                                <?php if($search || $status): ?>
                                    Tidak ada meeting ditemukan.
                                <?php else: ?>
                                    Kamu belum diundang ke meeting apapun.
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($myMeetings->hasPages()): ?>
            <div class="pagination-wrap">
                <span class="text-xs" style="color:var(--text-muted);">Menampilkan <?php echo e($myMeetings->firstItem()); ?>–<?php echo e($myMeetings->lastItem()); ?> dari <?php echo e($myMeetings->total()); ?></span>
                <?php echo e($myMeetings->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>

</div>


<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[560px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Meeting</h3>
            <button type="button" onclick="closeModal('detail-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex justify-end" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeModal('detail-modal')" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const meetingsData = <?php echo json_encode($meetingsJson, 15, 512) ?>;

const statusMap = {
    approved:    { label: '● DISETUJUI',  cls: 'badge-blue' },
    confirmed:   { label: '● DIKONFIRMASI', cls: 'badge-primary' },
    in_progress: { label: '● BERLANGSUNG', cls: 'badge-primary' },
};

function showDetail(id) {
    const m = meetingsData.find(i => i.id === id);
    if (!m) return;

    const body = document.getElementById('detail-body');
    const st = statusMap[m.status] || { label: '● ' + m.status, cls: 'badge-gray' };

    const infoRows = [
        { label: 'Pemohon', value: m.requester?.name || '-' },
        { label: 'Judul', value: m.title },
        { label: 'Tanggal', value: m.meeting_date || '-' },
        { label: 'Waktu', value: (m.start_time?.substring(0,5)||'') + ' – ' + (m.end_time?.substring(0,5)||'') },
        { label: 'Ruangan', value: m.room?.name || '-' },
    ];

    let detailHtml = '';
    if (m.why) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">Why</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${escHtml(m.why)}</p></div>`;
    if (m.what) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">What</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${escHtml(m.what)}</p></div>`;
    if (m.how_expected) detailHtml += `<div class="p-4 rounded-xl" style="background:var(--bg-surface-2);border:1px solid var(--border-color);"><p class="text-xs font-bold mb-1.5" style="color:var(--color-accent-light);">How</p><p class="text-sm leading-relaxed" style="color:var(--text-secondary);">${escHtml(m.how_expected)}</p></div>`;

    let assetsHtml = '';
    if (m.assets && m.assets.length) {
        assetsHtml = `<div class="flex flex-wrap gap-1.5">${m.assets.map(a => `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold" style="background:#e0e7ff;color:#4338ca;">${escHtml(a.name)} (${a.quantity})</span>`).join('')}</div>`;
    }

    body.innerHTML = `
        <div class="space-y-4">
            <div class="rounded-2xl overflow-hidden" style="border:1px solid var(--border-color);">
                <div class="px-5 py-3 flex items-center justify-between" style="background:var(--bg-surface-2);border-bottom:1px solid var(--border-color);">
                    <p class="text-xs font-bold tracking-wider" style="color:var(--text-muted);">INFORMASI MEETING</p>
                    <span class="badge ${st.cls}">${st.label}</span>
                </div>
                <div class="grid grid-cols-2 gap-0">
                    ${infoRows.map((r, i) => `
                        <div class="px-5 py-3" ${i < 2 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                            <p class="text-xs mb-0.5" style="color:var(--text-muted);">${r.label}</p>
                            <p class="text-sm font-semibold" style="color:var(--text-primary);">${escHtml(r.value)}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
            ${detailHtml ? `
            <div>
                <p class="text-xs font-bold tracking-wider mb-2.5 px-1" style="color:var(--color-accent-light);">DETAIL PERMOHONAN</p>
                <div class="space-y-2.5">${detailHtml}</div>
            </div>` : ''}
            ${assetsHtml ? `
            <div>
                <p class="text-xs font-bold tracking-wider mb-2 px-1" style="color:var(--color-accent-light);">ASET DIBUTUHKAN</p>
                ${assetsHtml}
            </div>` : ''}
        </div>
    `;

    openModal('detail-modal');
}

function escHtml(str) {
    if (!str) return '';
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('detail-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal('detail-modal');
});

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
    });

    function refreshTodayMeetings() {
        fetch('<?php echo e(route("realtime.meetings")); ?>')
            .then(r => r.json())
            .then(data => {
                const today = new Date().toISOString().slice(0,10);
                data.filter(m => m.date === today).forEach(m => {
                    const dot = document.querySelector(`.today-dot[data-id="${m.id}"]`);
                    if (!dot) return;
                    const isActive = m.rt_label.includes('Berlangsung');
                    dot.style.background = isActive ? 'var(--color-accent)' : 'var(--color-secondary)';
                    dot.style.boxShadow  = isActive ? '0 0 6px rgba(124,58,237,0.8)' : '0 0 6px rgba(59,130,246,0.6)';
                });
            }).catch(() => {});
    }

    setInterval(refreshTodayMeetings, 30000);
    refreshTodayMeetings();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\user\dashboard.blade.php ENDPATH**/ ?>