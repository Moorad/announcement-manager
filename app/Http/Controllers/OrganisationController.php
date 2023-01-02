<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\User;
use App\Models\UserOrganisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganisationController extends Controller
{
	public function __construct()
	{
		$this->middleware('owner_of_org', ['except' => ['index', 'store', 'create']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$organisations = Organisation::join('users', 'organisations.admin_id', '=', 'users.id')
			->select('organisations.*', 'users.name as admin_name')
			->get();

		return view('organisations.index', ['organisations' => $organisations, 'user' => Auth::user()]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		if ($request->attributes->get('owns_org')) {
			return redirect()->to(route('organisations.users'));
		}

		return view('organisations.create', ['user' => Auth::user()]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//Do validation

		$org = new Organisation;
		$org->name = $request->org_name;
		$org->admin_id = Auth::user()->id;
		$org->save();

		return redirect()->to(route('organisations.show', $org->id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, Request $request)
	{
		$inner = function ($query) use ($id) {
			$query->where('org_id',  $id)
				->orWhere('org_id', null);
		};

		$users = User::leftJoin('user_organisations', 'user_organisations.user_id', '=', 'users.id')
			->select('users.*', 'user_organisations.org_id')
			->where($inner)
			->whereNot('users.role', 'admin')->get();

		$memberCount = count(UserOrganisation::where('org_id', $id)->get());

		return view('organisations.show', ['user' => Auth::user(), 'org_data' => $request->attributes->get('org_data'), 'users' => $users, 'member_count' => $memberCount]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
