<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\DiscussionCategory;

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
			])
			->withCount("comments")
			->firstOrFail();

		return view('discussions.show', [
			"discussion" => $discussion,
		]);
	}
}
