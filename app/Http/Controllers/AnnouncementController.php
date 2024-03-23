<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index() {
		$announcements = Announcement::where("is_draft", "=", 0)
			->latest()
			->paginate(10)
			->fragment("content");

		return view('announcements.index', [
			"announcements" => $announcements,
		]);
	}

	public function show(Request $req, $slug)
	{
		$announcement = Announcement::where("slug", "=", $slug)
			->where("is_draft", "=", 0)
			->firstOrFail();

		$otherAnnouncements = Announcement::where("slug", "!=", $slug)
			->where("is_draft", "=", 0)
			->latest()
			->limit(3)
			->get();

		return view('announcements.show', [
			"announcement" => $announcement,
			"otherAnnouncements" => $otherAnnouncements,
		]);
	}
}
