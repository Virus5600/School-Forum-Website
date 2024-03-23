<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Announcement;

class AnnouncementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::factory()
			->count(20)
			->create();
    }
}
