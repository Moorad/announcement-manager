<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganisationController extends Controller
{
	public function index()
	{
		$organisations = Organisation::all();

		return view('organisations.index', ['organisations' => $organisations, 'name' => Auth::user()->name, 'role' => Auth::user()->role]);
	}

	public function create()
	{
		$users = User::all();
		return view('organisations.create', ['users' => $users, 'name' => Auth::user()->name, 'role' => Auth::user()->role]);
	}
}
