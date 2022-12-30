<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
	//
	public function search(Request $request)
	{

		$query = $request->search;
		if ($query == null) {
			$users = User::all();
		} else {
			$users = User::where('name', 'LIKE', '%' . $query . '%')->get();
		}


		return view('layouts.member_table', ['users' => $users]);
	}
}
