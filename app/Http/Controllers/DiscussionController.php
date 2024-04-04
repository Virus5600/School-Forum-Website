<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Discussion;
use App\Models\DiscussionCategory;

use DB;
use Exception;
use Log;
use Validator;

class DiscussionController extends Controller
{
	// Include Params
	private function fetchParams(): array { return $this->includeParams(self::ADMIN_QUERY_PARAMS); }

	// GUEST / PUBLIC SIDE
	public function index(Request $req, $category = null) {
		$hasCat = false;
		if ($req->has("category")) {
			return redirect()
				->route("discussions.category.index", $req->category);
		}

		if ($category) {
			$validator = Validator::make(['category' => $category], [
				'category' => ['required', 'string', 'max:100'],
			]);

			$hasCat = !$validator->fails();
		}

		if ($hasCat) {
			$catID = DiscussionCategory::where("name", $validator->validated()["category"])->first()
				?->id;

			$discussions = Discussion::where("category_id", "=", $catID)
				->with(
				"postedBy"
			)->orderBy("created_at", "desc")
				->paginate(10);
		}
		else {
			$discussions = DiscussionCategory::where("name", $validator->validated()["category"])
				->has('discussions')
				->with(
				"discussions",
				"discussions.postedBy"
			)->orderBy("name", "asc")
				->paginate(10);
		}

		// FINAL MODIFICATION
		$discussions = $discussions->withQueryString();

		return view('discussions.index', [
			"hasCat" => $hasCat,
			"category" => $hasCat ? $validator->validated()["category"] : "",
			"discussions" => $discussions,
		]);
	}
}
