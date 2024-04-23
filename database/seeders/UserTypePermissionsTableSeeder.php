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
			'lost_and_found_tab_access',
			'lost_and_found_tab_access',
			'lost_and_found_tab_create',
			'lost_and_found_tab_edit',
			'lost_and_found_tab_status',
			'lost_and_found_tab_archive',
			'lost_and_found_tab_unarchive',
			'lost_and_found_tab_delete',
			'reports_tab_access',
			'reports_tab_status',
			'reports_tab_action',
			'settings_tab_access',
			'settings_tab_edit'
		];
		$this->insertEntries($typeID, $perms);

		// Teacher
		$typeID = UserType::where('slug', '=', 'teacher')->first()->id;
		$perms = [
			'admin_dashboard',
			'lost_and_found_tab_access',
			'lost_and_found_tab_access',
			'lost_and_found_tab_create',
			'lost_and_found_tab_edit',
			'lost_and_found_tab_status',
			'lost_and_found_tab_archive',
			'lost_and_found_tab_unarchive',
			'lost_and_found_tab_delete',
			'reports_tab_access',
			'reports_tab_status',
			'reports_tab_action',
		];
		$this->insertEntries($typeID, $perms);

		// Student
		$typeID = UserType::where('slug', '=', 'student')->first()->id;
		$perms = [
		];
	}

	private function insertEntries(int $typeID, array $perms = []): void
	{
		UserType::find($typeID)
			->permissions()
			->attach(
				Permission::whereIn('slug', $perms)
					->pluck('id')
					->toArray()
			);
	}
}
