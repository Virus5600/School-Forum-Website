<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'category_id',
		'title',
		'content',
		'posted_by'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime',
	];

	protected $with = [
		'category',
	];

	// Relationships
	public function category() { return $this->belongsTo('App\Models\DiscussionCategory', 'category_id'); }
	public function postedBy() { return $this->belongsTo('App\Models\User', 'posted_by'); }

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
			'category' => ['required', 'string', 'max:100'],
			'title' => ['required', 'string', 'max:100'],
			'content' => ['required', 'string', 'max:8192'],
			'posted_by' => ['required', 'integer', 'exists:users,id'],
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
			'category.required' => 'Please enter a category',
			'category.string' => 'Invalid category',
			'category.max' => 'Category must not exceed 100 characters',
			'title.required' => 'Please enter a title',
			'title.string' => 'Invalid title',
			'title.max' => 'Title must not exceed 100 characters',
			'content.required' => 'Content is required',
			'content.string' => 'Invalid content',
			'content.max' => 'Content is too long',
			'posted_by.required' => 'Please specify the user who posted this',
			'posted_by.integer' => 'Invalid User',
			'posted_by.exists' => 'User does not exist',
		];
	}
}
