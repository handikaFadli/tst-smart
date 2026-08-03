<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContract extends Model
{
    /** @use HasFactory<\Database\Factories\ClientContractFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'nomor_kontrak',
        'tanggal_mulai',
        'tanggal_berakhir',
        'file',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
