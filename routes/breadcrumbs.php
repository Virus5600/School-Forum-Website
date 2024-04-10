<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;

use App\Models\Discussion;
use App\Models\LostFound;

// HOME
Breadcrumbs::for(
	"home",
	fn(Trail $trail) => $trail->push("Home", route("home"))
);

// DISCUSSIONS
Breadcrumbs::for(
	"discussions.index",
	fn(Trail $trail) => $trail->push("Discussions", route("discussions.index"))
);

// DISCUSSIONS > CREATE
Breadcrumbs::for(
	"discussions.create",
	fn(Trail $trail) => $trail->parent("discussions.index")
		->push("Create Discussion", route("discussions.create"))
);

// DISCUSSIONS > CATEGORY
Breadcrumbs::for(
	"discussions.categories.index",
	fn(Trail $trail) => $trail->parent("discussions.index")
		->push("Categories", route("discussions.categories.index"))
);

// DISCUSSIONS > CATEGORY > SHOW (CATEGORY)
Breadcrumbs::for(
	"discussions.categories.show",
	fn(Trail $trail, string $name) => $trail->parent("discussions.categories.index")
		->push(Str::limit(ucwords($name), 25), route("discussions.categories.show", $name))
);

// DISCUSSIONS > CATEGORY > SHOW (DISCUSSION)
Breadcrumbs::for(
	"discussions.show",
	function (Trail $trail, string $category, string $slug) {
		$title = Discussion::select("title")
			->where("slug", $slug)
			->firstOrFail()
			->title;

		$trail->parent("discussions.categories.show", $category)
			->push(Str::limit($title, 10), route("discussions.show", [$category, $slug]));
	}
);

// DISCUSSIONS > CATEGORY > SHOW (DISCUSSION) > EDIT
Breadcrumbs::for(
	"discussions.edit",
	fn(Trail $trail, string $category, string $slug) => $trail->parent("discussions.show", $category, $slug)
		->push("Edit Discussion", route("discussions.edit", [$category, $slug]))
);

// DISCUSSIONS > CATEGORY > SHOW (DISCUSSION) > COMMENT (EDIT)
Breadcrumbs::for(
	"discussions.comments.edit",
	fn(Trail $trail, string $category, string $slug, int $id) => $trail
		->parent("discussions.show", $category, $slug)
		->push("Edit Comment", route("discussions.comments.edit", [$category, $slug, $id]))
);

// ANNOUNCEMENTS
Breadcrumbs::for(
	"announcements.index",
	fn(Trail $trail) => $trail->push("Announcements", route("announcements.index"))
);

// ANNOUNCEMENTS > SHOW
Breadcrumbs::for(
	"announcements.show",
	fn(Trail $trail, string $slug) => $trail
		->parent("announcements.index")
		->push(Str::limit($slug, 10), route("announcements.show", $slug))
);

// LOST AND FOUND
Breadcrumbs::for(
	"lost-and-found.index",
	fn(Trail $trail) => $trail->push("Lost and Found", route("lost-and-found.index"))
);

// LOST AND FOUND > SHOW
Breadcrumbs::for(
	"lost-and-found.show",
	function(Trail $trail, string $item) {
		$item = LostFound::find($item);

		$trail->parent("lost-and-found.index")
			->push(Str::limit($item->item_found, 10), route("lost-and-found.show", $item->id));
	}
);
