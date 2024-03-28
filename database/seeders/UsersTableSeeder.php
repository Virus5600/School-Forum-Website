<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// Master Admin User - Owner
		User::create([
			'username' => config('master-admin.username'),
			'first_name' => config('master-admin.first_name'),
			'middle_name' => config('master-admin.middle_name'),
			'last_name' => config('master-admin.last_name'),
			'email' => config('master-admin.email'),
			'gender' => 'others',
			'avatar' => 'master-admin.png',
			'user_type_id' => config('master-admin.user_type_id'),
			'password' => config('master-admin.password'),
		]);

		// Admin User (Dev)
		User::create([
			'username' => 'Virus5600',
			'first_name' => 'Karl Satchi',
			'middle_name' => 'Esguerra',
			'last_name' => 'Navida',
			'email' => 'satchinavida@gmail.com',
			'gender' => 'male',
			'avatar' => 'default-male.png',
			'user_type_id' => 2,
			'password' => 'password'
		]);
	}
}
