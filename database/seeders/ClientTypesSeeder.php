<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Seeder;

class ClientTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientTypes = [
            [
                'nama' => 'Perusahaan',
                'deskripsi' => '-',
            ],
            [
                'nama' => 'Sekolah',
                'deskripsi' => '-',
            ],
            [
                'nama' => 'Bimbel',
                'deskripsi' => '-',
            ],
            [
                'nama' => 'Ponpes',
                'deskripsi' => '-',
            ]
        ];

        foreach ($clientTypes as $type) {
            ClientType::create($type);
        }
    }
}
