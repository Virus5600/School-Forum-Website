<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Exception;
use Log;

class Settings extends Model
{
	protected $fillable = [
		'name',
		'value',
		'default_value',
		'is_file',
	];

	// CUSTOM FUNCTIONS
	/**
	 * Get all settings from the database and return them as an array when `$key` is
	 * `null`. If `$key` is not `null`, return the setting with the specified key.
	 *
	 * @param string $key The key of the setting to get. Optional parameter.
	 *
	 * @return array|Settings The settings from the database as an array or the setting
	 */
	public static function getInstance($key = null) {
		if ($key == null)
			return Settings::get();
		return Settings::where('name', '=', $key)->first();
	}

	/**
	 * Get the value of the setting with the specified key from the database and
	 * return it as a JSON string.
	 *
	 * @param string $key The key of the setting to get. Required parameter.
	 *
	 * @return string The value of the setting with the specified key as a JSON string.
	 */
	public static function valueToJSON($key) {
		$setting = Settings::where('name', '=', $key)->first();

		if ($setting == null)
			return null;

		$toRet = array();
		foreach (preg_split("/\,\s*/", $setting->value) as $v)
			array_push($toRet, array("value" => trim($v)));

		return json_encode($toRet);
	}

	/**
	 * Get the value of the setting with the specified key from the database and
	 * return it as a string.
	 *
	 * @param string $key The key of the setting to get. Required parameter.
	 *
	 * @return string The value of the setting with the specified key as a string.
	 */
	public static function getValue($key) {
		$setting = Settings::getInstance($key);

		if ($setting == null)
			return null;
		return $setting->value ?? $setting->default_value;
	}

	/**
	 * Get the value of the setting with the specified key from the database and
	 * return it as a string. If the setting is a file, return the file path.
	 *
	 * @param string $key The key of the setting to get. Required parameter.
	 *
	 * @return string The value of the setting with the specified key as a string.
	 */
	public static function getFile($key) {
		$setting = Settings::getInstance($key);

		if ($setting->is_file)
			return asset('uploads/settings/' . $setting->value);
		return $setting->value;
	}

	/**
	 * Get the image in the specified format.
	 *
	 * @param string $type The format of the image to be returned. Allowed values are: html, url, filename. By default, it is set to `html`.
	 * @param bool $useDefault Whether to use the default image if the image is not found or you feel like it. By default, it is set to `false`.
	 *
	 * @return string The value of the setting with the specified key as a string.
	 *
	 * @throws Exception If the setting with the specified key is not a file.
	 */
	public function getImage($useDefault=false, $getFull=true) {
		if ($this->is_file == false)
			throw new Exception("The setting with the key '{$this->name}' is not a file.");

		$file = $this->value;
		if ($useDefault)
			$file = 'default.png';

		if ($getFull)
			return asset('uploads/settings/' . $file);
		return $file;
	}

	// STATIC FUNCTIONS
	public static function showRoute() {
		return route('admin.settings.index');
	}
}
