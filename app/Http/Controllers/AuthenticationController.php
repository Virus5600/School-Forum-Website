<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Sanctum\Sanctum;

use App\Jobs\AccountNotification;

use App\Models\PasswordReset;
use App\Models\User;

use DB;
use Exception;
use Log;
use Validator;

class AuthenticationController extends Controller
{
	// LOGINS
	protected function login() {
		return view("login");
	}

	protected function authenticate(Request $req) {
		$validator = Validator::make($req->all(), [
			'username' => ["required", "string"],
			'password' => ["required", "string"]
		]);

		$user = User::where('username', '=', $req->username)->first();

		// Identifies whether the user exists or not.
		if ($user == null || $validator->fails()) {
			return redirect()
				->back()
				->with('flash_error', 'Wrong username/password!')
				->withInput($req->only('username'));
		}

		// Authenticate the user
		$authenticated = false;
		if (!$user->locked) {
			$authenticated = auth()->attempt([
				'username' => $req->username,
				'password' => $req->password
			]);
		}

		// Designate the next action depending on the authentication result
		if ($authenticated) {
			if ($user) {
				$req->session()->regenerate();

				try {
					DB::beginTransaction();

					activity('authentication')
						->byAnonymous()
						->on($user)
						->event('login-success')
						->withProperties([
							'timestamp' => now()->timezone('Asia/Manila'),
							'login_attempts' => $user->login_attempts,
							'previous_auth' => $user->last_auth,
						])
						->log("User {$user->username} successfully logged in.");

					$user->login_attempts = 0;
					$user->last_auth = now()->timezone('Asia/Manila');
					$user->save();

					DB::commit();
				} catch (Exception $e) {
					DB::rollback();
					Log::error($e);
				}
			}

			$token = $user->createToken('authenticated');
			if ($expiration = config('sanctum.expiration')) {
				$model = Sanctum::$personalAccessTokenModel;
				$model::where('created_at', '<', now()->subMinutes($expiration))->delete();
			}

			session(["bearer" => $token->plainTextToken]);

			// Defines what page to redirect to after successful login
			$intended = $user->userType->slug === "student" ? "home" : "admin.dashboard";
			return redirect()
				->intended(route($intended))
				->with('flash_success', "Logged In!");
		}
		else {
			$msg = "";

			if ($user) {
				try {
					DB::beginTransaction();

					// Increase login attempts if login failed
					if ($user->login_attempts < 5) {
						$user->login_attempts = $user->login_attempts + 1;
						$msg = "Wrong username/password!";
					}
					// Lock the account if the user attempted more than 5 logins
					else {
						if ($user->locked == 0) {
							// Generate a password reset link if there are no other instances of this email in the password reset table
							if (PasswordReset::where('email', '=', $user->email)->get()->count() <= 0) {
								PasswordReset::insert([
									'email' => $user->email,
									'created_at' => now()->timezone('Asia/Manila')
								]);

								$pr = PasswordReset::where('email', '=', $user->email)->first();
								$pr->generateToken()->generateExpiration();

								activity('authentication')
									->byAnonymous()
									->on($user)
									->event('login-attempt')
									->withProperties([
										'timestamp' => now()->timezone('Asia/Manila'),
										'login_attempts' => $user->login_attempts,
										'previous_auth' => $user->last_auth,
									])
									->log("Locked account of {$user->username} ({$user->email}) after 5 incorrect attempts");
							}
							// Otherwise, fetch the row to use the already generated data
							else {
								$pr = PasswordReset::where('email', '=', $user->email)->first();

								activity('authentication')
									->byAnonymous()
									->on($user)
									->event('login-attempt')
									->withProperties([
										'timestamp' => now()->timezone('Asia/Manila'),
										'login_attempts' => $user->login_attempts,
										'previous_auth' => $user->last_auth,
									])
									->log("Login attempt to {$user->username} ($user->email) after lockout");
							}

							// Send an email to the owner of the locked account
							$args = [
								"subject" => "Your account has been locked!",
								"token" => $pr->token,
								"email" => $user->email,
								"recipients" => [$user->email]
							];

							AccountNotification::dispatchAfterResponse($user, "locked", $args, true)
								->onQueue("account_breach");
						}

						$user->locked = 1;
						$user->locked_by = User::getIP();
						$msg = "Exceeded 5 tries, account locked";
					}
					$user->save();

					activity('authentication')
						->byAnonymous()
						->on($user)
						->event('login-attempt')
						->withProperties([
							'timestamp' => now()->timezone('Asia/Manila'),
							'login_attempts' => $user->login_attempts,
							'previous_auth' => $user->last_auth,
						])
						->log("Login attempted for {$user->username} ({$user->email})");

					DB::commit();
				} catch (Exception $e) {
					DB::rollback();
					Log::error($e);
				}
			}
		}

		auth()->logout();
		return redirect()
			->back()
			->with('flash_error', $msg)
			->withInput($req->only('username'));
	}

	protected function logout(Request $req) {
		if (auth()->check()) {
			$user = auth()->user();

			$token = $user->currentAccessToken();
			if ($token != null)
				$token->delete();

			auth()->logout();
			session()->flush();
			session()->invalidate();
			session()->regenerateToken();

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

			return redirect(route("home"))
				->with('flash_success', "Logged out!");
		}

		return redirect()
			->route("admin.dashboard")
			->with("flash_error", "Something went wrong, please try again.");
	}

	// FORGOT PASSWORD
	protected function forgotPassword(Request $req) {
		return view("change-password.index", [
			"identifier" => $req->username ?? ""
		]);
	}

	// CHANGE PASSWORD
	protected function changePassword(Request $req, string $token) {
		return view("change-password.edit", [
			"token" => $token
		]);
	}

	protected function updatePassword(Request $req, string $token) {
		$pr = PasswordReset::where('token', '=', $token)->first();
		$user = $pr->user;

		if ($user == null) {
			return redirect()
				->route('login')
				->with('flash_error', 'User either does not exists or is already deleted');
		}

		$validator = Validator::make($req->all(), [
			'password' => array('required', 'regex:/([a-z]*)([0-9])*/i', 'min:8', 'confirmed'),
			'password_confirmation' => 'required'
		], [
			'password.required' => 'The new password is required',
			'password.regex' => 'Password must contain at least 1 letter and 1 number',
			'password.min' => 'Password should be at least 8 characters',
			'password.confirmed' => 'You must confirm your password first',
			'password_confirmation.required' => 'You must confirm your password first'
		]);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator);
		}

		try {
			DB::beginTransaction();

			$user->password = Hash::make($req->password);
			$user->login_attempts = 0;
			$user->locked = 0;
			$user->locked_by = null;

			$args = [
				'subject' => 'Password Changed',
				'recipients' => [$user->email],
				'email' => $user->email,
				'password' => $req->password
			];

			// Uses past-tense due to password is now changed
			AccountNotification::dispatchAfterResponse($user, "changed-password", $args)
				->onQueue("account_update");

			$email = $pr->email;
			$expires_at = $pr->expires_at;

			$user->save();
			$pr->delete();

			// LOGGER
			activity('user')
				->byAnonymous()
				->on($user)
				->event('update')
				->withProperties([
					'first_name' => $user->first_name,
					'middle_name' => $user->middle_name,
					'last_name' => $user->last_name,
					'suffix' => $user->suffix,
					'is_avatar_link' => $user->is_avatar_link,
					'avatar' => $user->avatar,
					'email' => $user->email,
					'type_id' => $user->type
				])
				->log("Password for '{$user->email}' updated.");

			activity('password-reset')
				->byAnonymous()
				->event('delete')
				->withProperties([
					'email' => $email,
					'expires_at' => $expires_at
				])
				->log("Password for '{$user->email}' updated.");

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			return redirect()
				->back()
				->with('flash_error', 'Something went wrong, please try again later.');
		}

		return redirect()
			->route('login')
			->with('flash_success', "Succesfully updated password");
	}

	// REGISTER
	protected function register(Request $req) {
		return view("register");
	}

	protected function store(Request $req) {
	}
}
