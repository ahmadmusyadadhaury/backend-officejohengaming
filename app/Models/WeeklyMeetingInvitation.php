<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyMeetingInvitation extends Model
{
    protected $fillable = ['session_id', 'user_id', 'is_read', 'read_at'];

    protected $casts = ['is_read' => 'boolean', 'read_at' => 'datetime'];

    public function session()
    {
        return $this->belongsTo(WeeklyMeetingSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
