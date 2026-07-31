<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientContact extends Model
{
    /** @use HasFactory<\Database\Factories\ClientContactFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'nama',
        'jabatan',
        'whatsapp',
        'is_pic_utama',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'is_pic_utama' => 'boolean',
        ];
    }
 
    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Klien yang dimiliki kontak ini.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
 
    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * Format link WhatsApp menjadi URL langsung.
     * Contoh: "081234567890" → "https://wa.me/6281234567890"
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        if (! $this->whatsapp) {
            return null;
        }

        // Sudah dalam format wa.me
        if (str_starts_with($this->whatsapp, 'wa.me') || str_starts_with($this->whatsapp, 'https://')) {
            return str_starts_with($this->whatsapp, 'https://')
                ? $this->whatsapp
                : 'https://' . $this->whatsapp;
        }

        // Nomor lokal: ganti awalan 0 dengan 62
        $nomor = ltrim($this->whatsapp, '+');
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        return 'https://wa.me/' . preg_replace('/\D/', '', $nomor);
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopePicUtama($query)
    {
        return $query->where('is_pic_utama', true);
    }
}
