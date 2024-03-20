<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LostFound>
 */
class LostFoundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$hasFounder = rand(0, 1) === 0;

        return [
			"owner_name" => rand(0, 1) === 0 ? "Anonymous User" : fake()->name(),
			"founder_name" => $hasFounder ? null : fake()->name(),
			"item_found" => fake()->productName(),
			"item_image" => "default.png",
			// "place_found" => fake()->
        ];
    }
}
