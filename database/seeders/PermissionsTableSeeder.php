<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// ADMIN ACCESS
		Permission::create([
			'name' => 'Admin Access',
			'slug' => 'admin_access'
		]);

		// REPORTS
		$reportsPerm = Permission::create([
			'name' => 'Reports Tab Access',
			'slug' => 'reports_tab_access'
		]);

		Permission::create([
			'parent_permission' => $reportsPerm->id,
			'name' => 'Reports Tab Status',
			'slug' => 'reports_tab_status'
		]);

		Permission::create([
			'parent_permission' => $reportsPerm->id,
			'name' => 'Reports Tab Action',
			'slug' => 'reports_tab_action'
		]);

		// LOST AND FOUND
		$lostFoundPerm = Permission::create([
			'name' => 'Lost and Found Tab Access',
			'slug' => 'lost_and_found_tab_access'
		]);

		Permission::create([
			'parent_permission' => $lostFoundPerm->id,
			'name' => 'Lost and Found Tab Create',
			'slug' => 'lost_and_found_tab_create'
		]);

		Permission::create([
			'parent_permission' => $lostFoundPerm->id,
			'name' => 'Lost and Found Tab Edit',
			'slug' => 'lost_and_found_tab_edit'
		]);

		Permission::create([
			'parent_permission' => $lostFoundPerm->id,
			'name' => 'Lost and Found Tab Status',
			'slug' => 'lost_and_found_tab_status'
		]);

		Permission::create([
			'parent_permission' => $lostFoundPerm->id,
			'name' => 'Lost and Found Tab Archive',
			'slug' => 'lost_and_found_tab_archive'
		]);

		Permission::create([
			'parent_permission' => $lostFoundPerm->id,
			'name' => 'Lost and Found Tab Unarchive',
			'slug' => 'lost_and_found_tab_unarchive'
		]);

		Permission::create([
			'parent_permission' => $lostFoundPerm->id,
			'name' => 'Lost and Found Tab Delete',
			'slug' => 'lost_and_found_tab_delete'
		]);

		// SETTINGS
		$settingsPerm = Permission::create([
			'name' => 'Settings Tab Access',
			'slug' => 'settings_tab_access'
		]);

		Permission::create([
			'parent_permission' => $settingsPerm->id,
			'name' => 'Settings Tab Edit',
			'slug' => 'settings_tab_edit'
		]);
	}
}
