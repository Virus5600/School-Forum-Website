<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Kyslik\ColumnSortable\Sortable;

use DB;
use Exception;
use Log;

class Reportable extends Model
{
    use HasFactory, Sortable;

	protected $fillable = [
		'reported_by',
		'reportable_id',
		'reportable_type',
		'status',
		'action_taken',
		'action_description',
		'reason'
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	public $sortable = self::SORTABLE;

	// Constants
	const SORTABLE = [
		'reportable_type',
		'reportedBy.username',
		'reason',
		'status',
		'action_taken',
		'created_at',
	];

	// Boot
	protected static function booted(): void
	{
		static::created(function(Reportable $reportable) {
			try {
				DB::beginTransaction();
				$reportable->uuid = Str::uuid();
				$reportable->save();
				DB::commit();
			} catch (Exception $e) {
				Log::error($e);
				DB::rollback();
			}
		});
	}

	// Relationships
	public function reportable() { return $this->morphTo(); }
	public function reportedBy() { return $this->belongsTo('App\Models\User', 'reported_by'); }
}
