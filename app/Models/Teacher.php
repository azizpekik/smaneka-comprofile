<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'position',
        'subject',
        'bio',
        'is_pinned',
        'pin_order',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'pin_order' => 'integer',
    ];

    /**
     * Scope for pinned teachers
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope for unpinned teachers
     */
    public function scopeUnpinned($query)
    {
        return $query->where('is_pinned', false);
    }

    /**
     * Scope for ordered by pin priority then name
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('is_pinned', 'desc')
                     ->orderBy('pin_order', 'asc')
                     ->orderBy('name', 'asc');
    }

    /**
     * Check if pinned teachers count is at maximum (10)
     */
    public static function isPinLimitReached(): bool
    {
        return self::pinned()->count() >= 10;
    }

    /**
     * Get next available pin order
     */
    public static function getNextPinOrder(): int
    {
        return self::pinned()->max('pin_order') + 1;
    }
}
