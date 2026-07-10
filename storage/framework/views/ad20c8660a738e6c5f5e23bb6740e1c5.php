<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Tambah Meeting Mingguan'); ?>
<?php $__env->startSection('page-title', 'Tambah Jadwal Meeting Mingguan'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="<?php echo e(route('admin.weekly-meetings.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="gaming-label">Judul <span style="color:#f87171;">*</span></label>
                <input type="text" name="title" value="<?php echo e(old('title', 'Weekly Meeting')); ?>" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Ruangan <span style="color:#f87171;">*</span></label>
                <select name="room_id" required class="gaming-input gaming-select">
                    <option value="">Pilih Ruangan</option>
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($room->id); ?>" <?php echo e(old('room_id') == $room->id ? 'selected' : ''); ?>><?php echo e($room->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="gaming-label">Hari <span style="color:#f87171;">*</span></label>
                <select name="day_of_week" required class="gaming-input gaming-select">
                    <?php $__currentLoopData = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val); ?>" <?php echo e(old('day_of_week') == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="gaming-label">Jam Mulai <span style="color:#f87171;">*</span></label>
                    <input type="text" name="start_time" id="weekly-start" value="<?php echo e(old('start_time')); ?>" required class="gaming-input" placeholder="--:--" autocomplete="off">
                </div>
                <div>
                    <label class="gaming-label">Jam Selesai <span style="color:#f87171;">*</span></label>
                    <input type="text" name="end_time" id="weekly-end" value="<?php echo e(old('end_time')); ?>" required class="gaming-input" placeholder="--:--" autocomplete="off">
                </div>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo e(route('admin.weekly-meetings.index')); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const weeklyStart = document.getElementById('weekly-start');
    const weeklyEnd = document.getElementById('weekly-end');
    if (weeklyStart && weeklyEnd) {
        const wsFp = flatpickr(weeklyStart, {
            enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true,
            defaultDate: weeklyStart.value || '08:00',
            onChange: function(sel, str) {
                weFp.set('minTime', str);
                if (weFp.selectedDates.length && weFp.selectedDates[0] <= sel[0]) {
                    weFp.setDate(sel[0].getTime() + 3600000);
                }
            }
        });
        const weFp = flatpickr(weeklyEnd, {
            enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true,
            minTime: wsFp.selectedDates.length ? wsFp.input.value : '09:00',
            defaultDate: weeklyEnd.value || '09:00',
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\weekly\create.blade.php ENDPATH**/ ?>