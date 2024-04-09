<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

use App\Enums\VoteType;

use DB;
use Exception;
use Log;

class VotedComment extends Model
{
	protected $fillable = [
		'type',
		'comment_id',
		'voted_by'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	/**
	 * Default actions that can be performed on a vote.
	 */
	const DEFAULT_ACTIONS = [
		"upvote" => "upvote",
		"downvote" => "downvote",
	];

	// Relationships
	public function comment() { return $this->belongsTo('App\Models\DiscussionReplies'); }
	public function votedBy() { return $this->belongsTo('App\Models\User', 'voted_by');}

	// Custom Functions
	/**
	 * Get the status of the vote and returns the actions that can be performed.
	 *
	 * @return array An array containing the action for `upvote` and `downvote`.
	 */
	public function getStatusAction(): array
	{
		// Identify the status of the vote
		$status = $this->type;

		// Provide the actions
		$action = self::DEFAULT_ACTIONS;

		// Modify the actions based on the status
		switch ($status) {
			case VoteType::UPVOTE->value:
				$action['upvote'] = "unvote";
				$action['downvote'] = "swap-to-downvote";
				break;
			case VoteType::DOWNVOTE->value:
				$action['upvote'] = "swap-to-upvote";
				$action['downvote'] = "unvote";
				break;
		}

		return $action;
	}

	// Processor Function
	/**
	 * Process the vote and returns a response containing the status of the operation,
	 * along with the action that was performed.
	 *
	 * @param Object|array $cleanData
	 * @param VoteType $type
	 *
	 * @return JsonResponse
	 */
	public static function processVote(Object|array $cleanData, VoteType $type): JsonResponse
	{
		if (is_array($cleanData)) {
			$cleanData = (object) $cleanData;
		}

		try {
			DB::beginTransaction();

			// Fetch the vote record
			$vote = VotedComment::where('comment_id', '=', $cleanData->id)
				->where('voted_by', '=', $cleanData->userID)
				->first();

			// If the vote record doesn't exist, create a new one
			$newlyCreated = false;
			if (!$vote) {
				$newlyCreated = true;
				$vote = VotedComment::create([
					'type' => $type->value,
					'comment_id' => $cleanData->id,
					'voted_by' => $cleanData->userID,
				]);
			}

			// If the vote record exists, update the vote type
			if (!$newlyCreated) {
				$deleted = false;
				switch ($cleanData->action) {
					case "swap-to-upvote":
						$vote->type = VoteType::UPVOTE->value;
						break;

					case "swap-to-downvote":
						$vote->type = VoteType::DOWNVOTE->value;
						break;

					case "unvote":
						$vote->delete();
						$deleted = true;
						break;
				}

				if (!$deleted)
					$vote->save();
			}

			$action = [
				"upvote" => "upvote",
				"downvote" => "downvote",
			];

			switch ($cleanData->action) {
				case VoteType::UPVOTE->value:
				case "swap-to-upvote":
					$action['upvote'] = "unvote";
					$action['downvote'] = "swap-to-downvote";
					break;

				case VoteType::DOWNVOTE->value:
				case "swap-to-downvote":
					$action['upvote'] = "swap-to-upvote";
					$action['downvote'] = "unvote";
					break;
			}

			$updatedCount = $vote->comment->getVoteCount();

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return response()->json([
				"message" => "Something went wrong, please try again later.",
				"status" => 500,
			], 500);
		}

		return response()->json([
			"message" => "Vote processed successfully.",
			"status" => 200,
			"updatedData" => [
				"id" => $cleanData->id,
				"updatedCount" => $updatedCount,
				"voteType" => "comment",
			],
			"action" => $cleanData->action,
			"newAction" =>	$action,
		], 200);
	}
}
