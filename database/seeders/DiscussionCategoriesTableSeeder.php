<?php

namespace Database\Seeders;

use App\Models\DiscussionCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscussionCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiscussionCategory::factory()
			->general()
			->count(1)
			->create();

		DiscussionCategory::factory()
			->count(9)
			->create();
    }
}
