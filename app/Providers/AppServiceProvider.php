<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		// New Faker methods
		$this->implementFakeMethods();
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		// Use Bootstrap as default paginator styling.
		Paginator::useBootstrap();
	}

	private function implementFakeMethods(): void
	{
		$classes = [
			\App\Providers\Faker\ArticleProvider::class
		];

		// For when using `$this->faker` in factories
		$this->app->singleton(Generator::class, function() use ($classes) {
			$faker = Factory::create();

			foreach ($classes as $class)
				$faker->addProvider(new $class($faker));

				return $faker;
		});

		// For when using `fake()` in factories
		$this->app->bind(
			Generator::class . ":" . config("app.faker_locale"),
			Generator::class
		);
	}
}
