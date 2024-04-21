<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportable extends Model
{
    use HasFactory;

	protected $fillable = [
		'reportable_id',
		'reportable_type',
		'reported_by',
		'reason'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relationships
	public function reportable() { return $this->morphTo(); }
	public function user() { return $this->belongsTo('App\Models\User', 'reported_by'); }
}
