<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

use App\Enums\VoteType;

use DB;
use Exception;
use Log;

class VotedDiscussion extends Model
{
    use HasFactory;

	protected $fillable = [
		'type',
		'discussion_id',
		'voted_by'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relationships
	public function discussion() { return $this->belongsTo('App\Models\Discussion'); }
	public function votedBy() { return $this->belongsTo('App\Models\User', 'voted_by');}

	// Processor Function
	/**
	 * Process the vote and returns a response containing the status of the operation,
	 * along with the action that was performed.
	 *
	 * @param Object|array $cleanData
	 * @param VoteType $type
	 */
	public static function processVote(Object|array $cleanData, VoteType $type): JsonResponse
	{
		if (is_array($cleanData)) {
			$cleanData = (object) $cleanData;
		}

		try {
			DB::beginTransaction();

			// Fetch the vote record
			$vote = VotedDiscussion::where('discussion_id', '=', $cleanData->id)
				->where('voted_by', '=', $cleanData->userID)
				->first();

			// If the vote record doesn't exist, create a new one
			$newlyCreated = false;
			if (!$vote) {
				$newlyCreated = true;
				$vote = VotedDiscussion::create([
					'type' => $type->value,
					'discussion_id' => $cleanData->id,
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

			$updatedCount = $vote->discussion->getVoteCount();

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
			],
			"action" => $cleanData->action,
			"newAction" =>	$action,
		], 200);
	}
}