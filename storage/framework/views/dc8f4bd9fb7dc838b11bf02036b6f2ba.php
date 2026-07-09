<?php $__env->startSection('body-class', 'page-leader'); ?>
<?php $__env->startSection('title', 'Ajukan Pembayaran'); ?>
<?php $__env->startSection('page-title', 'Pengajuan Pembayaran'); ?>
<?php $__env->startSection('page-subtitle', 'Ajukan pembayaran tagihan untuk mendapatkan persetujuan'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php $role = auth()->user()->role; ?>
    <?php echo $__env->make($role === 'koordinator' ? 'partials.sidebar-leader' : (in_array($role, ['admin','hr','head_of_store','gm','ceo','admin_ga']) ? 'partials.sidebar-admin' : 'partials.sidebar-user'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-2 animate-fade-in">
    <div class="max-w-2xl mx-auto">
        <div class="gaming-card p-6">
            <form method="POST" action="<?php echo e(route('payment-approval.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                
                <div class="field-group mb-5">
                    <label class="gaming-label">Jenis Pembayaran <span class="field-req">*</span></label>
                    <select name="jenis" id="f-jenis" required class="gaming-input" onchange="toggleJenis()">
                        <option value="">Pilih jenis</option>
                        <option value="internet" <?php if(old('jenis') === 'internet'): echo 'selected'; endif; ?>>Internet (WiFi)</option>
                        <option value="listrik" <?php if(old('jenis') === 'listrik'): echo 'selected'; endif; ?>>Listrik Token</option>
                        <option value="aset_digital" <?php if(old('jenis') === 'aset_digital'): echo 'selected'; endif; ?>>Aset Digital</option>
                        <option value="ipl_ruko" <?php if(old('jenis') === 'ipl_ruko'): echo 'selected'; endif; ?>>IPL Ruko</option>
                    </select>
                    <?php $__errorArgs = ['jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div id="internet-fields" class="form-grid-2" style="display:none;">
                    <div class="field-group">
                        <label class="gaming-label">Nama Internet <span class="field-req">*</span></label>
                        <input type="text" name="nama_internet" placeholder="Contoh: Wifi 1 (Kantor Utama)" class="gaming-input" value="<?php echo e(old('nama_internet')); ?>">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Provider <span class="field-req">*</span></label>
                        <select name="provider" class="gaming-input">
                            <option value="">Pilih provider</option>
                            <option value="Indosat">Indosat</option>
                            <option value="IndiHome">IndiHome</option>
                            <option value="First Media">First Media</option>
                            <option value="MyRepublic">MyRepublic</option>
                            <option value="Biznet">Biznet</option>
                            <option value="CBN">CBN</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" placeholder="Nama penanggung jawab" class="gaming-input" value="<?php echo e(old('pic')); ?>">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
                        <select name="jabatan" class="gaming-input gaming-select">
                            <option value="">Pilih Jabatan</option>
                            <option value="Chief Executive Officer (CEO)">CEO</option>
                            <option value="General Manager (GM)">GM</option>
                            <option value="Head of Store">Head of Store</option>
                            <option value="Admin Master">Admin Master</option>
                            <option value="HR">HR</option>
                            <option value="Koordinator">Koordinator</option>
                            <option value="Karyawan">Karyawan</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Masa Tenggang <span class="field-req">*</span></label>
                        <input type="date" name="masa_tenggang" class="gaming-input" value="<?php echo e(old('masa_tenggang')); ?>">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Biaya <span class="field-req">*</span></label>
                        <input type="number" name="biaya" placeholder="Contoh: 300000" class="gaming-input" min="0" step="0.01" value="<?php echo e(old('biaya')); ?>">
                    </div>
                </div>

                <div id="other-fields" class="form-grid-2" style="display:none;">
                    <div class="field-group">
                        <label class="gaming-label" id="other-label">Periode <span class="field-req">*</span></label>
                        <input type="text" name="periode" id="f-periode" placeholder="Contoh: Januari 2026" class="gaming-input" value="<?php echo e(old('periode')); ?>">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nominal <span class="field-req">*</span></label>
                        <input type="number" name="nominal" placeholder="Contoh: 300000" class="gaming-input" min="0" step="0.01" value="<?php echo e(old('nominal')); ?>">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Tagihan <span class="field-req">*</span></label>
                        <input type="date" name="tanggal_tagihan" class="gaming-input" value="<?php echo e(old('tanggal_tagihan')); ?>">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jatuh Tempo <span class="field-req">*</span></label>
                        <input type="date" name="jatuh_tempo" class="gaming-input" value="<?php echo e(old('jatuh_tempo')); ?>">
                    </div>
                </div>

                
                <div id="listrik-note" class="mb-4 p-3 rounded-xl" style="display:none;background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.25);">
                    <p class="text-xs" style="color:#3b82f6;">Untuk token listrik, isi periode, nominal token, dan tanggal pembelian.</p>
                </div>

                
                <div class="field-group mb-5">
                    <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                    <input type="date" name="tanggal_bayar" required class="gaming-input" value="<?php echo e(old('tanggal_bayar', date('Y-m-d'))); ?>">
                    <?php $__errorArgs = ['tanggal_bayar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="field-group mb-5">
                    <label class="gaming-label">Upload Bukti Bayar <span class="field-req">*</span></label>
                    <input type="file" name="bukti_bayar" accept="image/jpeg,image/png" required class="gaming-input" style="padding:8px;">
                    <p class="text-xs mt-1" style="color:var(--text-muted);">Format: JPEG/PNG, maks 2MB</p>
                    <?php $__errorArgs = ['bukti_bayar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-form btn-form-simpan" style="width:100%;padding:12px;">
                        <svg class="w-4 h-4 inline-block -mt-0.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Ajukan Pembayaran
                    </button>
                </div>
            </form>
        </div>
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
function toggleJenis() {
    const jenis = document.getElementById('f-jenis').value;
    document.getElementById('internet-fields').style.display = jenis === 'internet' ? 'grid' : 'none';
    document.getElementById('other-fields').style.display = (jenis === 'internet' || !jenis) ? 'none' : 'grid';
    document.getElementById('listrik-note').style.display = jenis === 'listrik' ? 'block' : 'none';
    document.getElementById('other-label').textContent = jenis === 'aset_digital' ? 'Nama Aset' : 'Periode';
    document.getElementById('f-periode').placeholder = jenis === 'aset_digital' ? 'Contoh: Adobe Photoshop' : 'Contoh: Januari 2026';
}

document.addEventListener('DOMContentLoaded', function() {
    const old = '<?php echo e(old('jenis')); ?>';
    if (old) { document.getElementById('f-jenis').value = old; toggleJenis(); }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/payment-approval/create.blade.php ENDPATH**/ ?>