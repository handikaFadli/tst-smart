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
                'nama' => 'Server 1',
                'ip_address' => '103.1.1.1',
                'catatan' => 'Sharing'
            ],
            [
                'nama' => 'Server 2',
                'ip_address' => '103.1.1.2',
                'catatan' => 'Mandiri'
            ],
            [
                'nama' => 'Server 3',
                'ip_address' => '103.1.1.3',
                'catatan' => 'Mandiri'
            ],
        ];

        foreach ($servers as $server) {
            Server::create($server);
        }
    }
}
