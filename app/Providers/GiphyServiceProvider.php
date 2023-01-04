<?php

namespace App\Providers;

use App\Services\GiphyAPI;
use Illuminate\Support\ServiceProvider;

class GiphyServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(GiphyAPI::class, function ($app) {
			return new GiphyAPI();
		});
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}
}
