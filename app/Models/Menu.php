<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'url', 'order', 'parent_id', 'is_active', 'page_id'];

    protected $appends = ['route_type'];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function getRouteTypeAttribute(): string
    {
        if (empty($this->url) || $this->url === '#') {
            return 'Static Page';
        }
        
        $protectedSlugs = config('protected-slugs', []);
        $urlPath = ltrim($this->url, '/');
        
        return in_array($urlPath, $protectedSlugs) ? 'System Route' : 'Static Page';
    }
}
