<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $casts = [
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    protected $fillable = [
        'kode_ticket',
        'client_id',
        'created_by',
        'assigned_to',
        'judul',
        'deskripsi',
        'category_id',
        'priority',
        'status',
        'resolved_at',
        'closed_at',
    ];

    public function ticketLogs(): HasMany
    {
        return $this->hasMany(TicketLog::class, 'ticket_id');
    }

    public function ticketMessages(): HasMany
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }

    public function ticketAttachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    public function ruleLogs(): HasMany
    {
        return $this->hasMany(TicketRuleLog::class, 'ticket_id');
    }

    public function latestRuleLog()
    {
        return $this->hasOne(TicketRuleLog::class)->latestOfMany();
    }

    // public function latestRuleLog(bool $withLock = false): ?TicketRuleLog
    // {
    //     $q = $this->ruleLogs()->orderByDesc('id');
    //     if ($withLock) {
    //         $q->lockForUpdate();
    //     }

    //     return $q->first();
    // }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            'open' => 'bg-blue-100 text-blue-700 border-blue-200',
            'in_progress' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'pending' => 'bg-orange-100 text-orange-700 border-orange-200',
            'resolved' => 'bg-green-100 text-green-700 border-green-200',
            'closed' => 'bg-gray-200 text-gray-700 border-gray-300',
            default => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public function getPriorityClassAttribute()
    {
        return match ($this->priority) {
            'high' => 'bg-red-100 text-red-700 border-red-200',
            'medium' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'low' => 'bg-green-100 text-green-700 border-green-200',
            default => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }
}
