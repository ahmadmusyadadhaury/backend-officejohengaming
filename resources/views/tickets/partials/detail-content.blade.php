@php
    $user = $user ?? auth()->user();
    $isTeam = $user->isTicketTeam();
    $isOwner = $ticket->user_id === $user->id;
    $isLeader = $user->isTicketLeader();
    $transitions = \App\Services\TicketService::TRANSITIONS[$ticket->status] ?? [];
    $technicians = $technicians ?? ($isLeader ? \App\Support\Ticket::technicians() : collect());
@endphp

<style>
    .rating-star { transition: color 0.15s ease, transform 0.15s ease; }
    .rating-star.active, .rating-star:hover { color: #fbbf24 !important; transform: scale(1.15); }
</style>

<div class="tk tk-stack">

    {{-- Header --}}
    <div class="flex flex-wrap items-center gap-2">
        @if($embedded ?? false)
        <button type="button" onclick="closeTicketDetail()" class="btn btn-secondary btn-sm">← Tutup</button>
        @else
        <a href="{{ $isTeam ? route('ticket.index') : route('ticket.my') }}" class="btn btn-secondary btn-sm">← Kembali</a>
        @endif
        <span class="tk-slip tk-slip-lg">
            <span class="tk-slip-tab" style="background:{{ $ticket->priorityColor() }};"></span>
            {{ $ticket->ticket_number }}
        </span>
        <span class="text-xs" style="color:var(--tk-muted);">Dibuat {{ $ticket->created_at->format('d M Y H:i') }}</span>
        @if($ticket->isOverSla())
        <span class="tk-sla tk-sla-over"><span class="tk-sla-dot"></span>Melewati SLA</span>
        @endif
        <div class="ml-auto flex items-center gap-2">
            @include('tickets.partials.badges', ['ticket' => $ticket])
            <span class="tk-chip" style="background:{{ $ticket->priorityColor() }}1a;color:{{ $ticket->priorityColor() }};border-color:{{ $ticket->priorityColor() }}40;">
                <span class="tk-chip-dot" style="background:{{ $ticket->priorityColor() }};"></span>
                {{ $ticket->priorityLabel() }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
        {{-- KIRI: detail + chat --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Detail card --}}
            <div class="tk-card p-5">
                <h3 class="text-base font-bold mb-4" style="color:var(--tk-text);">{{ $ticket->title }}</h3>
                <dl class="tk-def grid grid-cols-2 md:grid-cols-4 gap-x-3 gap-y-4">
                    <div>
                        <dt>Pengaju</dt>
                        <dd>{{ $ticket->requester?->name }}</dd>
                    </div>
                    <div>
                        <dt>Departemen</dt>
                        <dd>{{ $ticket->department ?? '-' }} ({{ $ticket->position ?? '-' }})</dd>
                    </div>
                    <div>
                        <dt>Kategori</dt>
                        <dd>{{ $ticket->category?->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt>Lokasi</dt>
                        <dd>{{ $ticket->location ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt>Teknisi</dt>
                        <dd>{{ $ticket->technician?->name ?? 'Belum ditugaskan' }}</dd>
                    </div>
                    <div>
                        <dt>Batas SLA</dt>
                        <dd style="color:{{ $ticket->isOverSla() ? 'var(--tk-over)' : 'inherit' }};">{{ $ticket->sla_due_at ? $ticket->sla_due_at->format('d M Y H:i') : '-' }}</dd>
                    </div>
                    <div>
                        <dt>Diselesaikan</dt>
                        <dd>{{ $ticket->resolved_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt>Ditutup</dt>
                        <dd>{{ $ticket->closed_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </div>
                </dl>

                @if($ticket->sla_due_at)
                <div class="mt-5">
                    @php
                        $progress = $ticket->slaProgress();
                        $pct = $ticket->sla_due_at->lt($ticket->created_at) ? 0 : min(100, (int) round(now()->diffInSeconds($ticket->created_at) / max(1, $ticket->created_at->diffInSeconds($ticket->sla_due_at)) * 100));
                    @endphp
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="tk-mono text-xs" style="color:var(--tk-muted);">Progres SLA: {{ $progress }}</span>
                        @if(!$ticket->isClosed())
                        <span class="tk-sla {{ $ticket->isOverSla() ? 'tk-sla-over' : 'tk-sla-ok' }}">
                            <span class="tk-sla-dot"></span>{{ $ticket->isOverSla() ? 'Terlambat' : 'Dalam batas' }}
                        </span>
                        @endif
                    </div>
                    <div class="tk-rail">
                        <i style="width:{{ $pct }}%;background:{{ $ticket->isOverSla() ? 'var(--tk-over)' : 'var(--tk-accent)' }};"></i>
                    </div>
                </div>
                @endif

                <div class="mt-5 pt-4" style="border-top:1px solid var(--tk-border);">
                    <p class="tk-eyebrow mb-2">Deskripsi</p>
                    <p class="text-sm whitespace-pre-wrap" style="color:var(--tk-text);">{{ $ticket->description }}</p>
                </div>

                @if($ticket->attachments->isNotEmpty())
                <div class="mt-5 pt-4" style="border-top:1px solid var(--tk-border);">
                    <p class="tk-eyebrow mb-2">Lampiran Ticket ({{ $ticket->attachments->count() }})</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($ticket->attachments as $attachment)
                        <a href="{{ $attachment->url() }}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition" style="border:1px solid var(--tk-border);color:var(--tk-text);text-decoration:none;" onmouseover="this.style.background='var(--tk-bg-soft)'" onmouseout="this.style.background='none'">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                            <span class="truncate max-w-[140px]">{{ $attachment->original_name }}</span>
                            @if($isTeam || $attachment->user_id === $user->id)
                            <form method="POST" action="{{ route('ticket.attachment.destroy', [$ticket, $attachment]) }}" data-confirm="Hapus lampiran ini?" onsubmit="confirmSubmit(event, this)" class="inline ml-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs" style="color:var(--tk-over);background:none;border:none;cursor:pointer;">✕</button>
                            </form>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Komentar / chat --}}
            <div class="tk-card p-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="tk-eyebrow mb-0.5">Diskusi</p>
                        <h3 class="tk-h">{{ $ticket->comments->count() }} komentar</h3>
                    </div>
                </div>

                <div class="space-y-3 max-h-[420px] overflow-y-auto pr-1" id="ticket-comments">
                    @forelse($ticket->comments as $comment)
                    @php $isCommenterTeam = $comment->user?->isTicketTeam(); @endphp
                    <div class="flex gap-3 {{ $isCommenterTeam ? 'justify-start' : 'justify-end' }}">
                        @if($isCommenterTeam)
                        <span class="tk-avatar" title="{{ $comment->user?->name }}">{{ strtoupper(substr($comment->user?->name ?? 'IT', 0, 2)) }}</span>
                        @endif
                        <div class="max-w-[85%] rounded-xl px-4 py-2.5 tk-bubble {{ $isCommenterTeam ? 'tk-bubble-team' : 'tk-bubble-user' }}">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-semibold" style="color:var(--tk-text);">{{ $comment->user?->name }}</span>
                                <span class="text-[0.6rem]" style="color:var(--tk-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                                @if($isCommenterTeam)
                                <span class="tk-chip" style="background:var(--tk-accent-soft);color:var(--tk-accent);border-color:var(--tk-accent-border);">TIM IT</span>
                                @endif
                            </div>
                            <p class="text-sm whitespace-pre-wrap" style="color:var(--tk-text);">{{ $comment->comment }}</p>
                            @if($comment->attachments->isNotEmpty())
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach($comment->attachments as $attachment)
                                <a href="{{ $attachment->url() }}" target="_blank" class="flex items-center gap-1.5 px-2 py-1 rounded-lg text-[0.65rem] font-medium transition" style="border:1px solid var(--tk-border);color:var(--tk-text);text-decoration:none;" onmouseover="this.style.background='var(--tk-bg-soft)'" onmouseout="this.style.background='none'">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    {{ $attachment->original_name }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="tk-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p>Belum ada komentar.</p>
                    </div>
                    @endforelse
                </div>

                @if(!$ticket->isClosed() && !$ticket->isCancelled() && !$ticket->isRejected())
                <form method="POST" action="{{ route('ticket.comment', $ticket) }}" enctype="multipart/form-data" class="mt-4 pt-4" style="border-top:1px solid var(--tk-border);">
                    @csrf
                    <textarea name="comment" required rows="3" maxlength="5000" placeholder="Tulis komentar atau tanggapan..." class="gaming-input mb-2"></textarea>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2.5">
                        <label class="flex-1 text-xs" style="color:var(--tk-muted);">
                            📎
                            <input type="file" name="attachments[]" multiple accept=".{{ implode(',.', config('ticket.allowed_extensions')) }}" class="text-xs">
                        </label>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>

        {{-- KANAN: aksi + riwayat --}}
        <div class="space-y-4">
            {{-- Panel aksi tim IT --}}
            @if($isTeam)
            <div class="tk-card p-4">
                <p class="tk-eyebrow mb-2">Kontrol</p>
                <h3 class="tk-h mb-3">Panel Tim IT</h3>
                <div class="space-y-2.5">
                    @if(in_array($ticket->status, ['open', 'reopened']) && !$ticket->assigned_to)
                    <form method="POST" action="{{ route('ticket.take', $ticket) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm w-full">👋 Ambil Ticket Ini</button>
                    </form>
                    @endif

                    @if($isLeader)
                    <form method="POST" action="{{ route('ticket.assign', $ticket) }}" class="space-y-1.5">
                        @csrf
                        <label class="block text-[0.62rem] font-semibold" style="color:var(--tk-muted);">Tugaskan Teknisi</label>
                        <select name="assigned_to" class="gaming-select" required>
                            @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ $ticket->assigned_to === $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-secondary btn-sm w-full">Tugaskan</button>
                    </form>
                    @endif

                    @if($transitions && ($ticket->assigned_to === $user->id || $isLeader))
                    <form method="POST" action="{{ route('ticket.status', $ticket) }}" class="space-y-1.5 pt-2.5" style="border-top:1px solid var(--tk-border);">
                        @csrf
                        @method('PATCH')
                        <label class="block text-[0.62rem] font-semibold" style="color:var(--tk-muted);">Ubah Status</label>
                        <select name="status" class="gaming-select" required>
                            @foreach($transitions as $tran)
                            <option value="{{ $tran }}">{{ \App\Support\Ticket::statusLabel($tran) }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="note" placeholder="Catatan (opsional)" class="gaming-input" maxlength="1000">
                        <button type="submit" class="btn btn-secondary btn-sm w-full">Simpan Status</button>
                    </form>
                    @endif

                    @if(in_array($ticket->status, ['assigned', 'in_progress', 'waiting_user', 'reopened']))
                    <form method="POST" action="{{ route('ticket.resolve', $ticket) }}" class="space-y-1.5 pt-2.5" style="border-top:1px solid var(--tk-border);">
                        @csrf
                        <input type="text" name="note" placeholder="Solusi yang diberikan (opsional)" class="gaming-input" maxlength="1000">
                        <button type="submit" class="btn btn-success btn-sm w-full">✓ Tandai Selesai</button>
                    </form>
                    @endif
                </div>
            </div>
            @endif

            {{-- Panel pengaju --}}
            @if($isOwner)
            <div class="tk-card p-4">
                <p class="tk-eyebrow mb-2">Anda</p>
                <h3 class="tk-h mb-3">Aksi Anda</h3>
                <div class="space-y-2.5">
                    @if($ticket->status === 'resolved')
                    <form method="POST" action="{{ route('ticket.close', $ticket) }}" data-confirm="Konfirmasi bahwa masalah sudah selesai dan tutup ticket?" onsubmit="confirmSubmit(event, this)">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm w-full">✓ Masalah Selesai</button>
                    </form>
                    @endif
                    @if(in_array($ticket->status, ['resolved', 'closed']))
                    <form method="POST" action="{{ route('ticket.reopen', $ticket) }}" data-confirm="Buka kembali ticket ini?" onsubmit="confirmSubmit(event, this)">
                        @csrf
                        <input type="text" name="note" placeholder="Alasan dibuka kembali (opsional)" class="gaming-input mb-1.5" maxlength="1000">
                        <button type="submit" class="btn btn-warning btn-sm w-full">↺ Buka Kembali</button>
                    </form>
                    @endif
                </div>
            </div>
            @endif

            {{-- Rating --}}
            @if($isOwner && $ticket->status === 'closed')
            <div class="tk-card p-4">
                <p class="tk-eyebrow mb-2">Feedback</p>
                <h3 class="tk-h mb-3">⭐ Penilaian</h3>
                @if($ticket->rating)
                <div class="text-center py-2">
                    <p class="text-2xl font-bold mb-1" style="color:#fbbf24;">{{ str_repeat('★', $ticket->rating->rating) }}<span style="color:var(--tk-muted);">{{ str_repeat('☆', 5 - $ticket->rating->rating) }}</span></p>
                    <p class="text-xs" style="color:var(--tk-muted);">{{ $ticket->rating->rating }} / 5</p>
                    @if($ticket->rating->comment)
                    <p class="text-xs mt-2" style="color:var(--tk-text);">"{{ $ticket->rating->comment }}"</p>
                    @endif
                </div>
                @else
                <form method="POST" action="{{ route('ticket.rate', $ticket) }}" class="space-y-2.5">
                    @csrf
                    <div class="flex justify-center gap-1.5" id="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" data-rating="{{ $i }}" class="rating-star text-2xl transition" style="color:var(--tk-muted);background:none;border:none;cursor:pointer;">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-value" required>
                    <textarea name="comment" rows="2" maxlength="1000" placeholder="Komentar (opsional)" class="gaming-input"></textarea>
                    <button type="submit" class="btn btn-primary btn-sm w-full">Kirim Penilaian</button>
                </form>
                @endif
            </div>
            @endif

            {{-- Riwayat --}}
            <div class="tk-card p-4">
                <p class="tk-eyebrow mb-2">Aktivitas</p>
                <h3 class="tk-h mb-4">Riwayat Aktivitas</h3>
                <div class="tk-timeline max-h-[320px] overflow-y-auto pr-1">
                    @foreach($ticket->histories as $history)
                    <div class="tk-timeline-item">
                        <p class="text-xs font-semibold" style="color:var(--tk-text);">{{ $history->user?->name }}</p>
                        <p class="text-xs" style="color:var(--tk-muted);">{{ $history->description }}</p>
                        <p class="tk-mono text-[0.6rem]" style="color:var(--tk-muted);">{{ $history->created_at->format('d M Y H:i') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
