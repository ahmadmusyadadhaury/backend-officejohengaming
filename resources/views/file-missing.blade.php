<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/gaming.css') }}">
</head>
<body class="login-bg grid-pattern flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md relative z-10">
        <div class="login-card p-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4"
                style="background:linear-gradient(135deg,rgba(251,191,36,0.2),rgba(245,158,11,0.1));border:1px solid rgba(251,191,36,0.3);">
                <svg class="w-8 h-8" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h1 class="font-gaming text-xl font-bold mb-2" style="color:var(--text-primary);">
                Dokumen Belum Diupload
            </h1>
            <p style="color:var(--text-muted);font-size:0.85rem;margin-bottom:1.5rem;">
                File lampiran untuk dokumen ini belum tersedia di server.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary inline-flex items-center gap-2" style="padding:0.6rem 1.5rem;font-size:0.85rem;text-decoration:none;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
