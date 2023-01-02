<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Announcement;
use App\Models\AnnouncementVote;
use App\Models\Organisation;
use App\Models\User;
use App\Models\UserOrganisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
	public function show($id, Request $request)
	{
		$user = User::where('id', $id)->first();

		if ($user == null) {
			return abort(404);
		}

		$grouped_votes = AnnouncementVote::selectRaw('announcement_id, SUM(vote_val) as vote_sum')
			->groupBy('announcement_id');

		$announcements = Announcement::join('users', 'announcements.user_id', '=', 'users.id')
			->leftJoinSub($grouped_votes, 'announcement_votes', function ($join) {
				$join->on('announcement_votes.announcement_id', '=', 'announcements.id');
			})
			->select('announcements.*', 'users.name as user_name', 'users.role as user_role', 'announcement_votes.vote_sum')
			->where('announcements.user_id', $id)->get();

		$in_org = UserOrganisation::where('user_id', $id)->first();
		$owns_org = Organisation::where('admin_id', $id)->first();

		if ($owns_org != null) {
			$org_data = Organisation::where('admin_id', $id)->first();
		} else if ($in_org) {
			$org_data = Organisation::where('id', $in_org->org_id)->first();
		} else {
			$org_data = null;
		}

		return view('profile.show', [
			'user' => $user, 'in_org' => $in_org != null, 'owns_org' => $owns_org != null, 'org_data' => $org_data, 'announcements' => $announcements
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
