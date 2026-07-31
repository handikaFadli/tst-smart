<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['nama_fitur' => 'Ujian', 'kode' => 'ujian'],
            ['nama_fitur' => 'Presensi', 'kode' => 'presensi'],
            ['nama_fitur' => 'E-Learning', 'kode' => 'e_learning'],
            ['nama_fitur' => 'SPMB', 'kode' => 'spmb'],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
