<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    /** @use HasFactory<\Database\Factories\FeatureFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_fitur',
        'kode',
    ];

    public function clientApps()
    {
        return $this->belongsToMany(ClientApp::class, 'client_app_features');
    }
}
