<?php

namespace App\Models;

use App\Support\Ticket as TicketSupport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'assigned_to',
        'title',
        'description',
        'location',
        'department',
        'position',
        'priority',
        'status',
        'sla_due_at',
        'resolved_at',
        'closed_at',
    ];

    protected $casts = [
        'sla_due_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function histories()
    {
        return $this->hasMany(TicketHistory::class);
    }

    public function ratings()
    {
        return $this->hasMany(TicketRating::class);
    }

    public function rating()
    {
        return $this->hasOne(TicketRating::class);
    }

    public function notifications()
    {
        return $this->hasMany(TicketNotification::class);
    }

    public function statusLabel(): string
    {
        return TicketSupport::statusLabel($this->status);
    }

    public function priorityLabel(): string
    {
        return TicketSupport::priorityLabel($this->priority);
    }

    public function statusColor(): string
    {
        return TicketSupport::statusColor($this->status);
    }

    public function priorityColor(): string
    {
        return TicketSupport::priorityColor($this->priority);
    }

    public function isClosed(): bool
    {
        return TicketSupport::isClosedStatus($this->status);
    }

    public function isCancelled(): bool
    {
        return in_array($this->status, ['cancelled', 'rejected']);
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Ticket sedang dalam proses pengerjaan (belum selesai / dibatalkan).
     */
    public function isActive(): bool
    {
        return ! $this->isClosed();
    }

    public function isOverSla(): bool
    {
        if ($this->isClosed() || ! $this->sla_due_at) {
            return false;
        }

        return now()->greaterThan($this->sla_due_at);
    }

    /**
     * Persentase penggunaan SLA (0-100) untuk progress bar.
     */
    public function slaProgress(): int
    {
        if (! $this->sla_due_at) {
            return 0;
        }

        $deadline = $this->sla_due_at;
        $start = $this->created_at ?: $deadline->copy()->subMinutes($this->slaDurationMinutes());
        $total = $start->diffInSeconds($deadline);

        if ($total <= 0) {
            return 100;
        }

        $end = $this->resolved_at ?? now();
        $elapsed = $start->diffInSeconds($end);

        return (int) round(min(100, ($elapsed / $total) * 100));
    }

    public function slaDurationMinutes(): int
    {
        return (int) TicketSla::where('priority', $this->priority)->value('duration_minutes');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', config('ticket.closed_statuses', []));
    }

    public function scopeOverSla($query)
    {
        return $query->active()
            ->whereNotNull('sla_due_at')
            ->where('sla_due_at', '<', now());
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (! $keyword) {
            return $query;
        }

        $keyword = trim($keyword);

        return $query->where(function ($q) use ($keyword) {
            $q->where('ticket_number', 'like', "%{$keyword}%")
                ->orWhere('title', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%")
                ->orWhereHas('requester', fn ($uq) => $uq->where('name', 'like', "%{$keyword}%"))
                ->orWhereHas('category', fn ($cq) => $cq->where('name', 'like', "%{$keyword}%"))
                ->orWhereHas('technician', fn ($uq) => $uq->where('name', 'like', "%{$keyword}%"));
        });
    }
}
