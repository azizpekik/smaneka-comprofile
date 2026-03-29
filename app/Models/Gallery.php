<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['album_id', 'image_path', 'caption'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
