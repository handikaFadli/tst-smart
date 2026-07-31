<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketRuleLog extends Model
{
    /** @use HasFactory<\Database\Factories\TicketRuleLogFactory> */
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'ticket_rule_id',
        'response_deadline',
        'resolution_deadline',
        'first_response_at',
        'resolved_at',
        'assigned_at',
        'response_breached',
        'resolution_breached',
        'status',
    ];

    protected $casts = [
        'response_deadline' => 'datetime',
        'resolution_deadline' => 'datetime',
        'first_response_at' => 'datetime',
        'resolved_at' => 'datetime',
        'assigned_at' => 'datetime',
        'response_breached' => 'boolean',
        'resolution_breached' => 'boolean',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(TicketRule::class, 'ticket_rule_id');
    }
}
