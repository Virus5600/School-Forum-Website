<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use DB;
use Exception;
use Log;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

	protected $fillable = [
		"poster",
		"title",
		"slug",
		"summary",
		"content",
		"is_draft",
		"published_at",
		"author_id",
	];

	protected $casts = [
		"created_at" => "datetime",
		"updated_at" => "datetime",
		"deleted_at" => "datetime",
	];

	// Relationship Functions
	public function author() { return $this->belongsTo(User::class, "author_id", "id"); }

	// Custom Functions
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
	public function getPoster($type="html", $useDefault=false, $additionalClasses='') {
		if (in_array($type, ["html", "url", "filename"]) === false)
			throw new Exception("Invalid parameter value for \"\$type\": {$type}\nOnly allowed values are: html, url, filename.");

		$file = $this->poster ?? 'default.png';
		if ($useDefault)
			$file = 'default.png';

		switch ($type) {
			case "html":
				$caption = $this->caption ?? $this->filename;
				return "<img src=\"" . asset("/uploads/announcements/{$this->filename}") . "\" class=\"mx-auto {$additionalClasses}\" alt=\"{$caption}\">";

			case "url":
				return asset("/uploads/announcements/{$file}");

			case "filename":
				return $file;
		}
	}

	public function getAuthorName($username = true) {
		$author = $this->author;
		if ($author === null)
			return "Unknown";

		return $username ? $author->getName() : $author->username;
	}

	// STATIC FUNCTIONS
	public static function showRoute($id) {
		$announcement = Announcement::withTrashed()->find($id);

		if ($announcement == null)
			return "javascript:SwalFlash.info(`Cannot Find Item`, `Item may already be deleted or an anonymous user.`, true, false, `center`, false);";
		return route('admin.announcements.show', [$id]);
	}
}
