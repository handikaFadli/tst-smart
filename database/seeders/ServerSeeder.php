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
                'nama_server' => 'Server 1',
                'ip_address' => '103.1.1.1',
                'catatan' => 'Main production server'
            ],
            [
                'nama_server' => 'Server 2',
                'ip_address' => '103.1.1.2',
                'catatan' => 'Backup server'
            ],
            [
                'nama_server' => 'Server 3',
                'ip_address' => '103.1.1.3',
                'catatan' => 'Testing server'
            ],
        ];

        foreach ($servers as $server) {
            Server::create($server);
        }
    }
}
