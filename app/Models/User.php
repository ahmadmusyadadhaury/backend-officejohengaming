<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'username', 'password', 'role', 'team_id', 'is_active', 'avatar', 'theme', 'email_notifications', 'app_notifications'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'email_notifications' => 'boolean',
            'app_notifications' => 'boolean',
        ];
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && \Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/'.$this->avatar);
        }

        // Default avatar pakai inisial
        return '';
    }

    // Roles yang punya akses penuh (setara admin)
    const FULL_ACCESS_ROLES = ['admin', 'head_of_store', 'gm', 'hr', 'ceo'];

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

    public function invitations()
    {
        return $this->hasMany(MeetingInvitation::class);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, self::FULL_ACCESS_ROLES);
    }

    public function isKoordinator(): bool
    {
        return $this->role === 'koordinator';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function hasFullAccess(): bool
    {
        return in_array($this->role, self::FULL_ACCESS_ROLES);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Admin Master',
            'head_of_store' => 'Head of Store',
            'gm' => 'General Manager',
            'ceo' => 'Chief Executive Officer',
            'hr' => 'HR',
            'koordinator' => 'Koordinator',
            'admin_ga' => 'Admin General Affairs',
            'user' => 'Karyawan',
            default => ucfirst($this->role),
        };
    }
}
