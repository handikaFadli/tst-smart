<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'nama',
        'client_type_id',
        'pic_tim_id',
    ];

    protected $appends = [
        'sisa_hari_aplikasi',
        'sisa_hari_domain',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function app()
    {
        return $this->hasOne(ClientApp::class);
    }

    public function getSisaHariAplikasiAttribute()
    {
        return $this->app?->expired_aplikasi?->diffInDays(now()) ?? null;
    }

    public function getSisaHariDomainAttribute()
    {
        return $this->app?->expired_domain?->diffInDays(now()) ?? null;
    }

    public function picTim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_tim_id');
    }

    // public function accounts(): HasMany
    // {
    //     return $this->hasMany(ClientAccount::class, 'client_id');
    // }

    public function contacts(): HasMany
    {
        return $this->hasMany(ClientContact::class, 'client_id');
    }

    public function mainContact(): HasMany
    {
        return $this->contacts()->where('is_pic_utama', true);
    }

    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class, 'client_type_id');
    }
}
