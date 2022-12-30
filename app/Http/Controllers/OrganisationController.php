<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganisationController extends Controller
{
	public function index()
	{
		$organisations = DB::table('organisations')->join('users', 'organisations.admin_id', '=', 'users.id')->select('organisations.*', 'users.name as admin_name')->get();

		return view('organisations.index', ['organisations' => $organisations, 'name' => Auth::user()->name, 'role' => Auth::user()->role]);
	}

	public function create(Request $request)
	{

		if ($request->attributes->get('has_org') == True) {
			return redirect()->to(route('organisations.users'));
		}

		return view('organisations.create', ['name' => Auth::user()->name, 'role' => Auth::user()->role]);
	}

	public function store(Request $request)
	{
		//Do validation
		$creator_id = Auth::user()->id;

		$org = new Organisation;
		$org->name = $request->org_name;
		$org->admin_id = $creator_id;
		$org->save();

		return redirect()->to(route('organisation.users'));
	}

	public function users(Request $request)
	{
		$users = User::all();

		// dd($users);
		return view('organisations.users', ['name' => Auth::user()->name, 'role' => Auth::user()->role, 'org_data' => $request->attributes->get('org_data'), 'users' => $users]);
	}
}
