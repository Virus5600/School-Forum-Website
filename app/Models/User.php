<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;

use Laravel\Sanctum\HasApiTokens;

use DB;
use Exception;
use Log;

class User extends Authenticatable
{
	use Notifiable, HasFactory, SoftDeletes, HasApiTokens;

	protected $fillable = [
		'username',
		'first_name',
		'middle_name',
		'last_name',
		'suffix',
		'email',
		'gender',
		'avatar',
		'user_type_id',
		'login_attempts',
		'is_verified',
		'locked',
		'locked_by',
		'password',
		'last_auth',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime',
		'last_auth' => 'datetime',
	];

    protected $with = [
		'userType.permissions',
		'userPerm'
	];

    // Relationships
	public function accountVerification() { return $this->hasOne('App\Models\AccountVerification'); }
	public function announcements() { return $this->hasMany('App\Models\Announcement', 'author_id', 'id'); }
	public function discussions() { return $this->hasMany('App\Models\Discussion', 'posted_by'); }
	protected function passwordReset() { return $this->belongsTo('App\Models\PasswordReset'); }
	public function userType() { return $this->belongsTo('App\Models\UserType'); }
	public function userPerm() { return $this->hasMany('App\Models\UserPermission'); }
	public function userPerms() { return $this->belongsToMany('App\Models\Permission', 'user_permissions'); }

    // Custom Functions
	public function permissions() {
		if ($this->userPerm->count() <= 0)
			$perms = $this->userType->permissions;

		return $perms ?? $this->userPerm;
	}

	public function isUsingTypePermissions() {
		return $this->userPerm->count() <= 0;
	}

	public function hasPermission(...$permissions) {
		$matches = 0;
		$usingTypePermissions = $this->isUsingTypePermissions();
		$perms = $this->permissions();

		if (is_array($permissions[0]))
			$permissions = $permissions[0];

		foreach ($perms as $p) {
			if ($usingTypePermissions) {
				if (in_array($p->slug, $permissions)) {
					$matches += 1;
				}
			}
			else {
				if (in_array($p->permission->slug, $permissions)) {
					$matches += 1;
				}
			}
		}

		return $matches == count($permissions);
	}

	public function hasSomePermission(...$permissions) {
		$usingTypePermissions = $this->isUsingTypePermissions();
		$perms = $this->permissions();

		if (is_array($permissions[0]))
			$permissions = $permissions[0];

		foreach ($perms as $p) {
			if ($usingTypePermissions) {
				if (in_array($p->slug, $permissions)) {
					return true;
				}
			}
			else {
				if (in_array($p->permission->slug, $permissions)) {
					return true;
				}
			}
		}
	}

	/**
	 * Get the image in the specified format.
	 *
	 * @param string $type The format of the image to be returned. Allowed values are: html, url, filename. By default, it is set to `html`.
	 * @param bool $useDefault Whether to use the default image if the image is not found or you feel like it. By default, it is set to `false`.
	 * @param string $additionalClasses Additional classes to be added to the image tag. Purely optional.
	 *
	 * @return string The value of the setting with the specified key as a string.
	 *
	 * @throws Exception if `$type` is not one of the allowed values.
	 */
	public function getAvatar($type="html", $useDefault=false, $additionalClasses='') {
		if (in_array($type, ["html", "url", "filename"]) === false)
			throw new Exception("Invalid parameter value for \"\$type\": {$type}\nOnly allowed values are: html, url, filename.");

		$file = $this->avatar;
		if ($useDefault)
			$file = 'default.png';

		switch ($type) {
			case "html":
				$caption = $this->caption ?? $this->avatar;
				return "<img src=\"" . asset("/uploads/users/{$this->avatar}") . "\" class=\"mx-auto {$additionalClasses}\" alt=\"{$caption}\">";

			case "url":
				return asset("/uploads/users/{$file}");

			case "filename":
				return $file;
		}
	}

	public function getName($include_middle = false) {
		return $this->first_name . ($include_middle ? (' ' . $this->middle_name . ' ') : ' ') . $this->last_name;
	}

	// STATIC FUNCTIONS
	public static function getIP() {
		$ip = request()->ip();

		if (!empty($_SERVER['HTTP_CLIENT_IP']))
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];

		return $ip;
	}

	public static function showRoute($id) {
		$user = User::withTrashed()->find($id);

		if ($user == null)
			return "javascript:SwalFlash.info(`Cannot Find Item`, `Item may already be deleted or an anonymous user.`, true, false, `center`, false);";
		return route('admin.users.show', [$id]);
	}

	// VALIDATOR RELATED FUNCTIONS
	/**
	 * Get the validation rules for the specified fields. If no fields are specified,
	 * all fields will be returned.
	 *
	 * @param string $fields The fields to get the validation rules for. If not specified, all fields will be returned.
	 *
	 * @return array The validation rules for the specified fields.
	 */
	public static function getValidationRules(...$fields): array
	{
		$rules = [
			'avatar' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'nullable'],
			'first_name' => ['required', 'string'],
			'middle_name' => ['string', 'nullable'],
			'last_name' => ['required', 'string'],
			'suffix' => ['string', 'max:50', 'nullable'],
			'gender' => ['required', 'string', Rule::in(['male', 'female', 'others'])],
			'username' => ['required', 'unique:users,username', 'string'],
			'email' => ['required', 'unique:users,email', 'email'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		];

		if ($fields == null || count($fields) <= 0)
			return $rules;

		$toRet = [];
		foreach ($fields as $field) {
			if (array_key_exists($field, $rules))
				$toRet[$field] = $rules[$field];
		}

		return $toRet;
	}

	/**
	 * Get the validation messages for all the fields.
	 *
	 * @return array The validation messages for all the fields.
	 */
	public static function getValidationMessages(): array
	{
		return [
			'avatar.image' => 'Avatar must be an image',
			'avatar.mimes' => 'Avatar must be a file of type: jpg, jpeg, png, webp',
			'avatar.max' => 'Avatar must not exceed 5MB',
			'first_name.required' => 'First name is required',
			'first_name.string' => 'First name must be a string',
			'middle_name.string' => 'Middle name must be a string',
			'last_name.required' => 'Last name is required',
			'last_name.string' => 'Last name must be a string',
			'suffix.string' => 'Suffix must be a string',
			'suffix.max' => 'Suffix must not exceed 50 characters',
			'gender.required' => 'Gender is required',
			'gender.string' => 'Please select a valid choice',
			'gender.in' => 'Please select a valid choice',
			'username.required' => 'Username is required',
			'username.unique' => 'Username is already taken',
			'username.string' => 'Username must be a string',
			'email.required' => 'Email is required',
			'email.unique' => 'Email is already taken',
			'email.email' => 'Email must be a valid email address',
			'password.required' => 'Password is required',
			'password.string' => 'Password must be a string',
			'password.min' => 'Password must be at least 8 characters long',
			'password.confirmed' => 'Passwords do not match',
		];
	}
}
