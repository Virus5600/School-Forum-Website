<?php

namespace App\Http\Controllers;

use App\Models\Reportable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use DB;
use Exception;
use Log;

class ReportController extends Controller
{
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
