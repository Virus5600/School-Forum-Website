<?php

namespace App\Http\Controllers;

use App\Enums\EmailVerificationType;
use App\Jobs\AccountNotification;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use Spatie\Activitylog\Models\Activity;

use App\Models\User;

use DB;
use Exception;
use Hash;
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

			if ($cleanData->email != $user->email) {
				$user->email = $cleanData->email;

				$this->reVerifyAccount(
					type: EmailVerificationType::EMAIL_UPDATE(),
					validator: $validator,
					user: $user
				);

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

	// PASSWORD RELATED
	public function changePassword() {
		return view('authenticated.profile.change-password');
	}

	public function updatePassword() {
		$validator = Validator::make(
			request()->all(),
			User::getValidationRules('password', 'current_password:update'),
			User::getValidationMessages()
		);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator);
		}

		try {
			DB::beginTransaction();

			$user = auth()->user();
			$cleanData = (object) $validator->validated();

			$user->password = Hash::make($cleanData->password);
			$user->save();

			$this->reVerifyAccount(
				type: EmailVerificationType::PASSWORD_UPDATE(),
				validator: $validator,
				user: $user,
				args: ['password' => $cleanData->password]
			);

			activity('user')
				->by($user)
				->on($user)
				->event('updated password')
				->log('Updated password at' . now()->timezone('Asia/Manila')->format('(D) M d, Y h:i A') . '.');

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back()
				->with('flash_error', 'An error occurred while updating your password. Please try again later.');
		}

		return redirect()->route('profile.index')
			->with('flash_success', 'Password updated successfully.');
	}

	// DEACTIVATION RELATED
	public function deactivate() {
		return view('authenticated.profile.deactivate');
	}

	public function deactivateConfirmed() {
		try {
			DB::beginTransaction();

			// Store the user to begin deactivation process...
			$user = auth()->user();

			// Delete the user's access token...
			$token = $user->currentAccessToken();
			if ($token != null)
				$token->delete();

			// Logout the user...
			auth()->logout();
			session()->flush();
			session()->invalidate();
			session()->regenerateToken();

			// Log the logout activity...
			activity('user')
				->by($user)
				->on($user)
				->event('logout')
				->withProperties([
					'timestamp' => now()->timezone('Asia/Manila'),
					'login_attempts' => $user->login_attempts,
					'previous_auth' => $user->last_auth,
				])
				->log("User {$user->username} ({$user->email}) logged out");

			// Deactivate the user...
			$user->delete();

			// Log the deactivation activity...
			activity('user')
				->by($user)
				->on($user)
				->event('deactivated')
				->withProperties([
					'timestamp' => now()->timezone('Asia/Manila'),
					'ip_address' => $user->getUserIP(),
					'previous_auth' => $user->last_auth,
				])
				->log("User {$user->username} ({$user->email}) deactivated");

			// Notify the user of the deactivation...
			AccountNotification::dispatchAfterResponse(
				user: $user,
				type: $type,
				args: $args,
				callOnDestruct: true
			);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();

			Log::error($e);
		}
	}
}
