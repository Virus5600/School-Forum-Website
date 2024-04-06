<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LostFound;

use DB;
use Exception;
use Log;
use Validator;

class LostFoundController extends Controller
{
	// Include Params
	private function fetchParams(): array { return $this->includeParams(self::ADMIN_QUERY_PARAMS); }

	// GUEST / PUBLIC SIDE
    public function index() {
		$lostItems = LostFound::whereNull("owner_name")
			->latest()
			->paginate(9)
			->fragment("content");

		return view('lost_found.index', [
			"lostItems" => $lostItems,
			"instructions" => LostFound::getInstructions(),
		]);
	}

	public function show(Request $req, $id) {
		$item = LostFound::findOrFail($id);

		return view('lost_found.show', [
			"item" => $item,
			"instructions" => LostFound::getInstructions(),
		]);
	}

	// ADMIN SIDE
	public function adminIndex(Request $req) {
		// Sortable Columns
		$sortable = LostFound::SORTABLE;
		array_push($sortable, "found_on");

		// Sort Column Target
		if ($req->has("sort") && in_array($req->sort, $sortable)) {
			$sort = $req->sort;
		} else {
			$sort = "created_at";
		}

		// Sort Direction
		if ($req->has("direction") && in_array($req->direction, ["asc", "desc"])) {
			$dir = $req->direction;
		} else {
			$dir = "desc";
		}

		// Initialize Query
		$items = LostFound::select([
			"*",
			DB::raw("CONCAT(date_found, ' ', time_found) as found_on"),
		])
		->withTrashed();

		// Search Query
		if ($req->has("search")) {
			$search = $req->search;
			$items = LostFound::where("item_found", "LIKE", "%$search%")
				->orWhere("item_description", "LIKE", "%$search%")
				->orWhere("founder_name", "LIKE", "%$search%")
				->orWhere("place_found", "LIKE", "%$search%")
				->orWhere("owner_name", "LIKE", "%$search%")
				->orWhere("status", "LIKE", "%$search%");
		}

		// Actual Query
		$items = $items
			->sortable($sortable)
			->orderBy($sort, $dir)
			->latest()
			->paginate(10)
			->fragment("content")
			->withQueryString();

		$columns = [
			"Item" => "item_found",
			"Description" => "item_description",
			"Founder" => "founder_name",
			"Found At" => "place_found",
			"Found On" => "found_on",
			"Owner" => "owner_name",
			"Status" => "status",
		];

		$toRet = [
			"items" => $items,
			"columns" => $columns,
		];

		$params = $this->fetchParams();
		$toRet = array_merge($toRet, $params);
		return view('authenticated.admin.lost_found.index', $toRet)
			->with('params', $params);
	}

	public function adminCreate(Request $req) {
		$params = $this->fetchParams();

		return view('authenticated.admin.lost_found.create', $params)
			->with('params', $params);
	}

	public function adminStore(Request $req) {
		$cols = array_keys($req->except(self::ADMIN_EXCEPT));
		$validator = Validator::make(
			$req->except(self::ADMIN_EXCEPT),
			LostFound::getValidationRules(...$cols),
			LostFound::getValidationMessages()
		);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator)
				->withInput();
		}

		$cleanData = (object) $validator->validated();

		try {
			DB::beginTransaction();

			$defaultImage = LostFound::DEFAULT_POSTER;
			if ($req->exists('item_image')) {
				// Convert to WEBP format
				$imageName = time() . '.webp';
				$this->convertToWEBP(
					$imageName,
					$cleanData->item_image,
					'uploads/lost-and-found'
				);

				$cleanData->item_image = $imageName;
			}
			else {
				$cleanData->item_image = $defaultImage;
			}

			// Store the data
			$item = LostFound::create((array) $cleanData);

			// Log the activity
			activity('lost-and-found')
				->by(auth()->user())
				->performedOn($item)
				->event('create')
				->withProperties((array) $cleanData);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back('admin.lost-and-found.create')
				->with('flash_error', 'An error occurred while creating the item.');
		}

		$params = $this->fetchParams();

		return redirect()
			->route('admin.lost-and-found.index', $params)
			->with('params', $params)
			->with('flash_success', 'Item has been created.');
	}

	public function adminShow($id) {
		$item = LostFound::findOrFail($id);

		return view('authenticated.admin.lost_found.show', [
			"item" => $item,

		]);
	}

	public function adminDestroy(Request $req, $id) {
		$item = LostFound::findOrFail($id);
		$item->forceDelete();

		$params = $this->fetchParams();
		$params["params"] = $params;

		return redirect()
			->route('admin.lost-and-found.index', $params)
			->with('flash_success', 'Item has been deleted.');
	}
}
