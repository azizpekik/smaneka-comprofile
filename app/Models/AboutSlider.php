<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSlider extends Model
{
    protected $fillable = [
        'image_path',
        'caption',
        'link',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope for active sliders
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered sliders
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
