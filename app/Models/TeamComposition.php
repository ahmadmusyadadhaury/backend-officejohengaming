<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamComposition extends Model
{
    protected $fillable = ['role', 'label', 'max_count', 'sort_order'];

    protected $casts = [
        'max_count' => 'integer',
        'sort_order' => 'integer',
    ];
}
