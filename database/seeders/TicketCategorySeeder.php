<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticket_categories = [
            [
                'nama' => 'Server Issues',
                'deskripsi' => '-',
                'is_active' => true
            ],
            [
                'nama' => 'Network Problems',
                'deskripsi' => '-',
                'is_active' => true
            ],
            [
                'nama' => 'Software Bugs',
                'deskripsi' => '-',
                'is_active' => true
            ],
        ];

        foreach ($ticket_categories as $category) {
            TicketCategory::create($category);
        }
    }
}
