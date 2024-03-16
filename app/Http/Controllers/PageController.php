<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
	////////////////
	// GUEST SIDE //
	////////////////
	protected function index() {
		return view('index');
	}

	////////////////
	// ADMIN SIDE //
	////////////////
	// protected function dashboard(Request $req) {
	// 	return view('admin.dashboard');
	// }
}
