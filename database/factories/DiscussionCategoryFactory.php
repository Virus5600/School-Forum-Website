<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiscussionCategory>
 */
class DiscussionCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			'name' => fake()->word(),
        ];
    }

	/**
	 * Indicate that the category is a general category.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	public function general(): Factory
	{
		return $this->state(fn (array $attributes) => [
			'name' => "general",
		]);
	}

	/**
	 * Provide a category name.
	 *
	 * @return \Illuminate\Database\Eloquent\Factories\Factory
	 */
	public function category(string $name): Factory
	{
		return $this->state(fn (array $attributes) => [
			'name' => $name,
		]);
	}
}
