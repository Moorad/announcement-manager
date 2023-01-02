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

	public function show($id)
	{
		// return $id;
		$announcementVotes = DB::table('announcement_votes')->selectRaw('announcement_id, SUM(vote_val) as vote_sum')->groupBy('announcement_id');

		$announcement = DB::table('announcements')->join('users', 'announcements.user_id', '=', 'users.id')->leftJoinSub($announcementVotes, 'announcement_votes', function ($join) {
			$join->on('announcement_votes.announcement_id', '=', 'announcements.id');
		})->select('announcements.*', 'users.name as user_name', 'users.role as user_role', 'announcement_votes.vote_sum')->where('announcements.id', $id)->first();

		if ($announcement == null) {
			return abort(404);
		}

		$comments = DB::table('comments')->where('announcement_id', $id)->join('users', 'users.id', 'comments.user_id')->select('comments.*', 'users.name as user_name', 'users.role as user_role')->get();

		return view('announcements.show', ['name' => Auth::user()->name, 'role' => Auth::user()->role, 'user_id' => Auth::user()->id, 'announcement' => $announcement, 'comments' => $comments]);
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
