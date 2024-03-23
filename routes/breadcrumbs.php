<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;

use App\Models\LostFound;

// HOME
Breadcrumbs::for(
	"home",
	fn(Trail $trail) => $trail->push("Home", route("home"))
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
