<?php

namespace App\Http\Controllers;

use App\Models\Reportable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Log;

class ReportController extends Controller
{
	// Include Params
	private function fetchParams(): array { return $this->includeParams(self::ADMIN_QUERY_PARAMS); }

	// ADMIN CONTROLLERS
	public function index(Request $req) {
		// Sortable Columns
		$sortable = Reportable::SORTABLE;

		// Sort Column Target
		if ($req->has("sort") && in_array($req->sort, $sortable)) {
			$sort = $req->sort;
		} else {
			$sort = "reportables.created_at";
		}

		// Sort Direction
		if ($req->has("direction") && in_array($req->direction, ["asc", "desc"])) {
			$dir = $req->direction;
		} else {
			$dir = "desc";
		}

		// Initialize Query
		$reports = Reportable::leftJoin('discussions', function($join) {
				// Join the discussions table
				$join->on('reportables.reportable_id', '=', 'discussions.id')
					->where('reportables.reportable_type', '=', "'discussion'");
			})->leftJoin(DB::raw('discussion_replies AS comments'), function($join) {
				// Join the comments (discussion_replies) table
				$join->on('reportables.reportable_id', '=', 'comments.id')
					->where('reportables.reportable_type', '=', "'comment'");
			})
				// Join the users table
				->leftJoin('users', 'reportables.reported_by', '=', 'users.id');


		// Search
		if ($req->has("search")) {
			$search = trim($req->search);
			$reports->where('reportables.reportable_type', 'like', "%$search%")
				->orWhere('users.username', 'like', "%$search%")
				->orWhere('reportables.reason', 'like', "%$search%")
				->orWhere('reportables.status', 'like', "%$search%")
				->orWhere('reportables.action_taken', 'like', "%$search%")
				->orWhere('discussions.title', 'like', "%$search%")
				->orWhere('comments.content', 'like', "%$search%");
		}

		// Actual Query
		$reports = $reports
			->with('reportedBy')
			->sortable($sortable)
			->orderBy($sort, $dir)
			->latest('reportables.created_at')
			->paginate(10)
			->fragment("content")
			->withQueryString();

		$columns = [
			"Type" => "reportable_type",
			"Reported By" => "users.username",
			"Reason" => "reason",
			"Status" => "status",
			"Action Taken" => "action_taken",
			"Reported On" => "created_at",
		];

		$toRet = [
			"reports" => $reports,
			"columns" => $columns,
		];

		$params = $this->fetchParams();
		$toRet = array_merge($toRet, $params);
		return view('authenticated.admin.reports.index', $toRet)
			->with('params', $params);
	}

	public function show(Request $req, $uuid) {
		$report = Reportable::with([
				'reportedBy:id,avatar,username,gender,created_at,last_auth,is_verified',
				'reportable' => function(MorphTo $morphable) {
					$morphable->morphWith([
						"App\Models\Discussion" => ['postedBy'],
						"App\Models\DiscussionReplies" => [
							'repliedBy',
							'discussion' => ['postedBy'],
						],
					]);
				}])
			->where('uuid', $uuid)
			->firstOrFail();

		$toRet = [
			"report" => $report,
		];

		$params = $this->fetchParams();
		$toRet = array_merge($toRet, $params);
		return view('authenticated.admin.reports.show', $toRet)
			->with('params', $params);
	}

	public function updateStatus(Request $req, $id) {
	}

	public function updateAction(Request $req, $id) {
	}

	// API FUNCTIONS
	public function reportDiscussion(Request $req) {
		$validator = $this->validateReportParams(
			'discussion',
			$req->except(self::EXCEPT)
		);

		if ($validator->fails()) {
			Log::error($validator->errors());

			return response()->json([
				"message" => $this->formatErrors($validator),
				"status" => 422
			], 422);
		}

		return $this->report($validator->validate(), 'discussion');
	}

	public function reportComment(Request $req) {
		$validator = $this->validateReportParams(
			'comment',
			$req->except(self::EXCEPT)
		);

		if ($validator->fails()) {
			Log::error($validator->errors());

			return response()->json([
				"message" => $this->formatErrors($validator),
				"status" => 422
			], 422);
		}

		return $this->report($validator->validate(), 'comment');
	}

	/**
	 * Report a discussion or comment.
	 *
	 * @param Object|array $cleanData`
	 * @param string $type
	 *
	 * @return JsonResponse
	 */
    private function report(Object|array $cleanData, string $type): JsonResponse
	{
		$type = strtolower(trim($type));
		if (!in_array($type, ['discussion', 'comment'])) {
			Log::error("Invalid type: $type");

			return response()->json([
				"message" => "Invalid type: $type",
				"status" => 422
			], 422);
		}

		if (is_array($cleanData)) {
			$cleanData = (object) $cleanData;
		}

		try {
			DB::beginTransaction();

			$reportable = Reportable::create([
				'reported_by' => $cleanData->userID,
				'reportable_type' => $type,
				'reportable_id' => $cleanData->id,
				'reason' => $cleanData->reason
			]);

			DB::commit();
		} catch (Exception $e) {
			DB::rollBack();
			Log::error($e);

			return response()->json([
				"message" => "An error occurred while reporting $type",
				"status" => 500
			], 500);
		}

		return response()->json([
			"message" => "Reported $type",
			"status" => 200
		], 200);
	}
}
