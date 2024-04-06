<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Discussion;
use App\Models\DiscussionReplies;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiscussionReplies>
 */
class DiscussionRepliesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$discussionId = Discussion::inRandomOrder()->first()->id;

        return [
			'discussion_id' => $discussionId,
			'replied_by' => User::inRandomOrder()->first()->id,
			'content' => fake()->paragraphs(rand(1, 3), true),
        ];
    }

	/**
	 * Provides a reply with a specific discussion ID.
	 */
	public function discussionId(int $discussionId): static
	{
		return $this->state(fn (array $attributes) => [
			'discussion_id' => $discussionId
		]);
	}

	/**
	 * Provides a reply with a specific user ID.
	 */
	public function repliedBy(int $repliedBy): static
	{
		return $this->state(fn (array $attributes) => [
			'replied_by' => $repliedBy,
		]);
	}

	/**
	 * Provides a reply with specific content.
	 */
	public function content(string $content): static
	{
		return $this->state(fn (array $attributes) => [
			'content' => $content,
		]);
	}

	/**
	 * Provides a reply with random dates.
	 */
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
