<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servers = [
            [
                'nama' => 'Server 01',
                'ip_address' => '192.168.1.10',
                'catatan' => 'Sharing'
            ],
            [
                'nama' => 'Server 02',
                'ip_address' => '192.168.1.11',
                'catatan' => 'Mandiri'
            ],
            [
                'nama' => 'Server 03',
                'ip_address' => '192.169.1.11',
                'catatan' => 'Mandiri'
            ],
        ];

        foreach ($servers as $server) {
            Server::create($server);
        }
    }
}
