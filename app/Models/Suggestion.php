<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    /**
     * Constants for status
     */
    const STATUS_BARU = 'baru';
    const STATUS_DIBACA = 'dibaca';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get status label with badge color
     *
     * @return array<string, string>
     */
    public function getStatusLabel(): array
    {
        return match ($this->status) {
            self::STATUS_BARU => ['label' => 'Baru', 'color' => 'warning'],
            self::STATUS_DIBACA => ['label' => 'Dibaca', 'color' => 'success'],
            default => ['label' => 'Baru', 'color' => 'warning'],
        };
    }

    /**
     * Scope for baru status
     */
    public function scopeBaru($query)
    {
        return $query->where('status', self::STATUS_BARU);
    }

    /**
     * Scope for dibaca status
     */
    public function scopeDibaca($query)
    {
        return $query->where('status', self::STATUS_DIBACA);
    }

    /**
     * Mark as read
     */
    public function markAsRead(): void
    {
        $this->update(['status' => self::STATUS_DIBACA]);
    }
}
