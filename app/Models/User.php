<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['nik', 'name', 'email', 'password', 'role', 'team_id', 'is_leader', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password'   => 'hashed',
            'is_leader'  => 'boolean',
            'is_active'  => 'boolean',
        ];
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'requested_by');
    }

    public function participatingMeetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_participants', 'user_id', 'meeting_id')
            ->withPivot('status')->withTimestamps();
    }

    public function moms()
    {
        return $this->hasMany(Mom::class, 'created_by');
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isLeader(): bool { return $this->role === 'leader' || $this->is_leader; }
    public function isUser(): bool { return $this->role === 'user'; }
}
