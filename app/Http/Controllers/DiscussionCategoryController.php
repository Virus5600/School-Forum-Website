<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Discussion;
use App\Models\DiscussionCategory;

use Validator;

class DiscussionCategoryController extends Controller
{
    public function index(Request $req) {
		// Initiate Query
		$query = DiscussionCategory::query();

		// Search
		$search = $req->search;
		if ($req->search) {
			$search = Validator::make($req->all(), [
				"search" => "string|max:255",
			])->validate()["search"];

			$search = strtolower(trim($search));

			$query->where("name", "like", "%$search%");
		}

		$categories = $query->has('discussions')
			->withCount("discussions")
			->with('discussions');

		// Sort
		if (!($req->has('sort') && $req->has('direction'))) {
			$categories = $categories->orderBy("created_at", "desc")
				->orderBy("discussions_count", "desc");
		}
		else {
			$sortables = [
				"name",
				"discussions_count",
			];

			$validator = Validator::make($req->all(), [
				"sort" => ["string", "in:" . implode(",", $sortables)],
				"direction" => ["string", "in:asc,desc"],
			]);

			if ($validator->fails()) {
				$categories = $categories->orderBy("created_at", "desc")
					->orderBy("discussions_count", "desc");
			}
			else {
				$sort = $req->sort;
				$dir = $req->direction;

				$categories = $categories->orderBy($sort, $dir);
			}
		}

		$categories = $categories->paginate(10)
			->fragment("category_table")
			->withQueryString();

		return view('discussions.categories.index', [
			"search" => $search,
			"categories" => $categories,
		]);
	}

	public function show(Request $req, $name) {
		$category = DiscussionCategory::where('name', '=', $name)
			->firstOrFail();

		// Initialize Discussion Query
		$query = Discussion::select("discussions.*")
			->with('postedBy:id,username,deleted_at')
			->leftJoin('users', 'discussions.posted_by', '=', 'users.id')
			->where('category_id', '=', $category->id);

		// Search
		$search = $req->search;
		if ($req->search) {
			$search = Validator::make($req->all(), [
				"search" => "string|max:255",
			])->validate()["search"];

			$search = strtolower(trim($search));

			$query = $query->where(function($q) use ($search, $req) {
				$q = $q->where("discussions.title", "like", "%$search%")
					->orWhere("discussions.content", "like", "%$search%");

				if (!$req->has('user'))
					$q->orWhere("users.username", "like", "%$search%")
						->whereNull("users.deleted_at");
			});
		}

		// Sort
		if (!($req->has('sort') && $req->has('direction'))) {
			$query = $query->orderBy("discussions.created_at", "desc");
		}
		else {
			$sortables = [
				"title",
				"created_at",
				"postedBy.username",
			];

			$validator = Validator::make($req->all(), [
				"sort" => ["string", "in:" . implode(",", $sortables)],
				"direction" => ["string", "in:asc,desc"],
			]);

			if ($validator->fails()) {
				$query = $query->orderBy("discussions.created_at", "desc");
			}
			else {
				$sort = $req->sort;
				$dir = $req->direction;

				$query = $query->orderBy($sort, $dir);
			}
		}

		// User Filter
		if ($req->has('user')) {
			$user = $req->user;

			$query = $query->where('users.username', '=', $user);
		}

		$discussions = $query->paginate(10)
			->fragment("discussion_table")
			->withQueryString();

		return view('discussions.categories.show', [
			"search" => $req->search,
			"category" => $category,
			"discussions" => $discussions,
		]);
	}
}
