<?php

namespace App\Providers\Faker;

use Faker\Provider\Base;

class ArticleProvider extends Base
{
	public function articleTitle($wordCount = 5): string
	{
		$sentence = $this->generator->sentence($wordCount);
		return substr($sentence, 0, strlen($sentence) - 1);
	}
}
