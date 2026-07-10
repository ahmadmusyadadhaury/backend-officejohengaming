<?php $__env->startSection('title', 'Request Meeting'); ?>
<?php $__env->startSection('page-title', 'Request Meeting'); ?>
<?php $__env->startSection('page-subtitle', 'Ajukan permintaan ruang meeting baru'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card overflow-hidden max-w-lg mx-auto">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Request Meeting Baru</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Isi detail pertemuan untuk mengajukan meeting.</div>
            </div>
            <a href="<?php echo e(route('koordinator.meetings.index')); ?>" class="btn btn-secondary btn-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        <form method="POST" action="<?php echo e(route('koordinator.meetings.store')); ?>" enctype="multipart/form-data" class="p-5 space-y-5">
            <?php echo csrf_field(); ?>

            
            <div>
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">INFO DASAR</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="gaming-label">Judul Meeting <span style="color:#f87171;">*</span></label>
                        <input type="text" name="title" value="<?php echo e(old('title')); ?>" required placeholder="Contoh: Evaluasi Konten Mingguan" class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Ruangan <span style="color:#f87171;">*</span></label>
                        <select name="room_id" required class="gaming-input gaming-select">
                            <option value="">Pilih Ruangan</option>
                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($room->id); ?>" <?php echo e(old('room_id') == $room->id ? 'selected' : ''); ?>>
                                    <?php echo e($room->name); ?> (<?php echo e($room->capacity); ?> orang)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="gaming-label">Tanggal Meeting <span style="color:#f87171;">*</span></label>
                        <input type="date" name="meeting_date" value="<?php echo e(old('meeting_date')); ?>" required min="<?php echo e(date('Y-m-d')); ?>" class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Jam Mulai <span style="color:#f87171;">*</span></label>
                        <input type="text" name="start_time" id="start-time" value="<?php echo e(old('start_time')); ?>" required class="gaming-input" placeholder="--:--" autocomplete="off">
                    </div>
                    <div>
                        <label class="gaming-label">Jam Selesai <span style="color:#f87171;">*</span></label>
                        <input type="text" name="end_time" id="end-time" value="<?php echo e(old('end_time')); ?>" required class="gaming-input" placeholder="--:--" autocomplete="off">
                    </div>
                </div>
            </div>

            
            <?php if(in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr', 'ceo'])): ?>
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">TIM UTAMA</p>
                <label class="gaming-label">Pilih Tim Utama <span style="color:#f87171;">*</span></label>
                <select name="main_team_id" required class="gaming-input gaming-select">
                    <option value="">Pilih Tim Utama</option>
                    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($team->id); ?>" <?php echo e(old('main_team_id') == $team->id ? 'selected' : ''); ?>><?php echo e($team->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs mt-1" style="color:var(--text-muted);">Tim utama yang akan menjadi penyelenggara meeting.</p>
            </div>
            <?php endif; ?>

            
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">TIM TAMBAHAN</p>
                        <p class="text-xs" style="color:var(--text-muted);">Opsional — tim kamu otomatis ter-undang</p>
                    </div>
                    <button type="button" onclick="addTeamRow()" class="btn btn-secondary btn-sm">+ Tambah Tim</button>
                </div>
                <div id="extra-teams" class="space-y-2">
                    <?php if(old('extra_teams')): ?>
                        <?php $__currentLoopData = old('extra_teams'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-2 team-row">
                            <select name="extra_teams[]" class="gaming-input flex-1">
                                <option value="">Pilih Tim</option>
                                <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($team->id); ?>" <?php echo e($tid == $team->id ? 'selected' : ''); ?>><?php echo e($team->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="button" onclick="this.closest('.team-row').remove()" class="btn btn-danger btn-sm">✕</button>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">DETAIL MEETING (5W1H)</p>
                <div class="space-y-3">
                    <div>
                        <label class="gaming-label">WHY — Kenapa meeting ini diadakan? <span style="color:#f87171;">*</span></label>
                        <textarea name="why" rows="2" required placeholder="Jelaskan alasan diadakannya meeting..." class="gaming-input" style="resize:vertical;"><?php echo e(old('why')); ?></textarea>
                    </div>
                    <div>
                        <label class="gaming-label">WHAT — Apa yang akan dibahas? <span style="color:#f87171;">*</span></label>
                        <textarea name="what" rows="2" required placeholder="Topik atau agenda meeting..." class="gaming-input" style="resize:vertical;"><?php echo e(old('what')); ?></textarea>
                    </div>
                    <div>
                        <label class="gaming-label">HOW — Hasil yang diharapkan <span style="color:#f87171;">*</span></label>
                        <textarea name="how_expected" rows="2" required placeholder="Keputusan atau output yang diharapkan..." class="gaming-input" style="resize:vertical;"><?php echo e(old('how_expected')); ?></textarea>
                    </div>
                </div>
            </div>

            
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <p class="font-gaming font-semibold text-sm mb-2" style="color:var(--text-primary);letter-spacing:0.05em;">LAMPIRAN FILE <span style="color:var(--text-muted);font-weight:400;font-family:'Inter',sans-serif;font-size:0.75rem;letter-spacing:0;">(Opsional)</span></p>
                <input type="file" name="file" accept=".pdf,.doc,.docx" class="gaming-input" style="padding:0.5rem;">
                <p class="text-xs mt-1" style="color:var(--text-muted);">Format: PDF, DOC, DOCX. Maks 10MB.</p>
            </div>

            
            <?php if($assets->count()): ?>
            <div class="pt-4" style="border-top:1px solid var(--border-color);">
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">KEBUTUHAN ASET <span style="color:var(--text-muted);font-weight:400;font-family:'Inter',sans-serif;font-size:0.75rem;letter-spacing:0;">(Opsional)</span></p>
                <div class="grid grid-cols-2 gap-2">
                    <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-3 p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                        <span class="text-sm flex-1" style="color:var(--text-primary);"><?php echo e($asset->name); ?></span>
                        <input type="number" name="assets[<?php echo e($asset->id); ?>]" min="0" max="<?php echo e($asset->quantity); ?>" value="0"
                            class="gaming-input text-center" style="width:64px;padding:0.35rem 0.5rem;">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            
            <div class="flex gap-3 pt-4" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Request
                </button>
                <a href="<?php echo e(route('koordinator.meetings.index')); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const teamsData = <?php echo json_encode($teams, 15, 512) ?>;

    function addTeamRow() {
        const container = document.getElementById('extra-teams');
        const selected = [...container.querySelectorAll('select')].map(s => s.value);
        const options = teamsData.filter(t => !selected.includes(String(t.id)))
            .map(t => `<option value="${t.id}">${t.name}</option>`).join('');
        if (!options) { showAlertModal('Semua tim sudah ditambahkan.'); return; }
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 team-row';
        row.innerHTML = `
            <select name="extra_teams[]" class="gaming-input flex-1">
                <option value="">Pilih Tim</option>${options}
            </select>
            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger btn-sm">✕</button>`;
        container.appendChild(row);
    }

    const dateInput = document.querySelector('input[name="meeting_date"]');
    const startInput = document.querySelector('#start-time');
    const endInput = document.querySelector('#end-time');

    let startFp = null;
    let endFp = null;

    function initPickers() {
        const today = getTodayStr();
        const isToday = dateInput.value === today;
        const min = isToday ? nowTime() : '00:00';
        const startVal = isToday ? nowTime() : (startInput.value || '08:00');
        const endVal = isToday ? addHour(nowTime()) : (endInput.value || '09:00');

        if (startFp) startFp.destroy();
        if (endFp) endFp.destroy();

        startFp = flatpickr(startInput, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            minTime: isToday ? nowTime() : '00:00',
            defaultDate: startVal,
            onChange: function(selectedDates, dateStr) {
                if (endFp) {
                    endFp.set('minTime', dateStr);
                    if (endFp.selectedDates.length && endFp.selectedDates[0] <= selectedDates[0]) {
                        endFp.setDate(addHour(dateStr));
                    }
                }
            }
        });

        endFp = flatpickr(endInput, {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            minTime: startFp.selectedDates.length ? startFp.input.value : startVal,
            defaultDate: endVal,
        });

        if (!isToday) {
            startFp.set('minTime', '00:00');
            endFp.set('minTime', startFp.input.value);
        }
    }

    initPickers();

    dateInput.addEventListener('change', function() {
        const isToday = this.value === getTodayStr();
        if (isToday) {
            startFp.set('minTime', nowTime());
            startFp.setDate(nowTime());
            endFp.set('minTime', nowTime());
            endFp.setDate(addHour(nowTime()));
        } else {
            startFp.set('minTime', '00:00');
            if (!startFp.selectedDates.length) startFp.setDate('08:00');
            endFp.set('minTime', startFp.input.value);
            if (!endFp.selectedDates.length) endFp.setDate('09:00');
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\leader\meetings\create.blade.php ENDPATH**/ ?>