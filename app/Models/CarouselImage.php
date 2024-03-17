<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use DB;
use Exception;
use Log;

class CarouselImage extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'filename',
		'caption',
		'link',
		'active',
		'created_by',
		'updated_by',
		'deleted_by',
	];

	protected $casts = [
		'active' => 'boolean',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime',
	];

	// Custom Functions
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
	public function getImage($type="html", $useDefault=false, $additionalClasses='') {
		if (in_array($type, ["html", "url", "filename"]) === false)
			throw new Exception("Invalid parameter value for \"\$type\": {$type}\nOnly allowed values are: html, url, filename.");

		$file = $this->filename;
		if ($useDefault)
			$file = 'default.png';

		switch ($type) {
			case "html":
				$caption = $this->caption ?? $this->filename;
				return "<img src=\"" . asset("/uploads/carousel/{$this->filename}") . "\" class=\"mx-auto {$additionalClasses}\" alt=\"{$caption}\">";

			case "url":
				return asset("/uploads/carousel/{$file}");

			case "filename":
				return $file;
		}
	}
}
