<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\LostFound;

class LostFoundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LostFound::factory()
			->count(20)
			->create();
    }
}
