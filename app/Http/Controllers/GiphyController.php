<?php

namespace App\Http\Controllers;

use App\Services\GiphyAPI;
use Illuminate\Http\Request;

class GiphyController extends Controller
{
	public function trending()
	{
		$gifs = app()->make(GiphyAPI::class)->trending();

		return view('components.gif-list', ['gifs' => $gifs->data]);
	}

	public function search(Request $request)
	{
		if ($request->query('q')) {
			$gifs = app()->make(GiphyAPI::class)->search($request->query('q'));
		} else {
			$gifs = app()->make(GiphyAPI::class)->trending();
		}

		return view('components.gif-list', ['gifs' => $gifs->data]);
	}
}
