<?php

namespace Database\Factories;

use Illuminate\Support\Str;
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
		$word = fake()->word();
        return [
			'name' => $word,
			'slug' => Str::slug($word, "-")
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
			'slug' => "general"
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
			'slug' => Str::slug($name, '-'),
		]);
	}
}
