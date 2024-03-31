<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\LostFound;

class PageController extends Controller
{
	////////////////
	// GUEST SIDE //
	////////////////
	protected function index() {
		$announcements = Announcement::orderBy("created_at", "desc")
			->limit(4)
			->get();

		$lostItems = LostFound::where("status", "lost")
			->orderBy("created_at", "desc")
			->limit(4)
			->get();

		return view("index", [
			"announcements" => $announcements,
			"lostItems" => $lostItems
		]);
	}

	////////////////
	// ADMIN SIDE //
	////////////////
	protected function dashboard(Request $req) {
		return view("authenticated.admin.dashboard");
	}
}
