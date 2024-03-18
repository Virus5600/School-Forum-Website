<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use Exception;
use Log;

class User extends Authenticatable
{
	use Notifiable, HasFactory, SoftDeletes;

	// Implement Mailer (https://laracasts.com/discuss/channels/laravel/php-mailer)
	// (https://www.webappfix.com/post/how-to-send-mail-using-phpmailer-in-laravel.html)

	protected $fillable = [
		'username',
		'first_name',
		'middle_name',
		'last_name',
		'suffix',
		'email',
		'avatar',
		'user_type_id',
		'login_attempts',
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

    // protected $with = [
	// 	'userType.permissions',
	// 	'userPerm'
	// ];

    // Relationships
	public function userType() { return $this->belongsTo('App\Models\UserType'); }
	protected function passwordReset() { return $this->belongsTo('App\Models\PasswordReset'); }
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

		$file = $this->filename;
		if ($useDefault)
			$file = 'default.png';

		switch ($type) {
			case "html":
				$caption = $this->caption ?? $this->filename;
				return "<img src=\"" . asset("/uploads/users/{$this->filename}") . "\" class=\"mx-auto {$additionalClasses}\" alt=\"{$caption}\">";

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
}
