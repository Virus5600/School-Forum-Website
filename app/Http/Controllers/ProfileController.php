<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ProfileController extends Controller
{
    public function index() {
		$activities = Activity::where('subject_type', '=', 'App\Models\User')
			->where('subject_id', '=', auth()->user()->id)
			->orderBy('created_at', 'desc')
			->get()
			->groupBy(function($date) {
				return $date->created_at->format('M d, Y (D)');
			});

		return view('authenticated.profile.index', [
			'activities' => $activities
		]);
	}
}
