<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingReminder extends Model
{
    protected $fillable = ['meeting_id', 'type', 'sent_at'];

    protected $casts = ['sent_at' => 'datetime'];

    public function meeting() { return $this->belongsTo(Meeting::class); }
}
