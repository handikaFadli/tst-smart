<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'nama' => 'Edulink',
                'kode' => 'EDU',
                'deskripsi' => '-',

            ],
            [
                'nama' => 'Ujian CBT',
                'kode' => 'CBT',
                'deskripsi' => '-',

            ],
            [
                'nama' => 'Kartu Pintar',
                'kode' => 'KP',
                'deskripsi' => '-',

            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
