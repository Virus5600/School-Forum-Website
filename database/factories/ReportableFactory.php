<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Discussion;
use App\Models\DiscussionReplies;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reportable>
 */
class ReportableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$models = [
			'discussion' => Discussion::class,
			'comment' => DiscussionReplies::class
		];

        return [
			'reportable_type' => $type = fake()->randomElement(array_keys($models)),
			'reportable_id' => fake()->numberBetween(1, $models[$type]::count()),
			'reason' => fake()->sentence(),
			'reported_by' => fake()->numberBetween(1, User::count()),
        ];
    }

	/**
	 * Provides a reportable discussion.
	 *
	 * @param \App\Models\Discussion|int $id
	 */
	public function discussion(Discussion|int $id): static
	{
		$id = $id instanceof Discussion ? $id->id : $id;

		return $this->state(fn (array $attributes) => [
			'reportable_type' => 'discussion',
			'reportable_id' => $id
		]);
	}

	/**
	 * Provides a reportable discussion reply.
	 *
	 * @param \App\Models\DiscussionReplies|int $id
	 */
	public function reply(DiscussionReplies|int $id): static
	{
		$id = $id instanceof DiscussionReplies ? $id->id : $id;

		return $this->state(fn (array $attributes) => [
			'reportable_type' => 'comment',
			'reportable_id' => $id
		]);
	}

	/**
	 * Provides a user who reported the item.
	 *
	 * @param \App\Models\User|int $id
	 */
	public function reportedBy(User|int $id): static
	{
		$id = $id instanceof User ? $id->id : $id;

		return $this->state(fn (array $attributes) => [
			'reported_by' => $id
		]);
	}
}
