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
		$announcements = Announcement::orderBy("created_at", "desc")
			->limit(4)
			->get();

		$lostItems = [];

		return view("index", [
			"announcements" => $announcements,
			"lostItems" => $lostItems
		]);
	}

	////////////////
	// ADMIN SIDE //
	////////////////
	// protected function dashboard(Request $req) {
	// 	return view("admin.dashboard");
	// }
}
