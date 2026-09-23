<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyMeeting extends Model
{
    protected $fillable = ['room_id', 'title', 'day_of_week', 'day_of_week_old', 'day_of_week_changed_on', 'start_time', 'end_time', 'is_active', 'created_by'];

    protected $casts = ['is_active' => 'boolean'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
