<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientAccount extends Model
{
    /** @use HasFactory<\Database\Factories\ClientAccountFactory> */
    use HasFactory;

    protected $fillable = [
        'client_app_id',
        'username',
        'password',
        'tipe_akun',
        'catatan',
        'is_active',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }


    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSekolah($query)
    {
        return $query->where('tipe_akun', 'sekolah');
    }

    public function scopeSupport($query)
    {
        return $query->where('tipe_akun', 'support');
    }

    public function app()
    {
        return $this->belongsTo(ClientApp::class, 'client_app_id');
    }
}
