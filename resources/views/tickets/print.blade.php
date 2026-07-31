<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Ticket — JOHEN OFFICE</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #1f2937; padding: 32px; background: #fff; }
        h1 { font-size: 18px; color: #111827; }
        .subtitle { color: #6b7280; margin: 4px 0 20px; font-size: 11px; }
        .meta { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #6c5cff; padding-bottom: 12px; margin-bottom: 20px; }
        .summary { display: flex; gap: 16px; margin-bottom: 24px; }
        .summary-item { border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px 16px; min-width: 110px; text-align: center; }
        .summary-item .num { font-size: 20px; font-weight: 700; color: #6c5cff; }
        .summary-item .lbl { font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.04em; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #6c5cff; color: #fff; font-size: 10px; text-transform: uppercase; letter-spacing: 0.03em; padding: 8px 6px; text-align: left; }
        td { border: 1px solid #e5e7eb; padding: 7px 6px; font-size: 11px; }
        tr:nth-child(even) td { background: #f9fafb; }
        .foot { margin-top: 24px; font-size: 10px; color: #9ca3af; text-align: right; }
    </style>
</head>
<body>
    <div class="meta">
        <div>
            <h1>Johen Office Management System</h1>
            <p class="subtitle">Laporan Ticket Helpdesk IT
                @if($filters['from'] ?? null) · Dari {{ \Illuminate\Support\Carbon::parse($filters['from'])->format('d/m/Y') }} @endif
                @if($filters['to'] ?? null) · s/d {{ \Illuminate\Support\Carbon::parse($filters['to'])->format('d/m/Y') }} @endif
            </p>
        </div>
        <div>
            <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
            <p>Oleh: {{ auth()->user()->name }}</p>
        </div>
    </div>

    @php
        $total = $tickets->count();
        $closed = $tickets->whereIn('status', ['closed', 'cancelled', 'rejected'])->count();
        $overSla = $tickets->filter(fn ($t) => $t->sla_due_at !== null && $t->sla_due_at->lt(now()))->count();
        $avgRating = $tickets->pluck('rating')->filter()->avg('rating');
    @endphp

    <div class="summary">
        <div class="summary-item"><div class="num">{{ $total }}</div><div class="lbl">Total</div></div>
        <div class="summary-item"><div class="num">{{ $closed }}</div><div class="lbl">Ditutup</div></div>
        <div class="summary-item"><div class="num">{{ $total - $closed }}</div><div class="lbl">Aktif</div></div>
        <div class="summary-item"><div class="num" style="color:#ef4444;">{{ $overSla }}</div><div class="lbl">Over SLA</div></div>
        <div class="summary-item"><div class="num" style="color:#f59e0b;">{{ $avgRating ? number_format($avgRating, 1) : '-' }}</div><div class="lbl">Rating</div></div>
    </div>

    @if($tickets->isEmpty())
        <p style="text-align:center;color:#6b7280;padding:40px 0;">Tidak ada data untuk periode ini.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>No. Ticket</th>
                <th>Judul</th>
                <th>Pengaju</th>
                <th>Departemen</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Teknisi</th>
                <th>Dibuat</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td style="font-family:monospace;font-weight:600;">{{ $ticket->ticket_number }}</td>
                <td>{{ $ticket->title }}</td>
                <td>{{ $ticket->requester?->name ?? '-' }}</td>
                <td>{{ $ticket->department ?? '-' }}</td>
                <td>{{ $ticket->priorityLabel() }}</td>
                <td>{{ $ticket->statusLabel() }}</td>
                <td>{{ $ticket->technician?->name ?? '-' }}</td>
                <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $ticket->rating ? str_repeat('★', $ticket->rating->rating) : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="foot">
        <p>Dibuat otomatis oleh JOHEN OFFICE Management System</p>
    </div>
</body>
</html>
