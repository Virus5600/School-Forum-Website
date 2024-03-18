<?php

namespace App\Providers;

use Faker\Generator;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
		// Use Bootstrap as default paginator styling.
        Paginator::useBootstrap();

		// New Faker methods
		$this->implementFakeMethods();
    }

	private function implementFakeMethods(): void
	{
		$faker = $this->app->make(Generator::class);

		$classes = [
			\App\Providers\Faker\ArticleProvider::class
		];

		foreach ($classes as $class)
			$faker->addProvider(new $class($faker));
	}
}
