<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(FeatureSeeder::class);

        // Master data
        $this->call(ProductsSeeder::class);
        $this->call(ServerSeeder::class);
        $this->call(ClientTypesSeeder::class);
        $this->call(TicketCategorySeeder::class);

        // Relasi / turunan
        $this->call(TicketRuleSeeder::class);
    }
}
