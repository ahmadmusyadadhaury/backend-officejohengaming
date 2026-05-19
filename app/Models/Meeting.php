<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'title', 'room_id', 'requested_by', 'team_id',
        'why', 'what', 'meeting_date', 'start_time', 'end_time', 'actual_end_time',
        'how_expected', 'file_path',
        'status', 'reject_reason', 'queue_position', 'is_weekly', 'weekly_day', 'weekly_time',
        'approved_by', 'approved_at',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'is_weekly'    => 'boolean',
        'approved_at'  => 'datetime',
    ];

    public function room() { return $this->belongsTo(Room::class); }
    public function requester() { return $this->belongsTo(User::class, 'requested_by'); }
    public function team() { return $this->belongsTo(Team::class); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }

    // Multi-tim yang diundang
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'meeting_teams');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'meeting_participants', 'meeting_id', 'user_id')
            ->withPivot('status')->withTimestamps();
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'meeting_assets')->withPivot('quantity')->withTimestamps();
    }

    public function reminders()
    {
        return $this->hasMany(MeetingReminder::class);
    }

    public function mom()
    {
        return $this->hasOne(Mom::class);
    }

    public function invitations()
    {
        return $this->hasMany(MeetingInvitation::class);
    }

    // Override request where this meeting is the requester
    public function overrideRequest()
    {
        return $this->hasOne(MeetingOverrideRequest::class, 'requester_meeting_id');
    }

    // Override request where this meeting is the target
    public function overrideTarget()
    {
        return $this->hasOne(MeetingOverrideRequest::class, 'target_meeting_id');
    }

    // Semua tim yang terlibat (tim koordinator + tim tambahan)
    public function allTeamIds(): array
    {
        return array_unique(array_merge(
            [$this->team_id],
            $this->teams->pluck('id')->toArray()
        ));
    }
}
