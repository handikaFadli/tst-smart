<?php

namespace Database\Seeders;

use App\Models\Product;
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
                'kode' => 'EDL',
                'nama' => 'Edulink',
                'deskripsi' => '-',
            ],
            [
                'kode' => 'CBT',
                'nama' => 'Ujian CBT',
                'deskripsi' => '-',
            ],
            [
                'kode' => 'KP',
                'nama' => 'Kartu Pintar',
                'deskripsi' => '-',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
