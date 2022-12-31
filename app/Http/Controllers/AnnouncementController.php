<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
	//

	public function create()
	{
		return view('announcements.create');
	}

	public function store(Request $request)
	{

		$post = new Announcement;
		$post->user_id = Auth::user()->id;
		$post->org_id = $request->attributes->get('org_data')->id;
		$post->title = $request->announcement_title;
		$post->text = $request->announcement_text;

		if ($request->hasFile('announcement_image')) {
			$request->validate([
				'image' => 'mimes:png,jpeg,jpg,svg,webp'
			]);

			$request->file('announcement_image')->store('announcement_images', 'public');

			$post->attached_image = $request->file('announcement_image')->hashName();
		}

		$post->save();

		return redirect()->to(route('home'));
	}

	public function update_vote(Request $request)
	{
		$userVoteExists = DB::table('announcement_votes')->where('announcement_id', $request->announcement_id)->where('user_id', $request->user_id)->first();

		if ($userVoteExists == null) {
			$vote = new AnnouncementVote;
			$vote->announcement_id = $request->announcement_id;
			$vote->user_id = $request->user_id;
			$vote->vote_val = $request->vote_val;
			$vote->save();
		} else {
			if ($userVoteExists->vote_val == $request->vote_val) {
				DB::table('announcement_votes')->where('announcement_id', $request->announcement_id)->where('user_id', $request->user_id)->delete();
			} else {
				DB::table('announcement_votes')->where('announcement_id', $request->announcement_id)->where('user_id', $request->user_id)->update(['vote_val' => $request->vote_val]);
			}
		}

		$sum = DB::table('announcement_votes')->where('announcement_id', $request->announcement_id)->sum('vote_val');

		return $sum;
	}
}
