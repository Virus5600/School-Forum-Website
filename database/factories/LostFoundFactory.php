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
			"status" => $hasFounder ? "found" : "lost",
			"owner_name" => $hasFounder ? null : fake()->name(),
			"founder_name" => rand(0, 1) === 0 ? "Anonymous User" : fake()->name(),
			"item_found" => fake()->word(),
			"item_image" => "default.png",
			"place_found" => fake()->city(),
			"date_found" => fake()->dateTimeBetween(startDate: "-1 year", timezone: "Asia/Manila")->format("Y-m-d"),
			"time_found" => fake()->dateTimeBetween(startDate: "00:00:00", endDate: "23:59:59", timezone: "Asia/Manila")->format("H:i:s"),
        ];
    }

	// STATE MODIFIERS
	/**
	 * Provides a custom owner name for the lost item.
	 */
	public function withOwnerName(string $ownerName): static
	{
		return $this->state(fn (array $attributes) => [
			"owner_name" => $ownerName,
		]);
	}

	/**
	 * Provides a custom founder name for the lost item.
	 */
	public function withFounderName(string $founderName): static
	{
		return $this->state(fn (array $attributes) => [
			"founder_name" => $founderName,
		]);
	}

	/**
	 * Provides a custom item found for the lost item.
	 */
	public function withItemFound(string $itemFound): static
	{
		return $this->state(fn (array $attributes) => [
			"item_found" => $itemFound,
		]);
	}

	/**
	 * Provides a custom item image for the lost item.
	 */
	public function withItemImage(string $itemImage): static
	{
		return $this->state(fn (array $attributes) => [
			"item_image" => $itemImage,
		]);
	}

	/**
	 * Provides a custom place found for the lost item.
	 */
	public function withPlaceFound(string $placeFound): static
	{
		return $this->state(fn (array $attributes) => [
			"place_found" => $placeFound,
		]);
	}

	/**
	 * Provides a custom date found for the lost item.
	 */
	public function withDateFound(string $dateFound): static
	{
		return $this->state(fn (array $attributes) => [
			"date_found" => $dateFound,
		]);
	}

	/**
	 * Provides a custom time found for the lost item.
	 */
	public function withTimeFound(string $timeFound): static
	{
		return $this->state(fn (array $attributes) => [
			"time_found" => $timeFound,
		]);
	}
}
