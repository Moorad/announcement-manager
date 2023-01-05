<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserOrganisation;
use App\Notifications\AddedUserToOrg;
use App\Notifications\RemovedUserFromOrg;
use Illuminate\Http\Request;

class UserController extends Controller
{

	public function search(Request $request)
	{
		$inner = function ($query) use ($request) {
			$query->where('org_id',  $request->org_id)
				->orWhere('org_id', null);
		};

		$users = User::leftJoin('user_organisations', 'user_organisations.user_id', '=', 'users.id')
			->select('users.*', 'user_organisations.org_id')
			->where($inner)
			->whereNot('users.role', 'admin');

		if ($request->search == null) {
			$users = $users->get();
		} else {
			$users = $users->where('name', 'LIKE', '%' . $request->search . '%')->get();
		}

		return view('layouts.member_table', ['users' => $users]);
	}

	public function update_member(Request $request)
	{
		$user_id = $request->user_id;
		$org_id = $request->org_id;

		$member = UserOrganisation::where('user_id', $user_id)->where('org_id', $org_id);

		$user = User::where('id', $user_id)->first();
		if ($member->first() == null) {
			$userOrg = new UserOrganisation;
			$userOrg->user_id = $user_id;
			$userOrg->org_id = $org_id;
			$userOrg->save();

			$user->notify(new AddedUserToOrg);
			return 'Member ID ' . $user_id . ' has been added to the organisation';
		} else {
			$member->delete();

			User::where('id', $user_id)->update(['role' => 'member']);

			$user->notify(new RemovedUserFromOrg);
			return 'Member ID ' . $user_id . ' has been removed from the organisation';
		}
	}

	public function update_announcer(Request $request)
	{
		$user_id = $request->user_id;

		$user = User::where('id', $user_id);

		if ($user->first()->role == 'member') {
			$user->update(['role' => 'announcer']);
			return 'Member ID ' . $user_id . ' has been promoted to an announcer';
		} else {
			$user->update(['role' => 'member']);
			return 'Member ID ' . $user_id . ' has been demoted to a member';
		}
	}
}
