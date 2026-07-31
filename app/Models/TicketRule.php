<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketRule extends Model
{
    /** @use HasFactory<\Database\Factories\TicketRuleFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_rule',
        'category_id',
        'priority',
        'response_time',
        'resolution_time',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function ruleLogs(): HasMany
    {
        return $this->hasMany(TicketRuleLog::class, 'ticket_rule_id');
    }
}
