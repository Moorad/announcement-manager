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
		$this->app->singleton(GiphyAPI::class, function ($app) {
			$api_key = env('GIPHY_API_KEY');
			$limit = 15; // Max number of gifs
			$age_rating = 'g';
			return new GiphyAPI($api_key, $limit, $age_rating);
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
