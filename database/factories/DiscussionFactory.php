<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'category' => rand(0, 1) == 0 ? fake()->word() : 'general discussion',
			'title' => fake()->sentence(),
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
			'category' => 'general discussion'
		]);
	}

	/**
	 * Provides a discussion with a provided category.
	 */
	public function category(string $category): static
	{
		return $this->state(fn (array $attributes) => [
			'category' => $category
		]);
	}

	/**
	 * Provides a discussion with a provided title.
	 */
	public function title(string $title): static
	{
		return $this->state(fn (array $attributes) => [
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
}
