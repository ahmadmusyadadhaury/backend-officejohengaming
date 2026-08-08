<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'capacity', 'facilities', 'location', 'description', 'is_active', 'team_id', 'is_weekly_only'];

    protected $casts = [
        'facilities' => 'array',
        'is_active' => 'boolean',
        'is_weekly_only' => 'boolean',
    ];

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function isAvailable($date, $startTime, $endTime, $excludeMeetingId = null): bool
    {
        $query = $this->meetings()
            ->where('meeting_date', $date)
            ->whereIn('status', ['approved', 'confirmed', 'in_progress'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });

        if ($excludeMeetingId) {
            $query->where('id', '!=', $excludeMeetingId);
        }

        return ! $query->exists();
    }
}
