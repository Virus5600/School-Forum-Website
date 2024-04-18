<?php

namespace App\Enums;

use App\Traits\BaseEnumTraits;

enum VoteType: string {
	use BaseEnumTraits;

	case UPVOTE = "upvote";
	case DOWNVOTE = "downvote";
}
