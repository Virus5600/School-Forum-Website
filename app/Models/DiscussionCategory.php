<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionCategory extends Model
{
    use HasFactory;

	protected $fillable = [
		'name'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];

	// Relationships
	public function discussions() { return $this->hasMany("App\Models\Discussion", "category_id"); }
}
