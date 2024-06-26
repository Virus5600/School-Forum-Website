<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$this->call([
			SettingsTableSeeder::class,
			PermissionsTableSeeder::class,
			UserTypesTableSeeder::class,
			UserTypePermissionsTableSeeder::class,
			UsersTableSeeder::class,
			CarouselImagesTableSeeder::class,
			AnnouncementsTableSeeder::class,
			LostFoundTableSeeder::class,
			DiscussionCategoriesTableSeeder::class,
			DiscussionsTableSeeder::class,
			DiscussionRepliesTableSeeder::class,
		]);
	}
}
