<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use App\Models\TicketRule;
use Illuminate\Database\Seeder;

class TicketRuleSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua kategori tiket yang sudah di-seed
        $categories = TicketCategory::all();

        $rules = [];
        foreach ($categories as $category) {
            $rules[] = [
                'category_id'    => $category->id,
                'nama_rule'      => "Low Priority - {$category->nama}",
                'priority'       => 'low',
                'response_time'  => 480,   // 8 jam (dalam menit)
                'resolution_time' => 2400,  // 5 hari kerja (dalam menit)
                'is_active'      => true,
            ];
            $rules[] = [
                'category_id'    => $category->id,
                'nama_rule'      => "Medium Priority - {$category->nama}",
                'priority'       => 'medium',
                'response_time'  => 240,   // 4 jam
                'resolution_time' => 1440,  // 3 hari kerja
                'is_active'      => true,
            ];
            $rules[] = [
                'category_id'    => $category->id,
                'nama_rule'      => "High Priority - {$category->nama}",
                'priority'       => 'high',
                'response_time'  => 60,    // 1 jam
                'resolution_time' => 480,   // 8 jam
                'is_active'      => true,
            ];
        }

        foreach ($rules as $rule) {
            TicketRule::create($rule);
        }
    }
}
