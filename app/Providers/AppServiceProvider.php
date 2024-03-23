<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		if (in_array(strtolower(config('app.env')), ['local', 'testing'])) {
			// New Faker methods
			$this->implementFakeMethods();
		}
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		// Use Bootstrap as default paginator styling.
		Paginator::useBootstrapFive();
	}

	private function implementFakeMethods(): void
	{
		$classes = [
			\App\Providers\Faker\ArticleProvider::class
		];

		// For when using `$this->faker` in factories
		$this->app->singleton(\Faker\Generator::class, function() use ($classes) {
			$faker = \Faker\Factory::create(config("app.faker_locale", "en_PH"));

			foreach ($classes as $class)
				$faker->addProvider(new $class($faker));

				return $faker;
		});

		// For when using `fake()` in factories
		$this->app->bind(
			\Faker\Generator::class . ":" . config("app.faker_locale"),
			\Faker\Generator::class
		);
	}
}
