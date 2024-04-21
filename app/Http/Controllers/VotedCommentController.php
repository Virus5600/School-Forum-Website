<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Enums\VoteType;

use App\Models\VotedComment;

class VotedCommentController extends Controller
{
    // API FUNCTIONS
	public function upvote(Request $req) {
		$validator = $this->validateVoteParams('comment', $req->except(self::EXCEPT));

		if ($validator->fails()) {
			return response()->json([
				"message" => $this->formatErrors($validator),
				"status" => 422
			], 422);
		}

		return VotedComment::processVote($validator->validate(), VoteType::UPVOTE);
	}

	public function downvote(Request $req) {
		$validator = $this->validateVoteParams('comment', $req->except(self::EXCEPT));

		if ($validator->fails()) {
			return response()->json([
				"message" => $this->formatErrors($validator),
				"status" => 422
			], 422);
		}

		return VotedComment::processVote($validator->validate(), VoteType::DOWNVOTE);
	}
}
