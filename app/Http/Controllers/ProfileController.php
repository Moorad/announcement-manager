<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
	public function show($id, Request $request)
	{
		$user = DB::table('users')->where('id', $id)->first();

		if ($user == null) {
			return abort(404);
		}

		$announcementVotes = DB::table('announcement_votes')->selectRaw('announcement_id, SUM(vote_val) as vote_sum')->groupBy('announcement_id');

		$announcements = DB::table('announcements')->join('users', 'announcements.user_id', '=', 'users.id')->leftJoinSub($announcementVotes, 'announcement_votes', function ($join) {
			$join->on('announcement_votes.announcement_id', '=', 'announcements.id');
		})->select('announcements.*', 'users.name as user_name', 'users.role as user_role', 'announcement_votes.vote_sum')->where('announcements.user_id', $id)->get();

		$in_org = DB::table('user_organisations')->where('user_id', $id)->first();
		$owns_org = DB::table('organisations')->where('admin_id', $id)->first();

		if ($owns_org != null) {
			$org_data = DB::table('organisations')->where('admin_id', $id)->first();
		} else if ($in_org) {
			$org_data = DB::table('organisations')->where('id', $in_org->org_id)->first();
		} else {
			$org_data = null;
		}


		// dd($org_data);

		return view('profile.show', [
			'name' => $user->name, 'role' => $user->role, 'user' => $user, 'user_id' => $user->id, 'in_org' => $in_org != null, 'owns_org' => $owns_org != null, 'org_data' => $org_data, 'announcements' => $announcements
		]);
	}

	/**
	 * Display the user's profile form.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\View\View
	 */
	public function edit(Request $request)
	{
		return view('profile.edit', [
			'user' => $request->user(),
		]);
	}

	/**
	 * Update the user's profile information.
	 *
	 * @param  \App\Http\Requests\ProfileUpdateRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(ProfileUpdateRequest $request)
	{
		$request->user()->fill($request->validated());

		if ($request->user()->isDirty('email')) {
			$request->user()->email_verified_at = null;
		}

		$request->user()->save();

		return Redirect::route('profile.edit')->with('status', 'profile-updated');
	}

	/**
	 * Delete the user's account.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Request $request)
	{
		$request->validateWithBag('userDeletion', [
			'password' => ['required', 'current-password'],
		]);

		$user = $request->user();

		Auth::logout();

		$user->delete();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return Redirect::to('/');
	}
}
