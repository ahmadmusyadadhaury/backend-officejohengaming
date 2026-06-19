<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['name', 'description', 'quantity', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_assets')->withPivot('quantity')->withTimestamps();
    }
}

