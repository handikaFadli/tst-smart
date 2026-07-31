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
        // User::factory(10)->create();

        $this->call(UserSeeder::class);
        $this->call(FeatureSeeder::class);
        // $this->call(ClientAppFeatureSeeder::class);
        // $this->call(ServerSeeder::class);
        // $this->call(TicketCategorySeeder::class);
    }
}
