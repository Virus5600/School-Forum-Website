<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
	////////////////
	// GUEST SIDE //
	////////////////
	protected function index() {
		$announcements = [
			\Str::random(1000)
		];

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
