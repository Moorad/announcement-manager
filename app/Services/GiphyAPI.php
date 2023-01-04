<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GiphyAPI
{
	private $api_key;

	public function __construct()
	{
		$this->api_key = env('GIPHY_API_KEY');
	}

	public function trending()
	{
		$limit = 15;
		$rating = 'g'; // Age rating: G
		$response = Http::get('https://api.giphy.com/v1/gifs/trending?api_key=' . $this->api_key . '&limit=' . $limit . '&rating=' . $rating);

		return json_decode($response->body());
	}

	public function search(string $query)
	{
		$limit = 15;
		$offset = 0;
		$rating = 'g'; // Age rating: G
		$response = Http::get('https://api.giphy.com/v1/gifs/search?api_key=' . $this->api_key . '&q=' . $query . '&limit=' . $limit . '&offset=' . $offset . '&rating=' . $rating . '&lang=en');

		return json_decode($response->body());
	}

	public function saveGif(string $url)
	{
		$image = file_get_contents($url);

		$hashed_name = md5($image) . '.gif';
		Storage::put('public/announcement_images/' . $hashed_name, $image);

		return $hashed_name;
	}
}
