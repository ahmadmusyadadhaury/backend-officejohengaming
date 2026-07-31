<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'comment_id',
        'user_id',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function comment()
    {
        return $this->belongsTo(TicketComment::class, 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function url(): string
    {
        return route('files.show', $this->file_path);
    }

    public function isImage(): bool
    {
        return $this->mime_type && str_starts_with($this->mime_type, 'image/');
    }
}
