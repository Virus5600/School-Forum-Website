<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "poster" => "default.png",
			"title" => fake()->articleTitle(),
			"slug" => fake()->slug(),
			"summary" => fake()->paragraph(),
			"content" => fake()->paragraphs(3, true),
			"is_draft" => false,
			"published_at" => now(),
			"author_id" => 1,
			"created_at" => now()
        ];
    }

	// STATE MODIFIERS
	/**
	 * Provides a poster image for the announcement.
	 */
	public function withPoster(string $poster): static
	{
		return $this->state(fn (array $attributes) => [
			"poster" => $poster,
		]);
	}

	/**
	 * Provides a custom title for the announcement.
	 */
	public function withTitle(string $title): static
	{
		return $this->state(fn (array $attributes) => [
			"title" => $title,
		]);
	}

	/**
	 * Provides a custom slug for the announcement.
	 */
	public function withSlug(string $slug): static
	{
		return $this->state(fn (array $attributes) => [
			"slug" => $slug,
		]);
	}

	/**
	 * Provides a custom summary for the announcement.
	 */
	public function withSummary(string $summary): static
	{
		return $this->state(fn (array $attributes) => [
			"summary" => $summary,
		]);
	}

	/**
	 * Provides a custom content for the announcement.
	 */
	public function withContent(string $content): static
	{
		return $this->state(fn (array $attributes) => [
			"content" => $content,
		]);
	}

	/**
	 * Indicate that the announcement is a draft.
	 */
	public function draft(): static
	{
		return $this->state(fn (array $attributes) => [
			"is_draft" => true,
		]);
	}

	/**
	 * Indicate that the announcement is published.
	 */
	public function published(): static
	{
		return $this->publishedAt(now()->format("Y-m-d H:i:s"));
	}

	/**
	 * Indicate that the announcement is published at the specified date and time.
	 */
	public function publishedAt(string $datetime): static
	{
		return $this->state(fn (array $attributes) => [
			"is_draft" => false,
			"published_at" => $datetime,
		]);
	}

	/**
	 * Indicate that the announcement is published by the specified user.
	 */
	public function publishedBy(int $authorId): static
	{
		return $this->state(fn (array $attributes) => [
			"author_id" => $authorId,
		]);
	}

	/**
	 * Indicate that the announcement is created at the specified date and time.
	 */
	public function createdAt(string $datetime): static
	{
		return $this->state(fn (array $attributes) => [
			"created_at" => $datetime,
		]);
	}
}
