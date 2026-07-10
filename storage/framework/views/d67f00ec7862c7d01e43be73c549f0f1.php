<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family:sans-serif;background:#f4f4f4;padding:40px;">
    <div style="max-width:520px;margin:auto;background:#fff;border-radius:12px;padding:32px;">
        <div style="text-align:center;margin-bottom:24px;">
            <div style="width:56px;height:56px;background:#fef2f2;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
        <p style="margin:0 0 12px;font-size:14px;color:#333;">Yth. Approver,</p>
        <p style="margin:0 0 12px;font-size:14px;color:#555;">
            Terdapat pengajuan pembayaran pajak kendaraan yang perlu di-approve:
        </p>
        <p style="margin:0 0 6px;font-size:14px;color:#333;">
            Kendaraan: <strong style="color:#6c5cff;"><?php echo e($vehicle->nama_kendaraan); ?></strong>
        </p>
        <p style="margin:0 0 6px;font-size:14px;color:#333;">
            Plat Nomor: <strong style="color:#6c5cff;"><?php echo e($vehicle->plat_nomor); ?></strong>
        </p>
        <p style="margin:0 0 6px;font-size:14px;color:#333;">
            Jenis Pajak: <strong style="color:#6c5cff;"><?php echo e($request->jenis === 'tahunan' ? 'Pajak Tahunan' : 'Pajak 5 Tahunan'); ?></strong>
        </p>
        <p style="margin:0 0 6px;font-size:14px;color:#333;">
            Nominal: <strong style="color:#6c5cff;">Rp <?php echo e(number_format($request->nominal, 0, ',', '.')); ?></strong>
        </p>
        <p style="margin:0 0 20px;font-size:14px;color:#333;">
            Diajukan Oleh: <strong style="color:#6c5cff;"><?php echo e($requester->name); ?> (<?php echo e($requester->role); ?>)</strong>
        </p>
        <p style="margin:0 0 20px;font-size:14px;color:#333;">Terima kasih.</p>
        <a href="<?php echo e($url); ?>" style="display:inline-block;padding:10px 20px;background:#6c5cff;color:#fff;text-decoration:none;border-radius:8px;font-size:14px;">Lihat & Approve Pengajuan</a>
        <p style="margin-top:24px;font-size:12px;color:#999;">Email ini dikirim otomatis oleh Johen Office System.</p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\emails\pajak-approval.blade.php ENDPATH**/ ?>