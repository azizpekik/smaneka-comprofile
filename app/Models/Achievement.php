<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['title', 'description', 'year', 'image'];

    protected $casts = [
        'year' => 'integer',
    ];
}
