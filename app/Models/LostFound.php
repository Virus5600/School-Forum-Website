<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Kyslik\ColumnSortable\Sortable;

use DB;
use Exception;
use Log;

class LostFound extends Model
{
    use HasFactory, SoftDeletes, Sortable;

	protected $fillable = [
		"status",
		"owner_name",
		"founder_name",
		"item_found",
		"item_image",
		"item_description",
		"place_found",
		"date_found",
		"time_found",
	];

	public $sortable = self::SORTABLE;

	// Constants
	const DEFAULT_POSTER = "default.png";
	const SORTABLE = [
		"created_at",
		"status",
		"owner_name",
		"founder_name",
		"item_found",
		"item_description",
		"place_found",
		"date_found",
		"time_found",
	];

	// Custom Functions
	/**
	 * Get the user that owns the lost item if it exists.
	 *
	 * @return \App\Models\User|null
	 */
	public function getOwner(): ?User
	{
		$user = User::whereConcat(["first_name", " ", "last_name"], "=", $this->owner_name)->first();

		if ($user) return $user;
		return null;
	}

	/**
	 * Get the user that found the lost item if it exists.
	 *
	 * @return \App\Models\User|null
	 */
	public function getFounder(): ?User
	{
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
	public function getImage($type="html", $useDefault=false, $additionalClasses=''): string
	{
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

	/**
	 * Fetches the instructions on how to handle lost and found items.
	 */
	public static function getInstructions(): string
	{
		return Settings::getValue("lost-found-instructions");
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
			"status" => ['required', 'string', 'in:lost,found'],
			"owner_name" => ['required', 'string'],
			"founder_name" => ['nullable', 'string'],
			"item_found" => ['required', 'string', 'max:512'],
			"item_image" => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
			"item_description" => ['nullable', 'string', 'max:1000'],
			"place_found" => ['required', 'string', 'max:512'],
			"date_found" => ['required', 'date'],
			"time_found" => ['required', 'date_format:H:i'],
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
			"status.required" => "Status is required.",
			"status.string" => "The status must be a string.",
			"status.in" => "The status must be either 'lost' or 'found'.",
			"owner_name.required" => "Please provide the name or any of the owner. ",
			"owner_name.string" => "Owner's name must be a string.",
			"founder_name.string" => "The name of the founder must be a string.",
			"item_found.required" => "Please provide the name of the item(s).",
			"item_found.string" => "Invalid item name.",
			"item_found.max" => "Cannot exceed 512 characters.",
			"item_image.image" => "Invalid image format. Please upload a valid image.",
			"item_image.mimes" => "Allowed image formats are: jpg, jpeg, png, webp.",
			"item_image.max" => "Image size cannot exceed 5MB.",
			"item_description.string" => "Please provide a valid description.",
			"item_description.max" => "Cannot exceed 1000 characters.",
			"place_found.required" => "Please provide the place where the item was found.",
			"place_found.string" => "Invalid place name.",
			"place_found.max" => "Cannot exceed 512 characters.",
			"date_found.required" => "The date the item was found is required.",
			"date_found.date" => "The date must be a valid date.",
			"time_found.required" => "The time the item was found is required.",
			"time_found.date_format" => "The time must be a valid time format.",
		];
	}
}
