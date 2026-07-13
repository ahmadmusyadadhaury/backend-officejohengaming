<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Aset Tidak Ditemukan | JOHEN OFFICE</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #f7f7f7;
            --bg-surface: #ffffff;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --color-accent: #7c3aed;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-base: #0d0f1a;
                --bg-surface: #141832;
                --text-primary: #e2e8f0;
                --text-muted: #94a3b8;
                --border-color: rgba(255,255,255,0.08);
            }
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
        }
        .notfound-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
            max-width: 400px;
            width: 90%;
            text-align: center;
            padding: 48px 32px;
            animation: fadeInUp 0.5s ease forwards;
        }
        @media (prefers-color-scheme: dark) {
            .notfound-card { box-shadow: 0 8px 32px rgba(0,0,0,0.5); }
        }
        .notfound-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(239,68,68,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .notfound-icon svg { width: 36px; height: 36px; color: #ef4444; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="notfound-card">
        <div class="notfound-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 style="font-size:1.25rem;font-weight:700;margin:0 0 8px;">Aset Tidak Ditemukan</h1>
        <p style="font-size:0.85rem;color:var(--text-muted);margin:0 0 24px;line-height:1.6;">
            Data aset dengan kode yang Anda cari tidak tersedia di sistem kami.
        </p>
        <a href="/" style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;border-radius:12px;background:linear-gradient(135deg,#7c3aed,#6d28d9);color:#fff;font-size:0.85rem;font-weight:600;text-decoration:none;transition:all 0.2s;">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Kembali ke Beranda
        </a>
        <p style="font-size:0.7rem;color:var(--text-muted);margin-top:20px;">
            &copy; {{ date('Y') }} JOHEN OFFICE
        </p>
    </div>
</body>
</html>
