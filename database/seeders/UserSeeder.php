<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{

		$users = [
			[
				'name' => 'Tim Teknis',
				'email' => 'timteknis@example.com',
				'role' => 'support',
				'password' => bcrypt('password'),
				'is_active' => true,
			],
			[
				'name' => 'Leader',
				'email' => 'leader@example.com',
				'role' => 'leader',
				'password' => bcrypt('password'),
				'is_active' => true,
			],
			[
				'name' => 'Admin',
				'email' => 'admin@example.com',
				'role' => 'admin',
				'password' => bcrypt('password'),
				'is_active' => true,
			]
		];

		foreach ($users as $user) {
			User::create($user);
		}
	}
}
