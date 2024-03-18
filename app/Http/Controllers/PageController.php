<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Announcement;

class PageController extends Controller
{
	////////////////
	// GUEST SIDE //
	////////////////
	protected function index() {
		$announcements = Announcement::factory()
			->count(rand(0, 10))
			->published()
			->make();

		return view('index', [
			'announcements' => $announcements,
		]);
	}

	////////////////
	// ADMIN SIDE //
	////////////////
	// protected function dashboard(Request $req) {
	// 	return view('admin.dashboard');
	// }
}
