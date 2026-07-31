<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAppFeature extends Model
{
    /** @use HasFactory<\Database\Factories\ClientAppFeatureFactory> */
    use HasFactory;
    protected $fillable = [
        'client_app_id',
        'feature_id',
    ];
}
