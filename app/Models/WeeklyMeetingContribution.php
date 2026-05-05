<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyMeetingContribution extends Model
{
    protected $fillable = ['session_id', 'user_id', 'what_to_discuss', 'file_path'];

    public function session() { return $this->belongsTo(WeeklyMeetingSession::class); }
    public function user() { return $this->belongsTo(User::class); }
}
