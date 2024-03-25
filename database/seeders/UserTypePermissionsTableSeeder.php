<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Permission;
use App\Models\UserType;
use App\Models\UserTypePermission;

class UserTypePermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// Master Admin
		$typeID = UserType::where('slug', '=', 'master_admin')->first()->id;
		$perms = Permission::pluck('slug')->toArray();
		$this->insertEntries($typeID, $perms);

		// Admin
		$typeID = UserType::where('slug', '=', 'admin')->first()->id;
		$perms = [
			'admin_dashboard',
			'settings_tab_access',
			'settings_tab_edit'
		];

		// Editor
		$typeID = UserType::where('slug', '=', 'teacher')->first()->id;
		$perms = [
			'admin_dashboard',
		];

		// Writer
		$typeID = UserType::where('slug', '=', 'student')->first()->id;
		$perms = [
		];
	}

	private function insertEntries($typeID, $perms = []): void
	{
		for ($i = 1; $i <= count($perms); $i++) {
			UserTypePermission::insert([
				'user_type_id' => $typeID,
				'permission_id' => $i
			]);
		}
	}
}
