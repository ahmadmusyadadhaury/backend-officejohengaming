<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'title', 'room_id', 'requested_by', 'team_id', 'second_team_id',
        'why', 'what', 'meeting_date', 'start_time', 'end_time', 'actual_end_time',
        'where_detail', 'who_summary', 'how_expected',
        'status', 'reject_reason', 'is_weekly', 'weekly_day', 'weekly_time',
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
    public function secondTeam() { return $this->belongsTo(Team::class, 'second_team_id'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }

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
}
