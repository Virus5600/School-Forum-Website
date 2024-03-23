<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;

// HOME
Breadcrumbs::for(
	"home",
	fn(Trail $trail) => $trail->push("Home", route("home"))
);

// ANNOUNCEMENTS
Breadcrumbs::for(
	"announcements",
	fn(Trail $trail) => $trail->push("Announcements", route("announcements"))
);

// ANNOUNCEMENTS > SHOW
Breadcrumbs::for(
	"announcements.show",
	fn(Trail $trail, $slug) => $trail
		->parent("announcements")
		->push(Str::limit($slug, 10), route("announcements.show", $slug))
);
