<?php

namespace App\Http\Controllers;

use App\Services\GiphyAPI;
use Illuminate\Http\Request;

class GiphyController extends Controller
{
	public function trending(GiphyAPI $GiphyService)
	{
		$gifs = $GiphyService->trending();

		return view('components.gif-list', ['gifs' => $gifs->data]);
	}

	public function search(Request $request, GiphyAPI $GiphyService)
	{
		if ($request->query('q')) {
			$gifs = $GiphyService->search($request->query('q'));
		} else {
			$gifs = $GiphyService->trending();
		}

		return view('components.gif-list', ['gifs' => $gifs->data]);
	}
}
