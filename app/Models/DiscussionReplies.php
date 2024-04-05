<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionReplies extends Model
{
    use HasFactory;

	protected $fillable = [
		'discussion_id',
		'replied_to',
		'replied_by',
		'content'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	protected $with = [
		'repliedBy'
	];

	// Relationships
	public function discussion() { return $this->belongsTo("App\Models\Discussion", 'discussion_id'); }
	public function repliedTo() { return $this->belongsTo("App\Models\DiscussionReplies", 'replied_to'); }
	public function repliedBy() { return $this->belongsTo("App\Models\User", 'replied_by'); }
	public function replies() { return $this->hasMany("App\Models\DiscussionReplies", 'replied_to');}
}
