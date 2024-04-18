<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\Discussion;
use App\Models\DiscussionCategory;
use App\Models\LostFound;
use App\Models\User;

use DB;
use Exception;
use Hash;
use Validator;

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

	protected function loaderIO(Request $req) {
		$tokens = [
			"52abcb913a992fad9c8e1eef99be8e70",
			"d339104e9d20dac006c782f918e6683e"
		];

		$token = preg_replace("/.+loaderio-(\w+)/", '$1', $req->fullUrl());
		$index = 0;

		if (in_array($token, $tokens))
			$index = array_search($token, $tokens);

		return view("loaderio{$index}");
	}

	////////////////////////
	// AUTHENTICATED SIDE //
	////////////////////////
	protected function confirmPassword() {
		return view("authenticated.password-confirmation");
	}

	protected function confirmSubmittedPassword(Request $req) {
		$validator = Validator::make(
			$req->except(self::EXCEPT),
			User::getValidationRules('password'),
			User::getValidationMessages()
		);

		if ($validator->fails()) {
			return redirect()
				->back()
				->with('flash_error', 'Wrong password...')
				->withErrors($validator);
		}

		$cleanData = (object) $validator->validated();

		try {
			$verified = Hash::check(
				$cleanData->password,
				auth()->user()->password
			);

			if (!$verified) {
				return redirect()
					->back()
					->with('flash_error', 'Wrong password...');
			}

			session()->remove('before-confirm-password');
			$req->session()->passwordConfirmed();

			return redirect()
				->intended(route('profile.index'));
		} catch (Exception $e) {
			Log::error($e->getMessage());

			return redirect()
				->back()
				->with('flash_error', 'An error occurred while verifying your password...');
		}
	}

	////////////////
	// ADMIN SIDE //
	////////////////
	protected function dashboard() {
		return view("authenticated.admin.dashboard");
	}
}
