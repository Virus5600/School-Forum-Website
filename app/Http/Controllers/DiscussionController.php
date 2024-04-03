<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
	public function index(Request $req) {
		$hasCat = false;
		if ($req->has("category")) {
			$validator = Validator::make($req->only('category'), [
				'category' => ['required', 'string', 'max:100'],
			]);

			$hasCat = !$validator->fails();
		}

		$query = DiscussionCategory::query();

		if ($hasCat)
			$query->where("name", $validator->validated()["category"]);

		$discussions = $query->has('discussions')
			->with(
			"discussions",
			"discussions.postedBy"
		)->orderBy("name", "asc")
			->paginate(10);

		return view('discussions.index', [
			"discussions" => $discussions,
		]);
	}
}
