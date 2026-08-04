<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingRecording extends Model
{
    protected $fillable = [
        'meeting_id',
        'created_by',
        'audio_path',
        'transcript',
        'summary',
        'duration',
        'status',
        'finalized_at',
    ];

    protected $casts = [
        'duration' => 'integer',
        'finalized_at' => 'datetime',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDurationFormattedAttribute(): string
    {
        $h = floor($this->duration / 3600);
        $m = floor(($this->duration % 3600) / 60);
        $s = $this->duration % 60;
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }
}
