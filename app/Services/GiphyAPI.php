<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GiphyAPI
{
	private $api_key;
	private $limit;
	private $rating;

	public function __construct($api_key, $limit, $age_rating)
	{
		$this->api_key = $api_key;
		$this->limit = $limit;
		$this->rating = $age_rating;
	}

	public function trending()
	{

		$response = Http::get('https://api.giphy.com/v1/gifs/trending?api_key=' . $this->api_key . '&limit=' . $this->limit . '&rating=' . $this->rating);

		return json_decode($response->body());
	}

	public function search(string $query)
	{
		$response = Http::get('https://api.giphy.com/v1/gifs/search?api_key=' . $this->api_key . '&q=' . $query . '&limit=' . $this->limit . '&offset=0&rating=' . $this->rating . '&lang=en');

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
