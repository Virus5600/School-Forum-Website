<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Discussion;
use App\Models\DiscussionReplies;

class DiscussionRepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discussions = Discussion::get();

		foreach ($discussions as $discussion) {
			if (rand(0, 1)) {
				for ($i = 0; $i < rand(0, 10); $i++) {
					$discussion->comments()->save(
						DiscussionReplies::factory()
							->discussionId($discussion->id)
							->randomDates()
							->make()
					);
				}
			}
		}
    }
}
