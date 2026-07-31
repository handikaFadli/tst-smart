<?php

namespace Database\Seeders;

use App\Models\ClientApp;
use App\Models\Feature;
use Illuminate\Database\Seeder;

class ClientAppFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $app = ClientApp::first();
        $features = Feature::pluck('id')->toArray();

        if ($app) {
            $app->features()->sync($features); // attach semua fitur
        }
    }
}
