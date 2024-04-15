<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use Spatie\Activitylog\Models\Activity;

use App\Jobs\AccountNotification;

use App\Models\User;

use DB;
use Exception;
use Log;
use Validator;

class ProfileController extends Controller
{
    public function index() {
		$activities = Activity::where('subject_type', '=', 'App\Models\User')
			->where('subject_id', '=', auth()->user()->id)
			->orderBy('created_at', 'desc')
			->get()
			->groupBy(function($date) {
				return $date->created_at->format('M d, Y (D)');
			});

		$activities = new LengthAwarePaginator($activities, $activities->count(), 10);

		return view('authenticated.profile.index', [
			'activities' => $activities
		]);
	}

	public function edit() {
		$user = auth()->user();

		return view('authenticated.profile.edit', [
			'user' => $user
		]);
	}

	public function update(Request $req) {
		$user = auth()->user();
		$route = 'profile.index';

		$validator = Validator::make(
			$req->except(self::EXCEPT),
			User::getValidationRules('first_name', 'middle_name', 'last_name', 'suffix', 'gender', 'username:update', 'email:update'),
			User::getValidationMessages()
		);

		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator);
		}

		$cleanData = (object) $validator->validated();

		try {
			DB::beginTransaction();

			$user->first_name = $cleanData->first_name;
			$user->middle_name = $cleanData->middle_name;
			$user->last_name = $cleanData->last_name;
			$user->suffix = $cleanData->suffix;
			$user->gender = $cleanData->gender;
			$user->username = $cleanData->username;

			# TODO: Implement email verification and its process
			if ($cleanData->email != $user->email) {
				$user->email = $cleanData->email;

				$user->is_verified = 0;
				$user->accountVerification()->create([
					'token' => substr(bin2hex(random_bytes(32)), 0, 16),
					'expires_at' => now()->addDay()
				]);

				// MAILER
				$reqArgs = $validator->validated();
				$args = [
					'subject' => 'Email Updated',
					'req' => $reqArgs,
					'email' => $cleanData->email,
					'recipients' => [$cleanData->email],
					'code' => $user->accountVerification->token
				];
				AccountNotification::dispatchAfterResponse(
					user: $user,
					type: "email_update",
					args: $args,
					callOnDestruct: true
				)->onQueue("email_update");

				$route = 'verification.index';
			}

			if (in_array($user->avatar, User::DEFAULT_AVATAR) && $user->user_type_id != 1)
				$user->avatar = User::DEFAULT_AVATAR[$user->gender];

			activity('user')
				->by($user)
				->on($user)
				->event('updated profile')
				->withProperties($validator->validated())
				->log('Updated profile at' . now()->timezone('Asia/Manila')->format('(D) M d, Y h:i A') . '.');

			$user->save();

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()->back()
				->with('flash_error', 'An error occurred while updating your profile. Please try again later.');
		}

		return redirect()->route($route)
			->with('flash_success', 'Profile updated successfully.');
	}
}
