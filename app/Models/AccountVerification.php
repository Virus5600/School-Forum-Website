<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class AccountVerification extends Model
{
    use HasFactory;

	protected $fillable = [
		'user_id',
		'token',
		'expires_at'
	];

	protected $hidden = [
		'token'
	];

	protected $casts = [
		'expires_at' => 'datetime'
	];

	// Relationships
	public function user() { return $this->belongsTo(User::class); }

	// Custom Functions
	/**
	 * Generates a new token for the user
	 */
	public function generateToken(): void
	{
		try {
			DB::beginTransaction();

			$this->token = substr(bin2hex(random_bytes(8)), 0, 16);

			while (AccountVerification::where('token', $this->token)->exists())
				$this->token = bin2hex(random_bytes(8));

			$this->expires_at = now()->addDay();
			$this->save();

			DB::commit();
		} catch (Exception $e) {
			DB::rollBack();
			Log::error($e);
		}
	}

	/**
	 * Checks if the token is valid
	 *
	 * @param string $token
	 * @return bool
	 */
	public function isValid(string $token): bool
	{
		return $this->token == $token && $this->expires_at > now();
	}

	// Static Functions
	/**
	 * Generates a new token for the user
	 *
	 * @param User|int $user
	 * @return AccountVerification
	 */
	public static function generateTokenForUser(User|int $user): AccountVerification
	{
		$token = substr(bin2hex(random_bytes(8)), 0, 16);

		while (AccountVerification::where('token', $token)->exists())
			$token = substr(bin2hex(random_bytes(8)), 0, 16);

		$verification = AccountVerification::create([
			'user_id' => is_int($user) ? $user : $user->id,
			'token' => $token,
			'expires_at' => now()->addDay()
		]);

		return $verification;
	}
}
