<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LostFound;

class LostFoundController extends Controller
{
    public function index() {
		$lostItems = LostFound::whereNull("owner_name")
			->latest()
			->paginate(9)
			->fragment("content");

		return view('lost_found.index', [
			"lostItems" => $lostItems,
			"instructions" => LostFound::getInstructions(),
		]);
	}

	public function show(Request $req, $id) {
		$item = LostFound::findOrFail($id);

		return view('lost_found.show', [
			"item" => $item,
			"instructions" => LostFound::getInstructions(),
		]);
	}
}
