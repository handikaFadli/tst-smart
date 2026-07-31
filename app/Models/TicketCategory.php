<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    /** @use HasFactory<\Database\Factories\TicketCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'is_active',
    ];

    public function rules()
    {
        return $this->hasMany(TicketRule::class, 'category_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'category_id');
    }
}
