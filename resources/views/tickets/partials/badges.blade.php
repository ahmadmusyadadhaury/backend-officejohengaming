@php
    $ticket = $ticket ?? null;
    $label = $ticket ? $ticket->statusLabel() : \App\Support\Ticket::statusLabel($status ?? 'open');
    $color = $ticket ? $ticket->statusColor() : \App\Support\Ticket::statusColor($status ?? 'open');
@endphp
<span class="tk-chip" style="background:{{ $color }}1a;color:{{ $color }};border-color:{{ $color }}40;">
    <span class="tk-chip-dot" style="background:{{ $color }};"></span>
    {{ $label }}
</span>
