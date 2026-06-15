<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyMeetingSession extends Model
{
    protected $fillable = ['weekly_meeting_id', 'session_date', 'start_time', 'end_time', 'actual_end_time', 'status'];

    protected $casts = ['session_date' => 'date'];

    public function weeklyMeeting()
    {
        return $this->belongsTo(WeeklyMeeting::class);
    }

    public function contributions()
    {
        return $this->hasMany(WeeklyMeetingContribution::class, 'session_id');
    }

    public function invitations()
    {
        return $this->hasMany(WeeklyMeetingInvitation::class, 'session_id');
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['active', 'extended']);
    }
}
