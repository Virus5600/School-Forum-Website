<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\DiscussionCategory;
use App\Models\User;

use Exception;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discussion>
 */
class DiscussionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$title = fake()->sentence();
        return [
            'category_id' => rand(0, 1) == 0 ? fake()->numberBetween(1, DiscussionCategory::count()) : 1,
			'slug' => Str::of($title . " " . now()->timestamp)->slug('-'),
			'title' => $title,
			'content' => fake()->paragraphs(3, true),
			'posted_by' => fake()->numberBetween(1, User::count())
        ];
    }

	/**
	 * Provides a discussion with the category "general discussion".
	 */
	public function general(): static
	{
		return $this->state(fn (array $attributes) => [
			'category_id' => 1
		]);
	}

	/**
	 * Provides a discussion with a provided category.
	 */
	public function category(int $id): static
	{
		if (DiscussionCategory::find($id) === null)
			throw new Exception("Category with ID {$id} does not exist.");

		return $this->state(fn (array $attributes) => [
			'category_id' => $id
		]);
	}

	/**
	 * Provides a discussion with a provided title.
	 */
	public function title(string $title): static
	{
		return $this->state(fn (array $attributes) => [
			'slug' => Str::of($title . " " . now()->timestamp)->slug('-'),
			'title' => $title
		]);
	}

	/**
	 * Provides a discussion with a provided content.
	 */
	public function content(string $content): static
	{
		return $this->state(fn (array $attributes) => [
			'content' => $content
		]);
	}

	/**
	 * Provides a discussion with a provided user.
	 */
	public function postedBy(int $userId): static
	{
		if (User::find($userId) === null)
			throw new Exception("User with ID {$userId} does not exist.");

		return $this->state(fn (array $attributes) => [
			'posted_by' => $userId
		]);
	}

	public function randomDates(): static
	{
		return $this->state(function (array $attributes) {
			$createdAt = fake()->dateTimeBetween('-1 day', 'now', 'Asia/Manila');
			$updatedAt = fake()->dateTimeBetween($createdAt, 'now', 'Asia/Manila');
			$edited = fake()->boolean();

			return [
				'created_at' => $createdAt,
				'updated_at' => $edited ? $updatedAt : $createdAt,
			];
		});
	}
}
