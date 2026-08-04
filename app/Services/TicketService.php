<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketComment;
use App\Models\TicketHistory;
use App\Models\TicketNotification;
use App\Models\TicketRating;
use App\Models\TicketTeamMember;
use App\Models\User;
use App\Support\Ticket as TicketSupport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketService
{
    public const TRANSITIONS = [
        'open' => ['assigned', 'in_progress', 'waiting_user', 'cancelled', 'rejected'],
        'assigned' => ['in_progress', 'waiting_user', 'cancelled', 'rejected'],
        'in_progress' => ['waiting_user', 'resolved', 'cancelled'],
        'waiting_user' => ['in_progress', 'resolved', 'cancelled'],
        'resolved' => ['closed', 'reopened'],
        'reopened' => ['in_progress', 'waiting_user', 'resolved', 'cancelled'],
        'closed' => ['reopened'],
    ];

    public function __construct(
        protected TicketNumberService $numberService,
        protected TicketSlaService $slaService,
        protected ActivityLogService $activityLog,
    ) {}

    /**
     * Membuat ticket baru + lampiran + history + notifikasi tim IT.
     */
    public function store(array $data, array $attachments, User $user): Ticket
    {
        return DB::transaction(function () use ($data, $attachments, $user) {
            $ticket = Ticket::create([
                'ticket_number' => $this->numberService->generate(),
                'user_id' => $user->id,
                'category_id' => $data['category_id'] ?? null,
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'] ?? null,
                'department' => TicketSupport::departmentFromUser($user),
                'position' => TicketSupport::positionFromUser($user),
                'priority' => $data['priority'],
                'status' => 'open',
                'sla_due_at' => $this->slaService->dueAt($data['priority']),
            ]);

            $this->storeAttachments($ticket, $attachments, $user);

            $this->history($ticket, $user, 'created', 'Ticket dibuat oleh '.$user->name, null, 'open');

            $this->activityLog->log(
                'ticket.created',
                "Ticket {$ticket->ticket_number} dibuat",
                Ticket::class,
                $ticket->id,
                null,
                $ticket->toArray()
            );

            $this->notifyTeam($ticket, 'Ticket Baru',
                "Ticket {$ticket->ticket_number} — {$ticket->title} dibuka oleh {$user->name}");

            return $ticket;
        });
    }

    /**
     * Tim IT mengambil ticket (open → assigned).
     */
    public function take(Ticket $ticket, User $tech): Ticket
    {
        return DB::transaction(function () use ($ticket, $tech) {
            $old = $ticket->status;
            $ticket->update([
                'status' => $ticket->status === 'reopened' ? 'in_progress' : 'assigned',
                'assigned_to' => $tech->id,
            ]);

            $this->history($ticket, $tech, 'taken', 'Ticket diambil oleh '.$tech->name, $old, $ticket->status);
            $this->activityLog->log('ticket.taken', "Ticket {$ticket->ticket_number} diambil oleh {$tech->name}",
                Ticket::class, $ticket->id, $old, $ticket->status);

            $this->notifyRequester($ticket, 'Ticket Diambil',
                "Ticket {$ticket->ticket_number} telah diambil oleh {$tech->name}.");

            return $ticket;
        });
    }

    /**
     * Leader IT menugaskan ticket ke teknisi tertentu.
     */
    public function assign(Ticket $ticket, User $tech, User $by): Ticket
    {
        return DB::transaction(function () use ($ticket, $tech, $by) {
            $oldTech = $ticket->assigned_to;
            $oldStatus = $ticket->status;

            $ticket->update([
                'assigned_to' => $tech->id,
                'status' => in_array($ticket->status, ['open', 'reopened']) ? 'assigned' : $ticket->status,
            ]);

            $this->history($ticket, $by, 'assigned',
                'Ticket ditugaskan ke '.$tech->name.' oleh '.$by->name,
                $oldTech ? User::find($oldTech)?->name : null, $tech->name);

            $this->activityLog->log('ticket.assigned', "Ticket {$ticket->ticket_number} ditugaskan ke {$tech->name}",
                Ticket::class, $ticket->id, $oldTech, $tech->id);

            if ($oldStatus !== $ticket->status) {
                $this->history($ticket, $by, 'status', 'Status berubah', $oldStatus, $ticket->status);
            }

            $this->notifyTicket($ticket, $tech->id, 'Ticket Ditugaskan',
                "Anda ditugaskan menangani ticket {$ticket->ticket_number} — {$ticket->title}.");

            $this->notifyRequester($ticket, 'Teknisi Ditugaskan',
                "Ticket {$ticket->ticket_number} ditugaskan ke {$tech->name}.");

            return $ticket;
        });
    }

    /**
     * Update status oleh tim IT (dengan validasi transisi).
     */
    public function updateStatus(Ticket $ticket, string $status, User $user, ?string $note = null): Ticket
    {
        $allowed = self::TRANSITIONS[$ticket->status] ?? [];

        if (! in_array($status, $allowed, true)) {
            throw new \InvalidArgumentException("Perubahan status {$ticket->status} → {$status} tidak diizinkan.");
        }

        return DB::transaction(function () use ($ticket, $status, $user, $note) {
            $old = $ticket->status;

            $ticket->update([
                'status' => $status,
                'resolved_at' => $status === 'resolved' ? now() : $ticket->resolved_at,
                'closed_at' => $status === 'closed' ? now() : $ticket->closed_at,
            ]);

            $this->history($ticket, $user, 'status',
                'Status berubah dari '.TicketSupport::statusLabel($old).' ke '.TicketSupport::statusLabel($status),
                $old, $status, $note);

            $this->activityLog->log('ticket.status', "Status {$ticket->ticket_number} berubah",
                Ticket::class, $ticket->id, $old, $status);

            $this->notifyRequester($ticket, 'Update Status',
                "Status ticket {$ticket->ticket_number} menjadi ".TicketSupport::statusLabel($status).'.');

            return $ticket;
        });
    }

    /**
     * Teknisi menyelesaikan ticket (→ resolved).
     */
    public function resolve(Ticket $ticket, User $tech, ?string $note = null): Ticket
    {
        return DB::transaction(function () use ($ticket, $tech, $note) {
            $old = $ticket->status;

            $ticket->update(['status' => 'resolved', 'resolved_at' => now()]);

            $this->history($ticket, $tech, 'resolved', 'Ticket diselesaikan oleh '.$tech->name, $old, 'resolved', $note);
            $this->activityLog->log('ticket.resolved', "Ticket {$ticket->ticket_number} diselesaikan",
                Ticket::class, $ticket->id, $old, 'resolved');

            $this->notifyRequester($ticket, 'Ticket Selesai 🎉',
                "Ticket {$ticket->ticket_number} telah diselesaikan. Mohon konfirmasi — masih bermasalah atau selesai?");

            return $ticket;
        });
    }

    /**
     * Pengaju mengonfirmasi ticket selesai (→ closed).
     */
    public function close(Ticket $ticket, User $user): Ticket
    {
        return DB::transaction(function () use ($ticket, $user) {
            $old = $ticket->status;

            $ticket->update(['status' => 'closed', 'closed_at' => now()]);

            $this->history($ticket, $user, 'closed', 'Ticket dikonfirmasi selesai oleh '.$user->name, $old, 'closed');
            $this->activityLog->log('ticket.closed', "Ticket {$ticket->ticket_number} ditutup",
                Ticket::class, $ticket->id, $old, 'closed');

            if ($ticket->assigned_to) {
                $this->notifyTicket($ticket, $ticket->assigned_to, 'Ticket Ditutup',
                    "Ticket {$ticket->ticket_number} telah dikonfirmasi selesai oleh {$user->name}.");
            }

            return $ticket;
        });
    }

    /**
     * Membuka kembali ticket (resolved/closed → reopened).
     */
    public function reopen(Ticket $ticket, User $user, ?string $note = null): Ticket
    {
        return DB::transaction(function () use ($ticket, $user, $note) {
            $old = $ticket->status;

            $ticket->update([
                'status' => 'reopened',
                'resolved_at' => null,
                'closed_at' => null,
            ]);

            $this->history($ticket, $user, 'reopened', 'Ticket dibuka kembali oleh '.$user->name, $old, 'reopened', $note);
            $this->activityLog->log('ticket.reopened', "Ticket {$ticket->ticket_number} dibuka kembali",
                Ticket::class, $ticket->id, $old, 'reopened');

            if ($ticket->assigned_to) {
                $this->notifyTicket($ticket, $ticket->assigned_to, 'Ticket Dibuka Kembali',
                    "Ticket {$ticket->ticket_number} dibuka kembali oleh {$user->name}.");
            }

            return $ticket;
        });
    }

    /**
     * Menambah komentar (chat) + lampiran. Auto-balik ke in_progress bila user merespon saat waiting_user.
     */
    public function comment(Ticket $ticket, User $user, string $comment, array $files = []): TicketComment
    {
        return DB::transaction(function () use ($ticket, $user, $comment, $files) {
            $created = TicketComment::create([
                'ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'comment' => $comment,
            ]);

            $this->storeAttachments($ticket, $files, $user, $created);

            $this->history($ticket, $user, 'comment', 'Komentar ditambahkan oleh '.$user->name);
            $this->activityLog->log('ticket.comment', "Komentar pada {$ticket->ticket_number} oleh {$user->name}",
                Ticket::class, $ticket->id);

            // User merespons saat menunggu konfirmasi → otomatis dilanjutkan pengerjaan
            if ($ticket->status === 'waiting_user' && ! $user->isTicketTeam()) {
                $old = $ticket->status;
                $ticket->update(['status' => 'in_progress']);
                $this->history($ticket, $user, 'status',
                    'Ticket dilanjutkan pengerjaan karena pengaju merespons', $old, 'in_progress');
            }

            $this->notifyOtherParty($ticket, $user, 'Komentar Baru',
                "Komentar baru pada ticket {$ticket->ticket_number} oleh {$user->name}.");

            return $created;
        });
    }

    /**
     * Memberi rating kepuasan (wajib saat ticket closed).
     */
    public function rate(Ticket $ticket, User $user, int $rating, ?string $comment = null): TicketRating
    {
        return DB::transaction(function () use ($ticket, $user, $rating, $comment) {
            $saved = TicketRating::updateOrCreate(
                ['ticket_id' => $ticket->id],
                ['user_id' => $user->id, 'rating' => $rating, 'comment' => $comment]
            );

            $this->history($ticket, $user, 'rating', 'Rating '.$rating.' bintang diberikan', null, (string) $rating);
            $this->activityLog->log('ticket.rated', "Ticket {$ticket->ticket_number} diberi rating {$rating}",
                Ticket::class, $ticket->id, null, $rating);

            if ($ticket->assigned_to) {
                $this->notifyTicket($ticket, $ticket->assigned_to, 'Rating Baru ⭐',
                    "Ticket {$ticket->ticket_number} mendapatkan rating {$rating} bintang.");
            }

            return $saved;
        });
    }

    /**
     * Simpan lampiran ke disk public + catat history.
     */
    public function storeAttachments(Ticket $ticket, array $files, User $user, ?TicketComment $comment = null): void
    {
        $disk = config('ticket.attachments_disk', 'public');
        $folder = config('ticket.attachments_folder', 'ticket-attachments');

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $file->store($folder.'/'.now()->format('Y/m'), $disk);

            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'comment_id' => $comment?->id,
                'user_id' => $user->id,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);

            $this->history($ticket, $user, 'attachment', 'Lampiran ditambahkan: '.$file->getClientOriginalName());
        }
    }

    /**
     * Hapus lampiran + file fisik.
     */
    public function deleteAttachment(TicketAttachment $attachment): void
    {
        Storage::disk(config('ticket.attachments_disk', 'public'))->delete($attachment->file_path);
        $attachment->delete();
    }

    protected function history(
        Ticket $ticket,
        User $user,
        string $action,
        ?string $description = null,
        $oldValue = null,
        $newValue = null,
        ?string $extra = null
    ): TicketHistory {
        return TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'action' => $action,
            'description' => trim(($description ?: '').($extra ? " — {$extra}" : '')),
            'old_value' => $oldValue !== null ? (string) $oldValue : null,
            'new_value' => $newValue !== null ? (string) $newValue : null,
        ]);
    }

    protected function notifyRequester(Ticket $ticket, string $title, string $message): void
    {
        $this->notifyTicket($ticket, $ticket->user_id, $title, $message);
    }

    protected function notifyTicket(Ticket $ticket, int $userId, string $title, string $message): void
    {
        $url = route('ticket.show', $ticket);

        TicketNotification::create([
            'ticket_id' => $ticket->id,
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'is_read' => false,
        ]);

        Notification::send($userId, 'ticket', $title, $message, $url);
    }

    /**
     * Notifikasi untuk seluruh anggota tim IT.
     */
    protected function notifyTeam(Ticket $ticket, string $title, string $message): void
    {
        $url = route('ticket.show', $ticket);
        $userIds = TicketTeamMember::query()->pluck('user_id')->all();

        $now = now();
        $rows = array_map(fn ($id) => [
            'ticket_id' => $ticket->id,
            'user_id' => $id,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'is_read' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ], $userIds);

        if ($rows) {
            TicketNotification::insert($rows);
        }

        if ($userIds) {
            Notification::sendToMany($userIds, 'ticket', $title, $message, $url);
        }
    }

    /**
     * Notifikasi ke pihak lawan (bukan komentator).
     */
    protected function notifyOtherParty(Ticket $ticket, User $commenter, string $title, string $message): void
    {
        if ($commenter->isTicketTeam()) {
            $this->notifyRequester($ticket, $title, $message);
        } else {
            if ($ticket->assigned_to) {
                $this->notifyTicket($ticket, $ticket->assigned_to, $title, $message);
            } else {
                $this->notifyTeam($ticket, $title, $message);
            }
        }
    }
}
