<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketTeamMember extends Model
{
    protected $fillable = ['user_id', 'is_leader'];

    protected $casts = ['is_leader' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
