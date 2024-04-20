<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\VoteType;

class DiscussionReplies extends Model
{
    use HasFactory;

	protected $fillable = [
		'discussion_id',
		'replied_by',
		'content'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	protected $with = [
		'repliedBy'
	];

	// Relationships
	public function discussion() { return $this->belongsTo("App\Models\Discussion", 'discussion_id'); }
	public function repliedBy() { return $this->belongsTo("App\Models\User", 'replied_by')->withTrashed(); }
	public function votes() { return $this->hasMany("App\Models\VotedComment", 'comment_id'); }

	// Custom Functions
	/**
	 * Get the vote count for the comment.
	 *
	 * @return int The vote count for the comment.
	 */
	public function getVoteCount(): int
	{
		$updatedCount = $this->votes->sum(function($vote) {
			return $vote->type == VoteType::UPVOTE->value ? 1 : -1;
		});

		return $updatedCount;
	}

	/**
	 * Get the status of the vote and returns the actions that can be performed.
	 *
	 * @param int $user_id The ID of the user who voted.
	 *
	 * @return array An array containing the action for `upvote` and `downvote`.
	 */
	public function getStatusAction(int $user_id): array
	{
		$vote = $this->votes->where('voted_by', $user_id)->first();
		if ($vote == null)
			return VotedComment::DEFAULT_ACTIONS;

		return $vote->getStatusAction();
	}

	// VALIDATOR RELATED FUNCTIONS
	/**
	 * Get the validation rules for the specified fields. If no fields are specified,
	 * all fields will be returned.
	 *
	 * @param string $fields The fields to get the validation rules for. If not specified, all fields will be returned.
	 *
	 * @return array The validation rules for the specified fields.
	 */
	public static function getValidationRules(...$fields): array
	{
		$rules = [
			"content" => ['required', 'string', 'max:8192']
		];

		if ($fields == null || count($fields) <= 0)
			return $rules;

		$toRet = [];
		foreach ($fields as $field) {
			if (array_key_exists($field, $rules))
				$toRet[$field] = $rules[$field];
		}

		return $toRet;
	}

	/**
	 * Get the validation messages for all the fields.
	 *
	 * @return array The validation messages for all the fields.
	 */
	public static function getValidationMessages(): array
	{
		return [
			"content.required" => "Status is required.",
			"content.string" => "The status must be a string.",
			"content.max" => "The status must not exceed 8192 characters."
		];
	}
}
