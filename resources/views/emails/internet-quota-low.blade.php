<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family:sans-serif;background:#f4f4f4;padding:40px;">
    <div style="max-width:520px;margin:auto;background:#fff;border-radius:12px;padding:32px;">
        <div style="text-align:center;margin-bottom:24px;">
            <img src="{{ asset('images/logo/logo_web.png') }}" alt="Johen Office" style="height:48px;width:auto;">
        </div>
        <p style="margin:0 0 12px;font-size:14px;color:#333;">Yth. Pengguna,</p>
        <p style="margin:0 0 12px;font-size:14px;color:#555;">
            Pemberitahuan: Kuota internet tersisa
            <strong style="color:{{ $level === 'danger' ? '#dc2626' : '#d97706' }};">{{ number_format($remainingGb, 1) }} GB</strong>.
        </p>
        <p style="margin:0 0 16px;font-size:14px;color:#555;">
            @if($level === 'danger')
                <strong style="color:#dc2626;">SEGERA ISI KUOTA:</strong> Segera lakukan pembelian kuota internet untuk menghindari gangguan operasional!
            @else
                Mohon segera mempersiapkan pembelian kuota internet untuk menghindari gangguan operasional.
            @endif
        </p>
        <p style="margin:0 0 20px;font-size:14px;color:#333;">Terima kasih.</p>
        <a href="{{ $url }}" style="display:inline-block;padding:10px 20px;background:#6c5cff;color:#fff;text-decoration:none;border-radius:8px;font-size:14px;">Kelola Kuota Internet</a>
        <p style="margin-top:24px;font-size:12px;color:#999;">Email ini dikirim otomatis oleh Johen Office System.</p>
    </div>
</body>
</html>
