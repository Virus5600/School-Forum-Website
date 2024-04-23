<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Enums\VoteType;

use App\Models\Discussion;
use App\Models\DiscussionCategory;
use App\Models\VotedDiscussion;

use DB;
use Exception;
use Log;
use Validator;

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

	public function create(Request $req) {
		$categories = DiscussionCategory::get();

		return view('discussions.create', [
			"categories" => $categories,
			"url" => $req->url,
			"category" => $req->category,
		]);
	}

	public function store(Request $req) {
		// Validate
		$validator = Validator::make(
			$req->except(self::EXCEPT),
			Discussion::getValidationRules('category', 'title', 'content'),
			Discussion::getValidationMessages()
		);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withInput();
		}

		$cleanData = (object) $validator->validate();

		try {
			DB::beginTransaction();

			// Fetch/Create category
			$category = DiscussionCategory::firstOrCreate([
				'name' => strtolower($cleanData->category),
			], [
				'name' => $cleanData->category,
				'slug' => Str::of(strtolower($cleanData->category))->slug('-'),
			]);

			// Create Discussion
			$discussion = Discussion::create([
				'category_id' => $category->id,
				'slug' => Str::of("{$cleanData->title} " . now()->timestamp)->slug('-'),
				'title' => $cleanData->title,
				'content' => $cleanData->content,
				'posted_by' => auth()->user()->id,
			]);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back()
				->withInput()
				->with('flash_error', 'An error occurred while creating the discussion. Please try again later.');
		}

		return redirect()
			->route('discussions.show', ['name' => $category->name, 'slug' => $discussion->slug])
			->with('flash_success', 'Discussion has been created successfully.');
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
				"postedBy:id,username,avatar,gender,deleted_at",
				"votes"
			])
			->withCount("comments")
			->firstOrFail();

		// Vote Status
		$action = VotedDiscussion::DEFAULT_ACTIONS;
		if (auth()->check())
			$action = VotedDiscussion::where('discussion_id', '=', $discussion->id)
				->where('voted_by', '=', auth()->user()->id)
				->first()
				?->getStatusAction() ?? $action;

		// Fetch Comments
		$comments = $discussion->comments()
			->with('repliedBy', 'votes')
			->orderBy('created_at', 'asc')
			->paginate(10)
			->fragment('content');

		return view('discussions.show', [
			"discussion" => $discussion,
			"comments" => $comments,
			"upvoteAction" => $action['upvote'],
			"downvoteAction" => $action['downvote'],
		]);
	}

	public function edit(Request $req, string $name, string $slug) {
		// Fetch Discussion
		$discussion = Discussion::where("slug", "=", $slug)
			->firstOrFail();

		return view('discussions.edit', [
			"discussion" => $discussion,
			"category" => $name,
			"slug" => $slug,
		]);
	}

	public function update(Request $req, string $name, string $slug) {
		// Fetch Discussion
		$discussion = Discussion::where("slug", "=", $slug)
			->firstOrFail();

		// Validate
		$validator = Validator::make(
			$req->except(self::EXCEPT),
			Discussion::getValidationRules('title', 'content'),
			Discussion::getValidationMessages()
		);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withInput()
				->with('flash_error', $this->formatErrors($validator));
		}

		$cleanData = (object) $validator->validate();

		try {
			DB::beginTransaction();

			// Update Discussion
			$discussion->update([
				'title' => $cleanData->title,
				'slug' => Str::of("{$cleanData->title} {$discussion->created_at->timestamp}")->slug('-'),
				'content' => $cleanData->content,
			]);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back()
				->withInput()
				->with('flash_error', 'An error occurred while updating the discussion. Please try again later.');
		}

		return redirect()
			->route('discussions.show', ['name' => $name, 'slug' => $discussion->slug])
			->with('flash_success', 'Discussion has been updated successfully.');
	}

	public function delete(Request $req, string $name, string $slug) {
		// Fetch Discussion
		$discussion = Discussion::where("slug", "=", $slug)
			->firstOrFail();

		try {
			DB::beginTransaction();

			// Fetch Category (for redirection)
			$category = $discussion->category;

			// Delete Discussion
			$discussion->delete();

			// Set redirection
			$route = 'discussions.categories.show';
			$params = ['name' => $category->name];
			if (count($category->discussions) <= 0) {
				$route = 'discussions.index';
				$params = [];
			}

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back()
				->with('flash_error', 'An error occurred while deleting the discussion. Please try again later.');
		}

		return redirect()
			->route($route, $params)
			->with('flash_success', 'Discussion has been deleted successfully.');
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
