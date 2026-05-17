<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'image',
        'benefits',
        'wa_number',
        'cta_text',
    ];

    protected $casts = [
        'benefits' => 'array',
    ];

    /**
     * Get formatted WhatsApp link
     */
    public function getWaLinkAttribute(): ?string
    {
        if (!$this->wa_number) {
            return null;
        }
        
        // Remove any non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $this->wa_number);
        
        // Add country code if not present
        if (strlen($number) <= 11) {
            $number = '62' . ltrim($number, '0');
        }
        
        return "https://wa.me/{$number}";
    }

    /**
     * Get default CTA text
     */
    public function getCtaTextOrDefaultAttribute(): string
    {
        return $this->cta_text ?? 'Tertarik? Hubungi kami untuk info lebih lanjut!';
    }
}
