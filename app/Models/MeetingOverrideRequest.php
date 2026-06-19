<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingOverrideRequest extends Model
{
    protected $fillable = ['requester_meeting_id', 'target_meeting_id', 'reason', 'status'];

    protected $casts = ['status' => 'string'];

    public function requesterMeeting()
    {
        return $this->belongsTo(Meeting::class, 'requester_meeting_id');
    }

    public function targetMeeting()
    {
        return $this->belongsTo(Meeting::class, 'target_meeting_id');
    }
}
