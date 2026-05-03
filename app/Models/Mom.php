<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mom extends Model
{
    protected $fillable = ['meeting_id', 'created_by', 'summary', 'decisions', 'action_plan', 'pic', 'file_path', 'status', 'sent_at'];

    protected $casts = ['sent_at' => 'datetime'];

    public function meeting() { return $this->belongsTo(Meeting::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
