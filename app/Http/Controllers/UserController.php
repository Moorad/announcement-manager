<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOrganisation;
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

	public function update_member(Request $request)
	{
		$user_id = $request->user_id;
		$org_id = $request->org_id;

		$memberExists = UserOrganisation::where('user_id', $user_id)->where('org_id', $org_id);

		if ($memberExists->first() == null) {
			$userOrg = new UserOrganisation;
			$userOrg->user_id = $user_id;
			$userOrg->org_id = $org_id;
			$userOrg->save();

			return 'Member ID ' . $user_id . ' has been added to the organisation';
		} else {
			$memberExists->delete();
			return 'Member ID ' . $user_id . ' has been removed from the organisation';
		}
	}
}
