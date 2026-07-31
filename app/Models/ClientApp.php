<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientApp extends Model
{
    /** @use HasFactory<\Database\Factories\ClientAppFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'product_id',
        'url_aplikasi',
        'jumsis',
        'kode_examol',
        'link_presensi',
        'aktivasi_aplikasi',
        'expired_aplikasi',
        'expired_domain',
        'status',
        'server_id',
        'catatan',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'client_app_features');
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function accounts()
    {
        return $this->hasMany(ClientAccount::class);
    }

    protected $casts = [
        'aktivasi_aplikasi' => 'datetime',
        'expired_aplikasi' => 'datetime',
        'expired_domain' => 'datetime',
    ];

    // Accessors
    // -------------------------------------------------------------------------

    /**
     * Sisa hari sebelum aplikasi expired.
     * Mengembalikan null jika tidak ada tanggal, negatif jika sudah lewat.
     */
    public function getSisaHariAplikasiAttribute(): ?int
    {
        return $this->expired_aplikasi
            ? (int) now()->startOfDay()->diffInDays($this->expired_aplikasi, false)
            : null;
    }

    /**
     * Sisa hari sebelum domain expired.
     */
    public function getSisaHariDomainAttribute(): ?int
    {
        return $this->expired_domain
            ? (int) now()->startOfDay()->diffInDays($this->expired_domain, false)
            : null;
    }

    /**
     * Apakah aplikasi sudah expired atau akan expired dalam 30 hari.
     */
    public function getIsAplikasiWarningAttribute(): bool
    {
        if (! $this->expired_aplikasi) {
            return false;
        }

        return $this->sisa_hari_aplikasi <= 30;
    }

    /**
     * Apakah domain sudah expired atau akan expired dalam 30 hari.
     */
    public function getIsDomainWarningAttribute(): bool
    {
        if (! $this->expired_domain) {
            return false;
        }

        return $this->sisa_hari_domain <= 30;
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeByJenis($query, string $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeByPic($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeAplikasiExpiringSoon($query, int $days = 30)
    {
        return $query->whereNotNull('expired_aplikasi')
            ->whereBetween('expired_aplikasi', [now(), now()->addDays($days)]);
    }

    public function scopeDomainExpiringSoon($query, int $days = 30)
    {
        return $query->whereNotNull('expired_domain')
            ->whereBetween('expired_domain', [now(), now()->addDays($days)]);
    }
}
