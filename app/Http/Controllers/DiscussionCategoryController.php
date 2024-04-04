<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscussionCategoryController extends Controller
{
    public function index(Request $req) {
		// TODO: Implement
		return view('discussions.category.index');
	}
}
