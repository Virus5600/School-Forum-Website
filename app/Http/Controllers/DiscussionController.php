<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Enums\VoteType;

use App\Models\DiscussionCategory;
use App\Models\VotedDiscussion;

class DiscussionController extends Controller
{
	// Include Params
	private function fetchParams(): array { return $this->includeParams(self::ADMIN_QUERY_PARAMS); }

	// GUEST / PUBLIC SIDE
	public function index(Request $req) {
		// Fetch Discussions
		$discussions = DiscussionCategory::has('discussions')
			->with(
				"discussions",
				"discussions.postedBy"
			)->orderBy("name", "asc")
			->paginate(6)
			->fragment("content");

		// Fetch Categories
		$categories = DiscussionCategory::has('discussions')
			->withCount("discussions")
			->orderBy("updated_at", "desc")
			->orderBy("discussions_count", "desc")
			->limit(9)
			->get();

		// FINAL MODIFICATION
		$discussions = $discussions->withQueryString();

		return view('discussions.index', [
			"categories" => $categories,
			"discussions" => $discussions,
		]);
	}

	public function show(Request $req, string $name, string $slug) {
		// Fetch Category
		$category = DiscussionCategory::where("name", Str::lower($name))
			->firstOrFail();

		// Fetch Discussion
		$discussion = $category->discussions()
			->where("slug", "=", $slug);

		// FINAL MODIFICATION
		$discussion = $discussion
			->with([
				"postedBy:id,username,avatar",
				"comments" => [
					"repliedBy:id,username,avatar"
				],
				"votes"
			])
			->withCount("comments")
			->firstOrFail();

		// Vote Status
		$status = null;
		if (auth()->check())
			$status = VotedDiscussion::where('discussion_id', '=', $discussion->id)
				->where('voted_by', '=', auth()->user()->id)
				->first();

		// Identify the status.
		if ($status) {
			$status = $status->type;
		}

		// Provide the actions
		$action = [
			"upvote" => "upvote",
			"downvote" => "downvote",
		];

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

		return view('discussions.show', [
			"discussion" => $discussion,
			"upvoteAction" => $action['upvote'],
			"downvoteAction" => $action['downvote'],
		]);
	}

	// API FUNCTIONS
	public function upvote(Request $req) {
		$validator = $this->validateVoteParams('discussion', $req->except('_token', 'bearer', '_method'));

		if ($validator->fails()) {
			return response()->json([
				"message" => $this->formatErrors($validator),
				"status" => 422
			], 422);
		}

		return VotedDiscussion::processVote($validator->validate(), VoteType::UPVOTE);
	}

	public function downvote(Request $req) {
		$validator = $this->validateVoteParams('discussion', $req->except('_token', 'bearer', '_method'));

		if ($validator->fails()) {
			return response()->json([
				"message" => $this->formatErrors($validator),
				"status" => 422
			], 422);
		}

		return VotedDiscussion::processVote($validator->validate(), VoteType::DOWNVOTE);
	}
}
