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
                'deskripsi' => 'Issues related to server performance and functionality',
                'is_active' => true
            ],
            [
                'nama' => 'Network Problems',
                'deskripsi' => 'Issues related to network connectivity and performance',
                'is_active' => true
            ],
            [
                'nama' => 'Software Bugs',
                'deskripsi' => 'Issues related to software bugs and errors',
                'is_active' => true
            ],
        ];

        foreach ($ticket_categories as $category) {
            TicketCategory::create($category);
        }
    }
}
