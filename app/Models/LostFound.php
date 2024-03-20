<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use DB;
use Exception;
use Log;

class LostFound extends Model
{
    use HasFactory, SoftDeletes;

	protected $fillable = [
		"owner_name",
		"founder_name",
		"item_found",
		"item_image",
		"place_found",
		"date_found",
		"time_found",
	];

	// Constants
	const DEFAULT_POSTER = "default.png";

	// Custom Functions
	/**
	 * Get the user that owns the lost item if it exists.
	 *
	 * @return \App\Models\User|null
	 */
	public function getOwner() {
		$user = User::whereConcat(["first_name", " ", "last_name"], "=", $this->owner_name)->first();

		if ($user) return $user;
		return null;
	}

	/**
	 * Get the user that found the lost item if it exists.
	 *
	 * @return \App\Models\User|null
	 */
	public function getFounder() {
		$user = User::whereConcat(["first_name", " ", "last_name"], "=", $this->founder_name)->first();

		if ($user) return $user;
		return null;
	}

	/**
	 * Get the poster image in the specified format.
	 *
	 * @param string $type The format of the image to be returned. Allowed values are: html, url, filename. By default, it is set to `html`.
	 * @param bool $useDefault Whether to use the default image if the image is not found or you feel like it. By default, it is set to `false`.
	 * @param string $additionalClasses Additional classes to be added to the image tag. Purely optional.
	 *
	 * @return string The value of the setting with the specified key as a string.
	 *
	 * @throws Exception if `$type` is not one of the allowed values.
	 */
	public function getImage($type="html", $useDefault=false, $additionalClasses='') {
		$type = strtolower($type);
		if (in_array($type, ["html", "url", "filename"]) === false)
			throw new Exception("Invalid parameter value for \"\$type\": {$type}\nOnly allowed values are: html, url, filename.");

		$file = $this->poster ?? self::DEFAULT_POSTER;
		if ($useDefault)
			$file = self::DEFAULT_POSTER;

		switch ($type) {
			case "html":
				$caption = $this->caption ?? $this->filename;
				return "<img src=\"" . asset("/uploads/lost-and-found/{$this->filename}") . "\" class=\"mx-auto {$additionalClasses}\" alt=\"{$caption}\">";

			case "url":
				return asset("/uploads/lost-and-found/{$file}");

			case "filename":
				return $file;
		}
	}
}
