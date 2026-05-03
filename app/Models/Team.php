<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function leader()
    {
        return $this->hasOne(User::class)->where('is_leader', true);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
