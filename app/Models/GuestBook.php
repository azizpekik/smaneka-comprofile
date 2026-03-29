<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    protected $fillable = ['day_date', 'name', 'position', 'address', 'purpose'];

    protected $casts = [
        'day_date' => 'date',
    ];
}
