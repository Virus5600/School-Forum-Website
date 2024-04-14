<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\Discussion;
use App\Models\DiscussionCategory;
use App\Models\LostFound;

use DB;

class PageController extends Controller
{
	////////////////
	// GUEST SIDE //
	////////////////
	protected function index() {
		// Announcement Items
		$announcements = Announcement::orderBy("created_at", "desc")
			->limit(4)
			->get();

		// Lost Items
		$lostItems = LostFound::where("status", "lost")
			->orderBy("created_at", "desc")
			->limit(4)
			->get();

		// Forum Items
		$trendingCategoriesRaw = DiscussionCategory::has('discussions')
			->select([
				"discussion_categories.name as category",
				DB::raw("MAX(discussion_categories.id) as id"),
				DB::raw("COUNT(discussions.id) as category_count"),
				DB::raw("MAX(discussions.created_at) as created_at"),
				DB::raw("MAX(discussions.updated_at) as updated_at"),
			])
			->leftJoin("discussions", "discussion_categories.id", "=", "discussions.category_id")
			->groupBy("discussion_categories.name")
			->orderBy("category_count", "desc")
			->get()
			->toArray();

		$trendingCategories = [];
		foreach ($trendingCategoriesRaw as $v) {
			$category = $v['category'];

			if (isset($trendingCategories[$category])) {
				$tmp = $trendingCategories[$category];

				$lastTouched = Carbon::parse($tmp['updated_at'])
					->gt(Carbon::parse($v['updated_at'])) ?
						$tmp['updated_at'] : $v['updated_at'];

				$trendingCategories[$category] = [
					// Amount
					'amount' => $tmp['amount'] + $v['category_count'],

					// Updated At
					'updated_at' => $lastTouched,
				];
			}
			else {
				$lastTouched = Carbon::parse($v['created_at'])
					->gt(Carbon::parse($v['updated_at'])) ?
						$v['created_at'] : $v['updated_at'];

				$trendingCategories[$v['category']] = [
					'id' => $v['id'],
					'amount' => $v['category_count'],
					'updated_at' => $lastTouched
				];
			}
		}
		$trendingCategories = collect($trendingCategories)
			->sortBy([
				['amount', 'desc'],
				['updated_at', 'desc'],
			])
			->splice(0, 4);

		$discussions = [];
		foreach ($trendingCategories as $k => $v) {
			$discussions[$k] = Discussion::where('category_id', '=', $v['id'])
				->orderBy('created_at', 'desc')
				->orderBy('updated_at', 'desc')
				->limit(3)
				->get();
		}

		return view("index", [
			"announcements" => $announcements,
			"lostItems" => $lostItems,
			"discussions" => $discussions
		]);
	}

	protected function loaderIO() {
		return view('loaderio');
	}

	////////////////
	// ADMIN SIDE //
	////////////////
	protected function dashboard(Request $req) {
		return view("authenticated.admin.dashboard");
	}
}
