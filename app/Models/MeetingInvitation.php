<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingInvitation extends Model
{
    protected $fillable = ['meeting_id', 'user_id', 'is_read', 'read_at'];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
