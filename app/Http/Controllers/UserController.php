<?php

namespace App\Http\Controllers;

use App\Models\UserOrganisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	//
	public function search(Request $request)
	{
		$term = $request->search;
		$users = DB::table('users')->leftJoin('user_organisations', 'user_organisations.user_id', '=', 'users.id')->select('users.*', 'user_organisations.org_id')->where(function ($query) {
			global $request;
			$query->where('org_id', $request->org_id)->orWhere('org_id', null);
		})->whereNot('users.role', 'admin');

		if ($term == null) {
			$users = $users->get();
		} else {
			$users = $users->where('name', 'LIKE', '%' . $term . '%')->get();
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

	public function update_announcer(Request $request)
	{
		$user_id = $request->user_id;

		$user = DB::table('users')->where('id', $user_id)->first();

		if ($user->role == 'member') {
			DB::table('users')->where('id', $user_id)->update(['role' => 'announcer']);
			return 'Member ID ' . $user_id . ' has been promoted to an announcer';
		} else {
			DB::table('users')->where('id', $user_id)->update(['role' => 'member']);
			return 'Member ID ' . $user_id . ' has been demoted to a member';
		}
	}
}
