<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Discussion;

class DiscussionController extends Controller
{
	// Include Params
	private function fetchParams(): array { return $this->includeParams(self::ADMIN_QUERY_PARAMS); }

	// GUEST / PUBLIC SIDE
	public function index() {
		$categories = Discussion::select(['category'])
			->distinct()
			->pluck('category')
			->toArray();

		dd($categories);

		$discussions = Discussion::latest()->paginate(10);

		return view('discussions.index', [
			"discussions" => $discussions,
		]);
	}
}
