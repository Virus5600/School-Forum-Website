<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\CarouselImage;

class CarouselImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$carouselImages = [
			[
				'filename' => 'carousel-1.jpg',
				'active' => true,
				'created_by' => 1,
				'updated_by' => 1,
			],
			[
				'filename' => 'carousel-2.jpg',
				'active' => true,
				'created_by' => 1,
				'updated_by' => 1,
			],
			[
				'filename' => 'carousel-3.jpg',
				'active' => true,
				'created_by' => 1,
				'updated_by' => 1,
			],
			[
				'filename' => 'carousel-4.jpg',
				'active' => true,
				'created_by' => 1,
				'updated_by' => 1,
			],
			[
				'filename' => 'carousel-5.jpg',
				'active' => true,
				'created_by' => 1,
				'updated_by' => 1,
			],
		];

		foreach ($carouselImages as $carouselImage) {
			CarouselImage::create($carouselImage);
		}
    }
}
