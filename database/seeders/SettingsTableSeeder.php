<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Settings;

class SettingsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// FAVICON/LOGO
		Settings::create([
			'name' => 'web-logo',
			'value' => 'default.png',
			'default_value' => 'default.png',
			'is_file' => true
		]);

		// WEB NAME
		Settings::create([
			'name' => 'web-name',
			'value' => 'InnoTech',
			'default_value' => 'InnoTech'
		]);

		// DESCRIPTION
		Settings::create([
			'name' => 'web-desc',
			'value' => 'A dedicated forum website that allows both students and teachers alike to converse, provide and receive help, provide announcements, check the lost & found, and real time Casa point monitoring.',
			'default_value' => 'A dedicated forum website that allows both students and teachers alike to converse, provide and receive help, provide announcements, check the lost & found, and real time Casa point monitoring.'
		]);
	}
}
